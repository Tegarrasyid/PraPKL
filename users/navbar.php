<?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  require "koneksi.php";

  // hitung jumlah keranjang untuk user yang sedang login
  if (!isset($_SESSION['id_users'])) {
      $total_cart = 0;
  } else {
      $id_users  = $_SESSION['id_users'];
      $queryCart = mysqli_query($koneksi, "SELECT COALESCE(SUM(jumlah_produk),0) AS total FROM keranjang WHERE id_users = '$id_users' ");

      // pastikan $queryCart berhasil dan fetch_assoc tidak null
      if ($queryCart && ($rowCart = mysqli_fetch_assoc($queryCart))) {
          $total_cart = (int)$rowCart['total'];
      } else {
          $total_cart = 0;
      }
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar Login</title>
  <link rel="stylesheet" href="bootstrap/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/fontawesome/css/fontawesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    .navbar-brand img {
      border-radius: 50%;
    }
    .warna {
      background-color: black;
    }
    .warna1 {
      color: white;
    }
    .brand {
      margin-left: 20px;
    }
    .profil-img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark warna sticky-top">
    <div class="brand">
      <a class="nav-link my-3" href="index.php">
        <img src="../gambar/Logo Web.png" alt="Logo Sepatu">
      </a>
    </div>
    <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTongglerDemo02">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarTongglerDemo02">
      <ul class="navbar-nav">
        <li class="nav-item me-3"><a class="nav-link warna1" href="index.php">Home</a></li>
        <li class="nav-item me-3"><a class="nav-link warna1" href="tentang.php">About</a></li>
        <li class="nav-item me-3"><a class="nav-link warna1" href="produk.php">Products</a></li>

        <!-- Form Pencarian -->
        <li class="nav-item me-3">
          <form action="produk.php" method="get">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Cari Produk" aria-label="Cari Products" aria-describedby="basic-addon2" name="keyword">
              <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
            </div>
          </form>
        </li>

        <!-- Keranjang -->
        <li class="nav-item me-4">
          <a class="nav-link warna1 position-relative" href="keranjang.php">
            <i class="fa-solid fa-cart-shopping"></i>
            <?php if($total_cart > 0): ?>
              <span id="notif-keranjang" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?php echo $total_cart; ?>
              </span>
            <?php endif; ?>
          </a>
        </li>

        <!-- Login/Register & Profil -->
        <li class="nav-item me-5">
          <div id="login-register">
            <a href="login.php"><button class="btn btn-primary" id="login-btn">Login</button></a>
          </div>
          <div id="profil" style="display: none;">
            <div class="btn-group">
              <img src="../gambar/profil1.png" alt="Profil" class="profil-img dropdown-toggle" data-bs-toggle="dropdown">
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profil.php"><i class="fa-solid fa-user"></i> Edit Profil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php" id="logout-btn"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></li>
              </ul>
            </div>
          </div>
        </li>

      </div>
      </ul>
    </div>
  </nav>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const loginBtn = document.getElementById("login-btn");
      const logoutBtn = document.getElementById("logout-btn");
      const loginRegister = document.getElementById("login-register");
      const profil = document.getElementById("profil");
      const currentPage = window.location.pathname.split("/").pop();

      // Cek apakah pengguna sudah login (disimpan di localStorage)
      function updateNavbar() {
        const isLoggedIn = localStorage.getItem("isLoggedIn") === "true";

        if (isLoggedIn) {
          loginRegister.style.display = "none";
          profil.style.display = "block";
        } else {
          loginRegister.style.display = "block";
          profil.style.display = "none";
        }

        // Jika berada di halaman login atau register, pastikan tombol login/register tetap ada
        if (currentPage === "login.php" || currentPage === "register.php") {
          loginRegister.style.display = "block";
          profil.style.display = "none";
        }
      }

      // Panggil updateNavbar() saat halaman pertama kali dimuat
      updateNavbar();

      // Simulasi Login
      loginBtn.addEventListener("click", function() {
        localStorage.setItem("isLoggedIn", "true");
        updateNavbar();
      });

      // Logout
      logoutBtn.addEventListener("click", function() {
        localStorage.removeItem("isLoggedIn");
        updateNavbar();
        location.reload(); // Refresh halaman setelah logout agar tampilan kembali ke semula
      });
    });
  </script>


  <script src="bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="fontawesome/fontawesome/js/all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>