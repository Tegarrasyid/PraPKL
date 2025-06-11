<?php

require "session.php";
require "koneksi.php";

$sql = "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.id_kategori = b.id_kategori";

if (isset($_GET['kategori']) && $_GET['kategori'] !== "") {
    $kat = mysqli_real_escape_string($koneksi, $_GET['kategori']);
    $sql .= " WHERE a.id_kategori = '$kat'";
}

$sql .= " ORDER BY a.id_produk DESC";

$queryproduk   = mysqli_query($koneksi, $sql);
$jumlahproduk  = mysqli_num_rows($queryproduk);


$querykategori = mysqli_query($koneksi, "SELECT * FROM kategori");


    function generateRandomString($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++){
            $randomString .= $characters[rand(0, $charactersLength -1)];
        }
        return $randomString;
    }
    
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.3.0/ckeditor5.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<style>
    .no-decor{
        text-decoration: none;
    }

    form div{
        margin-bottom: 10px;
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
                    Produk
                </li>
            </ol>
        </nav>

        <div class="my-5 col-12 ">
            <h2>Tambah Produk</h2>
            
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" >
                        </div>

                        <div>
                            <label for="kategori">Kategori</label>
                            <select name="kategori" id="kategori" class="form-control">
                                <option value="">Pilih Kategori</option>
                                <?php while($data=mysqli_fetch_array($querykategori)){ ?>
                                    <option value="<?php echo $data['id_kategori']; ?>"><?php echo $data['nama']; ?></option>
                                <?php } ?>
                            </select> 
                        </div>
                        
                        <div>
                            <label for="harga">Harga</label>
                            <input type="number" name="harga" id="harga" class="form-control" >
                        </div>

                        <div>
                            <label for="foto">Foto</label>
                            <input type="file" name="foto" id="foto" class="form-control">
                        </div>

                        <div>
                            <label for="ukuran">Ukuran</label>
                            <select name="ukuran[]" id="ukuran" class="form-control" multiple="multiple" required>
                                <?php
                                $daftar_ukuran = array("36", "37", "38", "39", "40", "41", "42");
                                $ukuran_terpilih = isset($data['ukuran']) ? explode(',', $data['ukuran']) : [];

                                foreach ($daftar_ukuran as $ukuran) {
                                    $selected = in_array($ukuran, $ukuran_terpilih) ? 'selected' : '';
                                    echo "<option value='$ukuran' $selected>$ukuran</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div>
                            <label for="detail">Detail Produk</label>
                            <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
                        </div>

                    <div>
                        <label for="ketersediaan_stok">Ketersediaan Stok</label>
                        <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                            <option value="tersedia" <?= ($data == 'tersedia') ? 'selected' : '' ?>>Tersedia</option>
                            <option value="habis" <?= ($data == 'habis') ? 'selected' : '' ?>>Habis</option>
                        </select>
                    </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                </div>
            </form>


            <!-- proses tambah produk -->
             <?php
                if(isset($_POST['simpan'])){
                    $nama = htmlspecialchars($_POST['nama']);
                    $kategori = htmlspecialchars($_POST['kategori']);
                    $harga = htmlspecialchars($_POST['harga']);
                    $detail = htmlspecialchars($_POST['detail']);
                    $ukuran = htmlspecialchars(implode(',', $_POST['ukuran']));
                    $ketersediaan_stok = htmlspecialchars($_POST['ketersediaan_stok']);
        
        
                    $target_dir = "../image/";
                    $nama_file =  basename($_FILES["foto"]["name"]);
                    $target_file = $target_dir . $nama_file;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $image_size = $_FILES["foto"]["size"];
                    $random_name = generateRandomString(20);
                    $baru = $random_name . "." . $imageFileType;
        
        
                    if($nama=='' || $harga==''){
                        ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            Nama, Harga wajib diisi
                        </div>
                        <?php
                    }else{
                        if($nama_file!=''){
                            if($image_size > 5000000000000){
                                ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    Foto tidak boleh lebih dari 100000 kb
                                </div>
                                <?php
                            }else{
                                if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif'){
                                    ?>
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Foto wajib bertipe jpg, png, atau gif
                                    </div>
                                    <?php
                                }else{
                                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $baru);
                                }
                            }
                        }

                        // //query insert ke dalam tabel produk
                        $querytambah = mysqli_query($koneksi, "INSERT INTO produk (id_kategori, nama, harga, foto, detail, 
                        ketersediaan_stok, ukuran) VALUES ('$kategori', '$nama', '$harga', '$baru', '$detail', '$ketersediaan_stok', '$ukuran')");


                        if($querytambah){
                        ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                Produk Berhasil di Tambah
                            </div>

                            <meta http-equiv="refresh" content="1 ; url=produk.php" />
                        <?php
                        }else{
                            echo mysqli_error($koneksi);
                        }
                    }
                }
        

             ?>
        </div>


        <div class="mt-3 mb-5">
            <div class="d-flex justify-content-between align-items-center mt-3">
                <h2>List Produk</h2>
                <form method="GET" action="" class="d-flex">
                    <select name="kategori" class="form-select me-2">
                        <option value="">-- Semua Kategori --</option>
                        <?php
                            $query_kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
                            while ($kategori = mysqli_fetch_array($query_kategori)) {
                                $selected = (isset($_GET['kategori']) && $_GET['kategori'] == $kategori['id_kategori']) ? 'selected' : '';
                                echo "<option value='".$kategori['id_kategori']."' $selected>".$kategori['nama']."</option>";
                            }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-bordered table-hover align-middle text-center">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Ukuran</th>
                                <th>Ketersediaan Stok</th>
                                <th>Foto Produk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php
                                if($jumlahproduk==0){
                            ?>
                                <tr>
                                    <td colspan=8 class="text-center">Tidak ada data Produk</td>
                                </tr>
                            <?php
                                }else{
                                    $jumlah=1;
                                    while($data = mysqli_fetch_array($queryproduk)){
                            ?>
                                    <tr>
                                        <td><?= $jumlah ?></td>
                                        <td><?= $data['nama'] ?></td>
                                        <td><?= $data['nama_kategori'] ?></td>
                                        <td><?= $data['harga'] ?></td>
                                        <td><?= $data['ukuran'] ?></td>
                                        <td><?= $data['ketersediaan_stok'] ?></td>
                                        <td><img src="../image/<?= $data['foto'] ?>" width="100"></td>
                                        <td>
                                        <a href="edit2.php?id=<?= $data['id_produk'] ?>" class="btn btn-primary">Edit</a>
                                        <a href="hapus2.php?id=<?= $data['id_produk'] ?>" class="btn btn-danger">Hapus</a>
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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#ukuran').select2({
                placeholder: "Pilih ukuran",
                allowClear: true
            });
        });
    </script>

    <script src="https://cdn.ckeditor.com/ckeditor5/44.3.0/classic/ckeditor.js"></script>

    <script>
    ClassicEditor
        .create( document.querySelector( '#detail' ) )
        .catch( error => {
            console.error( error );
        } );
    </script>

</body>
</html>