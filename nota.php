<?php 
    session_start();
    require 'fungsi.php';

    if(!isset($_SESSION["login"])){
      header("Location: login.php");
      exit;
    }

    // Nota transaksi
    $idAkunLogin = $_SESSION['id'];
    $nomorTransaksi = $_GET['nota'];
    $tampilkanTransaksi = $conn -> query("SELECT * FROM transaksi JOIN pembeli ON transaksi.pembeli_id = pembeli.id
                                          WHERE transaksi.nomor=$nomorTransaksi");    
    $detail = $tampilkanTransaksi ->fetch_assoc();

    $totalBelanja = 0;
    $ambil = $conn -> query("SELECT * FROM pembelian JOIN produk ON pembelian.software_id = produk.id
                             WHERE pembelian.transaksi_nomor=$nomorTransaksi");  

    if ($idAkunLogin !== $detail["pembeli_id"]){
      header("Location: riwayat.php?id=$idAkunLogin");
      exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="img/favicon.png"/>
    <title>Nota Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body class="bg-light">
  <header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-1">
      <div class="container">
          <div class="d-inline-block">
            <a class="navbar-brand" href="index.php">
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
                <li><a class="dropdown-item" href="logout.php" onclick="return confirm('Apakah Anda yakin untuk Logout?')">Keluar</a></li>
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
      <div class="row justify-content-center mt-0 my-4 px-1 border-top-0">

        <!-- Menampilkan nota -->
        <div class="card classic shadow p-0 border-dark mb-3 col-lg-6 col-md-8 col-sm-12">
          <div class="card-header bg-dark pb-1">
            <h4 class="text-white text-center"> Nota Transaksi</h4>
          </div>
          <div class="card-body">
            <div class="row">
              <h5 class="card-title text-secondary pb-2 ps-4"><span class="fw-bold">Nomor Pesanan :</span> <?= '#'.$detail['nomor'] ?></h5>
              <div class="col-7 ps-4">
                <h6 class="fw-normal"><span class="fw-bold">Tanggal Transaksi :</span> <?= date("d-m-Y", strtotime($detail['tanggal'])) ?></h6>
                <h6 class="fw-normal"><span class="fw-bold">Nama :</span> <?= $detail['nama_lengkap'] ?></h6>
                <h6 class="fw-normal"><span class="fw-bold">Email :</span> <?= $detail['email'] ?></h6>
                <h6 class="fw-normal"><span class="fw-bold">Nomor Handphone :</span> <?= '0'.$detail['no_telp'] ?></h6>
              </div>
              <div class="col-5">
                <h6 class="fw-bold">Rincian Belanja :</h6>
                  <ol>
                    <?php while($setiap = $ambil->fetch_assoc()): ?>
                      <?php $subharga = $setiap['harga'] * $setiap['jumlah']; ?>            
                      <li><h6 class="fw-normal"><?= $setiap['nama']; ?> (<?= $setiap['jumlah'] ?>)</h6></li>
                      <?php $totalBelanja += $subharga?>
                    <?php endwhile; ?>
                  </ol>
                <h6 class="fw-normal"><span class="fw-bold">Total Pembayaran : </span><?= 'Rp '.number_format($totalBelanja,0,',','.') ?></h6>
              </div>
            </div>
          </div>
          <div class="card-footer bg-secondary">
            <div class="row">
              <div class="col">
                <div class="text-start pt-1">
                  <h6><a href="index.php" class="text-white text-decoration-none"><i class="bi bi-arrow-left pe-1"></i> Kembali ke halaman utama</a></h6>
                </div>
              </div>
              <div class="col">
                <div class="text-end pt-1">
                  <h6><a href="riwayat.php?id=<?= $_SESSION['id'] ?>" class="text-white text-decoration-none">Lihat riwayat transaksi <i class="bi bi-arrow-right ps-1"></i></a></h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End of menampilkan nota -->

      </div>
    </div>
  </main>
  
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>