<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['id_users'])) {
    header("Location: login.php");
    exit;
}

$id_users = $_SESSION['id_users'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap/css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100">

<div class="container">
    <div class="text-center">
        <?php
            if(isset($_POST['update'])) {
                $password_baru = $_POST['password_baru'];
                $konfirmasi_password = $_POST['konfirmasi_password'];

                // Validasi: cek apakah password dan konfirmasi sama
                if ($password_baru !== $konfirmasi_password) {
                    ?>
                        <div class="form-control alert alert-danger mt-3" role="alert">
                            Konfirmasi password tidak sesuai.
                        </div>
                    <meta http-equiv="refresh" content="2 ; url=profil.php" />
                    <?php
                    exit;
                }

                // Update password
                $sql = "UPDATE users SET password = md5('$password_baru') WHERE id_users='$id_users'";
                $query = mysqli_query($koneksi, $sql);

                if($query) {
                    ?>
                    <div class="form-control alert alert-primary mt-3" role="alert">
                        Password Berhasil Terupdate
                    </div>
                    <meta http-equiv="refresh" content="2 ; url=profil.php" />
                    <?php
                } else {
                    ?>
                    <div class="form-control alert alert-danger mt-3" role="alert">
                        Password Gagal Terupdate
                    </div>
                    <meta http-equiv="refresh" content="2 ; url=profil.php" />
                    <?php                   }
            }

        ?>
    </div>
</div>

  <script src="../bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>

