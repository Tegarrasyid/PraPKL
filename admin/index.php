<?php
    require "session.php";
    require "koneksi.php";

    $querykategori = mysqli_query($koneksi, "SELECT * FROM kategori");
    $jumlahkategori = mysqli_num_rows($querykategori);

    $queryproduk = mysqli_query($koneksi, "SELECT * FROM produk");
    $jumlahproduk = mysqli_num_rows($queryproduk);

    $querypesanan = mysqli_query($koneksi, "SELECT * FROM pemesanan");
    $jumlahpesanan = mysqli_num_rows($querypesanan);


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/fontawesome/css/fontawesome.min.css">
</head>

<style>
    .kotak{
        border: solid;
    }

    .summary-kategori{
        background-color: #16812D;
        border-radius: 15px;
    }

    .summary-produk{
        background-color: #163581;
        border-radius: 15px;
    }

    .summary-pesanan{
        background-color:rgb(176, 119, 21);
        border-radius: 15px;
    }

    .no-decor{
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class ="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-solid fa-house-chimney"></i> Home
            </li>
        </ol>
    </nav>
    <h2>Halo Admin</h2>

    <div class ="container mt-5">
 
    </div>
        <div class= "row">
            <div class="col-lg-4 col-md-6 col-12 mb-3">
                <div class="summary-kategori p-3">
                    <div class="row">
                        <div class="col-6">
                           <i class="fas fa-solid fa-list fa-8x"></i>
                        </div>
                        <div class="col-6 text-white">
                            <h3 class="fs-2">Kategori</h3>
                            <p class="fs-5"><?php echo $jumlahkategori; ?> Kategori</p>
                            <p><a href="kategori.php" class="text-white no-decor">Lihat Detail</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12 mb-3">
                <div class="summary-produk p-3">
                    <div class="row">
                        <div class="col-6">
                            <i class="fa-solid fa-box fa-8x"></i> 
                        </div>
                        <div class="col-6 text-white">
                            <h3 class="fs-2">Product</h3>
                            <p class="fs-5"><?php echo $jumlahproduk; ?> Produk</p>
                            <p><a href="produk.php" class="text-white no-decor">Lihat Detail</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-12 mb-3">
                <div class="summary-pesanan p-3">
                    <div class="row">
                        <div class="col-6">
                            <i class="fa-solid fa-basket-shopping fa-8x"></i>
                        </div>
                        <div class="col-6 text-white">
                            <h3 class="fs-2">Pesanan</h3>
                            <p class="fs-5"><?php echo $jumlahpesanan; ?> Pesanan</p>
                            <p><a href="pesanan.php" class="text-white no-decor">Lihat Pesanan</a></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <script src="../bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/fontawesome/js/all.min.js"></script>
</body>
</html>