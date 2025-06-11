<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['id_users'])) {
    $_SESSION['redirect_after_login'] = $_POST['redirect_url'] ?? 'produk.php';
    $_SESSION['flash_keranjang'] = 'Silakan login terlebih dahulu untuk melakukan pembelian.';
    header("Location: login.php");
    exit;
}



$produkDibeli = [];

// ambil daftar barang dari POST (bisa satu atau banyak)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Beli dari detail produk
    if (isset($_POST['id_produk'])) {
        $id_produk = $_POST['id_produk'];
        $jumlah    = $_POST['jumlah'];
        $ukuran    = $_POST['ukuran_sepatu'] ?? '';

        $r = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
        if ($r && mysqli_num_rows($r) > 0) {
            $produkDibeli[] = array_merge(mysqli_fetch_assoc($r), compact('jumlah', 'ukuran'));
        }

    // Beli dari keranjang (dengan pilih keranjang dan klik Beli Sekarang)
    } elseif (isset($_POST['beli_sekarang']) && isset($_POST['pilih_keranjang']) && isset($_POST['produk'])) {
        $id_keranjang_terpilih = $_POST['pilih_keranjang'];
        foreach ($id_keranjang_terpilih as $idk) {
            if (isset($_POST['produk'][$idk])) {
                $id_produk = $_POST['produk'][$idk]['id_produk'];
                $jumlah    = $_POST['produk'][$idk]['jumlah'];
                $ukuran    = $_POST['produk'][$idk]['ukuran'];

                $r = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
                if ($r && mysqli_num_rows($r) > 0) {
                    $produkDibeli[] = array_merge(mysqli_fetch_assoc($r), compact('jumlah', 'ukuran'));
                }
            }
        }

    // Fallback: beli semua isi keranjang jika tombol beli tidak dipisah
    } elseif (isset($_POST['produk'])) {
        foreach ($_POST['produk'] as $id_produk => $jumlah) {
            $ukuran = $_POST['ukuran'][$id_produk] ?? '';
            $r = mysqli_query($koneksi, "SELECT * FROM produk WHERE id_produk='$id_produk'");
            if ($r && mysqli_num_rows($r) > 0) {
                $produkDibeli[] = array_merge(mysqli_fetch_assoc($r), compact('jumlah', 'ukuran'));
            }
        }
    }
}


if (isset($_POST['pilih_keranjang'])) {
  $id_keranjang_terpilih = $_POST['pilih_keranjang'];
  // Gunakan ID ini untuk ambil data dari database sesuai produk yang dipilih saja
}

// ambil data user
$id_users = $_SESSION['id_users'];
$userQ = mysqli_query($koneksi, "SELECT * FROM users WHERE id_users='$id_users'");
$user  = mysqli_fetch_assoc($userQ);

// hitung subtotal & diskon
$subtotal = 0;
foreach ($produkDibeli as $it) {
    $subtotal += $it['harga'] * $it['jumlah'];
}
$discountThreshold = 1000000;
$discountPercent   = 10;
$diskon = $subtotal > $discountThreshold
    ? ($subtotal * $discountPercent / 100)
    : 0;
$totalBeforeOngkir = $subtotal - $diskon;
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pembayaran</title>
  <link rel="stylesheet" href="bootstrap/bootstrap/css/bootstrap.min.css">
</head>
<style>

  .form-section {
    background:#fff; 
    padding:20px; 
    border-radius:10px; 
  }

  .produk-box  { 
    background:#eee; 
    padding:15px; 
    border-radius:10px; 
  }

  .produk-item { 
    display:flex; 
    align-items:center; 
    margin-bottom:10px; 
  }

  .produk-img  { 
    width:80px; 
    margin-right:15px; 
  }

  .total-box  { 
    display:flex; 
    justify-content:space-between; 
    font-weight:bold; 
    margin-top:10px; 
  }

  .form-section .mb-3 {
  display: flex;
  align-items: flex-start;
  margin-bottom: 1rem;
  }

  .form-section .mb-3 label {
    display: inline-block;
    width: 165px;
    font-weight: 500;
    vertical-align: top;
    position: relative;
  }

  .form-section .mb-3 label::after {
    content: ":";
    position: absolute;
    right: 8px; 
  }

  .form-section .mb-3 input,
  .form-section .mb-3 select,
  .form-section .mb-3 textarea {
    flex: 1;
  }

  .info-item {
  display: grid;
  grid-template-columns: 160px 10px auto;
  margin-bottom: 6px;
  font-size: 15px;
  }

  .info-item .label {
    font-weight: 500;
  }

  .info-item .separator {
    text-align: center;
  }

  .info-item .value {
    font-weight: normal;
  }

</style>
<body>
<?php require "navbar.php"; ?>

<div class="container my-5">
  <h3>Pembayaran</h3>
  <form action="proses_pembelian.php" method="post">
    <div class="row">
      <!-- data pener ima -->
      <div class="col-md-5 form-section">
        <?php
        // Asumsikan $user sudah diambil dari session / query sebelumnya
        if (empty($user['nama']) || empty($user['alamat']) || empty($user['email']) || empty($user['no_tlpn'])) {
            echo '<div class="alert alert-warning">
                    Data penerima belum lengkap. Silakan lengkapi terlebih dahulu di 
                    <a href="profil.php" class="alert-link">halaman profil</a>.
                  </div>';
            echo '<a href="profil.php" class="btn btn-primary">Lengkapi Profil</a>';
            exit;
        }
        ?>
        <h5>Data Penerima</h5>
        <div class="container p-3 " style="max-width: 600px;">
          <!-- Nama Lengkap -->
          <div class="row mb-2">
            <div class="col-5">Nama Lengkap</div>
            <div class="col-1 text-center">:</div>
            <div class="col-6"><?php echo $user['nama']; ?></div>
          </div>

          <!-- Alamat Lengkap -->
          <div class="row mb-2">
            <div class="col-5">Alamat Lengkap</div>
            <div class="col-1 text-center">:</div>
            <div class="col-6"><?php echo $user['alamat']; ?></div>
          </div>

          <!-- Email -->
          <div class="row mb-2">
            <div class="col-5">Email</div>
            <div class="col-1 text-center">:</div>
            <div class="col-6"><?php echo $user['email']; ?></div>
          </div>

          <!-- No. HP -->
          <div class="row mb-2">
            <div class="col-5">No. HP</div>
            <div class="col-1 text-center">:</div>
            <div class="col-6">0<?php echo $user['no_tlpn']; ?></div>
          </div>

          <!-- Catatan Tambahan -->
          <div class="row mb-3">
            <div class="col-5">Catatan Tambahan</div>
            <div class="col-1 text-center">:</div>
            <div class="col-6">
              <textarea class="form-control btn-light border-secondary" name="catatan" rows="4"></textarea>
            </div>
          </div>

          <!-- Wilayah Pengiriman -->
          <div class="row mb-3">
            <div class="col-5">Wilayah Pengiriman</div>
            <div class="col-1 text-center">:</div>
            <div class="col-6">
              <select id="region" class="text-center form-select" name="region" onchange="updateOngkir()" required>
                <option value="">-- Pilih Wilayah --</option>
                <option value="jawa">Jawa</option>
                <option value="sumatra">Sumatra</option>
                <option value="sulawesi">Sulawesi</option>
                <option value="kalimantan">Kalimantan</option>
                <option value="bali">Bali</option>
                <option value="papua">Papua</option>
              </select>
            </div>
          </div>
          
        </div>
      </div>

      <!-- ringkasan pesanan yang dibeli -->
      <div class="col-md-7">
        <div class="produk-box">
          <h5>Pesanan Anda</h5>
          <?php foreach ($produkDibeli as $it): ?>
            <div class="produk-item">
              <img src="../image/<?= htmlspecialchars($it['foto']) ?>"  width="200">
              <div class="col-md-6 ">
                <div class="info-item">
                  <span class="label">Nama Sepatu</span>
                  <span class="separator">:</span>
                  <span class="value"><?= htmlspecialchars($it['nama']) ?></span>
                </div>

                <div class="info-item">
                  <span class="label">Jumlah</span>
                  <span class="separator">:</span>
                  <span class="value"><?= $it['jumlah'] ?></span>
                </div>

                <div class="info-item">
                  <span class="label">Ukuran</span>
                  <span class="separator">:</span>
                  <span class="value"><?= htmlspecialchars($it['ukuran']) ?></span>
                </div>

                <div class="info-item">
                  <span class="label">Harga satuan</span>
                  <span class="separator">:</span>
                  <span class="value">Rp <?= number_format($it['harga'], 0, ',', '.') ?></span>
                </div>
              </div>
            </div>
            <input type="hidden" name="produk[<?= $it['id_produk'] ?>]" value="<?= $it['jumlah'] ?>">
            <input type="hidden" name="ukuran[<?= $it['id_produk'] ?>]" value="<?= $it['ukuran'] ?>">
          <?php endforeach; ?>

          <!-- ringkasan harga -->
          <div class="total-box">
            <span>Subtotal</span>
            <span>Rp <?= number_format($subtotal,0,',','.') ?></span>
          </div>
          <div class="total-box">
            <span>Total sebelum Ongkir</span>
            <span>Rp <span id="preOngkir"><?= number_format($totalBeforeOngkir,0,',','.') ?></span></span>
          </div>
          <div class="total-box">
            <span>Diskon (<?= $discountPercent ?>%)</span>
            <span class="text-danger">- Rp <?= number_format($diskon,0,',','.') ?></span>
          </div>
          <div class="total-box">
            <span>Ongkir</span>
            <span>Rp <span id="ongkirDisplay">0</span></span>
          </div>
          <div class="total-box">
            <span><strong>Total Bayar</strong></span>
            <span><strong>Rp <span id="grandTotal">0</span></strong></span>
          </div>

          <!-- kirim ke proses pesanan-->
          <input type="hidden" name="subtotal" value="<?= $subtotal ?>">
          <input type="hidden" name="diskon" value="<?= $diskon ?>">
          <input type="hidden" name="total_sebelum_ongkir" value="<?= $totalBeforeOngkir ?>">
          <input type="hidden" id="ongkirInput" name="ongkir" value="0">
          <input type="hidden" name="from" value="<?= $_POST['from'] ?? 'keranjang' ?>">
          <input type="hidden" name="nama" value="<?= $_POST['nama'] ?? '' ?>">   

          <button class="btn btn-success w-100 mt-3">Pesan Sekarang</button>
        </div>
      </div>

    </div>
  </form>
</div>

<?php require "footer.php"; ?>

<!-- js untuk tarif ongkir -->
<script>
  // tarif per wilayah 
  const regionRates = {
    jawa: 10000,
    sumatra: 15000,
    sulawesi: 20000,
    kalimantan: 25000,
    bali: 35000,
    papua: 45000
  };
  const pre = <?= $totalBeforeOngkir ?>;

  function updateOngkir() {
    const reg = document.getElementById('region').value;
    const ong = regionRates[reg] || 0;
    document.getElementById('ongkirDisplay').innerText = ong.toLocaleString('id-ID');
    document.getElementById('preOngkir').innerText     = pre.toLocaleString('id-ID');
    const grand = pre + ong;
    document.getElementById('grandTotal').innerText    = grand.toLocaleString('id-ID');
    document.getElementById('ongkirInput').value       = ong;
  }

  document.addEventListener('DOMContentLoaded', updateOngkir);
</script>

</body>
</html>
