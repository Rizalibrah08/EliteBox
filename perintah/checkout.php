<?php
session_start();
include '../koneksi.php';

$user_id = $_SESSION['user_id'] ?? 1;

// Cek keranjang aktif
$stmt = $conn->prepare("SELECT id FROM carts WHERE user_id = ? AND is_active = 1 LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cartResult = $stmt->get_result();

if ($cartResult->num_rows === 0) {
    echo "Tidak ada keranjang aktif.";
    exit;
}

$cart = $cartResult->fetch_assoc();
$cart_id = $cart['id'];

// Buat order baru
$stmt = $conn->prepare("INSERT INTO orders (user_id, cart_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $cart_id);
$stmt->execute();
$order_id = $stmt->insert_id;

// Ambil item dari cart_items
$sql = "SELECT product_id, quantity, p.price FROM cart_items ci
        JOIN products p ON ci.product_id = p.id
        WHERE ci.cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$items = $stmt->get_result();

// Simpan ke order_items
while ($item = $items->fetch_assoc()) {
    $stmtInsert = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmtInsert->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
    $stmtInsert->execute();
}

// Nonaktifkan keranjang
$conn->query("UPDATE carts SET is_active = 0 WHERE id = $cart_id");

// Nonaktifkan keranjang
$conn->query("UPDATE carts SET is_active = 0 WHERE id = $cart_id");

// Alih-alih alert, tampilkan halaman notifikasi
include 'checkout_view.php';

?>
