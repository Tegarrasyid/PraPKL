<?php
  require "koneksi.php";

  // path ke file JSON yang akan menyimpan ID produk random
  $file = __DIR__ . '/random_products.json';

  // 1. Ambil atau buat array ID acak
  if (file_exists($file) && ($ids = json_decode(file_get_contents($file), true))) {
  } else {
      $all  = mysqli_query($koneksi, "SELECT id_produk FROM produk");
      $ids  = [];
      while ($r = mysqli_fetch_assoc($all)) {
          $ids[] = (int)$r['id_produk'];
      }
      shuffle($ids);
      $ids = array_slice($ids, 0, 8);
      file_put_contents($file, json_encode($ids));
  }

  // 2. Query produk berdasarkan ID acak tadi, jaga urutan sesuai $ids
  if (count($ids) > 0) {
      $in   = implode(',', $ids);
      $sql  = "SELECT id_produk,nama,harga,foto,detail FROM produk WHERE id_produk IN ($in) ORDER BY FIELD(id_produk, $in)";
      $queryproduk = mysqli_query($koneksi, $sql);
  } else {
      $queryproduk = mysqli_query($koneksi,"SELECT id_produk,nama,harga,foto,detail FROM produk LIMIT 8" );
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Sepatu | Home</title>
    <link rel="stylesheet" href="bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome/css/all.min.css">
    
</head>
<style>
    .highlighted-kategori{
    height: 65px;
    width: 65px;
    }

    .no-decoration{
        text-decoration: none;
        color: black;
    }

    .warna{
      background-color: black;
      color: white;
    }

    .text-harga{
      font-size: 20px;
      color: black;
    }
</style>
<body>
  <?php  require "navbar.php"; ?>
  

 <div> <!-- bagian banner -->
  <div id="carouselExampleInterval" class="carousel slide mt-3" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="2000">
          <img src="../gambar/1.png" class="d-block w-100" alt="banner1">
        </div>
        <div class="carousel-item" data-bs-interval="2000">
          <img src="../gambar/222.png" class="d-block w-100" alt="banner2">
        </div>
        <div class="carousel-item" data-bs-interval="2000">
          <img src="../gambar/3.png" class="d-block w-100" alt="banner3">
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>

</div>

<!-- bagian home -->

<div class="container-fluid py-5"> <!-- hilighted kategori -->
  <div class="container text-center"> 

    <div class="row mt-5 justify-content-center"> 
      <div class="col-md-4 mb-5"> 
        <a class="no-decoration" href="produk_ss.php?kategori=Sepatu Sneakers">
        <div class="highlighted-kategori rounded-circle d-flex align-items-center"> 
          <img class="rounded-circle" src="../gambar/logo kets.png" alt="Sepatu Sneakers" >
          <h5 class="mt-2 ms-3 d-inline-block"> Sepatu Sneakers</h5> 
        </div> 
        </a>
      </div> 
      
      <div class="col-md-4 mb-5"> 
        <a class="no-decoration" href="produk_so.php?kategori=Sepatu Olahraga">
        <div class="highlighted-kategori rounded-circle d-flex align-items-center"> 
          <img class="rounded-circle" src="../gambar/logo olahraga.png" alt="Sepatu Olahraga" >
          <h5 class="mt-2 ms-3 d-inline-block"> Sepatu Olahraga</h5> 
        </div> 
        </a>
      </div> 
      <div class="col-md-2 mb-5"> 
        <a class="no-decoration" href="produk_sp.php?kategori=Sepatu Pantofel">
        <div class="highlighted-kategori rounded-circle d-flex align-items-center"> 
          <img class="rounded-circle" src="../gambar/logo pantofel.png" alt="Sepatu Pantofel" >
          <h5 class="mt-2 ms-3 d-inline-block"> Sepatu Pantofel</h5> 
        </div> 
        </a>
      </div> 
    </div> 

  </div> 
</div>

 <div class="container-fluid warna py-5"> <!-- tentang kami -->
  <div class="container ">
    <h3 class="text-center">Tentang Kami</h3>
    <p class="fs-5 mt-3 " style="text-align: justify;">
    SHAP adalah sebuah toko sepatu yang menghadirkan sepatu-sepatu yang berkualitas dengan harga yang kompetitif. Berbagai brand terkenal baik lokal maupun global telah bekerja sama dengan SHAP demi menghadirkan sepatu-sepatu yang berkualitas.
    </p>
  </div>
 </div>

<div class="container-fluid py-5 mt-3">  <!-- produk -->
  <div class="container ">
    <h3>Product</h3>

    <div class="row mt-5 ">
      <?php while($produk = mysqli_fetch_array($queryproduk)){ ?>
        <div class="col-sm-6 col-md-3 mb-4">
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

    <div class="text-center">
      <a class="btn btn-outline-primary mt-4 p-2 fs-6" href="produk.php">Lihat Semua</a>
    </div>
    
  </div>
</div>


<?php require "footer.php"; ?>

<script src="bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/fontawesome/js/all.min.js"></script>
</body>
</html>
