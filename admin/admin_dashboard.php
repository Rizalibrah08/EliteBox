<?php 
$page_title = "Dashboard";
include 'admin_header.php'; 

// Query untuk statistik
$total_users = $conn->query("SELECT COUNT(id) AS total FROM users WHERE role = 'user'")->fetch_assoc()['total'];
$total_products = $conn->query("SELECT COUNT(id) AS total FROM products")->fetch_assoc()['total'];
$pending_orders = $conn->query("SELECT COUNT(id) AS total FROM orders WHERE status = 'pending'")->fetch_assoc()['total'];

// Query untuk total pendapatan (hanya dari order yang selesai)
$total_revenue_query = "SELECT SUM(oi.quantity * oi.price) AS total FROM order_items oi JOIN orders o ON oi.order_id = o.id WHERE o.status = 'selesai'";
$total_revenue = $conn->query($total_revenue_query)->fetch_assoc()['total'] ?? 0;
?>

<style>
/* CSS khusus untuk dashboard */
.cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
.card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
.card-icon { font-size: 3rem; color: var(--primary-color); }
.card-info h3 { font-size: 2.5rem; margin: 0; }
.card-info p { margin: 0; color: #777; }
</style>

<script>document.querySelector('header h2').innerHTML = `<i class="fas fa-tachometer-alt"></i> <?php echo $page_title; ?>`;</script>

<div class="cards">
    <div class="card">
        <div class="card-info">
            <h3><?php echo $total_users; ?></h3>
            <p>Total Pelanggan</p>
        </div>
        <div class="card-icon"><i class="fas fa-users"></i></div>
    </div>
    <div class="card">
        <div class="card-info">
            <h3><?php echo $total_products; ?></h3>
            <p>Total Produk</p>
        </div>
        <div class="card-icon"><i class="fas fa-shopping-bag"></i></div>
    </div>
    <div class="card">
        <div class="card-info">
            <h3><?php echo $pending_orders; ?></h3>
            <p>Pesanan Baru</p>
        </div>
        <div class="card-icon"><i class="fas fa-box-open"></i></div>
    </div>
    <div class="card">
        <div class="card-info">
            <h3>Rp<?php echo number_format($total_revenue, 0, ',', '.'); ?></h3>
            <p>Total Pendapatan</p>
        </div>
        <div class="card-icon"><i class="fas fa-dollar-sign"></i></div>
    </div>
</div>

<div class="recent-activity" style="margin-top: 40px;">
    <h2>Aktivitas Terkini</h2>
    </div>


<?php include 'admin_footer.php'; ?>