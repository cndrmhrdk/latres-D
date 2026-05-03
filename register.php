<?php

    require "config/db.php";

    $pesan = "gagal, password konfirmasi tidak sesuai";
    $cek = false;
    $cek_duplikat = false;

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $nama = $_POST['nama'];
        $password = $_POST['password'];
        $password_konfirmasi = $_POST['konfirmasi_password'];

        if($password_konfirmasi != $password){
            // header("Location: register.php");
            $cek = true;
            // exit;
        } else {

            $sql = "SELECT * FROM users where username = ?";
            $statement = $connect->prepare($sql);
            $statement->bind_param("s", $nama);
            $statement->execute();
            $result = $statement->get_result();
            
            if($result->num_rows > 0){
                $cek_duplikat = true;
            } else {

                $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
                $statement = $connect->prepare($sql);
                $statement->bind_param("ss", $nama, $password);
                $statement->execute();
        
                header("Location: login.php");
            }

        }

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER PAGE</title>
</head>
<body>
    <center>
        <?php if($cek == true){?>
            <?= $pesan ?>
        <?php } else {?>
            <?php if($cek_duplikat == true) { ?>
                <?= "username sudah digunakan" ?>
            <?php } ?>
        <?php } ?>

        <br><br><br><br><br>
        <form action="" method="POST">
            <input type="text" name="nama" placeholder="masukkan nama" required><br><br>
            <input type="password" name="password" placeholder="masukkan password" required><br><br>
            <input type="password" name="konfirmasi_password" placeholder="konfirmasi password" required><br><br>
            <button type="submit">kirim</button>
        </form>
    </center>
</body>
</html>