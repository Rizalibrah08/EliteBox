<?php
session_start();
// Wajib ada untuk memastikan hanya user yang login bisa akses
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php?pesan=harus_login");
    exit;
}

include '../koneksi.php'; // Sesuaikan path jika perlu
$user_id = $_SESSION['user_id'];
$page_title = "Profil Saya";

// Inisialisasi variabel pesan
$pesan_sukses = '';
$pesan_error = '';

// Logika untuk memproses form ganti password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // Validasi input
    if (empty($password_lama) || empty($password_baru) || empty($konfirmasi_password)) {
        $pesan_error = "Semua field wajib diisi.";
    } elseif ($password_baru !== $konfirmasi_password) {
        $pesan_error = "Password baru dan konfirmasi tidak cocok.";
    } else {
        // Ambil data user dari database
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verifikasi password lama
        if (password_verify($password_lama, $user['password'])) {
            // Jika password lama benar, hash password baru dan update ke database
            $hash_password_baru = password_hash($password_baru, PASSWORD_BCRYPT);
            $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_stmt->bind_param("si", $hash_password_baru, $user_id);
            if ($update_stmt->execute()) {
                $pesan_sukses = "Password berhasil diperbarui!";
            } else {
                $pesan_error = "Terjadi kesalahan saat memperbarui password.";
            }
        } else {
            $pesan_error = "Password lama yang Anda masukkan salah.";
        }
    }
}

// Ambil data email untuk ditampilkan
$user_email = $_SESSION['email'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7f6; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: auto; }
        .card { background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px; padding: 25px; }
        h1, h2 { text-align: center; color: orange; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; }
        .form-group input { width: 95%; padding: 12px; border-radius: 5px; border: 1px solid #ccc; }
        .btn { background-color: orange; color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; display: block; width: 100%; font-size: 1em; }
        .message { padding: 15px; margin-bottom: 20px; border-radius: 5px; text-align: center; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $page_title; ?></h1>
        <p style="text-align:center;"><a href="../index.php" style="color:orange;">&larr; Kembali ke Beranda</a></p>

        <?php if($pesan_sukses): ?><div class="message success"><?php echo $pesan_sukses; ?></div><?php endif; ?>
        <?php if($pesan_error): ?><div class="message error"><?php echo $pesan_error; ?></div><?php endif; ?>

        <div class="card">
            <h2>Informasi Akun</h2>
            <div class="form-group">
                <label>Email</label>
                <input type="email" value="<?php echo htmlspecialchars($user_email); ?>" disabled>
            </div>
        </div>

        <div class="card">
            <h2>Ubah Password</h2>
            <form action="profil.php" method="POST">
                <div class="form-group">
                    <label for="password_lama">Password Lama</label>
                    <input type="password" id="password_lama" name="password_lama" required>
                </div>
                <div class="form-group">
                    <label for="password_baru">Password Baru</label>
                    <input type="password" id="password_baru" name="password_baru" required>
                </div>
                <div class="form-group">
                    <label for="konfirmasi_password">Konfirmasi Password Baru</label>
                    <input type="password" id="konfirmasi_password" name="konfirmasi_password" required>
                </div>
                <button type="submit" name="change_password" class="btn">Perbarui Password</button>
            </form>
        </div>
    </div>
</body>
</html>