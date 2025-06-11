<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
</head>

<style>
        .warna{
            background-color: black;
        }

        .content-subscribe a{
            color: white;
        }
    </style>

<body>
        
    <div class="container-fluid py-5 content-subscribe text-light warna mt-5" >
        <div class="container">
            <div class="row">
            
                <div class="col-lg-7 mb-4">
                    <a href="#"><img src="../gambar/besar.png" alt="SHAP logo" class="mb-3" style="max-width: 180px;"></a>
                    <p>SHAP adalah toko sepatu yang menyediakan sepatu berkualitas dan harga yang kompetitif.</p>
                    <p>Alamat: Jl. Mayor Jend. Sungkono No.34, Selabaya, Kec. Kalimanah, Kabupaten Purbalingga, Jawa Tengah 53371</p>
                    <h6 class="mt-4">Follow Us</h6>
                    <div class="d-flex gap-4 mt-2">
                    <a href="https://www.instagram.com/shap_store12" class="text-light fs-4"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.tiktok.com/@zizzy_s"       class="text-light fs-4"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.youtube.com/@shap-f8y"    class="text-light fs-4"><i class="fab fa-youtube"></i></a>
                    <a href="https://x.com/Asyid1337626"           class="text-light fs-4"><i class="fab fa-x-twitter"></i></a>
                    </div>
                </div>

                <!-- Kolom Kanan: Information & Customer Service -->
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-6 mb-4">
                            <h6>Information & Policies</h6>
                        <div class="mt-3">
                            <p>Privacy policies</p>
                        </div>
                        <div >
                            <p>Links</p>
                        </div>
                        <div >
                            <p>Delivery exchange</p>
                        </div>
                        <div >
                            <p>Payment confirmation</p>
                        </div>
                    </div>
                        <div class="col-6 mb-4">
                            <h6>Customer Services</h6>
                            <ul class="list-unstyled mt-3">
                            <li><i class="fab fa-whatsapp "></i> 0813-1418-8288</li>
                            <li><i class="far fa-envelope mt-3"></i> shap@gmail.com</li>
                            </ul>
                        </div>

                </div>

            </div> <!-- /row -->

            <div class="text-center py-3 border-top border-secondary mt-4">
                &copy; Copyright  <?= date('Y') ?> SHAP. All rights reserved.
            </div>

        </div> 

    </div>
</body>
</html>
