<?php
    require "koneksi.php";
    
    $querykategori = mysqli_query($koneksi, "SELECT * FROM kategori");

    // get produk by nama produk/keyword
        if (isset($_GET['keyword'])) {
            $queryproduk = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama LIKE '%$_GET[keyword]%' ORDER BY RAND()");
        }

    // get produk by kategori
        else if (isset($_GET['kategori'])) {
            $querygetkategoriid = mysqli_query($koneksi, "SELECT id_kategori FROM kategori WHERE nama='$_GET[kategori]'");
            $kategoriid = mysqli_fetch_array($querygetkategoriid);

            if ($kategoriid) {
                $queryproduk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_kategori='{$kategoriid['id_kategori']}' ORDER BY RAND()");
            } else {
                $queryproduk = mysqli_query($koneksi, "SELECT * FROM produk WHERE 1=0");
            }
        } 
        
    // get produk by default
        else {
            $queryproduk = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY RAND()");
        }

        $keyword  = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';  // ← SELALU ada
        $kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';

        $whereClause = '1';   // kondisi dasar TRUE
        if ($keyword !== '') {
            $keywords   = explode(' ', $keyword);
            $conditions = [];
            foreach ($keywords as $word) {
                $word        = mysqli_real_escape_string($koneksi, $word);
                $conditions[] = "(produk.nama LIKE '%$word%' OR kategori.nama LIKE '%$word%')";
            }
            $whereClause .= ' AND ' . implode(' AND ', $conditions);
        }

        if ($kategori !== '') {
            $kategoriSafe = mysqli_real_escape_string($koneksi, $kategori);
            $whereClause .= " AND kategori.nama = '$kategoriSafe'";
        }

        $queryproduk = mysqli_query( 
            $koneksi,
            "SELECT produk.* 
            FROM produk 
            LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori
            WHERE $whereClause
            ORDER BY RAND()"
        );

    $countdata = mysqli_num_rows($queryproduk);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Sepatu | Produk</title>
    <link rel="stylesheet" href="bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome/css/all.min.css">
</head>
<style>
    .banner{
        height: 580px;
        background: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0)), url('../gambar/4.png') 
    }

    .no-decoration{
        text-decoration: none;
        color: black;
    }
</style>
<body>
<?php require "navbar.php"; ?>

     <div class="container-fluid banner mt-4">    <!-- bagian banner -->
        <div class="container">
        </div>
     </div>

     <!-- body -->
      <div class="container py-5">
        <div class="row">

            <div class="col-lg-3 mb-5">
                <h3>Kategori</h3>
                <ul class="list-group mt-5">
                    <a class="no-decoration" href="produk_so.php?kategori=Sepatu+Olahraga"> <!-- aku -->
                        <li class="list-group-item">Sepatu Olahraga</li>
                    </a>
                    <a class="no-decoration" href="produk_ss.php?kategori=Sepatu+Sneakers"> <!-- aku -->
                        <li class="list-group-item">Sepatu Sneakers</li>
                    </a>
                    <a class="no-decoration" href="produk_sp.php?kategori=Sepatu+Pantofel"> <!-- aku -->
                        <li class="list-group-item">Sepatu Pantofel</li>
                    </a>
                </ul>
            </div>

            <div class="col-lg-9" >
                <h3 class="text-center mb-3">Product</h3>
                <div class="row mt-5">

                    <?php 
                        if($countdata<1){
                    ?>
                        <h4 class="text-center my-5">Produk yang anda cari tidak tersedia</h4>
                    <?php
                        }
                    ?>

                    <?php while($produk = mysqli_fetch_array($queryproduk)){ ?>
                        <div class="col-sm-6 col-md-4 mb-4">
                            <div class="card h-100 d-flex flex-column">
                                <img src="../image/<?php echo $produk['foto']; ?>" class="card-img-top" alt="sepatu">
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title" style="min-height: 50px;">
                                        <?php echo $produk['nama']; ?>
                                    </h4>
                                    <p class="card-text text-harga">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                                    <div class="mt-auto">
                                        <a href="produk_detail.php?nama=<?php echo $produk['nama']; ?>" class="btn btn-primary w-100">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            
        </div>
      </div>

<?php require "footer.php"; ?>

<script src="bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/fontawesome/js/all.min.js"></script>
</body>
</html>