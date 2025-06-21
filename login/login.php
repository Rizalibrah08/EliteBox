<?php
session_start();

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "dbelitebox"; // Ganti dengan nama database kamu

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password'])) {
  $email = $_POST['email'];
  $password_input = $_POST['password']; // Ambil password tanpa di-md5
  
  // 1. Ambil data user HANYA berdasarkan email
  $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows === 1) {
      $userData = $result->fetch_assoc();
  
      // 2. Verifikasi password yang diinput dengan hash di database
      if (password_verify($password_input, $userData['password'])) {
          // Jika password cocok, lanjutkan proses login
          $_SESSION['user_id'] = $userData['id'];
          $_SESSION['email'] = $userData['email'];
          $_SESSION['role'] = $userData['role'];
  
          if ($userData['role'] === 'admin') {
              header("Location: ../admin/admin_dashboard.php");
          } else {
              header("Location: ../index.php");
          }
          exit;
      }
  }
  
  // Jika email tidak ditemukan ATAU password_verify gagal
  $login_error = "Email atau password salah!";
}

// Proses Registrasi (khusus user)
if (isset($_POST['reg_email']) && isset($_POST['reg_password'])) {
    $reg_email = $_POST['reg_email'];
    $reg_password_plain = $_POST['reg_password'];
    // Enkripsi password dengan metode yang aman
    $reg_password_hashed = password_hash($reg_password_plain, PASSWORD_BCRYPT);
    $role = "user";

    // Cek apakah email sudah ada
    $cek = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $cek->bind_param("s", $reg_email);
    $cek->execute();
    $cek_result = $cek->get_result();

    if ($cek_result->num_rows > 0) {
        $reg_error = "Email sudah digunakan!";
    } else {
        $insert = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $reg_email, $reg_password_hashed, $role);
        if ($insert->execute()) {
            $reg_success = "Registrasi berhasil! Silakan login.";
        } else {
            $reg_error = "Gagal registrasi. Coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="login">
    <div class="container active" id="container">
      <!-- FORM REGISTRASI -->
      <div class="form-container sign-up">
        <form method="POST" action="">
          <h1>Create Account</h1>
          <div class="social-icons">
            <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
            <!-- <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a> -->
          </div>
          <span>or use your email for registration</span>
          <input type="email" name="reg_email" placeholder="Email" required />
          <input type="password" name="reg_password" placeholder="Password" required />
          <button type="submit">Sign Up</button>
          <?php if (isset($reg_error)) echo "<p style='color:red;'>$reg_error</p>"; ?>
          <?php if (isset($reg_success)) echo "<p style='color:green;'>$reg_success</p>"; ?>
        </form>
      </div>

      <!-- FORM LOGIN -->
      <div class="form-container sign-in">
        <form method="POST" action="">
          <h1>Sign In</h1>
          <div class="social-icons">
            <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
            <!-- <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
            <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a> -->
          </div>
          <span>or use your email password</span>
          <input type="email" name="email" placeholder="Email" required />
          <input type="password" name="password" placeholder="Password" required />
          <a href="#">Forgot your password?</a>
          <button type="submit">Sign In</button>
          <?php if (isset($login_error)) echo "<p style='color:red;'>$login_error</p>"; ?>
        </form>
      </div>

      <!-- TOGGLE PANEL -->
      <div class="toggle-container">
        <div class="toggle">
          <div class="toggle-panel toggle-left">
            <h1>Welcome Back!</h1>
            <p>Enter your personal details to use all of site features</p>
            <button class="hidden" id="login">Sign In</button>
          </div>
          <div class="toggle-panel toggle-right">
            <h1>Hello, Friend!</h1>
            <p>Register with your personal details to use all of site features</p>
            <button class="hidden" id="register">Sign Up</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>
