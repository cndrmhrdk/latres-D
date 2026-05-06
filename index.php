<?php
    require "config/db.php";

    if(!isset($_SESSION['id_user'])){
        header("Location: login.php");
        exit;
    }

    $sql = "SELECT * FROM assets";
    $statement = $connect->prepare($sql);
    $statement->execute();
    $result = $statement->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <title>DASHBOARD | MAM Agency</title>

    <style>
        :root {
            --bg-dark: #0d0d0f;
            --card-dark: #16161a;
            --accent-color: #82f7ff;
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            background-color: var(--bg-dark);
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: rgba(22, 22, 26, 0.8) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--accent-color) !important;
            font-size: 1.5rem;
        }

        .main-container {
            margin-top: 40px;
            background: var(--card-dark);
            border-radius: 28px;
            border: 1px solid var(--glass-border);
            padding: 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .table-responsive-custom {
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--glass-border);
        }

        table {
            margin-bottom: 0 !important;
            width: 100%;
        }

        thead th {
            background-color: #1f1f23 !important;
            color: #94a3b8 !important;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 20px !important;
            border: none !important;
        }

        .btn-tambah {
            background: #ffffff;
            color: #000;
            font-weight: 700;
            border-radius: 14px;
            padding: 12px 24px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-tambah:hover {
            background: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(130, 247, 255, 0.2);
        }

        .bg-info-subtle td { background-color: #cff4fc !important; color: #055160 !important; }
        .bg-warning-subtle td { background-color: #fff3cd !important; color: #664d03 !important; }
        
        tr:not(.bg-info-subtle):not(.bg-warning-subtle) {
            background-color: #ffffff !important;
            color: #1e293b !important;
        }

        .action-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.2s;
        }

        .action-icon:hover {
            transform: scale(1.15);
            filter: brightness(0.9);
        }
    </style>
</head>
<body>

    <nav class="navbar sticky-top">
        <div class="container px-4">
            <a class="navbar-brand"><i class="bi bi-camera-reels me-2"></i> MAM</a>
            <a href="logout.php?confirmed=yes" class="btn btn-outline-danger border-0 fw-bold">LOGOUT</a>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="main-container">
            
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Asset Inventory</h2>
                    <p class="opacity-25 small mb-0">Manajemen unit kamera, drone, dan lensa agency.</p>
                </div>
                <a href="tambah_alat.php" class="btn btn-tambah">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Alat
                </a>
            </div>

            <div class="table-responsive-custom">
                <?php if($result->num_rows > 0) { ?>
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>SERIAL</th>
                                <th>NAMA ALAT</th>
                                <th>MERK</th>
                                <th>STATUS</th>
                                <th class="text-center">JUMLAH</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; while($rows = $result->fetch_assoc()) : ?>
                                <?php if ($rows['status'] == "Dipinjam") : ?>
                                    <tr class="bg-info-subtle">
                                        <td class="text-center fw-bold"><?= $i ?></td>
                                        <td><code><?= $rows['serial_number'] ?></code></td>
                                        <td class="fw-semibold"><?= $rows['nama_alat'] ?></td>
                                        <td><?= $rows['merk'] ?></td>
                                        <td><span class="badge bg-info py-1 px-3"><?= $rows['status'] ?></span></td>
                                        <td class="text-center"><?= $rows['jumlah'] ?></td>
                                        <td class="text-center">
                                            <a href="detail.php?id_aset=<?= $rows['id_asset'] ?>" class="action-icon text-primary bg-primary-subtle"><i class="bi bi-eye"></i></a>
                                            <a href="edit.php?id_aset=<?= $rows['id_asset'] ?>" class="action-icon text-warning bg-warning-subtle mx-1"><i class="bi bi-pencil-square"></i></a>
                                            <a href="hapus.php?id_aset=<?= $rows['id_asset'] ?>" class="action-icon text-danger bg-danger-subtle" onclick="return confirm('Yakin mau hapus data ini?')"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php elseif ($rows['status'] == "Maintenance") : ?>
                                    <tr class="bg-warning-subtle">
                                        <td class="text-center fw-bold"><?= $i ?></td>
                                        <td><code><?= $rows['serial_number'] ?></code></td>
                                        <td class="fw-semibold"><?= $rows['nama_alat'] ?></td>
                                        <td><?= $rows['merk'] ?></td>
                                        <td><span class="badge bg-warning py-1 px-3 text-dark"><?= $rows['status'] ?></span></td>
                                        <td class="text-center"><?= $rows['jumlah'] ?></td>
                                        <td class="text-center">
                                            <a href="detail.php?id_aset=<?= $rows['id_asset'] ?>" class="action-icon text-primary bg-primary-subtle"><i class="bi bi-eye"></i></a>
                                            <a href="edit.php?id_aset=<?= $rows['id_asset'] ?>" class="action-icon text-warning bg-warning-subtle mx-1"><i class="bi bi-pencil-square"></i></a>
                                            <a href="hapus.php?id_aset=<?= $rows['id_asset'] ?>" class="action-icon text-danger bg-danger-subtle" onclick="return confirm('Yakin mau hapus data ini?')"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php else :?>
                                    <tr class="align-middle">
                                        <td class="text-center fw-bold"><?= $i ?></td>
                                        <td><code><?= $rows['serial_number'] ?></code></td>
                                        <td class="fw-semibold"><?= $rows['nama_alat'] ?></td>
                                        <td><?= $rows['merk'] ?></td>
                                        <td><span class="badge bg-success py-1 px-3"><?= $rows['status'] ?></span></td>
                                        <td class="text-center"><?= $rows['jumlah'] ?></td>
                                        <td class="text-center">
                                            <a href="detail.php?id_aset=<?= $rows['id_asset'] ?>" class="action-icon text-primary bg-primary-subtle"><i class="bi bi-eye"></i></a>
                                            <a href="edit.php?id_aset=<?= $rows['id_asset'] ?>" class="action-icon text-warning bg-warning-subtle mx-1"><i class="bi bi-pencil-square"></i></a>
                                            <a href="hapus.php?id_aset=<?= $rows['id_asset'] ?>" class="action-icon text-danger bg-danger-subtle" onclick="return confirm('Yakin mau hapus data ini?')"><i class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php $i++; endwhile; ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="p-5 text-center">
                        <i class="bi bi-box-seam text-muted" style="font-size: 3rem;"></i>
                        <p class="mt-3 text-muted fw-bold">DATA MASIH KOSONG</p>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>