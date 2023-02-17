<?php 
    session_start();
    require 'fungsi.php';
    if(!isset($_SESSION["login"])){
        header("Location: login.php");
        exit;
    }

    if(empty($_SESSION["basket"]) || !isset($_SESSION["basket"])){
        echo "<script>alert('keranjang belanja Anda kosong, silahkan lakukan pembelian terlebih dahulu.');</script>";
        echo "<script>location='index.php';</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="img/favicon.png"/>
  <title>Keranjang Belanja</title>
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
          <li class="nav-item me-1">
            <a class="nav-link active" aria-current="page" href="index.php">Beranda</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Akun Saya
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="riwayat.php?id=<?= $_SESSION['id'] ?>">Riwayat Transaksi</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="logout.php" onclick="return confirm('Apakah Anda yakin untuk Logout?')">Keluar</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
  </nav>
  <!-- End of Navbar -->
  </header>
  
  <main>
  <div class="container">
    <div class="mt-4">
      <h3 class="text-center mb-4">Keranjang Belanja</h3>
        <table class="table table-bordered border-secondary table-striped">
          <thead>
              <tr class="text-center">
                  <th>No</th>
                  <th>Produk</th>
                  <th>Harga satuan</th>
                  <th class="col-2">Jumlah Pembelian</th>
                  <th>Total Harga</th>
                  <th>Aksi</th>
              </tr>
          </thead>
          <tbody>
              <?php $i = 1; ?>
              <?php foreach ($_SESSION['basket'] as $id_software => $jumlah): ?>
                  <?php 
                      $perintahQuery = $conn->query("SELECT * FROM produk WHERE id = '$id_software'");
                      $ambilData = $perintahQuery->fetch_assoc();
                      $totalHarga = $ambilData["harga"]*$jumlah;
                  ?>
                  <tr>
                      <td class="text-center"><?= $i ?></td>
                      <td><?= $ambilData["nama"]; ?></td>
                      <td><?= 'Rp '.number_format($ambilData["harga"],0,',','.') ?></td>
                      <td class="text-center"><?= $jumlah ?></td>
                      <td><?= 'Rp '.number_format($totalHarga,0,',','.') ?></td>
                      <td class="text-center"><a href="hapus.php?id=<?= $id_software ?>" class="btn btn-sm btn-danger"><span class="me-1"><i class="bi bi-bag-x"></i></span> Hapus</a></td>
                  </tr>
                  <?php $i++; ?>
              <?php endforeach; ?>
          </tbody>
        </table>
        <a href="index.php" class="btn btn-sm btn-warning"><span class="me-1"><i class="bi bi-cart2"></i></span> Lanjutkan belanja</a>
        <a href="checkout.php" class="btn btn-sm btn-primary"><span class="me-1"><i class="bi bi-wallet2"></i></span> Checkout</a>
    </div>
  </div>
  </main>

  <!-- Footer -->
  <footer class="footer mt-auto py-2 bg-dark">
    <div class="container mt-1">
      <h6 class="text-center fw-light text-light ps-2">Copyright &copy; 2021 Gerigi Software</h6>
    </div>
  </footer>
  <!-- End of Footer -->
  
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>