<?php 
    session_start();
    $id_software = $_GET['id'];

    if(!isset($_SESSION["login"])){
        header("Location: login.php");
        exit;
    }

    //Jika produk sudah ada di keranjang, maka jumlah ditambah 1
    if(isset($_SESSION['basket'][$id_software])){
        $_SESSION['basket'][$id_software] += 1;
    }
    // Jika belum ada di keranjang, maka produk dianggap dibeli 1
    else {
        $_SESSION['basket'][$id_software] = 1;
    }

    //larikan ke halaman keranjang
    echo "<script>alert('Produk telah ditambahkan ke keranjang belanja');</script>";
    echo "<script>location='keranjang.php';</script>"
?>