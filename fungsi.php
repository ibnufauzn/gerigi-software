<?php 
    $conn = mysqli_connect("localhost", "root", "", "projectfa_gerigi");

    function query($tangkap_query){
        //Lemari
        global $conn;
        $result = mysqli_query($conn, $tangkap_query);
        
        //Wadah kosong untuk menyimpan baju dari lemari
        $records = [];

        //Mengisi wadah kosong menggunakan baju dari lemari secara satu per satu
        while ($record = mysqli_fetch_assoc($result)) {
            $records[] = $record; 
        }

        //Kembalikan wadah yang sudah berisi baju ke teman
        return $records;
    }

    // Fungsi untuk signup pengguna
    function registrasi($tangkapRegistrasi){
        global $conn;

        $namaLengkap = htmlspecialchars($tangkapRegistrasi["namaLengkap"]);
        $email = htmlspecialchars(strtolower($tangkapRegistrasi["email"])); 
        $password = htmlspecialchars(mysqli_real_escape_string($conn, $tangkapRegistrasi["password"]));
        $password2 = htmlspecialchars(mysqli_real_escape_string($conn, $tangkapRegistrasi["password2"]));
        $noTelp = htmlspecialchars($tangkapRegistrasi["noTelp"]);

        $periksaEmail = mysqli_query($conn, "SELECT email FROM pembeli WHERE email = '$email'");
        $periksaNoTelp = mysqli_query($conn, "SELECT no_telp FROM pembeli WHERE no_telp = $noTelp");

        if(mysqli_fetch_assoc($periksaEmail)){
            echo '<p style="color:red; text-align: center;">Email sudah terdaftar, silahkan gunakan email lain</p>';
            return false;
        }
        else if (strlen($password) < 8) {
            echo '<p style="color:red; text-align: center;">Password harus berisi 8 karakter atau lebih</p>';
            return false;
        }

        else if ($password !== $password2) {
            echo '<p style="color:red; text-align: center;">Konfirmasi password yang dimasukkan tidak sesuai</p>';
            return false;
        }
        else if (mysqli_fetch_assoc($periksaNoTelp)) {
            echo '<p style="color:red; text-align: center;">Nomor handphone sudah terdaftar, silahkan gunakan nomor lain</p>';
            return false;
        }

        //Enkripsi Password
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        mysqli_query($conn, "INSERT INTO pembeli(nama_lengkap, email, password, no_telp) VALUES('$namaLengkap','$email', '$password', '$noTelp');");
        return mysqli_affected_rows($conn);
    }
?>