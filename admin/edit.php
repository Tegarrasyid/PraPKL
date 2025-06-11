<?php
    require "session.php";
    require "koneksi.php";

    $id_kategori = $_GET['id'];
    $sql = "SELECT * FROM kategori WHERE id_kategori = '$id_kategori' ";
    $query = mysqli_query($koneksi, $sql);
    while ($data = mysqli_fetch_assoc($query)) { 
?>

 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
    <link rel="sheet" href="../bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/fontawesome/css/fontawesome.min.css">
</head>
<body>
    <?php require "navbar.php"; ?>
<div class="container mt-5">

<h2>Edit Kategori</h2>
<div class = "col-12 col-md-6">
<form action="" method="post">
    <div>
        <label for="kategori">Kategori</label>
        <input type="text" name="kategori" id="kategori" value = "<?php echo $data['nama']; ?>" 
        class="form-control">
    </div>
    <div class="mt-3">
        <button class="btn btn-primary" type="submit" name="editKategori">Edit</button>
    </div>
</form>

<?php 
    if(isset($_POST['editKategori'])){
        $kategori = htmlspecialchars($_POST['kategori']);

        if($data['nama']==$kategori){
    ?>
                <meta http-equiv="refresh" content="0 ; url=kategori.php" />
    <?php
        }else{
            $query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE nama='$kategori' ");
            $jumlahData = mysqli_num_rows($query);

            if($jumlahData > 0 ){
                ?>
                <div class="alert alert-warning mt-3" role="alert">
                    Kategori Sudah Ada
                </div>
                <?php
            }else{
                $querySimpan = mysqli_query($koneksi, "UPDATE kategori SET nama='$kategori' WHERE id_kategori='$id_kategori'");
                if($querySimpan){
                    ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        Kategori Berhasil di Edit
                    </div>

                    <meta http-equiv="refresh" content="2 ; url=kategori.php" />
                    <?php
                }else{
                    echo mysqli_error($koneksi);
                }
            }
        }
    }
?>
</div>
</div>


<script src="../bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/fontawesome/js/all.min.js"></script>
</body>
</html>
<?php } ?>