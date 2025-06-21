<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Berhasil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a; /* Latar belakang gelap */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
        }
        .notification-container {
            background-color: #2c2c2c; /* Warna dasar box */
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            text-align: center;
            padding: 40px;
            max-width: 400px;
            border-top: 5px solid #ff6600; /* Aksen oranye */
        }
        .icon-container {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #ff6600; /* Oranye */
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        .icon-container svg {
            width: 50px;
            height: 50px;
            fill: white;
        }
        h1 {
            color: #ff6600; /* Oranye */
            margin-top: 0;
            margin-bottom: 10px;
        }
        p {
            font-size: 1.1em;
            margin-bottom: 30px;
        }
        .btn-lanjut {
            background-color: #ff6600; /* Oranye */
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-lanjut:hover {
            background-color: #e65c00; /* Oranye lebih gelap */
        }
    </style>
    <meta http-equiv="refresh" content="5;url=riwayat.php" />
</head>
<body>
    <div class="notification-container">
        <div class="icon-container">
            <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path></svg>
        </div>
        <h1>Checkout Berhasil!</h1>
        <p>Terima kasih telah berbelanja. Pesanan Anda sedang diproses.</p>
        <a href="riwayat.php" class="btn-lanjut">Lihat Riwayat Pesanan</a>
    </div>
    <script>
        // Redirect otomatis setelah 5 detik
        setTimeout(function() {
            window.location.href = 'riwayat.php';
        }, 5000);
    </script>
</body>
</html>