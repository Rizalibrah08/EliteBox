<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: /login/login.php?pesan=login-dulu");
    exit;
}
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

  <title>Keranjang Saya</title>
  <link rel="stylesheet" href="styleKeranjang.css">
  <style>
    
  </style>
</head>
<body>

<?php 
// Gunakan user_id dari session atau sementara ID 1
$user_id = $_SESSION['user_id'] ?? 1;

// Ambil keranjang aktif
$stmt = $conn->prepare("SELECT id FROM carts WHERE user_id = ? AND is_active = 1 LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {?>
  <div class="head">
  <div class="logo">
      <h1><a href="#">Elite<span>Box</span></a></h1>
    </div>
    <div class="garis"></div>
  <h2 >Keranjang Belanja</h2>
</div>
  <h2 style='text-align:center;'>Keranjang kosong</h2>

  <div class="kluar">
      <a href="/index.php">Kembali</a>
    </div>
  <?php 
  exit;
}

$cart = $result->fetch_assoc();
$cart_id = $cart['id'];

// Ambil item dari cart_items
$sql = "SELECT ci.id AS cart_item_id, p.name, p.price, ci.quantity, (p.price * ci.quantity) AS subtotal
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.id
        WHERE ci.cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$items = $stmt->get_result();

?>

<div class="head">
  <div class="logo">
      <h1><a href="/index.php">Elite<span>Box</span></a></h1>
    </div>
    <div class="garis"></div>
  <h2 >Keranjang Belanja</h2>
</div>

<table>
  <thead>
    <tr>
      <div class="tbr">
        <th>No</th>
        <th>Nama Produk</th>
        <th>Harga Satuan</th>
        <th>Qty</th>
        <th>Subtotal</th>
        <th>Aksi</th>
      </div>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $total = 0;
    while ($row = $items->fetch_assoc()):
      $total += $row['subtotal'];
    ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td>Rp<?= number_format($row['price'], 0, ',', '.') ?></td>
      <td><?= $row['quantity'] ?></td>
      <td>Rp<?= number_format($row['subtotal'], 0, ',', '.') ?></td>
      <td>
        <div class="aksi">
          <!-- <input class="cb" type="checkbox" name="checkout_items[]" value="<?= $data['id_keranjang'] ?>"> -->
          <a href="hapus_item.php?id=<?= $row['cart_item_id'] ?>" class="btn"><i class="fa-solid fa-trash"></i></a>
        </div>
      </td>
    </tr>
    <?php endwhile; ?>
    <tr class="total">
      <td colspan="4">Total</td>
      <td colspan="2">Rp<?= number_format($total, 0, ',', '.') ?></td>
    </tr>
  </tbody>
</table>

<form action="checkout.php" method="post" style="text-align:center;">
  <button type="submit" class="co">
    <div class="co">
      Checkout
    </div>
</button>
</form>

</body>
</html>
