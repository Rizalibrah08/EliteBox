<!-- Header -->
<?php 
$page_title = "S3 Nylon";
include 'kemasan_header.php'; 
?>
<!-- Header -->

 <!-- Hero -->
 <div class="hero">
            <div class="container">
                <div class="hero-box">
                    <div class="text">
                        <h2>Kemasan Sachet Nylon</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non recusandae eius esse porro, fugiat impedit officiis a praesentium iste ab, atque in ipsum accusantium ratione.</p>
                        <a href="">Pilih Kemasan</a>
                    </div>

                    <img src="/assets/ha.png" alt="">
                </div>
            </div>
        </div>
        <!-- Hero -->

        <!-- info -->
        <div class="info">
            <div class="container">
                <div class="info-box">
                    <div class="info-text">
                        <h2>Ukuran dan Harga Kemasan Sachet Nylon</h2>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab non ducimus sapiente laudantium omnis reprehenderit! Dolore delectus ab eos distinctio beatae eligendi doloribus ullam similique voluptas. Obcaecati esse molestiae corrupti!</p>
                    </div>

                    <div class="tabel">
                        <div class="info-tabel">
                            <div class="row header">
                                <div class="cell">Size</div>
                                <div class="cell">Finishing</div>
                                <div class="cell">Ketebalan</div>
                                <div class="cell">Degassing Valve</div>
                                <div class="cell">V-Cut</div>
                                <div class="cell">Window Pouch</div>
                            </div>
                        </div>
    
                            <!-- Row 1 -->
                            <div class="col">
                                <div class="row">
                                    <div class="cell"><strong>150 × 250 mm</strong></div>
                                    <div class="cell"></div>
                                    <div class="cell"></div>
                                    <div class="cell"></div>
                                    <div class="cell"></div>
                                    <div class="cell"></div>
                                </div>
                              
                                <!-- Row 2 (highlighted) -->
                                <div class="row highlight">
                                    <div class="cell"><strong></strong></div>
                                    <div class="cell">Glossy / Matte</div>
                                    <div class="cell">100 mikron</div>
                                    <div class="cell"><em>Custom</em></div>
                                    <div class="cell">Ya</div>
                                    <div class="cell">Ya</div>
                                </div>
                              
                                <!-- Row 3 -->
                                <div class="row3">
                                    <div class="cell"><strong>200 × 300 mm</strong></div>
                                    <div class="cell"></div>
                                    <div class="cell"></div>
                                    <div class="cell"></div>
                                    <div class="cell"></div>
                                    <div class="cell"></div>
                                </div>
                            </div>
                    </div>
                    

                </div>
        </div>
    </div>
        <!-- info -->

        <!-- Daftar Kemasan -->
    <div class="daftar-harga">
        <div class="container">
            <div class="dh-box">
                <h2>Daftar Kemasan</h2>

                
                <div class="tabel">
                    <div class="info-tabel">
                        <!-- Header Tabel -->
                        <div class="row header">
                                <div class="cell">
                                    <p>Produk</p>
                                </div>
                                <div class="cell">
                                    <p>Ukuran<br>(Lebar × Tinggi)</p>
                                </div>
                                <div class="cell">
                                    <p>Harga Satuan</p>
                                </div> 
                                <div class="cell">
                                    <p>Kuantitas</p>
                                </div>
                                <div class="cell">
    
                                </div>
                        </div>
                    </div>

                    <!-- List Tabel -->
<?php 
$sql = "SELECT * FROM products WHERE type_id = 2";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()):
?>
                    <form onsubmit="addToCart(event, <?= $row['id'] ?>, this)" action="" class="col">
                        <div class="row">
                            <div class="cell">
                                <div class="produk">
                                    <img src="/assets/produk/<?= $row['image_url'] ?>" alt="" />
                                    <p><?= $row['name'] ?></p>
                                </div>
                            </div>
                            <div class="cell">
                            <?= $row['width_mm'] ?> × <?= $row['height_mm'] ?> mm
                            </div>
                            <div class="cell">
                            Rp<?= number_format($row['price'], 0, ',', '.') ?>,-
                            </div>
                            <div class="cell">
                                <div class="qty-box">
                                    <button type="button" onclick="adjustQty(this, -100)">-</button>
                                    <input type="number" name="quantity" value="0" min="0" readonly />
                                    <button type="button" onclick="adjustQty(this, 100)">+</button>
                                </div>
                            </div>

                            <div class="cell">
                                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                                <button class="btn-keranjang" type="submit">+ Keranjang</button>
                            </div>
                        </div>
                    </form>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
        <!-- Daftar Kemasan -->

<!-- footer -->
<?php include 'kemasan_footer.php'; ?>
<!-- footer -->