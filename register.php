<?php
    require "config/db.php";

    $pesan = "Gagal, konfirmasi password tidak sesuai!";
    $cek = false;
    $cek_duplikat = false;

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $nama = $_POST['nama'];
        $password = $_POST['password'];
        $password_konfirmasi = $_POST['konfirmasi_password'];

        if($password_konfirmasi != $password){
            $cek = true;
        } else {
            $sql = "SELECT * FROM users where username = ?";
            $statement = $connect->prepare($sql);
            $statement->bind_param("s", $nama);
            $statement->execute();
            $result = $statement->get_result();
            
            if($result->num_rows > 0){
                $cek_duplikat = true;
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
                $statement = $connect->prepare($sql);
                $statement->bind_param("ss", $nama, $password_hash);
                $statement->execute();
        
                header("Location: login.php");
                exit; 
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Agency Multimedia</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

    <div class="register-card">
        <h2>Buat Akun</h2>
        <p class="subtitle">Multimedia Asset Management (MAM)</p>

        <?php if($cek == true): ?>
            <div class="alert"><?= $pesan ?></div>
        <?php elseif($cek_duplikat == true): ?>
            <div class="alert">Username sudah digunakan!</div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <input type="text" name="nama" placeholder="Masukkan Username" required autocomplete="off">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Masukkan Password" required>
            </div>
            <div class="form-group">
                <input type="password" name="konfirmasi_password" placeholder="Konfirmasi Password" required>
            </div>
            
            <button type="submit" class="btn-submit">Daftar Sekarang</button>
        </form>

        <p style="text-align: center; margin-top: 25px; font-size: 15px; color: var(--text-muted);">
            Sudah punya akun? <a href="login.php" style="color: var(--text-title); text-decoration: none; font-weight: 500; transition: 0.3s;">Silakan login</a>
        </p>
    </div>


</body>
</html>