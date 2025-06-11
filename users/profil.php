<?php
session_start();
require "koneksi.php";

if (!isset($_SESSION['id_users'])) {
    header("Location: login.php");
    exit;
}

$id_users = $_SESSION['id_users'];
$sql = "SELECT * FROM users WHERE id_users='$id_users'";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profil Pengguna</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<?php require "navbar.php"; ?>


<div class="container-fluid p-4 bg-light my-2">
    <div class="row justify-content-center">
        
        <!-- Sidebar -->
        <div class="row">

            <div class="col-md-3 mt-3">
                <h3><i class="bi bi-list mt-1"></i> Menu</h3>
                <div class="list-group">
                    <a href="profil.php" class="list-group-item list-group-item-action"><i class="fa-solid fa-circle-user"></i> Profil</a>
                    <a href="pesanan.php" class="list-group-item list-group-item-action"><i class="fa-solid fa-bag-shopping"></i> Pesanan</a>
                    <a href="logout.php" class="list-group-item list-group-item-action" id="logout-profil"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                </div>
                <div class="d-grid mt-4 pt-3">
                    <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#editPwModal">Edit Password</button>
                </div>
            </div>

            <!-- Profil User -->
            <div class="col-md-9 mt-3">
                
                <div class ="d-flex justify-content-between align-items-center">
                    <h3 class="col-5"><i class="fa-solid fa-circle-user"></i> Data Diri</h3>
                    <button class="btn text-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                        <a><i class="bi bi-pencil-square"></i> Edit Profil</a>
                    </button>
                </div>
            
                <div class="card">
                    <div class="card-body">
                    
                        <div class="" style="max-width: 600px;">
                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Nama Lengkap</div>
                                <div class="col-7">: <?php echo $data['nama']; ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Alamat Lengkap</div>
                                <div class="col-7">: <?php echo $data['alamat']; ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Email</div>
                                <div class="col-7">: <?php echo $data['email']; ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 fw-bold">No. HP</div>
                                <div class="col-7">: 0<?php echo $data['no_tlpn']; ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Username</div>
                                <div class="col-7">: <?php echo $data['username']; ?></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-5 fw-bold">Password</div>
                                <div class="col-7">: *********</div>
                            </div>
                        </div>

                    </div>
                </div>
                
            </div>
        

            <!-- Modal Edit Profil -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Profil</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form Edit Profil -->
                            <form action="profil_proses_edit.php" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" value="<?php echo $data['nama']; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $data['email']; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">No. HP</label>
                                    <input type="tel" class="form-control" name="no_tlpn" value="<?php echo $data['no_tlpn']; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" value="<?php echo $data['username']; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <input type="text" class="form-control" name="alamat" value="<?php echo $data['alamat']; ?>" required>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name ="update" class="btn btn-primary" href="profil_proses_edit.php">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    

            <!-- Edit Password -->
            <div class="modal fade" id="editPwModal" tabindex="-1" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form Edit Profil -->
                            <form action="profil_password_edit.php" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Password Lama</label>
                                    <input type="password" name="password" id="password" value="<?php echo $data['password']; ?>" readonly class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" name="password_baru" id="password_baru" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" name="konfirmasi_password" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name ="update" class="btn btn-primary" href="profil_proses_edit.php">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<?php require "footer.php"; ?>

<!-- js untuk logout -->
<script>
  document.getElementById("logout-profil").addEventListener("click", function (e) {
    e.preventDefault();
    localStorage.removeItem("isLoggedIn");
    window.location.href = "logout.php";
  });
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>