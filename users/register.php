<?php 
session_start(); 
require "koneksi.php"; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="bootstrap/bootstrap/css/bootstrap.min.css">
</head>
  <style>
    .main{ 
      height: 100vh; 
      }
    .login-box{ 
      width: 500px; 
      height: 370px; 
      box-sizing: border-box; 
      border-radius: 15px; 
      }
  </style>
<body>
<?php require "navbar.php"; ?>
  <div class="main d-flex flex-column justify-content-center align-items-center">
    <div class="login-box p-5 shadow">
      <form action="" method="post">
        <div>
          <label for="username">Username</label>
          <input type="text" class="form-control" name="username" id="">
        </div>
        <div>
          <label for="email">Email</label>
          <input type="email" class="form-control" name="email" id="">
        </div>
        <div>
          <label for="password">Password</label>
          <input type="password" class="form-control" name="password" id="">
        </div>
        <div >
          <button class="btn btn-success form-control mt-4" type="submit" name="register">Register</button><br>
        </div>
        <p class="text-center mt-3">Sudah Punya Akun? <a href="login.php" >Login</a></p>
      </form><br>

      <div>
        <?php
          // proses register
          if(isset($_POST['register'])){
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            if (empty($username) || empty($email) || empty($password)) {
              header("location:register.php?error=kosong");
              exit;
            }

            $query = mysqli_query($koneksi, "INSERT INTO users (username, email, password) VALUES ('$username', '$email',md5('$password'))");

            if ($query) {
              ?>
              <div class="form-control alert alert-primary mt-3 text-center" role="alert">
                  Register Berhasil
              </div>
              <meta http-equiv="refresh" content="2 ; url=login.php" />
              <?php
            } else {
              ?>
              <div class="form-control alert alert-danger mt-3 text-center" role="alert">
                  Register Gagal
              </div>
              <meta http-equiv="refresh" content="2 ; url=register.php" />
              <?php
            }
          }
        ?>
      </div>
    </div>
  </div>
</body>
</html>

