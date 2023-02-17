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

    $idPelanggan = $_SESSION['id'];
    $tampilDataPelanggan = query("SELECT * FROM pembeli WHERE id=$idPelanggan")[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="img/favicon.png"/>
  <title>Checkout</title>
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
  <!-- Content of Checkout -->
  <div class="container">
    <h3 class="text-center mb-3 mt-4 mb-3">Checkout Keranjang Belanja</h3>
    <div class="row">
      <!-- Informasi Pesanan -->
        <div class="col-sm-12 col-md-6">
          <h6 class="fw-normal"><span class="fw-bold">Nama :</span> <?= $tampilDataPelanggan["nama_lengkap"]?></h6>
          <h6 class="fw-normal"><span class="fw-bold">Email :</span> <?= $tampilDataPelanggan["email"]?></h6>
          <h6 class="fw-normal"><span class="fw-bold">Nomor Handphone :</span> <?= '0'.$tampilDataPelanggan["no_telp"]?></h6>
          <h6 class="fw-normal"><span class="fw-bold">Rincian Keranjang Belanja :</span></h6>
          <div class="col-12">
            <table class="table table-bordered border-secondary table-striped table-sm">
              <thead>
                  <tr class="text-center">
                      <th>No</th>
                      <th>Produk</th>
                      <th class="col-3">Jumlah Pembelian</th>
                      <th>Total Harga</th>
                  </tr>
              </thead>
              <tbody>
                <?php $i = 1;
                      $totalBelanja = 0;      
                ?>
                <?php foreach ($_SESSION['basket'] as $id_software => $jumlah): ?>
                    <?php 
                        $perintahQuery = $conn->query("SELECT * FROM produk WHERE id = '$id_software'");
                        $ambilData = $perintahQuery->fetch_assoc();
                        $totalHarga = $ambilData["harga"]*$jumlah;
                    ?>
                    <tr>
                      <td class="text-center"><?= $i ?></td>
                      <td><?= $ambilData["nama"]; ?></td>
                      <td class="text-center"><?= $jumlah ?></td>
                      <td><?= 'Rp '.number_format($totalHarga,0,',','.') ?></td>
                    </tr>
                    <?php $i++; ?>
                    <?php $totalBelanja += $totalHarga?>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                  <tr>
                    <th class="text-end" colspan="3">Total Belanja</th>
                    <th><?= 'Rp '.number_format($totalBelanja,0,',','.') ?></th>
                  </tr>
              </tfoot>
            </table>
            <div class="my-3">
              <h6 class="fw-normal"><span class="fw-bold">Catatan :</span> Lisensi produk akan dikirimkan melalui email</h6>
            </div>
    
            <!-- Tombol -->
            <div class="pb-4">
              <form method="POST" name="checkout">
                <input type="hidden" name="id_pelanggan" value="<?= $_SESSION['id'] ?>">
                <button class="btn btn-sm btn-warning"><a href="keranjang.php" class="text-decoration-none text-dark"><span class="me-1"><i class="bi bi-cart2"></i></span> Kembali ke Keranjang</a></button>
                <button class="btn btn-sm btn-success" name="checkout" onclick="checkout()"><span class="me-1"><i class="bi bi-bag-check"></i></span> Konfirmasi</button>
              </form>
            </div>
            <!-- End of Tombol -->
          </div>
        </div>
        <!-- End of Informasi Pesanan -->

        <!-- Metode Pembayaran -->
        <div class="col-sm-12 col-md-5 offset-md-1 pb-3">
          <div class="card bg-transparent mb-2 border-dark">
            <div class="card-header text-center fw-bold bg-dark text-white">
            <i class="bi bi-save pe-2"></i> Metode Pembayaran
            </div>
            <div class="card-body pb-0">
              <h5 class="card-title">Indomaret / Ceriamart</h5>
              <h6 class="card-text fw-normal">Cara Pembayaran :</h6>
              <ol>
                <li>Klik konfirmasi produk</li>
                <li>Datang ke Indomaret atau Ceriamart</li>
                <li>Tunjukkan kode bayar <span class="fw-bold"><?= 'GS0'.$tampilDataPelanggan["no_telp"] ?></span> ke kasir</li>
                <li>Lakukan pembayaran</li>
                <li>Tunggu pengiriman lisensi 1 x 24 jam melalui email </li>
              </ol>
            </div>
            <div class="card-body border-top pb-0">
              <h5 class="card-title">ATM Transfer</h5>
              <h6 class="card-text fw-normal">Cara Pembayaran :</h6>
              <ol>
                <li>Klik konfirmasi produk</li>
                <li>Kunjungi ATM, kemudian masukkan kartu ATM dan PIN Anda</li>
                <li>Di menu utama, pilih <span class="fw-bold">transaksi lainnya</span> kemudian pilih <span class="fw-bold">transfer</span></li>
                <li>Pilih tujuan rekening <span class="fw-bold">PT Gerigi Software</span> </li>
                <li>Masukkan total pembayaran sebesar <span class="fw-bold"><?= 'Rp '.number_format($totalBelanja,0,',','.') ?></span></li>
                <li>Simpan struk bukti transfer </li>
                <li>Tunggu pengiriman lisensi 1 x 24 jam melalui email </li>
              </ol>
            </div>
          </div>
        </div>
        <!-- End of Metode Pembayaran -->
      </div>
  <!-- End of Content of Checkout -->

  <!-- Data diri ketika checkout -->
    <?php if(isset($_POST["checkout"])){
      $id = $_POST["id_pelanggan"];
      $metodeBayar = $_POST["metodeBayar"];
      $tanggal_pembelian = date("Y-m-d");
      $formatTotalBelanja = 'Rp '.number_format($totalBelanja,0,',','.');

      //menyimpan data ke tabel transaksi
      $ambil = mysqli_query($conn, "INSERT INTO transaksi(pembeli_id, tanggal, total) VALUES ('$id', '$tanggal_pembelian', '$formatTotalBelanja')");
      $nota_pembelian = $conn -> insert_id;

      foreach($_SESSION['basket'] as $id_software => $jumlah) {
        $conn->query("INSERT INTO pembelian (transaksi_nomor, software_id) VALUES ('$nota_pembelian', '$id_software')");
      }

      unset($_SESSION['basket']);
      echo "<script>alert('Pesanan berhasil dikonfirmasi');</script>";
      echo "<script>location='nota.php?nota=$nota_pembelian';</script>";
      }
    ?>
  <!-- End of data diri ketika checkout -->
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