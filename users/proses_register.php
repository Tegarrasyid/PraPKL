<?php
require "koneksi.php";

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO pelanggan (username, email, password) VALUES ('$username','$email',md5('$password'))";
$query = mysqli_query($koneksi, $sql);

if($query){
    header("location:login.php?registrasi=sukses");
    exit;
}else{
    header("location:register.php?registrasi=gagal");
    exit;   
}
?>