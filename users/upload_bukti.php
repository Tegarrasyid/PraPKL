<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['checkout'])) {
    header("Location: keranjang.php");
    exit;
}

$data = $_SESSION['checkout'];

// Ambil kembali nilai-nilai yang dibutuhkan
$subtotal           = $data['subtotal'] ?? 0;
$totalBeforeOngkir  = $data['totalBeforeOngkir'] ?? 0;
$diskon             = $data['diskon'] ?? 0;
$ongkir             = $data['ongkir'] ?? 0;

// Ambil asal halaman dan nama produk dari URL
$from = $_GET['from'] ?? 'keranjang';
$nama = $_GET['nama'] ?? '';
?>




 
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Bukti</title>
    <link rel="stylesheet" href="bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome/css/all.min.css">
    <style>
        .rekening-info {
            display: none;
            margin-top: 10px;
        }
        .produk-box {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 10px;
        }
        .total-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>

<?php require "navbar.php" ?>

<div class="container mt-5">
    <!-- Ringkasan Harga -->
    <div class="produk-box">
        <h5>Ringkasan Pembayaran</h5>
        <div class="total-box">
            <span>Subtotal</span>
            <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
        </div>
        <div class="total-box">
            <span>Total sebelum Ongkir</span>
            <span>Rp <?= number_format($totalBeforeOngkir, 0, ',', '.') ?></span>
        </div>
        <div class="total-box">
            <span>Diskon (10%)</span>
            <span class="text-danger">- Rp <?= number_format($diskon, 0, ',', '.') ?></span>
        </div>
        <div class="total-box">
            <span>Ongkir</span>
            <span>Rp <?= number_format($ongkir, 0, ',', '.') ?></span>
        </div>
        <div class="total-box">
            <span><strong>Total Bayar</strong></span>
            <span><strong>Rp <?= number_format($totalBeforeOngkir + $ongkir, 0, ',', '.') ?></strong></span>
        </div>
    </div>
</div>

<div class="container mt-3 ">
    <h4>Upload Bukti Transfer</h4>
    <form action="proses_pembayaran.php" method="post" enctype="multipart/form-data">
        <div class="row">
            <!-- Kolom Metode Pembayaran -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Metode Pembayaran</label>
                    <select name="metode" id="metode" required onchange="tampilkanRekening()" class="form-control">
                        <option value="">-- Pilih Metode Pembayaran--</option>
                        <option value="bca">BCA</option>
                        <option value="bni">BNI</option>
                        <option value="mandiri">Mandiri</option>
                    </select>
                </div>

                <!-- Info Rekening -->
                <div id="rekening-bca" class="rekening-info">
                    <ul>
                        <li>Bank: BCA</li>
                        <li>No Rekening: 1946840840978393</li>
                        <li>Atas Nama: PT Toko Sepatu</li>
                    </ul>
                </div>
                <div id="rekening-bni" class="rekening-info">
                    <ul>
                        <li>Bank: BNI</li>
                        <li>No Rekening: 8408409783931946</li>
                        <li>Atas Nama: PT Toko Sepatu</li>
                    </ul>
                </div>
                <div id="rekening-mandiri" class="rekening-info">
                    <ul>
                        <li>Bank: Mandiri</li>
                        <li>No Rekening: 4097839319468408</li>
                        <li>Atas Nama: PT Toko Sepatu</li>
                    </ul>
                </div>
            </div>

            <!-- Kolom Upload Bukti -->
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Upload Foto Bukti Transfer:</label>
                    <input type="file" name="bukti" required class="form-control">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-2">Kirim Bukti Pembayaran</button>
        
        <?php
        // Mengambil parameter GET, jika tidak ada maka default ke nilai tertentu
        $from = isset($_GET['from']) ? $_GET['from'] : 'keranjang';
        $nama = isset($_GET['nama']) ? $_GET['nama'] : '';

        // Logika untuk menentukan link kembali
        if ($from === 'detail_produk' && !empty($nama)) {
            $back_link = "produk_detail.php?nama=" . urlencode($nama);
        } else {
            $back_link = "keranjang.php";
        }

        ?>

        <a href="<?= $back_link ?>" class="btn btn-dark mt-2">Batal Pembelian</a>

    </form>
</div>

<?php require "footer.php" ?>

<script>
function tampilkanRekening() {
    const metode = document.getElementById('metode').value;
    const rekeningList = ['rekening-bca', 'rekening-bni', 'rekening-mandiri'];

    rekeningList.forEach(id => {
        document.getElementById(id).style.display = 'none';
    });

    if (metode) {
        const target = document.getElementById('rekening-' + metode);
        if (target) target.style.display = 'block';
    }
}
</script>

<script src="bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/fontawesome/js/all.min.js"></script>
</body>
</html>
