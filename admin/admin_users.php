<?php
$page_title = "Kelola Pengguna";
include 'admin_header.php';

// --- LOGIKA UPDATE PERAN (ROLE) ---
// Cek jika ada form yang disubmit untuk mengubah peran
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_role'])) {
    $user_id_to_update = intval($_POST['user_id']);
    $new_role = $_POST['new_role'];

    // Validasi sederhana untuk memastikan role yang diinput adalah 'admin' atau 'user'
    if ($new_role === 'admin' || $new_role === 'user') {

        // Fitur Keamanan: Admin tidak bisa mengubah rolenya sendiri di halaman ini
        // untuk mencegah terkunci dari akunnya sendiri secara tidak sengaja.
        if ($user_id_to_update == $_SESSION['user_id']) {
            // Sebaiknya tampilkan pesan error, tapi untuk sekarang kita abaikan saja perubahannya
            // (Tidak melakukan apa-apa)
        } else {
            // Lanjutkan proses update
            $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->bind_param("si", $new_role, $user_id_to_update);
            $stmt->execute();

            // Redirect kembali ke halaman yang sama untuk melihat perubahan
            header("Location: admin_users.php");
            exit;
        }
    }
}

// --- LOGIKA MENAMPILKAN DATA ---
// Ambil semua data pengguna dari database untuk ditampilkan
$result = $conn->query("SELECT id, email, role FROM users ORDER BY id ASC");

?>

<script>document.querySelector('header h2').innerHTML = `<i class="fas fa-users"></i> <?php echo $page_title; ?>`;</script>

<p>Di halaman ini Anda dapat melihat semua pengguna terdaftar dan mengubah peran mereka.</p>

<table>
    <thead>
        <tr>
            <th>ID Pengguna</th>
            <th>Email</th>
            <th>Peran Saat Ini</th>
            <th style="width: 25%;">Ubah Peran</th>
        </tr>
    </thead>
    <tbody>
        <?php while($user = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td>
                <span style="background-color: <?php echo ($user['role'] == 'admin' ? '#e74c3c' : '#3498db'); ?>; color: white; padding: 5px 10px; border-radius: 5px;">
                    <?php echo ucfirst($user['role']); ?>
                </span>
            </td>
            <td>
                <?php
                // Cek apakah baris ini adalah admin yang sedang login
                if ($user['id'] == $_SESSION['user_id']) {
                    echo "<strong>(Akun Anda)</strong>";
                } else {
                ?>
                    <form action="admin_users.php" method="POST" style="display: flex; gap: 10px;">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <select name="new_role" style="padding: 8px; border-radius: 5px; border: 1px solid #ccc; width: 60%;">
                            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
                            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                        </select>
                        <button type="submit" name="change_role" class="btn btn-update">Update</button>
                    </form>
                <?php
                }
                ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'admin_footer.php'; ?>