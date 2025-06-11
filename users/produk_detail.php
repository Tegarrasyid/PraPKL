<?php
    session_start(); 
    require "koneksi.php";

    $queryproduk = mysqli_query($koneksi, "SELECT ukuran FROM produk");

    $nama = htmlspecialchars($_GET['nama']);
    $queryProduk = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama='$nama'");
    $produk = mysqli_fetch_array($queryProduk);

    $queryProdukTerkait = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_kategori='$produk[id_kategori]' AND id_produk!='$produk[id_produk]' ORDER BY RAND() LIMIT 4");

    $query = "SHOW COLUMNS FROM produk LIKE 'ukuran'";
    $result = mysqli_query($koneksi, $query);

    $angka = isset($_POST['angka']) ? (int)$_POST['angka'] : 1;

    //penjumlahan dan pengurangan
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['tambah'])) {
            $angka += 1;
        } elseif (isset($_POST['kurang'])) {
            $angka -= 1;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Sepatu | Detail Produk</title>
    <link rel="stylesheet" href="bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.3.0/ckeditor5.css" />
</head>

<style>
    .w{
        background-color:rgb(223, 223, 223);
    }
    
    .produk-terkait-image{
        height: 100%;
        width: 100%;
        object-fit: cover;
        object-position: center;
    }

    .no-decoration{
        text-decoration: none;
        color: black;
    }
    
    .posisi{ 
        border-radius: 30px; 
        width: 100px; 
    }

    .counter-box {
        display: flex;
    }

    .counter {
        width: 60px;
        font-size: 22px;
        margin: 0 10px;
    }

    .text-justify {
    text-align: justify;
    }
</style>

<body>
<?php require "navbar.php"; ?>

<!-- Detail produk -->
<div class="container-fluid py-5 mt-5">
    <div class="container">
        <div class="row">

            <div class="col-lg-5 mb-3 ">
                <img src="../image/<?php echo $produk['foto']; ?>" class="w-100"  alt="sepatu">

                <!-- Spesifikasi dalam Dropdown -->
                <div class="mt-4 ">
                    <p>
                        <a class="btn btn-light border-dark form-control" onclick="toggleCollapse()" role="button">
                            Lihat Detail <i class="fa-solid fa-angle-down" id="icon-toggle"></i>
                        </a>
                    </p>
                    <div class="collapse" id="collapseSpesifikasi">
                        <div class="card card-body text-justify">
                            <?php echo nl2br(htmlspecialchars($produk['detail'])); ?>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-5 offset-lg-1  col-md-4 mb-4">
                <h1><?php echo $produk['nama']; ?></h1>

                <p class="fs-3 card-text text-harga">
                    Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
                </p>
                

                <p class="fs-4">Pilih Ukuran</p>
                

                <select name="ukuran_sepatu" id="ukuran" class="btn btn-light dropdown-toggle border-dark rounded" required>
                    <option value="" disabled selected>Pilih Ukuran</option>
                    <?php
                    $ukuran_tersedia = explode(',', $produk['ukuran']); 
                    foreach ($ukuran_tersedia as $uk) {
                        echo "<option value='$uk'>$uk</option>";
                    }
                    ?>
                </select>
                
                <div>
                    <p class="fs-4">Pilih Jumlah</p>
                    <form method="post" class="counter-box text-center">
                        <button type="submit" name="kurang" class="btn btn-light">-</button>
                        <div class="counter"><?php echo $angka; ?></div>
                        <button type="submit" name="tambah" class="btn btn-light">+</button>
                        <input type="hidden" name="angka" value="<?php echo $angka; ?>">
                    </form>
                </div>


                <?php if ($produk['ketersediaan_stok'] === 'tersedia') : ?>
                <!-- Form Masukkan Keranjang -->
                <form action="keranjang.php" method="post" id="formKeranjang">
                    <input type="hidden" name="id_produk" value="<?php echo $produk['id_produk']; ?>">
                    <input type="hidden" name="jumlah" value="<?php echo $angka; ?>">
                    <input type="hidden" name="nama_produk" value="<?php echo $produk['nama']; ?>">
                    <input type="hidden" name="ukuran_sepatu" id="ukuran_keranjang">
                    <button class="form-control btn btn-success mt-4" type="submit" name="masukkan_keranjang">Masukkan Keranjang</button>
                </form>

                <!-- Form Beli Sekarang -->
                <form action="pembayaran.php" method="post" id="formBeli">
                    <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>"> <!-- ID produk yang akan dibeli -->
                    <input type="hidden" name="jumlah" value="<?= $angka ?>"> <!-- Jumlah produk yang dibeli -->
                    <input type="hidden" name="ukuran_sepatu" id="ukuran_beli"> <!-- Ukuran sepatu yang dipilih (diisi lewat JS) -->
                    <input type="hidden" name="nama" value="<?= $_GET['nama'] ?>"> <!-- Nama produk, digunakan untuk kembali ke halaman detail -->
                    <input type="hidden" name="from" value="detail_produk"> <!-- Penanda bahwa pembelian berasal dari halaman detail produk -->
                    <input type="hidden" name="redirect_url" value="<?= $_SERVER['REQUEST_URI'] ?>"> <!-- URL halaman saat ini, digunakan untuk redirect setelah login -->
                    <button type="submit" class="btn btn-light form-control mt-1">Beli Sekarang</button> <!-- Tombol untuk mengirim form -->
                </form>
                <?php else : ?>
                <div class="alert alert-danger mt-4 text-center">Stok produk ini sedang habis.</div>
                <button class="form-control btn btn-secondary mt-2" disabled>Masukkan Keranjang</button>
                <button class="form-control btn btn-secondary mt-2" disabled>Beli Sekarang</button>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>

<!-- produk terkait -->
<div class="container-fluid py-5 mt-5 w">
    <div class="container">
        <h2 class="text-center mb-5">Produk Terkait</h2>
        <div class="row ">
            <?php while($produk = mysqli_fetch_array($queryProdukTerkait)){ ?>
                <div class="col-md-4 mb-4 col-md-6 col-lg-3 mb-3">
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

<?php require "footer.php"; ?>

<!-- js untuk dropdown detail produk -->
<script>
    function toggleCollapse() {
        var collapse = document.getElementById('collapseSpesifikasi');
        var icon = document.getElementById('icon-toggle');
        collapse.classList.toggle('show');
        if (collapse.classList.contains('show')) {
            icon.classList.remove('fa-angle-down');
            icon.classList.add('fa-angle-up');
        } else {
            icon.classList.remove('fa-angle-up');
            icon.classList.add('fa-angle-down');
        }
    }
</script>



<!-- js untuk memilih ukuran sepatu -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function validateUkuran() {
    const ukuran = document.getElementById("ukuran").value;
    if (!ukuran) {
      Swal.fire({
        title: 'Toko Sepatu',
        text: 'Silakan pilih ukuran sepatu terlebih dahulu.',
        icon: 'warning',
        confirmButtonText: 'Oke'
      });
      return false;
    }
    return true;
  }

  // Form Keranjang
  document.getElementById("formKeranjang").addEventListener("submit", function(e) {
    if (!validateUkuran()) {
      e.preventDefault(); // Stop submit
    } else {
      document.getElementById("ukuran_keranjang").value = document.getElementById("ukuran").value;
    }
  });

  // Form Beli Sekarang
  document.getElementById("formBeli").addEventListener("submit", function(e) {
    if (!validateUkuran()) {
      e.preventDefault(); // Stop submit
    } else {
      document.getElementById("ukuran_beli").value = document.getElementById("ukuran").value;
    }
  });
</script>



<script>
const {
    ClassicEditor,
    Essentials,
    Bold,
    Italic, 
    Font,
    Paragraph
} = CKEDITOR;

ClassicEditor
    .create( document.querySelector( 'detail' ), {
        licenseKey: '<YOUR_LICENSE_KEY>',
        plugins: [ Essentials, Bold, Italic, Font, Paragraph ],
        toolbar: [
            'undo', 'redo', '|', 'bold', 'italic', '|',
            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
        ]
    } )
    .then( /* ... */ )
    .catch( /* ... */ );

    </script>

<script src="bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/fontawesome/js/all.min.js"></script>
</body>
</html>
