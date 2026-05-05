<?php
    require "config/db.php";

    $error_message = ""; 

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $nama = $_POST['nama'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users where username = ?";
        $statement = $connect->prepare($sql);
        $statement->bind_param("s", $nama);
        $statement->execute();
        $result = $statement->get_result();

        if($result->num_rows > 0){
            $data_user = $result->fetch_assoc();

            if(password_verify($password, $data_user['password'])){
                $_SESSION['id_user'] = $data_user['id_user'];
                header("Location: index.php");
                exit;
            } else {
                $error_message = "Password yang kamu masukkan salah!";
            }
        } else {
            $error_message = "Username tidak ditemukan!";
        }
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Agency Multimedia</title>
    
    <!-- Mengambil Font 'Outfit' dari Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Memanggil file CSS yang sama dengan register -->
    <link rel="stylesheet" href="style.css"> 
</head>
<body>

    <!-- Menggunakan class register-card dari CSS yang sudah ada -->
    <div class="register-card">
        <h2>Selamat Datang</h2>
        <p class="subtitle">Silakan login terlebih dahulu</p>

        <!-- Menampilkan kotak error jika login gagal -->
        <?php if($error_message != ""): ?>
            <div class="alert"><?= $error_message ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <input type="text" name="nama" placeholder="Masukkan Username" required autocomplete="off">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Masukkan Password" required>
            </div>
            
            <button type="submit" class="btn-submit">Masuk</button>
        </form>

        <!-- Tambahan link untuk navigasi ke halaman register -->
        <p style="text-align: center; margin-top: 25px; font-size: 15px; color: var(--text-muted);">
            Belum punya akun? <a href="register.php" style="color: var(--text-title); text-decoration: none; font-weight: 500; transition: 0.3s;">Daftar di sini</a>
        </p>
    </div>

</body>
</html>