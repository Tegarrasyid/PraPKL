<?php
    session_start(); 
    require "koneksi.php";

    // Pastikan user sudah login
    if (!isset($_SESSION['id_users'])) {
        header("Location: login.php");
        exit;
    }

    $_SESSION['from_page'] = 'keranjang.php';
    $id_users = $_SESSION['id_users'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_keranjang'])) {
        $id_keranjang = $_POST['id_keranjang'];

        if (isset($_POST['tambah'])) {
            mysqli_query($koneksi, "UPDATE keranjang SET jumlah_produk = jumlah_produk + 1 WHERE id_keranjang = '$id_keranjang'");
        } elseif (isset($_POST['kurang'])) {
            mysqli_query($koneksi, "UPDATE keranjang SET jumlah_produk = GREATEST(jumlah_produk - 1, 1) WHERE id_keranjang = '$id_keranjang'");
        }else{
            $id_keranjang = $_POST['id_keranjang'];
            $delete = mysqli_query($koneksi, "DELETE FROM keranjang WHERE id_keranjang='$id_keranjang'");
            header("Location: keranjang.php");
            exit();
        }

        exit;
    }

    // PROSES POST: penambahan produk (dari produk_detail.php), update jumlah, atau hapus produk
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // 1. Proses penambahan produk dari produk_detail.php
        if (isset($_POST['masukkan_keranjang'])) {
            if (!isset($_POST['id_produk']) || !isset($_POST['jumlah'])) {
                die("Error: Data tidak lengkap untuk penambahan produk!");
            }
            $id_produk = $_POST['id_produk'];
            $jumlah_produk = (int) $_POST['jumlah'];
            if ($jumlah_produk < 1) {
                $jumlah_produk = 1;
            }
            // Tangkap ukuran yang dikirim
            $ukuran = isset($_POST['ukuran_sepatu']) ? $_POST['ukuran_sepatu'] : '';

            // Cek apakah produk dengan ukuran yang sama sudah ada di keranjang
            $cekKeranjang = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE id_produk='$id_produk' AND ukuran='$ukuran'");
            if (mysqli_num_rows($cekKeranjang) > 0) {
                // Update jumlah jika produk dengan ukuran yang sama sudah ada
                $update = mysqli_query($koneksi, "UPDATE keranjang SET jumlah_produk = jumlah_produk + $jumlah_produk WHERE id_produk='$id_produk' AND ukuran='$ukuran'");
                if (!$update) {
                    die("Error: Gagal update produk di keranjang! " . mysqli_error($koneksi));
                }
            } else {
                // Insert produk baru ke keranjang dengan ukuran
                $insert = mysqli_query($koneksi, "INSERT INTO keranjang (id_users, id_produk, jumlah_produk, ukuran) VALUES ('$id_users', '$id_produk', '$jumlah_produk', '$ukuran')");
                if (!$insert) {
                    die("Error: Gagal menambahkan produk ke keranjang! " . mysqli_error($koneksi));
                }
            }
            header("Location: produk_detail.php?nama=".$_POST['nama_produk']."&status=success");
            exit();
        }
        // 2. Proses update jumlah produk (tombol tambah atau kurang) di halaman keranjang
        elseif (isset($_POST['tambah']) || isset($_POST['kurang'])) {
            if (!isset($_POST['id_keranjang']) || !isset($_POST['jumlah'])) {
                die("Error: Data tidak lengkap untuk update jumlah!");
            }
            $id_keranjang = $_POST['id_keranjang'];
            $jumlah = (int) $_POST['jumlah'];

            if (isset($_POST['tambah'])) {
                $jumlah++;
            } elseif (isset($_POST['kurang']) && $jumlah > 1) {
                $jumlah--;
            }
            $update = mysqli_query($koneksi, "UPDATE keranjang SET jumlah_produk='$jumlah' WHERE id_keranjang='$id_keranjang'");
            if (!$update) {
                die("Error: Gagal update jumlah produk! " . mysqli_error($koneksi));
            }
        }

        header("Location: keranjang.php");
        exit();
    }

    // Mengambil data produk dari keranjang untuk ditampilkan (termasuk kolom ukuran)
    $queryKeranjang = mysqli_query($koneksi, "SELECT keranjang.id_keranjang, produk.id_produk, produk.nama, produk.harga, produk.foto, keranjang.jumlah_produk, keranjang.ukuran FROM keranjang 
        JOIN produk ON keranjang.id_produk = produk.id_produk WHERE keranjang.id_users = '$id_users'"
    );

    // Simpan semua baris dalam array agar bisa diproses ulang (untuk perhitungan ringkasan)
    $keranjangItems = [];
    while ($row = mysqli_fetch_array($queryKeranjang)) {
        $keranjangItems[] = $row;
    }

    // Hitung total harga dari semua produk
    $totalHarga = 0;
    foreach ($keranjangItems as $item) {
        $subtotal = $item['harga'] * $item['jumlah_produk'];
        $totalHarga += $subtotal;
    }

    // Pengaturan diskon
    $discountThreshold = 1000000; // jumlah untuk mendapat diskon
    $discountPercentage = 10;    // diskon 10%
    $discount = 0;
    if ($totalHarga > $discountThreshold) {
        $discount = ($totalHarga * $discountPercentage) / 100;
    }
    $totalBayar = $totalHarga - $discount;
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome/css/all.min.css">
    <style>
        .cart-container { 
            max-width: 900px; 
            margin: auto; 
        }
        .cart-item { 
            border-radius: 10px; 
            background-color: #f8f9fa; 
            padding: 15px; 
            margin-bottom: 15px; 
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1); 
        }
        .cart-img { 
            width: 100px; 
            height: auto; 
            border-radius: 5px; 
        }
        .qty-btn { 
            width: 35px; 
            height: 35px; 
            padding: 5px; 
        }
        .delete-btn:hover { 
            color: darkred; 
        }
        .summary { 
            background: #fff; 
            padding: 15px; 
            border-radius: 10px; 
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1); 
            margin-bottom: 20px; 
        }
        .checkout-btn { 
            background: limegreen; 
            color: white; 
        }
    </style>
</head>
<body>
<?php require "navbar.php"; ?>

<div class="container py-5">
    <h2 class="mb-4">Keranjang Belanja</h2>

<form action="pembayaran.php" method="post">
    <div class="row">
        <!-- Daftar Produk -->
        <div class="col-md-8">
                <?php foreach ($keranjangItems as $produk) { ?>
                <div class="cart-item d-flex align-items-center justify-content-between">

                    <input type="checkbox" name="pilih_keranjang[]" value="<?= $produk['id_keranjang'] ?>" 
                    class="form-check-input me-2 checkbox-produk" style="transform: scale(1.3); border: 2px solid #949496;"

                    data-harga="<?= $produk['harga'] ?>" data-jumlah="<?= $produk['jumlah_produk'] ?>">

                    <img src="../image/<?php echo $produk['foto']; ?>" class="img-fluid rounded" width="150" alt="sepatu">

                    <div class="ms-3 flex-grow-1">
                        <p class="mb-1 fw-bold">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                        <p class="mb-1"><?php echo $produk['nama']; ?></p>
                        <p class="mb-1">Ukuran: <?php echo $produk['ukuran']; ?></p>

                        <div class="d-flex align-items-center mt-2">
                            <button type="button" class="btn btn-light qty-btn kurang-btn" data-id="<?= $produk['id_keranjang'] ?>" data-jumlah="<?= $produk['jumlah_produk'] ?>">-</button>
                            <input type="text" value="<?= $produk['jumlah_produk'] ?>" class="form-control text-center mx-2 jumlah-produk" style="width: 50px;" readonly data-id="<?= $produk['id_keranjang'] ?>">
                            <button type="button" class="btn btn-light qty-btn tambah-btn" data-id="<?= $produk['id_keranjang'] ?>" data-jumlah="<?= $produk['jumlah_produk'] ?>">+</button>
                        </div>
                        
                    </div>
                    <!-- Tombol Hapus -->
                    <form method="post">
                        <input type="hidden" name="id_keranjang" value="<?= $produk['id_keranjang'] ?>">
                        <input type="hidden" name="hapus" value="1">
                        <button type="submit" class="btn delete-btn">
                            <i class="fa-solid fa-trash-can"></i> Hapus
                        </button>
                    </form>
                </div>
                <?php } ?>
                
        </div>

        <!-- Ringkasan Belanja -->
        <div class="col-md-4">
            <div class="summary p-3">
                <h4>Ringkasan</h4>
                <p>Subtotal: Rp <span id="subtotal">0</span></p>
                <p id="diskon" style="display:none;">Diskon (<?= $discountPercentage ?>%): -Rp <span id="diskon-nominal">0</span></p>
                <h5>Total: Rp <span id="total">0</span></h5>

                <?php foreach ($keranjangItems as $produk) { ?>
                    <input type="hidden" name="produk[<?= $produk['id_keranjang'] ?>][id_produk]" value="<?= $produk['id_produk'] ?>">
                    <input type="hidden" name="produk[<?= $produk['id_keranjang'] ?>][jumlah]" value="<?= $produk['jumlah_produk'] ?>">
                    <input type="hidden" name="produk[<?= $produk['id_keranjang'] ?>][ukuran]" value="<?= $produk['ukuran'] ?>">
                <?php } ?>
                <button type="submit" name="beli_sekarang" class="btn btn-success w-100">Beli Sekarang</button>
    
            </div>
        </div>
    </div>

</form>
</div>

<?php require "footer.php"; ?>
<script src="bootstrap/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/fontawesome/js/all.min.js"></script>

<!-- js untuk tombol tambah dan kurang -->
<script>
    document.querySelectorAll('.tambah-btn, .kurang-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id_keranjang = this.getAttribute('data-id');
            const isTambah = this.classList.contains('tambah-btn');

            // Kirim update ke server
            fetch('keranjang.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `id_keranjang=${id_keranjang}&${isTambah ? 'tambah=1' : 'kurang=1'}`
            }).then(() => {
                location.reload(); // Reload untuk ambil jumlah dan harga terbaru dari server
            });
        });
    });
</script>

<!-- js untuk tombol hapus -->
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Yakin ingin menghapus produk ini?')) {
                const form = this.closest('form');
                const formData = new FormData(form);

                fetch('keranjang.php', {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    if (response.ok) {
                        location.reload(); // Reload halaman setelah hapus berhasil
                    } else {
                        alert('Gagal menghapus produk.');
                    }
                });
            }
        });
    });
</script>

<!-- js untuk mengecek semua produk yang akan dibeli -->
<script>
    const checkboxes = document.querySelectorAll('.checkbox-produk');
    const subtotalElem = document.getElementById('subtotal');
    const totalElem = document.getElementById('total');
    const diskonElem = document.getElementById('diskon');
    const diskonNominalElem = document.getElementById('diskon-nominal');
    const discountPercentage = <?= $discountPercentage ?>;
    const discountThreshold = <?= $discountThreshold ?>;

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    function updateRingkasan() {
        let subtotal = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) {
                const harga = parseInt(cb.getAttribute('data-harga'));
                const jumlah = parseInt(cb.getAttribute('data-jumlah'));
                subtotal += harga * jumlah;
            }
        });

        let diskon = 0;
        if (subtotal > discountThreshold) {
            diskon = subtotal * discountPercentage / 100;
            diskonElem.style.display = 'block';
            diskonNominalElem.innerText = formatRupiah(diskon);
        } else {
            diskonElem.style.display = 'none';
        }

        const total = subtotal - diskon;

        subtotalElem.innerText = formatRupiah(subtotal);
        totalElem.innerText = formatRupiah(total);
    }

    // Event listener untuk checkbox
    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateRingkasan);
    });

    // Jalankan pertama kali
    updateRingkasan();
</script>

</body>
</html>
