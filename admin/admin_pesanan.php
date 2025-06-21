<?php
$page_title = "Kelola Pesanan";
include 'admin_header.php';

// Proses update status jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
    // Redirect untuk menghindari resubmit form
    header("Location: admin_pesanan.php");
    exit;
}

// Ambil semua pesanan, join dengan tabel user untuk nama pemesan
$orders = $conn->query("SELECT o.*, u.email FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC");
$possible_statuses = ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'];
?>
<script>document.querySelector('header h2').innerHTML = `<i class="fas fa-box-open"></i> <?php echo $page_title; ?>`;</script>

<table>
    <thead>
        <tr>
            <th>ID Pesanan</th>
            <th>Pemesan</th>
            <th>Tanggal</th>
            <th>Status Saat Ini</th>
            <th>Update Status</th>
        </tr>
    </thead>
    <tbody>
        <?php while($order = $orders->fetch_assoc()): ?>
        <tr>
            <td>#<?php echo $order['id']; ?></td>
            <td><?php echo htmlspecialchars($order['email']); ?></td>
            <td><?php echo date('d M Y, H:i', strtotime($order['created_at'])); ?></td>
            <td><?php echo ucfirst(htmlspecialchars($order['status'])); ?></td>
            <td>
                <form action="admin_pesanan.php" method="POST">
                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                    <select name="status">
                        <?php foreach($possible_statuses as $status): ?>
                        <option value="<?php echo $status; ?>" <?php if($status == $order['status']) echo 'selected'; ?>>
                            <?php echo ucfirst($status); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="update_status" class="btn btn-update" style="margin-left:10px;">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'admin_footer.php'; ?>