<?php 
session_start(); 
require "koneksi.php"; 

if (!isset($_SESSION['redirect_after_login']) && isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'login.php') === false) {
  $_SESSION['redirect_after_login'] = $_SERVER['HTTP_REFERER'];
}

?>

<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="bootstrap/bootstrap/css/bootstrap.min.css">
</head>
<style>
  .main{ 
    height: 100vh; 
    }
  .login-box{ 
    width: 500px; 
    height: 300px; 
    box-sizing: border-box; 
    border-radius: 15px; 
    }
</style>
<body>
  <?php require "navbar.php"; ?>

  <?php if (!empty($_SESSION['flash_keranjang'])): ?>
  <div class="alert alert-warning text-center">
    <?= $_SESSION['flash_keranjang']; unset($_SESSION['flash_keranjang']); ?>
  </div>
  <?php endif; ?>

  <?php if (!empty($_SESSION['flash_login'])): ?>
  <div class="alert alert-success text-center">
    <?= $_SESSION['flash_login']; unset($_SESSION['flash_login']); ?>
  </div>
  <?php endif; ?>

  <div class="main d-flex flex-column justify-content-center align-items-center">
    <div class="login-box p-5 shadow">
      <form action="" method="post">
        <div>
          <label for="username">Email</label>
          <input type="text" class="form-control" name="email" id="">
        </div>
        <div>
          <label for="password">Password</label>
          <input type="password" class="form-control" name="password" id="">
        </div>
        <div >
          <button class="btn btn-success form-control mt-4" type="submit" name="loginbtn">Login</button><br>
        </div>
        <p class="text-center mt-3">Belum Punya Akun? <a href="register.php" >Register</a></p>
      </form><br>
      <div class="text-center"> 
          <?php
            // proses login
            if (isset($_POST['loginbtn'])) {
              $email = htmlspecialchars($_POST['email']);
              $password = htmlspecialchars($_POST['password']);

              $sql = "SELECT * FROM users WHERE email='$email' AND password = md5('$password') ";
              $query = mysqli_query($koneksi, $sql);

              if (mysqli_num_rows($query) == 1) {
                $data = mysqli_fetch_array($query);
                $_SESSION['username'] = $data['username'];
                $_SESSION['id_users']  = $data['id_users'];
                // reset info keranjang untuk akun yang baru
                unset($_SESSION['ukuran']);
                          
                ?>

                <?php
                  $redirect = $_SESSION['redirect_after_login'] ?? 'index.php?=sukses';
                  unset($_SESSION['redirect_after_login']); // bersihkan setelah dipakai
                ?>
                  <meta http-equiv="refresh" content="0 ; url=<?= $redirect ?>" />
                <?php
              } else {
                ?>
                <div class="form-control alert alert-warning mt-3" role="alert">
                    Password Anda Salah
                </div>
                <meta http-equiv="refresh" content="2 ; url=login.php" />
                <?php
            }
            }
          ?>
        </div>
    </div>
  </div>
</body>
</html>
