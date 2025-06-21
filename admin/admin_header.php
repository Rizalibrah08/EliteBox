<?php
include '../koneksi.php';
session_start();
// Validasi Sesi Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login/login.php?pesan=bukan_admin");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - EliteBox</title>
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="admin-wrapper">
        <div class="sidebar">
            <div class="logo">
                <h2>Elite<span>Box</span></h2>
                <p>Admin Panel</p>
            </div>
            <ul>
                <li><a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="admin_pesanan.php"><i class="fas fa-box-open"></i> Kelola Pesanan</a></li>
                <li><a href="admin_produk.php"><i class="fas fa-shopping-bag"></i> Kelola Produk</a></li>
                <li><a href="admin_laporan.php"><i class="fas fa-chart-line"></i> Laporan Penjualan</a></li>
                <li><a href="admin_users.php"><i class="fas fa-users"></i> Kelola Pengguna</a></li>
                <li><a href="../perintah/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <header>
                <h2>
                    <i class="fas fa-bars"></i>
                    </h2>
                <div class="user-wrapper">
                    <i class="fas fa-user-circle"></i>
                    <div>
                        <h4><?php echo $_SESSION['email']; ?></h4>
                        <small>Admin</small>
                    </div>
                </div>
            </header>
            <main>