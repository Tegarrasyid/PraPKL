<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['id_users'])) {
    header("Location: login.php");
    exit;
}

$id_users = $_SESSION['id_users'];

// Ambil data pesanan user
$query = mysqli_query($koneksi, "
    SELECT p.*, pr.nama, pr.foto
    FROM pemesanan p
    JOIN produk pr ON p.id_produk = pr.id_produk
    WHERE p.id_users = '$id_users'
    ORDER BY p.tanggal_pemesanan DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya</title>
    <link rel="stylesheet" href="bootstrap/bootstrap/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            width: 200px;
            background-color: #f3f3f3;
            height: 100vh;
        }
        .menu-item {
            padding: 20px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }
        .menu-item:hover {
            background-color: #ddd;
        }
        .pesanan-card {
            background-color: #dbdfe8;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
        }
        .product-img {
            width: 120px;
            height: auto;
            object-fit: cover;
        }
        .status-text {
            font-weight: bold;
        }
        .no-decoration{
        text-decoration: none;
        }
    </style>
</head>
<body>

<?php require 'navbar.php'; ?>   

<!-- body -->

<div class="container-fluid p-4 bg-light my-2">
    <div class="row justify-content-center">

        <div class="row">

            <div class="col-lg-3 mb-5">
                    <h3><i class="bi bi-list mt-1"></i> Menu</h3>
                <ul class="list-group mt-3">
                        <a class="no-decoration" href="profil.php"> <!-- aku -->
                            <li class="list-group-item"><i class="fa-solid fa-circle-user"></i> Profil</li>
                        </a>
                        <a class="no-decoration" href="pesanan.php"> <!-- aku -->
                            <li class="list-group-item"><i class="fa-solid fa-bag-shopping"></i> Pesanan</li>
                        </a>
                        <a class="no-decoration" href="logout.php" id="logout-pesanan">
                            <li class="list-group-item"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</li>
                        </a>
                </ul>
            </div>

            <!-- Konten Pesanan -->
            <div class="col-lg-9">
                <h4><i class="fa-solid fa-bag-shopping"></i> Pesanan Saya</h4>
                <?php while ($row = mysqli_fetch_assoc($query)) { ?>
                    <div class="pesanan-card d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="../image/<?= $row['foto'] ?>" alt="Produk" class="product-img me-3" style="width: 150px; height: auto; border-radius: 5px;">
                            <div>
                                <p class="mb-1 fw-semibold fs-4">Nama Sepatu: <span class="fs-5"><?= $row['nama'] ?></span></p>
                                <p class="mb-0 fw-semibold fs-5">Ukuran: <span class="fs-5"><?= $row['ukuran'] ?></span></p>
                            </div>
                        </div><br><br><br><br>
                        <div class="status-text text-end">
                            <?= $row['status'] == 1 ? '<span class="text-success">Dikirim</span>' : '<span class="text-danger">Belum Dikirim</span>' ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</div>



<?php require "footer.php"; ?>


<script>
  document.getElementById("logout-pesanan").addEventListener("click", function (e) {
    e.preventDefault();
    localStorage.removeItem("isLoggedIn");
    window.location.href = "logout.php";
  });
</script>

<script src="bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/fontawesome/js/all.min.js"></script>
    
</body>
</html>