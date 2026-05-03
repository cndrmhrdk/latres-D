<?php

    require "config/db.php";

    if(!isset($_SESSION['id_user'])){
        header("Location: login.php");
        exit;
    }

    $sql = "SELECT * FROM assets";
    $statement = $connect->prepare($sql);
    // $statement->bind_param)
    $statement->execute();
    $result = $statement->get_result();
    
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>DASHBOARD</title>
</head>
<body class="m-0 p-0">
    <nav class="navbar bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand">Navbar</a>
            <a href="logout.php" class="btn btn-light text-primary">logout</a>
        </div>
    </nav>

    <div class="w-100 p-5 text-end">
        <a href="tambah_alat.php" class="btn btn-dark">+Tambah Alat</a>
    </div>

    <div class="d-flex justify-content-center align-items-center mt-5">
        <table class="align-middle" cellpadding="16">
            <tr class="bg-secondary-subtle">
                <th>NO</th>
                <th>SERIAL</th>
                <th>NAMA ALAT</th>
                <th>MERK</th>
                <th>STATUS</th>
                <th class="text-center">JUMLAH</th>
                <th class="text-center">AKSI</th>
            </tr>

            <?php $i = 1; while($rows = $result->fetch_assoc()) : ?>
                <?php if ($rows['status'] == "Dipinjam") : ?>
                    <tr class="bg-info-subtle align-middle">
                        <td><?= $i ?></td>
                        <td><?= $rows['serial_number'] ?></td>
                        <td><?= $rows['nama_alat'] ?></td>
                        <td><?= $rows['merk'] ?></td>
                        <td><span class="badge bg-info py-1"><?= $rows['status'] ?></span></td>
                        <td class="text-center"><span><?= $rows['jumlah'] ?></span></td>
                        <td class="text-center">
                            <span>
                                <a href="detail.php" class="text-primary bg-primary-subtle p-1 rounded-1"><i class="bi bi-eye"></i></a>
                                <a href="edit.php" class="text-warning bg-warning-subtle p-1 rounded-1"><i class="bi bi-pencil-square"></i></a>
                                <a href="hapus.php" class="text-danger bg-danger-subtle p-1 rounded-1"><i class="bi bi-trash"></i></a>
                            </span>
                        </td>
                    </tr>
                <?php elseif ($rows['status'] == "Maintenance") : ?>
                    <tr class="bg-warning-subtle align-middle">
                        <td><?= $i ?></td>
                        <td><?= $rows['serial_number'] ?></td>
                        <td><?= $rows['nama_alat'] ?></td>
                        <td><?= $rows['merk'] ?></td>
                        <td><span class="badge bg-warning py-1"><?= $rows['status'] ?></span></td>
                        <td class="text-center"><span><?= $rows['jumlah'] ?></span></td>
                        <td class="text-center">
                            <span>
                                <a href="detail.php" class="text-primary bg-primary-subtle p-1 rounded-1"><i class="bi bi-eye"></i></a>
                                <a href="edit.php" class="text-warning bg-warning-subtle p-1 rounded-1"><i class="bi bi-pencil-square"></i></a>
                                <a href="hapus.php" class="text-danger bg-danger-subtle p-1 rounded-1"><i class="bi bi-trash"></i></a>
                            </span>
                        </td>
                    </tr>
                <?php else :?>
                    <tr class="align-middle">
                        <td><?= $i ?></td>
                        <td><?= $rows['serial_number'] ?></td>
                        <td><?= $rows['nama_alat'] ?></td>
                        <td><?= $rows['merk'] ?></td>
                        <td><span class="badge bg-success py-1"><?= $rows['status'] ?></span></td>
                        <td class="text-center"><span><?= $rows['jumlah'] ?></span></td>
                        <td class="text-center">
                            <span>
                                <a href="detail.php" class="text-primary bg-primary-subtle p-1 rounded-1"><i class="bi bi-eye"></i></a>
                                <a href="edit.php" class="text-warning bg-warning-subtle p-1 rounded-1"><i class="bi bi-pencil-square"></i></a>
                                <a href="hapus.php" class="text-danger bg-danger-subtle p-1 rounded-1"><i class="bi bi-trash"></i></a>
                            </span>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php $i++; endwhile; ?>
        </table>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>