<?php 
    session_start();
    $id_produk=$_GET["id"];
    unset($_SESSION["basket"][$id_produk]);

    echo "<script>location='keranjang.php';</script>"
?>