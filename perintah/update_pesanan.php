<?php
session_start();
// Keamanan: Pastikan user sudah login untuk bisa mengakses file ini
$user_id = $_SESSION['user_id'] ?? 1;

// Keamanan: Pastikan request datang dari method POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: pesanan_saya.php');
    exit;
}

include '../koneksi.php'; // Sesuaikan path jika perlu

// Ambil dan bersihkan data dari form
$user_id = $_SESSION['user_id'];
$order_id = intval($_POST['order_id'] ?? 0);
$rating_penjualan = intval($_POST['rating_penjualan'] ?? 0);
$rating_pengiriman = intval($_POST['rating_pengiriman'] ?? 0);
$komentar = trim(htmlspecialchars($_POST['komentar'] ?? ''));

// Validasi input: pastikan order_id dan rating tidak kosong
if ($order_id === 0 || $rating_penjualan === 0 || $rating_pengiriman === 0) {
    // Jika ada data penting yang kosong, kembalikan ke halaman sebelumnya
    header('Location: pesanan_saya.php?status=error_input');
    exit;
}

// Keamanan Tambahan: Pastikan order yang akan diupdate benar-benar milik user yang sedang login
$stmt_check = $conn->prepare("SELECT id FROM orders WHERE id = ? AND user_id = ?");
$stmt_check->bind_param("ii", $order_id, $user_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows === 1) {
    // Jika order valid, update databasenya
    $new_status = 'selesai';
    $stmt_update = $conn->prepare("UPDATE orders SET status = ?, rating_penjualan = ?, rating_pengiriman = ?, komentar_rating = ? WHERE id = ?");
    $stmt_update->bind_param("siisi", $new_status, $rating_penjualan, $rating_pengiriman, $komentar, $order_id);
    
    if ($stmt_update->execute()) {
        // Jika berhasil, arahkan kembali ke halaman pesanan dengan pesan sukses
        header('Location: pesanan_saya.php?status=sukses');
        exit;
    } else {
        // Jika gagal update
        header('Location: pesanan_saya.php?status=error_db');
        exit;
    }
} else {
    // Jika user mencoba mengubah order milik orang lain (tidak mungkin terjadi jika UI benar, tapi ini lapisan keamanan)
    http_response_code(403);
    die("Aksi tidak diizinkan.");
}
?>