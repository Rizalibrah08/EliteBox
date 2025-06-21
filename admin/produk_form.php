<?php
$page_title = "Form Produk";
include 'admin_header.php';

// Inisialisasi variabel
$product = ['id' => '', 'name' => '', 'price' => '', 'type_id' => '', 'width_mm' => '', 'height_mm' => '','image_url' => ''];
$form_action = 'produk_form.php'; // Aksi default untuk tambah baru

// Cek apakah ini mode edit
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $page_title = "Edit Produk: " . htmlspecialchars($product['name']);
        $form_action = 'produk_form.php?id=' . $id;
    }
}

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type_id = $_POST['type_id'];
    $width_mm = $_POST['width_mm'];
    $height_mm = $_POST['height_mm'];
    $id_to_update = $_POST['id'] ?? null;

    // Logika Upload Gambar
    $image_name = $product['image_url']; // Gunakan gambar lama sebagai default
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = "../assets/produk1/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    if ($id_to_update) {
        // UPDATE
        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, type_id = ?, width_mm = ?, height_mm = ?, image_url = ? WHERE id = ?");
        $stmt->bind_param("sdiiisi", $name, $price, $type_id, $width_mm, $height_mm, $image_name, $id_to_update);
        $stmt->execute();
    } else {
        // INSERT
        $stmt = $conn->prepare("INSERT INTO products (name, price, type_id, width_mm, height_mm, image_url) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdiiis", $name, $price, $type_id, $width_mm, $height_mm, $image_name);
        $stmt->execute();
    }
    header("Location: admin_produk.php");
    exit;
}
?>
<script>document.querySelector('header h2').innerHTML = `<i class="fas fa-edit"></i> <?php echo $page_title; ?>`;</script>
<style>
/* CSS khusus untuk form */
.form-group { margin-bottom: 15px; }
.form-group label { display: block; margin-bottom: 5px; }
.form-group input, .form-group select { width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; }
</style>

<form action="<?php echo $form_action; ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
    <div class="form-group">
        <label for="name">Nama Produk</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
    </div>
    <div class="form-group">
        <label for="price">Harga</label>
        <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
    </div>
    <div class="form-group">
        <label for="type_id">Tipe ID</label>
        <input type="number" name="type_id" id="type_id" value="<?php echo htmlspecialchars($product['type_id']); ?>" required>
    </div>
    <div class="form-group">
        <label for="width_mm">Lebar (mm)</label>
        <input type="number" name="width_mm" id="width_mm" value="<?php echo htmlspecialchars($product['width_mm']); ?>" required>
    </div>
    <div class="form-group">
        <label for="height_mm">Tinggi (mm)</label>
        <input type="number" name="height_mm" id="height_mm" value="<?php echo htmlspecialchars($product['height_mm']); ?>" required>
    </div>
    <div class="form-group">
        <label for="image">Gambar Produk</label>
        <input type="file" name="image" id="image">
        <?php if ($product['image_url']): ?>
            <p>Gambar saat ini: <img src="../assets/produk1/<?php echo htmlspecialchars($product['image_url']); ?>" width="100"></p>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-update">Simpan Produk</button>
</form>

<?php include 'admin_footer.php'; ?>