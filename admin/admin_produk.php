<?php
$page_title = "Kelola Produk";
include 'admin_header.php';

// Ambil semua produk
$products = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>
<script>document.querySelector('header h2').innerHTML = `<i class="fas fa-shopping-bag"></i> <?php echo $page_title; ?>`;</script>

<a href="produk_form.php" class="btn btn-update" style="margin-bottom: 20px; display: inline-block;">+ Tambah Produk Baru</a>

<table>
    <thead>
        <tr>
            <th>Gambar</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while($p = $products->fetch_assoc()): ?>
        <tr>
            <td><img src="../assets/produk1/<?php echo htmlspecialchars($p['image_url']); ?>" alt="" width="60"></td>
            <td><?php echo htmlspecialchars($p['name']); ?></td>
            <td>Rp<?php echo number_format($p['price'], 0, ',', '.'); ?></td>
            <td>
                <a href="produk_form.php?id=<?php echo $p['id']; ?>" class="btn btn-edit">Edit</a>
                <a href="produk_hapus.php?id=<?php echo $p['id']; ?>" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'admin_footer.php'; ?>