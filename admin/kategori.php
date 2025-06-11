<?php
    require "session.php";
    require "koneksi.php";

    $querykategori = mysqli_query($koneksi, "SELECT * FROM kategori");
    $jumlahkategori = mysqli_num_rows($querykategori);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/fontawesome/css/fontawesome.min.css">
</head>
<style>
    .no-decor{
        text-decoration: none;
    }
</style>

<body>
    <?php require "navbar.php"; ?>
    <div class ="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <a href="../admin" class="no-decor text-muted"><i class="fas fa-solid fa-house-chimney"></i> Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                 Kategori
            </li>
        </ol>
    </nav>

        <div class="my-5 col-12 col-md-6">
            <h2>Tambah Kategori</h2>

            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" placeholder="Input Nama Kategori" 
                    class="form-control" required>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="tambahKategori">Tambah</button>
                </div>
            </form>
            

            <!-- Proses Tambah Kategori -->
           <?php
                if(isset($_POST['tambahKategori'])){
                    $kategori = htmlspecialchars($_POST['kategori']);

                    $queryCek = mysqli_query($koneksi, "SELECT nama FROM kategori WHERE nama='$kategori'");
                    $jumlahdatakategori = mysqli_num_rows($queryCek);
                    
                    if($jumlahdatakategori > 0){
                        ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Kategori Sudah Ada
                        </div>
                        <?php
                    }else{
                        $querySimpan = mysqli_query($koneksi, "INSERT INTO kategori (nama) VALUES ('$kategori')");

                        if($querySimpan){
                            ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                Kategori Berhasil di Tambah
                            </div>
 
                            <meta http-equiv="refresh" content="1 ; url=kategori.php" />
                            <?php
                        }else{
                            echo mysqli_error($koneksi);
                        }
                    }
                }
            ?>

        </div>

        <div class="mt-3">
            <h2>List Kategori</h2>

            <div class="table-responsive mt-4">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($jumlahkategori==0){
                        ?>
                            <tr>
                                <td colspan=3 class="text-center">Tidak ada data Kategori</td>
                            </tr>
                        <?php
                            }else{
                                $jumlah=1;

                                while($data = mysqli_fetch_array($querykategori)){
                        ?>
                                 <tr>
                                    <td><?= $jumlah ?></td>
                                    <td><?= $data['nama'] ?></td>
                                    <td>
                                    <a href="edit.php?id=<?= $data['id_kategori'] ?>" class="btn btn-primary">Edit</a>
                                    <a href="hapus.php?id=<?= $data['id_kategori'] ?>" class="btn btn-danger">Hapus</a>
                                    </td>
                                </tr>

                        <?php
                                $jumlah++;
                                }
                            }
                        ?>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>


    <script src="../bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/fontawesome/js/all.min.js"></script>
</body>
</html>