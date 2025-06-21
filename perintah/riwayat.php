<?php
session_start();
include '../koneksi.php';

$user_id = $_SESSION['user_id'] ?? 1;

$sql = "SELECT o.id AS order_id, o.status, o.created_at,
        p.name, oi.quantity, oi.price
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products p ON oi.product_id = p.id
        WHERE o.user_id = ?
        ORDER BY o.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$results = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <!-- Font Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Font Awesome CDN -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
      integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Fav Icon -->
    <link rel="shortcut icon" href="/assets/icon/favicon.ico" type="image/x-icon" />

    <link rel="stylesheet" href="styleRiwayat.css">
  <title>Riwayat Pembelian</title>
  <style>
    
  </style>
</head>
<body>

<div class="head">
  <div class="logo">
      <h1><a href="/index.php">Elite<span>Box</span></a></h1>
    </div>
    <div class="garis"></div>
  <h2 >Riwayat Pembelian</h2>
</div>

<table>
  <thead>
    <tr>
      <th>ID Order</th>
      <th>Produk</th>
      <th>Qty</th>
      <th>Harga</th>
      <th>Status</th>
      <th>Tanggal</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $results->fetch_assoc()): ?>
    <tr>
      <td>#<?= $row['order_id'] ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= $row['quantity'] ?></td>
      <td>Rp<?= number_format($row['price'], 0, ',', '.') ?></td>
      <td><?= ucfirst($row['status']) ?></td>
      <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

    <div class="kluar">
      <a href="/index.php">Kembali</a>
    </div>

</body>
</html>
