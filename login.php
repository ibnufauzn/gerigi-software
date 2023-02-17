<?php 
    session_start();
    require 'fungsi.php';

    //periksa cookie
    if(isset($_COOKIE['y']) && isset($_COOKIE['x'])){
        $simpanCookieId = hash('sha384', $_COOKIE['y']);
        $simpanCookieEmail = $_COOKIE['x'];

        //ambil email berdasarkan id
        $result = mysqli_query($conn, "SELECT * FROM pembeli WHERE id = $simpanCookieId");
        $ambilId = mysqli_fetch_assoc($result);

        //cek cookie id dan email
        if($simpanCookieEmail === hash('sha384', $ambilId['email']) ) {
            $_SESSION['login'] = true;
        }
    }

    if(isset($_SESSION["login"])){
        header("Location: index.php");
        exit;
    }

    if(isset($_POST["login"])){
        $email = $_POST["email"];
        $pass = $_POST["password"];

        $cekEmail = mysqli_query($conn, "SELECT * FROM pembeli WHERE email= '$email'");
        $pengguna = mysqli_query($conn, "SELECT id, nama_lengkap FROM pembeli WHERE email= '$email'");

        if(mysqli_num_rows($cekEmail) === 1){ //hitung berapa baris dari fungsi select, apabila ketemu nilainya 1
            // cek password
            $user = mysqli_fetch_assoc($cekEmail);
            if (password_verify($pass, $user["password"])) {
                //set session
                $_SESSION["login"] = true;
                $data = mysqli_fetch_assoc($pengguna);
                $jumlahPengguna = mysqli_num_rows($pengguna);
                if ($jumlahPengguna > 0){
                    $_SESSION['id'] = $data['id'];
                    $_SESSION['nama'] = $data['nama_lengkap'];
                }
                //cek cookie
                if(isset($_POST['remember'])){
                    //buat cookie
                    setcookie('x', hash('sha384', $user["email"]), time()+3600);
                    setcookie('y', hash('sha384', $user["id"]), time()+3600);
                }
                //end set session
                header("Location: index.php");
                exit;
            }
        }
        $error = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="img/favicon.png"/>
    <title>Sign in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
</head>
<body>
<header>

<!-- Layout -->
<div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8 col-sm-12">

      <!-- Logo Gerigi Software -->
        <div class="text-center mt-5 mb-4">
          <a href="index.php"><img src="img/logo-dark.png" alt="" class="d-inline-block"></a>
        </div>
      <!-- End of logo Gerigi Software -->
      
        <!-- Wrong Username or Password -->
      <?php if(isset($error)): ?>
        <div class="alert alert-danger alert-dismissible text-center fade show" role="alert">
          Username atau Password salah
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>
      <!-- End of Wrong Username or Password -->

          <!-- Sign in-->
          <div class="card shadow-sm">
            <div class="card-header bg-dark text-light border-bottom-0 pt-3">
              <h4 class="text-center"><i class="bi bi-person-check me-1 fw-bold"></i> SIGN IN</h4>
            </div>
            
            <div class="card-body">
              <form method ="POST">
              <label for="Email" class="form-label fw-bold">Email <span class="text-danger"> *</span></label>
                <div class="input-group mb-3">
                  <span class="input-group-text" style="padding: 0 15px;"><i class="bi bi-envelope"></i></span>
                  <input class="form-control" type="email" name="email" autocomplete="nope" id="Email">
                </div>

                <label for="password" class="form-label fw-bold">Password <span class="text-danger"> *</span></label>
                <div class="input-group mb-3">
                  <span class="input-group-text" style="padding: 0 15px;"><i class="bi bi-key"></i></span>
                  <input class="form-control" type="password" name="password" autocomplete="nope" id="password">
                </div>
                <div class="row">
                  <div class="col ms-1">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat Saya</label><br>
                  </div>
                  <div class="col">
                    <div class="text-end">
                      <h6>Belum punya akun? Daftar <a href="daftar.php">disini</a></h6>
                    </div>
                  </div>
                </div>
                <div class="text-center justify-content-center mt-2 pb-1">
                  <button type="submit" name="login" class="btn btn-dark px-4">Sign in</button>
                </div>
              </form>  
            </div>
          </div>
        <!-- End of sign in-->
      </div>
    </div>
  </div>
  <!-- End of Layout-->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>