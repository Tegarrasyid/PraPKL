<?php
require "session.php";
require "koneksi.php";

$querypemesanan = mysqli_query($koneksi, "SELECT
    p.id_pemesanan,
    pr.nama       AS nama_produk,
    pr.foto,
    p.ukuran      AS ukuran_dipesan,  
    p.jumlah_produk,
    p.diskon,
    p.ongkir,
    p.total_bayar,
    p.tanggal_pemesanan
  FROM pemesanan p
  JOIN produk pr ON p.id_produk = pr.id_produk
  ORDER BY p.tanggal_pemesanan DESC
");
$jumlahpemesanan = mysqli_num_rows($querypemesanan);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Admin | Pesanan</title>
  <link rel="stylesheet" href="../bootstrap/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../fontawesome/fontawesome/css/all.min.css">
  <style>
    .no-decor { text-decoration: none; }
    .table img { width: 100px; border-radius: 5px; }
  </style>
</head>
<body>
<?php require "navbar.php"; ?>
<div class="container mt-5">
  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
              <a href="../admin" class="no-decor text-muted"><i class="fas fa-solid fa-house-chimney"></i> Home</a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
              Pesanan
          </li>
      </ol>
  </nav>

  <h2 class="my-5 col-12 col-md-6">List Pesanan</h2>
  <div class="table-responsive mt-4">
    <table class="table table-bordered table-hover align-middle text-center">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Produk</th>
          <th>Foto</th>
          <th>Tanggal</th>
          <th>Ukuran</th>
          <th>Jumlah</th>
          <th>Total Bayar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php if ($jumlahpemesanan == 0): ?>
        <tr><td colspan="10">Belum ada pemesanan</td></tr>
      <?php else: ?>
        <?php $no=1; while($row = mysqli_fetch_assoc($querypemesanan)): ?>
        <tr>
          <td><?= $no ?></td>
          <td><?= ($row['nama_produk']) ?></td>
          <td><img src="../image/<?= htmlspecialchars($row['foto']) ?>" alt=""></td>
          <td><?= date('d M Y', strtotime($row['tanggal_pemesanan'])) ?></td>
          <td><?= htmlspecialchars($row['ukuran_dipesan']) ?></td>
          <td><?= $row['jumlah_produk'] ?> pcs</td>
          <td>Rp <?= number_format($row['total_bayar'],0,',','.') ?></td>
          <td>
            <a href="lihat_detail.php?id=<?= $row['id_pemesanan'] ?>" class="btn btn-primary">Detail</a>
          </td>
        </tr>
        <?php $no++; endwhile; ?>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
 