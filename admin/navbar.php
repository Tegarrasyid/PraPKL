
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
      <a class="nav-link my-3" href="../admin">
        <img src="../gambar/Logo Web.png" alt="Logo Sepatu">
      </a>
    </div>
    <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTongglerDemo02">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarTongglerDemo02">
      <ul class="navbar-nav">
        <li class="nav-item me-3"><a class="nav-link warna1" href="../admin">Home</a></li>
        <li class="nav-item me-3"><a class="nav-link warna1" href="kategori.php">Kategori</a></li>
        <li class="nav-item me-3"><a class="nav-link warna1" href="produk.php">Product</a></li>
        <li class="nav-item me-3"><a class="nav-link warna1" href="pesanan.php">Pesanan</a></li>
        <li class="nav-item me-3"><a class="nav-link warna1" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </nav>
</body>
</html>