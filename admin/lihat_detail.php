<?php
session_start();
require "koneksi.php";

$id_pesanan = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT pemesanan.*, 
       produk.nama AS nama, 
       produk.harga, 
       produk.foto, 
       produk.detail,
       users.nama AS nama_user,
       users.email, 
       users.no_tlpn, 
       users.alamat,
       pembayaran.bukti_pembayaran AS bukti
FROM pemesanan 
JOIN produk ON pemesanan.id_produk = produk.id_produk 
JOIN users ON pemesanan.id_users = users.id_users
LEFT JOIN pembayaran ON pemesanan.id_pemesanan = pembayaran.id_pemesanan
WHERE pemesanan.id_pemesanan = '$id_pesanan'
");

$data = mysqli_fetch_assoc($query);

$status_bayar = !empty($data['bukti']) ? 'Sudah Dibayar' : 'Belum Dibayar';
$status_kirim = $data['status'] == '1' ? 'Sudah Dikirim' : 'Belum Dikirim';



// Jika tombol Kirim ditekan
if (isset($_POST['kirim'])) {
    mysqli_query($koneksi, "UPDATE pemesanan SET status = '1' WHERE id_pemesanan = '$id_pesanan'");
    header("Location: pesanan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Pesanan</title>
  <link rel="stylesheet" href="../bootstrap/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../fontawesome/fontawesome/css/fontawesome.min.css">
</head>
<style>

  .no-decor{
      text-decoration: none;
  }

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

  .form-label {
  font-weight: 500;
  margin-bottom: 0.2rem;
  }

  .form-section .mb-3 {

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

</style>
<body>
<?php require "navbar.php"; ?>
<div class="container mt-5">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page">
            <a href="../admin" class="no-decor text-muted"><i class="fas fa-solid fa-house-chimney"></i> Home</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Detail Pemesanan
        </li>
    </ol>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-12 form-section">
        <div class="produk-box">
          <h5>Detail Pesanan</h5>

          <div class="row">
            <!-- Kolom kiri: gambar -->
            <div class="col-md-6">
              <div class="mb-5">
                <label class="form-label">Foto Produk :</label><br>
                <img src="../image/<?= $data['foto'] ?>" class="img-fluid rounded" >
              </div>

              <div class="mb-3">
                <label class="form-label">Catatan Pembelian</label>
                <?= $data['catatan'] ?>
              </div> 

              <div class="mb-3">
                <label class="form-label">Status Pembayaran</label>
                <b class="<?= $status_bayar == 'Sudah Dibayar' ? 'text-success' : 'text-danger' ?>">
                  <?= $status_bayar ?>
                </b>
              </div>

              <div class="mb-3">
                <label class="form-label">Status Pengiriman</label>
                <b class="<?= $status_kirim == 'Sudah Dikirim' ? 'text-success' : 'text-warning' ?>">
                  <?= $status_kirim ?>
                </b>
              </div>

              <div class="mb-3 mt-5">
                <?php if ($data['status'] == '0') : ?>
                  <form method="post">
                    <button type="submit" name="kirim" class="btn btn-primary">Kirim</button>
                  </form>
                <?php endif; ?>
              </div>
            
          </div>

          <!-- Kolom kanan: informasi penerima -->
          <div class="col-md-6">

            <div class="mb-3">
              <label class="form-label">Nama Penerima</label>
              <b><?= $data['nama_user'] ?></b>
            </div>

            <div class="mb-3">
              <label class="form-label">No. HP/Whatsapp</label>
              <b>0<?= $data['no_tlpn'] ?></b>
            </div>

            <div class="mb-3">
              <label class="form-label">Email</label>
              <b><?= $data['email'] ?></b>
            </div>

            <div class="mb-3">
              <label class="form-label">Alamat Penerima</label>
              <b><?= $data['alamat'] ?></b>
            </div>

            <div class="mb-3">
              <label class="form-label">Tanggal Pemesanan</label>
              <b><?= date('d M Y', strtotime($data['tanggal_pemesanan'])) ?></b>
            </div>

            <div class="mb-3">
              <label class="form-label">Nama Sepatu</label>
              <b><?= $data['nama'] ?></b>
            </div>

            <div class="mb-3">
              <label class="form-label">Ukuran Sepatu</label>
              <b><?= $data['ukuran'] ?></b>
            </div>

            <div class="mb-3">
              <label class="form-label">Total Bayar</label>
              <b>Rp <?= number_format($data['total_bayar']) ?></b>
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label">Bukti Pembayaran</label>
                <?php if (!empty($data['bukti'])): ?>
                    <img src="../bukti/<?= htmlspecialchars($data['bukti']) ?>" class="img-fluid rounded" width="200" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <?php else: ?>
                    <div class="text-danger">Belum ada bukti pembayaran</div>
                <?php endif; ?>
              </div>
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Bukti Pembayaran</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <img src="../bukti/<?= htmlspecialchars($data['bukti']) ?>" class="img-fluid rounded" width="5000">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>

            <a href="pesanan.php"><button class="btn btn-dark ">Kembali</button></a><br><br>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
  

  <script src="../bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/fontawesome/js/all.min.js"></script>
</body>
</html>
