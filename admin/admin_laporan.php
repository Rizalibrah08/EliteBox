<?php
$page_title = "Laporan Penjualan";
include 'admin_header.php';

// Tentukan rentang tanggal. Default 30 hari terakhir.
$end_date = $_GET['end_date'] ?? date('Y-m-d');
$start_date = $_GET['start_date'] ?? date('Y-m-d', strtotime('-29 days', strtotime($end_date)));

// Siapkan klausa WHERE untuk query
$date_clause = "AND o.created_at BETWEEN ? AND ?";

// Query untuk statistik ringkasan
$summary_sql = "SELECT 
                    SUM(oi.quantity * oi.price) AS total_revenue,
                    COUNT(DISTINCT o.id) AS total_orders,
                    SUM(oi.quantity) AS total_products_sold
                FROM orders o
                JOIN order_items oi ON o.id = oi.order_id
                WHERE o.status = 'selesai' $date_clause";

$stmt_summary = $conn->prepare($summary_sql);
$start_datetime = $start_date . ' 00:00:00';
$end_datetime = $end_date . ' 23:59:59';
$stmt_summary->bind_param("ss", $start_datetime, $end_datetime);
$stmt_summary->execute();
$summary = $stmt_summary->get_result()->fetch_assoc();

// Query untuk daftar pesanan yang telah selesai dalam rentang tanggal
$orders_sql = "SELECT o.id, o.created_at, u.email, SUM(oi.quantity * oi.price) as total_belanja
               FROM orders o
               JOIN users u ON o.user_id = u.id
               JOIN order_items oi ON o.id = oi.order_id
               WHERE o.status = 'selesai' $date_clause
               GROUP BY o.id
               ORDER BY o.created_at DESC";
$stmt_orders = $conn->prepare($orders_sql);
$stmt_orders->bind_param("ss", $start_datetime, $end_datetime);
$stmt_orders->execute();
$orders = $stmt_orders->get_result();
?>
<script>document.querySelector('header h2').innerHTML = `<i class="fas fa-chart-line"></i> <?php echo $page_title; ?>`;</script>
<style>
/* Impor style dari dashboard dan tambahkan beberapa style khusus */
.cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
.card h3 { font-size: 2rem; margin: 0; }
.card p { margin: 0; color: #777; }
.filter-form { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; display: flex; gap: 15px; align-items: center; }
.filter-form input[type="date"] { padding: 8px; border: 1px solid #ccc; border-radius: 5px; }
.filter-form button { padding: 9px 20px; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
th { background-color: #f2f2f2; }
</style>

<div class="filter-form">
    <form action="admin_laporan.php" method="GET" style="display: flex; gap: 15px; align-items: center;">
        <label for="start_date">Dari Tanggal:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>">
        <label for="end_date">Sampai Tanggal:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>">
        <button type="submit" class="btn btn-update">Filter</button>
    </form>
</div>

<div class="cards">
    <div class="card">
        <h3>Rp<?php echo number_format($summary['total_revenue'] ?? 0, 0, ',', '.'); ?></h3>
        <p>Total Pendapatan</p>
    </div>
    <div class="card">
        <h3><?php echo $summary['total_orders'] ?? 0; ?></h3>
        <p>Pesanan Selesai</p>
    </div>
    <div class="card">
        <h3><?php echo $summary['total_products_sold'] ?? 0; ?></h3>
        <p>Produk Terjual</p>
    </div>
</div>

<h2 style="margin-top: 30px; text-align: left;">Detail Transaksi Selesai</h2>
<table>
    <thead>
        <tr>
            <th>ID Pesanan</th>
            <th>Tanggal</th>
            <th>Email Pemesan</th>
            <th>Total Belanja</th>
        </tr>
    </thead>
    <tbody>
        <?php if($orders->num_rows > 0): ?>
            <?php while($order = $orders->fetch_assoc()): ?>
            <tr>
                <td>#<?php echo $order['id']; ?></td>
                <td><?php echo date('d M Y', strtotime($order['created_at'])); ?></td>
                <td><?php echo htmlspecialchars($order['email']); ?></td>
                <td>Rp<?php echo number_format($order['total_belanja'], 0, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4" style="text-align: center;">Tidak ada data penjualan pada rentang tanggal ini.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include 'admin_footer.php'; ?>