<?php
session_start();
include '../koneksi.php'; // koneksi ke database

// Cek user login (sementara pakai ID 1 kalau belum ada login)
$user_id = $_SESSION['user_id'] ?? 1;

// Ambil data dari form
$product_id = $_POST['product_id'] ?? null;
$quantity = $_POST['quantity'] ?? 0;

// Validasi minimal 100
if (!$product_id || $quantity < 100) {
    echo "Minimal pemesanan 100 pcs.";
    exit;
}

// Cek keranjang aktif
$stmt = $conn->prepare("SELECT id FROM carts WHERE user_id = ? AND is_active = 1 LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $cart = $result->fetch_assoc();
    $cart_id = $cart['id'];
} else {
    // Buat keranjang baru
    $stmt = $conn->prepare("INSERT INTO carts (user_id) VALUES (?)");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_id = $stmt->insert_id;
}

// Cek apakah produk sudah ada di keranjang
$stmt = $conn->prepare("SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
$stmt->bind_param("ii", $cart_id, $product_id);
$stmt->execute();
$existing = $stmt->get_result();

if ($existing->num_rows > 0) {
    // Tambah jumlah
    $item = $existing->fetch_assoc();
    $new_qty = $item['quantity'] + $quantity;
    $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
    $stmt->bind_param("ii", $new_qty, $item['id']);
    $stmt->execute();
} else {
    // Tambahkan item baru
    $stmt = $conn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $cart_id, $product_id, $quantity);
    $stmt->execute();
}

echo "SUKSES"; // digunakan oleh fetch() di script.js
?>
