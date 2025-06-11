<?php
require "session.php";
require "koneksi.php";

$id_produk = $_GET['id'];
$sql = "DELETE FROM produk WHERE id_produk = '$id_produk' ";
$query = mysqli_query($koneksi, $sql);

if($query){
    ?>
    <div class="alert alert-primary mt-3" role="alert">
        Produk Berhasil di Hapus
    </div>

    <meta http-equiv="refresh" content="2 ; url=produk.php" />
    <?php
}else{
    echo mysqli_error($koneksi);
} 

if ($query) {
    header("location:produk.php?hapus=sukses");
    exit;
    } else {
    header("location:produk.php?hapus=gagal");
    }
?>
