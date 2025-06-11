<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['checkout'])) {
    die("Data pemesanan tidak ditemukan");
}

// function kie fungsine nggo merubah nama gambar asli ne ko dadi nama sembarang si bakal disimpen nang folder gambar  
function generateRandomString($length = 10){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; //ini untuk huruf baru yang akan dipakay ya mill
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++){
        $randomString .= $characters[rand(0, $charactersLength -1)];
    }
    return $randomString;
}

$id_users = $_SESSION['id_users'];
$data     = $_SESSION['checkout'];
$tanggal  = date("Y-m-d H:i:s");
$metode   = $_POST['metode'];
$ukuran_data = $data['ukuran'];

// Upload bukti

    $folder = "../bukti/"; //tempat menyimpan gambar
    $nama_file =  basename($_FILES["bukti"]["name"]); 
    $target_file = $folder . $nama_file; // kie kaya nggo mindahna file  e ko tok
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // nek kie aku kurang paham nonton bae sng nng tutor sing durasi 2 jam nnag menit 30-40 an nek ora salah
    $image_size = $_FILES["bukti"]["size"]; // nek kie nggo ngukur ukuran foto ne misal kegeden ora bakal bisa nang ngisor ana penjelasan e
    $newName = uniqid("bukti_") . "." . $imageFileType;
    $baru = $newName . "." . $imageFileType; // nek kie kaya nggo mindahna tok ben gampang nek kurang jelas tonton video tutor e


    if($nama_file!=''){
        if($image_size > 5000000){ // kie nggo ngukur ben ukuran foto ora ngelewati batas sng ws ditentukna
            ?>
            <div class="alert alert-warning mt-3" role="alert">
                Foto tidak boleh lebih dari 100000 kb
            </div>
            <?php
        }else{
            if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif'){ // nek kie nggo tipe file e selain sng ws disaranna ora bisa diinput
                ?>
                <div class="alert alert-warning mt-3" role="alert">
                    Foto wajib bertipe jpg, png, atau gif
                </div>
                <?php
            }else{
                if (!move_uploaded_file($_FILES["bukti"]["tmp_name"], $folder . $newName)) {
                    echo "Upload gagal. Error code: " . $_FILES['bukti']['error'];
                    die();
                }
            }
        }
        
    }



// Hitung total
$total_keseluruhan = 0;
foreach ($data['produk'] as $id_produk => $jumlah) {
    $q = mysqli_query($koneksi, "SELECT harga FROM produk WHERE id_produk='$id_produk'");
    $p = mysqli_fetch_assoc($q);
    $total_keseluruhan += $p['harga'] * $jumlah;
}
$diskon = $total_keseluruhan >= 1000000 ? $total_keseluruhan * 0.1 : 0;
$grand_total = ($total_keseluruhan - $diskon) + $data['ongkir'];

// Simpan pemesanan & pembayaran
foreach ($data['produk'] as $id_produk => $jumlah) {
    $ukuran = $ukuran_data[$id_produk] ?? '';
    $q = mysqli_query($koneksi, "SELECT harga FROM produk WHERE id_produk='$id_produk'");
    $p = mysqli_fetch_assoc($q);
    $subtotal = $p['harga'] * $jumlah;

    $qk = mysqli_query($koneksi, "SELECT id_keranjang FROM keranjang WHERE id_users='$id_users' AND id_produk='$id_produk' LIMIT 1");
    $d  = mysqli_fetch_assoc($qk);
    $id_keranjang = $d ? $d['id_keranjang'] : "NULL";

    mysqli_query($koneksi, "
        INSERT INTO pemesanan (id_users, id_produk, id_keranjang, tanggal_pemesanan, jumlah_produk, total_harga, catatan, diskon, ongkir, ukuran, total_bayar)
        VALUES ('$id_users', '$id_produk', $id_keranjang, '$tanggal', '$jumlah', '$subtotal', '{$data['catatan']}', '$diskon', '{$data['ongkir']}', '$ukuran', '$grand_total')
    ");
    $id_pemesanan = mysqli_insert_id($koneksi);

    mysqli_query($koneksi, "
        INSERT INTO pembayaran (id_pemesanan, provider, bukti_pembayaran)
        VALUES ('$id_pemesanan', '$metode', '$newName')
    ");

    if ($id_keranjang !== "NULL") {
        mysqli_query($koneksi, "DELETE FROM keranjang WHERE id_keranjang='$id_keranjang'");
    }
}


unset($_SESSION['checkout']);
echo "<script>alert('Pembayaran berhasil, pesanan diproses'); window.location='index.php';</script>";
?>
