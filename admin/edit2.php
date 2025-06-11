<?php
    require "session.php";
    require "koneksi.php";

    $id_produk = $_GET['id'];
    $sql = "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.id_kategori=b.id_kategori WHERE a.id_produk = '$id_produk' ";
    $query = mysqli_query($koneksi, $sql);
    while ($data = mysqli_fetch_assoc($query)) { 

    $querykategori = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id_kategori!='$data[id_kategori]'");

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
    <title>Edit Produk</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/fontawesome/css/fontawesome.min.css">
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
    
    <div class="container mt-5">

    <h2>Edit Produk</h2>
    <div class = "col-md-12 mb-5">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div>
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" value = "<?php echo $data['nama']; ?>" class="form-control" autocomplete="off" >
                    </div>

                    <div>
                        <label for="kategori">Kategori</label>
                            <select name="kategori" id="kategori" class="form-control" >
                                <option value=""><?php echo $data['nama_kategori']; ?></option>
                                    <?php
                                    while($dataKategori=mysqli_fetch_array($querykategori)){
                                    ?>
                                        <option value="<?php echo $dataKategori['id_kategori']; ?>"><?php echo $dataKategori['nama'];  ?></option>
                                    <?php
                                    }
                                    ?>
                            </select>
                    </div>

                    <div>
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" value = "<?php echo $data['harga']; ?>" class="form-control" >
                    </div>

                    <div>
                        <label for="currentFoto">Foto Produk Sekarang :</label><br>
                        <img src="../image/<?php echo $data['foto']; ?>" alt="sepatu" width="350px" >
                    </div>
                    <div>
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <div>
                        <label for="detail">Detail</label>
                        <textarea name="detail" id="detail" cols="30" rows="10" class="form-control">
                            <?php echo trim($data['detail']); ?>
                        </textarea>
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

                    <div>
                        <label for="ketersediaan_stok">Ketersediaan Stok</label>
                        <select name="ketersediaan_stok" id="ketersediaan_stok" class="form-control">
                            <option value="<?php echo $data['ketersediaan_stok']; ?>"><?php echo $data['ketersediaan_stok']; ?></option>
                            <?php
                                if($data['ketersediaan_stok']=='tersedia'){
                                ?>
                                    <option value="habis">habis</option>
                                <?php
                                }else{
                                ?>
                                    <option value="tersedia">tersedia</option>
                                <?php
                                } 
                            ?>
                        </select>
                    </div>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="editproduk">Edit</button>
                </div>
            </div>
        </form>

        <!-- proses edit -->
        <?php
            if(isset($_POST['editproduk'])){
                $nama = htmlspecialchars($_POST['nama']);
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
                        Nama, Kategori, Harga wajib diisi
                    </div>
                    <?php
                }else{
                    $queryUpdate = mysqli_query($koneksi, "UPDATE produk SET nama='$nama',
                    harga='$harga', detail='$detail', ukuran='$ukuran', ketersediaan_stok='$ketersediaan_stok' WHERE id_produk=$id_produk");

                    if($queryUpdate){
                        ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                Produk Berhasil di Edit
                            </div>

                            <meta http-equiv="refresh" content="1 ; url=produk.php" />
                        <?php
                    }

                    if($nama_file!=''){
                        if($image_size > 5000000000000){
                            ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Foto tidak boleh lebih dari 500000 kb
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

                                $queryUpdate = mysqli_query($koneksi, "UPDATE produk SET foto='$baru' WHERE id_produk='$id_produk'");

                                if($queryUpdate){
                                    ?>
                                        <div class="alert alert-primary mt-3" role="alert">
                                            Produk Berhasil di Edit
                                        </div>
            
                                        <meta http-equiv="refresh" content="1 ; url=produk.php" />
                                    <?php
                                }else{
                                    echo mysqli_error($koneksi);
                                }
                            }
                        }
                    }
                }
            }
        ?>
    </div>

    </div>
 

    <script src="../bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
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


</body>
</html>
<?php } ?>