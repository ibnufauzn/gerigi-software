<?php 
  session_start();
  require 'fungsi.php';

  if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
  }

  $tangkapIdAkun = $_GET['id'];
  $akunLogin = $_SESSION['id'];

  if($tangkapIdAkun !== $akunLogin){
    header("Location: riwayat.php?id=$akunLogin");
    exit;
  }

  $buyers = query("SELECT * FROM transaksi WHERE pembeli_id = $akunLogin");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="img/favicon.png"/>
    <title>Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="footer.css">
  </head>
  <body>
    <header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-1">
      <div class="container">
          <div class="d-inline-block">
            <a class="navbar-brand" href="/">
              <img src="img/logo-gray.png" alt="" class="d-inline-block align-text-top">
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item me-3">
              <a class="nav-link active" aria-current="page" href="index.php">Beranda</a>
            </li>
            <li class="nav-item mt-1">
              <a class="nav-link py-1 px-2 btn btn-danger btn-sm text-white" href="logout.php" role="button" onclick="return confirm('Apakah Anda yakin untuk Logout?')";><i class="bi bi-person-x pe-2"></i> Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    </nav>
    <!-- End of Navbar -->
    </header>

    <div class="container">
      <div class="mt-5">
        <h3 class="text-center">Riwayat Transaksi</h3>
      </div>
      <div class="row mt-4 d-flex flex-row justify-content-center">
        <div class="col-8 col-lg-8 col-sm-12">

          <table class="table table-bordered table-striped">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nota Transaksi</th>
                    <th>Status Transaksi</th>
                    <th class="col-2">Total Belanja</th>
                </tr>
            </thead>
            <tbody>
              <?php $i = 1;
                    foreach($buyers as $buyer): ?>
              <tr>
                <td class="text-center align-middle"><?= $i; ?></td>
                <td class="text-center"><a href="nota.php?nota=<?= $buyer['nomor']; ?>" class="text-decoration-none text-primary"><?= $buyer['nomor']; ?></a></td>
                <td class="text-center"><?= $buyer['status']; ?></td>
                <td><?= $buyer['total']; ?></td>
              </tr>
              <?php $i++; ?>
              <?php endforeach; ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-2 bg-dark">
      <div class="container mt-1">
        <h6 class="text-center fw-light text-light ps-2">Copyright &copy; 2021 Gerigi Software</h6>
      </div>
    </footer>
    <!-- End of Footer -->

  </body>
</html>