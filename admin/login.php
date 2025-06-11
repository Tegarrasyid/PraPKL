<?php
session_start();
    require "koneksi.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap/css/bootstrap.min.css">
</head>

<style>
    .main{
        height: 100vh;
    }

    .login-box{
        width: 500px;
        height: 300px;
        box-sizing: border-box;
        border-radius: 15px;

    }
</style>

<body>
<?php require "navbar.php"; ?>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="login-box p-5 shadow">
            <form action="" method="post">
                <div>
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="">
                </div>
                <div >
                    <button class="btn btn-success form-control mt-4" type="submit" name="loginbtn">Login</button><br>
                
                </div>
            </form>
        </div>

        <div class="mt-3" style = "width: 500px">
            <?php 
            if(isset($_POST['loginbtn'])){
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);

                $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
                $countdata = mysqli_num_rows($query);
                $data = mysqli_fetch_array($query);
                
                if($countdata>0){
                    if (password_verify($password, $data['password'])) {
                        $_SESSION['username'] = $data['username'];
                        $_SESSION['login'] = true;
                        header('location: index.php');
                    }else{
                        ?>
                        <div class="alert alert-warning" role="alert">
                        <center>Password Anda Salah</center>
                        </div>
                        <?php 
                    }

                }else{
                    ?>
                    <div class="alert alert-warning" role="alert">
                    <center>Tidak Ada Akun</center>
                    </div>
                    <?php 
                }
            }
            ?>
        </div>
    </div>
</body>
</html>