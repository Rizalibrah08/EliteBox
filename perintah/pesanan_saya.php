<?php
session_start();
// Wajib ada untuk memastikan hanya user yang login bisa akses
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php?pesan=harus_login");
    exit;
}
include '../koneksi.php'; // Sesuaikan path jika perlu
$user_id = $_SESSION['user_id'];
$page_title = "Pesanan Saya";

// Ambil semua pesanan yang statusnya 'dikirim' ATAU 'selesai' tapi belum diberi rating
$sql = "SELECT * FROM orders 
        WHERE user_id = ? AND (status = 'dikirim' OR (status = 'selesai' AND rating_penjualan IS NULL)) 
        ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        /* CSS untuk halaman ini */
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7f6; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: auto; }
        h1 { text-align: center; color: orange; }
        a { color: orange; text-decoration: none; }
        .order-card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px; padding: 20px; }
        .order-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; }
        .order-header span { font-weight: bold; font-size: 1.1em; }
        .status { background-color: #3498db; color: white; padding: 5px 10px; border-radius: 15px; font-size: 0.8em; }
        .status-selesai { background-color: #2ecc71; }
        .btn { background-color: orange; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; font-weight: 500; }
        .btn-selesai { background-color: #2ecc71; }
        .rating-form { display: none; margin-top: 20px; background-color: #f9f9f9; padding: 20px; border-radius: 8px; border-top: 3px solid orange; }
        .rating-group { margin-bottom: 15px; }
        .rating-group > label { display: block; margin-bottom: 10px; font-weight: 500; }
        .rating-stars { display: inline-block; }
        .rating-stars input[type="radio"] { display: none; }
        .rating-stars label { font-size: 2em; color: #ddd; cursor: pointer; float: right; }
        .rating-stars input[type="radio"]:checked ~ label,
        .rating-stars label:hover,
        .rating-stars label:hover ~ label { color: orange; }
        textarea { width: 95%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; min-height: 80px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $page_title; ?></h1>
        <p style="text-align:center;"><a href="../index.php"> &larr; Kembali ke Beranda</a></p>

        <?php if ($orders->num_rows === 0): ?>
            <p style="text-align:center; margin-top: 40px;">Tidak ada pesanan aktif saat ini.</p>
        <?php else: ?>
            <?php while($order = $orders->fetch_assoc()): ?>
                <div class="order-card">
                    <div class="order-header">
                        <span>Order ID: #<?php echo $order['id']; ?></span>
                        <span class="status <?php if($order['status'] == 'selesai') echo 'status-selesai'; ?>">
                            <?php echo ucfirst($order['status']); ?>
                        </span>
                    </div>
                    <p>Tanggal Pesanan: <?php echo date('d F Y', strtotime($order['created_at'])); ?></p>
                    
                    <?php if ($order['status'] === 'dikirim'): ?>
                        <button class="btn btn-selesai" onclick="showRatingForm(this, <?php echo $order['id']; ?>)">
                            Pesanan Sudah Sampai
                        </button>
                    <?php endif; ?>

                    <form id="form-<?php echo $order['id']; ?>" class="rating-form" action="update_pesanan.php" method="POST" style="<?php if($order['status'] === 'selesai') echo 'display:block;'; ?>">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                        <h3>Berikan Ulasan Anda untuk Order #<?php echo $order['id']; ?></h3>
                        <div class="rating-group">
                            <label>Rating Produk & Pelayanan</label>
                            <div class="rating-stars">
                                <input type="radio" id="jual-5-<?php echo $order['id']; ?>" name="rating_penjualan" value="5" required><label for="jual-5-<?php echo $order['id']; ?>">★</label>
                                <input type="radio" id="jual-4-<?php echo $order['id']; ?>" name="rating_penjualan" value="4"><label for="jual-4-<?php echo $order['id']; ?>">★</label>
                                <input type="radio" id="jual-3-<?php echo $order['id']; ?>" name="rating_penjualan" value="3"><label for="jual-3-<?php echo $order['id']; ?>">★</label>
                                <input type="radio" id="jual-2-<?php echo $order['id']; ?>" name="rating_penjualan" value="2"><label for="jual-2-<?php echo $order['id']; ?>">★</label>
                                <input type="radio" id="jual-1-<?php echo $order['id']; ?>" name="rating_penjualan" value="1"><label for="jual-1-<?php echo $order['id']; ?>">★</label>
                            </div>
                        </div>
                        <div class="rating-group">
                            <label>Rating Pengiriman</label>
                            <div class="rating-stars">
                                <input type="radio" id="kirim-5-<?php echo $order['id']; ?>" name="rating_pengiriman" value="5" required><label for="kirim-5-<?php echo $order['id']; ?>">★</label>
                                <input type="radio" id="kirim-4-<?php echo $order['id']; ?>" name="rating_pengiriman" value="4"><label for="kirim-4-<?php echo $order['id']; ?>">★</label>
                                <input type="radio" id="kirim-3-<?php echo $order['id']; ?>" name="rating_pengiriman" value="3"><label for="kirim-3-<?php echo $order['id']; ?>">★</label>
                                <input type="radio" id="kirim-2-<?php echo $order['id']; ?>" name="rating_pengiriman" value="2"><label for="kirim-2-<?php echo $order['id']; ?>">★</label>
                                <input type="radio" id="kirim-1-<?php echo $order['id']; ?>" name="rating_pengiriman" value="1"><label for="kirim-1-<?php echo $order['id']; ?>">★</label>
                            </div>
                        </div>
                        <div class="rating-group">
                            <label for="komentar-<?php echo $order['id']; ?>">Bagaimana pengalaman Anda? (Opsional)</label>
                            <textarea id="komentar-<?php echo $order['id']; ?>" name="komentar" placeholder="Ceritakan pengalaman Anda dengan produk dan pengirimannya..."></textarea>
                        </div>
                        <button type="submit" class="btn">Kirim Ulasan</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <script>
        function showRatingForm(button, orderId) {
            button.style.display = 'none'; // Sembunyikan tombol "Pesanan Sudah Sampai"
            document.getElementById('form-' + orderId).style.display = 'block'; // Tampilkan form rating
        }
    </script>
</body>
</html>