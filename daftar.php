<?php require 'fungsi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="img/favicon.png"/>
  <title>Daftar Akun</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
</head>
<body>
  <!-- Layout -->
  <div class="container my-4">
    <div class="row justify-content-center">
      <div class="col-md-7">

        <!-- Logo Gerigi Software -->
        <div class="text-center mt-5 mb-4">
          <a href="index.php"><img src="img/logo-dark.png" alt="" class="d-inline-block"></a>
        </div>
       <!-- End of logo Gerigi Software -->

      <!-- Alert -->
        <?php if(!isset($_POST["daftar"])): ?>  
          <div class="alert shadow-sm alert-warning alert-dismissible text-center fade show" role="alert">
            Bila Anda sudah memiliki akun di Gerigi Software, silahkan <a href="login.php" class="text-decoration-none">masuk</a> untuk melanjutkan
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

        <?php elseif(registrasi($_POST)): ?>
          <div class="alert shadow alert-success alert-dismissible text-center fade show" role="alert">
            Akun Anda berhasil dibuat, silahkan <a href="login.php" class="text-decoration-none">masuk</a> untuk melanjutkan.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
      <!-- End of Alert -->

        <!-- Sign up-->
        <div class="card shadow">
          <div class="card-header bg-dark text-light text-center pt-3 border-bottom-0">
            <h3><i class="bi bi-person-plus"></i> DAFTAR AKUN</h3>
          </div>
          
          <div class="card-body">
            <form method ="POST">
              <div class="mb-3">
                <label for="nama" class="fw-bold form-label">Nama Lengkap<span class="text-danger"> *</span></label>
                <input type="text" name="namaLengkap" class="form-control" id="nama" autocomplete="nope" required autofocus>
              </div>

              <div class="mb-3">
                <label for="email" class="fw-bold form-label">Alamat Email<span class="text-danger"> *</span></label>
                <input type="email" name="email" class="form-control" id="email" autocomplete="nope" required>
              </div>

              <label class="fw-bold form-label" id="telefon">Nomor Handphone<span class="text-danger"> *</span></label>
              <div class="input-group mb-3">
                <span class="input-group-text" style="padding: 0 15px;"> 0</span>
                <input type="tel" name="noTelp" class="form-control" autocomplete="nope" for="telfon">
              </div>

              <div class="mb-3">
                <label for="password" class="fw-bold form-label">Password<span class="text-danger"> *</span></label>
                <input type="password" name="password" class="form-control" id="password" required>
                <div class="comment small form-text text-muted small form-text text-muted">Password minimal terdapat 8 karakter</div>
              </div>

              <div class="mb-3">
                <label for="password2" class="fw-bold form-label">Konfirmasi Password<span class="text-danger"> *</span></label>
                <input type="password" name="password2" class="form-control" id="password2" required>
              </div>

              <div class="text-center">
                <button type="submit" name="daftar" class="btn btn-dark px-4 mt-2 mb-1 w-100"><span class="fs-5">Daftar</span></button>
              </div>
            </form>  
          </div>
        </div>
        <!-- End of sign up -->

      </div>
    </div>
  </div>
  <!-- End of Layout-->

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>