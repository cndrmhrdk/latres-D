<?php

    require "config/db.php";

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

            if($data_user['password'] == $password){
                $_SESSION['id_user'] = $data_user['id_user'];

                header("Location: index.php");
                exit;
            } else {
                echo "password salah";
            }
        } else {
            echo "user tidak ditemuukan";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN PAGE</title>
</head>
<body>
    <form action="" method="POST">
        <br><br>
        <input type="text" name="nama" placeholder="nama" required><br><br>
        <input type="password" name="password" placeholder="password" required><br><br>
        <button type="submit">kirim</button>
    </form>
</body>
</html>