<?php
session_start();
include '../koneksi.php';

$id = $_GET['id'] ?? 0;
$id = intval($id);

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: keranjang.php");
exit;
