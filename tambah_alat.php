<?php

    require "config/db.php";

    if(!isset($_SESSION['id_user'])){
        header("Location: login.php");
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $serial_number = $_POST['serial_number'];
        $nama_alat = $_POST['nama_alat'];
        $merk_alat = $_POST['merk'];
        $status = $_POST['status'];
        $jumlah_unit = $_POST['jumlah_unit'];
        $url_gambar = $_POST['link_foto_alat'];


        $sql = "SELECT * FROM assets where serial_number = ?";
        $statement = $connect->prepare($sql);
        $statement->bind_param("s", $serial_number);
        $statement->execute();
        $result = $statement->get_result();
        
        if($result->num_rows > 0){
            $cek_duplikat = true;
        } else {

            $sql = "INSERT INTO assets (serial_number, nama_alat, merk, status, jumlah, url_gambar) VALUES (?, ?, ?, ?, ?, ?)";
            $statement = $connect->prepare($sql);
            $statement->bind_param("ssssis", $serial_number, $nama_alat, $merk_alat, $status, $jumlah_unit, $url_gambar);
            $statement->execute();
    
            echo "sukses tambah";
        }

    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>ADD TOOLS</title>
</head>
<body>
    <form action="" method="POST">
        <label>Serial Number</label><br>
        <input type="text" name="serial_number" placeholder="Contoh: CAM-NIKON-001" required><br><br>
        <label>Nama Alat</label><br>
        <input type="text" name="nama_alat" placeholder="Contoh: Nikon Z 6III" required><br><br>
        <label>Merk</label><br>
        <input type="text" name="merk" placeholder="Contoh: Nikon" required><br><br>
        <label>Status Awal</label><br>
        <select name="status" id="" required>
            <option value="" disabled selected>Pilih status</option>
            <option value="tersedia">Tersedia</option>
            <option value="dipinjam">Dipinjam</option>
            <option value="maintenance">Maintenance</option>
        </select><br><br>
        <label>Jumlah Unit</label><br>
        <input type="number" name="jumlah_unit" placeholder="1" required><br><br>
        <label>Link Foto Alat (URL)</label><br>
        <input type="text" name="link_foto_alat" placeholder="https://contoh.com/kamera-nikon.png" required><br><br>
        <button type="submit">kirim</button>
    </form>
</body>
</html>