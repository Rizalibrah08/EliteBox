<?php include "../koneksi.php"; ?>

<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="style.css" />

        <!-- Font Poppins -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
        />

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
        <link
        rel="shortcut icon"
        href="/assets/icon/favicon.ico"
        type="image/x-icon"
        />
        <title>Pesan Kemasan</title>
    </head>
    <body>
        <!-- navbar -->
        <div class="nav">
        <div class="container">
            <div class="nav-box">
            <div class="logo">
                <h1>
                <a href="../index.php">Elite<span>Box</span></a>
                </h1>
            </div>
            <ul class="menus">
                <li>
                <a href="../index.php">Beranda</a>
                </li>
                <li>
                <a href="#tentang">Tentang Kami</a>
                </li>
                <li>
                <div class="dropdown">
                    <a class="poin">Portofolio ▼</a>
                    <div class="dropdown-content">
                    <a href="#">Studi Kasus</a>
                    <a href="#">Portofolio</a>
                    </div>
                </div>
                </li>
                <li>
                <div class="dropdown" id="">
                    <a class="poin">Cari Kemasan ▼</a>
                    <div class="dropdown-content">
                    <a href="#">Kopi/Teh/Bubuk Minuman</a>
                    <a href="#">Obat dan Kosmetik</a>
                    <a href="#">Frozen Food</a>
                    <a href="#">Makanan Ringan</a>
                    <a href="#">Kue dan Roti</a>
                    <a href="#">Bibit Tanaman</a>
                    </div>
                </div>
                </li>
                <li>
                <div class="dropdown">
                    <a class="poin">Pesan Kemasan ▼</a>
                    <div class="dropdown-content">
                    <div class="category" onclick="toggleSub(this)">
                        <a>Sachet/3 Side Seal ▼</a>
                    </div>
                    <div class="subcategory" id="">
                        <a href="Metalized.php"
                        >> Metalized/Metalic (Efek Metalik)</a
                        >
                        <a href="s3nylon.php">> Standard Nylon (Window)</a>
                        <a href="s3alumunium.php"
                        >> Super Alumunium (Efek Metalik:Custom Material)</a
                        >
                    </div>
                    <div class="category" onclick="toggleSub(this)">
                        <a>Standing Pouch ▼</a>
                    </div>
                    <div class="subcategory" id="">
                        <a href="#">> Ekonomi OOP (Jendela Transparan)</a>
                        <a href="#">> Metalized (Efek Metalik)</a>
                        <a href="#">> Standard Nylon (Jendela Transparan)</a>
                        <a href="#"
                        >> Super Alumunium (Efek Metalik:Custom Material)</a
                        >
                    </div>
                    <a href="#">Lid Cup</a>
                    <a href="#">Roll Stock</a>
                    </div>
                </div>
                </li>
                <li>
                <a href="#kontak">Kontak</a>
                </li>
                <li>
                <div class="login">
                    <?php if (isset($_SESSION['email'])): ?>
                    <!-- Jika User Login -->
                    <div class="user-area">
                        <a href="/perintah/keranjang.php"><i class="fa-solid fa-cart-shopping"></i></a>
                        
                        <div class="dropdown">
                            <a ><i class="fa-solid fa-user"></i></a>
                            <div class="dropdown-content">
                                <a href="/perintah/profil.php">Profil Saya</a>
                                <a href="/perintah/pesanan_saya.php">Pesanan Saya</a>
                                <a href="/perintah/riwayat.php">Riwayat Pembelian</a>
                                <a href="/perintah/logout.php">Logout</a>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                        <!-- Jika belum Login -->
                        <div class="user-area">
                        <a href="/perintah/keranjang.php"><i class="fa-solid fa-cart-shopping"></i></a>
                        <a href="/login/login.php"><span>Masuk</span></a>
                        </div>
                        <?php endif; ?>
                </div>
                </li>
            </ul>
            </div>
        </div>
        </div>
        <!-- navbar -->