<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['id_users'])) {
    header("Location: login.php");
    exit;
}

$id_users = $_SESSION['id_users'];
$sql = "SELECT * FROM users WHERE id_users='$id_users'";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($query);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profil Pengguna</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<?php


if(isset($_POST['update'])) {
  $username = $_POST['username'];
  $nama = $_POST['nama'];
  $alamat = $_POST['alamat'];
  $no_tlpn = $_POST['no_tlpn'];
  $email = $_POST['email'];
  


    // Update data pada database
    $sql = "UPDATE users SET username='$username', nama='$nama', alamat='$alamat', no_tlpn='$no_tlpn', email='$email' WHERE id_users='$data[id_users]'";
    $query = mysqli_query($koneksi, $sql);

    // Periksa apakah data berhasil diupdate
    if($query) {
        echo "<script>alert('Data Berhasil Terupdate'); window.location='profil.php';</script>";
    } else {
        echo "<script>alert('Data Gagal Terupdate'); window.location='profil.php';</script>";
    }
}
?>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>