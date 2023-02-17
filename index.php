<?php 
  session_start();
  require 'fungsi.php';
  $periksaMasuk = isset($_SESSION["login"]);
  $products = query("SELECT * FROM produk ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="img/favicon.png"/>
  <title>Gerigi Software</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="custom.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-1">
    <div class="container">
        <div class="d-inline-block">
          <a class="navbar-brand" href="">
            <img src="img/logo-gray.png" alt="" class="d-inline-block align-text-top">
          </a>
      </div>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item me-1">
            <a class="nav-link active" aria-current="page" href="#">Beranda</a>
          </li>
          <li class="nav-item me-1">
            <a class="nav-link" href="#tentang"> Tentang Kami</a>
          </li>
          <!-- Akun Saya Menu -->
          <?php if ($periksaMasuk || isset($_COOKIE['x']) && isset($_COOKIE['y'])): ?>
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
          <?php endif; ?>

            <?php if(!($periksaMasuk || isset($_COOKIE['x']) && isset($_COOKIE['y']))): ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Daftar Akun
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="daftar.php">Daftar</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="login.php">Masuk</a></li>
                </ul>
              </li>
            <?php endif; ?>
            <!-- End of Akun Saya Menu -->
        </ul>
      </div>
    </div>
  </div>
  </nav>
  <!-- End of Navbar -->
  
  <!-- Welcome -->
  <section class="text-center container-fluid">
    <div class="row py-lg-5">
      <div class="py-4 col-lg-6 col-md-6 mx-auto">
      <?php if ($periksaMasuk || isset($_COOKIE['x']) && isset($_COOKIE['y'])): ?>
        <h1 class="fw-light-bold">Hai, <?= $_SESSION['nama'] ?></h1><br>
        <h5 class="lead text-dark">Nikmatilah software premium mulai sekarang</h5>
        <h5 class="lead text-dark">hindari perangkat kamu dari virus berbahaya.</h5>
      <?php endif; ?>
      <?php if(!($periksaMasuk || isset($_COOKIE['x']) && isset($_COOKIE['y']))): ?>
        <h1 class="fw-light-bold">Selamat Datang</h1><br>
        <h5 class="lead text-dark">Nikmatilah software premium mulai sekarang.</h5>
        <h5 class="lead text-dark">Hindari perangkat Anda dari virus berbahaya.</h5>
      <?php endif; ?>
      </div>
    </div>
  </section>
  <!-- End of Welcome -->

  <!-- Card -->
  <div class="py-5 bg-light">
    <div class="container">
      
    <h3 class="text-center pb-4 fw-light-bold"><i class="bi bi-tags"></i> Katalog Kami</h3>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">

      <!-- Modal -->
      <div class="modal fade" id="ModalInformasi" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header border-1 pb-2">
              <h5 class="modal-title ms-1"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body pt-2 mx-1">
                <h5></h5>
            </div>
            
            <div class="modal-footer border-0 pt-0 mx-1">
              <a role="button" id="the-link" class="fs-6 container-fluid btn btn-sm btn-success"><i class="bi bi-cart" style="padding-right: 2px;"></i> Beli Sekarang</a>
            </div>
          </div>
        </div>
      </div>
      <!-- End of Modal -->
      
      <!-- Each Card -->
        <?php foreach($products as $product): ?>
          <div class="col">
            <div class="card">
              <img src="fotoProduk/<?= $product["foto"]?>" width="100%" height="225">
              <div class="card-body">
                <h5 class="text-center card-text pb-3"><?= $product["nama"] ?></h5><hr class="mt-0"/>
                <div class="d-flex justify-content-between align-items-center">
                  <small class="text-muted fw-bold"><h6 class="text-danger mt-1">Rp <?= number_format($product["harga"],0,',','.'); ?></h6></small>
                  <div class="btn-group" role="group">
                    <!-- Button for displaying modal -->
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalInformasi" data-link="beli.php?id=<?=$product["id"]?>" data-judul="<?= $product["nama"]?>" data-deskripsi="<?= $product["deskripsi"]?>">
                      <i class="bi bi-info-circle" style="padding-right: 4px;"></i> Informasi
                    </button>
                    <!-- End of button for displaying modal -->
                    <a href="beli.php?id=<?=$product["id"]?>" class="btn btn-sm btn-outline-success" role="button">
                      <i class="bi bi-cart" style="padding-right: 4px;"></i> Beli Sekarang
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <!-- End of Each Card -->

        </div>
      </div>
    </div>
  <!-- End of Card -->

  <!-- Footer -->
  <div class="bg-dark">
    <div class="container py-2">
      <div class="row pt-4 pb-1">
        <div class="col-sm-8 col-md-7">
          <h3 class="fw-light text-light pb-2" id="tentang"> Tentang Kami</h3>
          <p class="text-light">Gerigi Software hadir sebagai solusi dari mahalnya biaya lisensi software yang dijual di pasaran.<br> Berdiri pada tahun 2021 di Surabaya, kami telah dipercaya sebagai partner resmi penyedia lisensi software di Indonesia.</p>
        </div>
        <div class="col-sm-4 offset-md-1">
          <h3 class="fw-light text-light pb-2"> Contact</h3>
          <ul class="list-unstyled" style="font-size:18px;">
            <li class="text-light"><i class="bi bi-whatsapp me-1 text-success"></i> 0812-3456-7890</li>
            <li class="text-light"><i class="bi bi-envelope-plus me-1 text-info"></i> callcenter@gerigi.com</li>
          </ul>
        </div>
    </div>
  </div>

  <!-- Copyright -->
  <div class="border-top border-secondary" style="margin: 0 111px">
    <div class="container-fluid col-12 col-sm-12 justify-content-center text-white bg-dark py-2">
      <h6 class="text-center fw-light mt-2">Copyright &copy; 2021 Gerigi Software</h6>
    </div>
  </div>
  <!-- End of Copyright -->

  <!-- End of Footer -->
  <script>
  var ModalInformasi = document.getElementById('ModalInformasi')
  ModalInformasi.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget
    var judul = button.getAttribute('data-judul')
    var deskripsi = button.getAttribute('data-deskripsi')
    var link = button.getAttribute('data-link')

    var modalTitle = ModalInformasi.querySelector('.modal-title')
    var modalBody = ModalInformasi.querySelector('.modal-body')
    document.querySelector('#the-link').setAttribute('href', link);

    modalTitle.textContent = judul
    modalBody.textContent = deskripsi
  })
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>