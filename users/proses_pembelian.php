<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['id_users'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit;
}

// Ambil nilai 'from' dan 'nama' dari session atau POST
$from = $_SESSION['from_page'] ?? ($_POST['from'] ?? 'keranjang');
$nama = $_SESSION['nama'] ?? ($_POST['nama'] ?? '');

// Ambil data dari form pembayaran.php
$nama_penerima = $_POST['nama'];
$email      = $_POST['email'];
$no_tlpn    = $_POST['no_tlpn'];
$alamat     = $_POST['alamat'];
$catatan    = $_POST['catatan'];
$region     = $_POST['region'];
$produk     = $_POST['produk'];
$ukuran     = $_POST['ukuran'];
$subtotal   = $_POST['subtotal'];
$diskon     = $_POST['diskon'];
$total_sebelum_ongkir = $_POST['total_sebelum_ongkir'];
$ongkir     = $_POST['ongkir'];

$total_bayar = $total_sebelum_ongkir + $ongkir;

// Simpan ke session
$_SESSION['checkout'] = [
    'nama' => $nama_penerima,
    'email' => $email,
    'no_tlpn' => $no_tlpn,
    'alamat' => $alamat,
    'catatan' => $catatan,
    'region' => $region,
    'produk' => $produk,
    'ukuran' => $ukuran,
    'subtotal' => $subtotal,
    'diskon' => $diskon,
    'totalBeforeOngkir' => $total_sebelum_ongkir,
    'ongkir' => $ongkir,
    'total_bayar' => $total_bayar
];

// Redirect ke upload bukti sambil kirim from dan nama
$from = $_POST['from'] ?? 'keranjang';
$nama = $_POST['nama'] ?? '';

header("Location: upload_bukti.php?from=$from&nama=" . urlencode($nama));
exit;

 
