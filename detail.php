<?php
    require "config/db.php";

    if(!isset($_GET['id_aset'])){
        header("Location: dashboard.php");
        exit;
    }

    $id_asset = $_GET['id_aset'];

    $sql = "SELECT * FROM assets where id_asset = ?";
    $statement = $connect->prepare($sql);
    $statement->bind_param("i", $id_asset);
    $statement->execute();
    $result = $statement->get_result();
    $aset = $result->fetch_assoc();

    if(!$aset){
        echo "Data tidak ditemukan!";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Detail Asset | MAM</title>

    <style>
        :root {
            --bg-dark: #0d0d0f;
            --card-dark: #16161a;
            --accent-color: #82f7ff;
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-muted: #94a3b8;
        }

        body {
            background-color: var(--bg-dark);
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            padding-bottom: 50px;
        }

        .navbar-custom {
            background: rgba(22, 22, 26, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
            padding: 15px 0;
            text-align: center;
            font-weight: 700;
            color: var(--accent-color);
            letter-spacing: 1px;
            margin-bottom: 40px;
        }

        .back-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
            display: inline-block;
            margin-bottom: 20px;
        }

        .back-link:hover { color: #fff; }

        .detail-card {
            background: var(--card-dark);
            border: 1px solid var(--glass-border);
            border-radius: 28px;
            overflow: hidden;
            max-width: 580px;
            margin: 0 auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .image-wrapper {
            width: 100%;
            position: relative;
            padding-top: 75%;
            background: #101014;
        }

        .image-wrapper img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .content-padding {
            padding: 35px;
        }

        .label-sm {
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .info-title {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 0;
        }

        .status-pill {
            float: right;
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .btn-edit-data {
            background-color: #ffffff;
            color: #000000;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .btn-edit-data:hover {
            background-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(130, 247, 255, 0.2);
            color: #000;
        }

        hr {
            border-color: var(--glass-border);
            margin: 25px 0;
            opacity: 1;
        }

        .footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 0.8rem;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

    <div class="navbar-custom">MAM.</div>

    <div class="container">
        <div style="max-width: 580px; margin: 0 auto;">
            <a href="index.php" class="back-link">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
            </a>

            <div class="detail-card">
                <div class="image-wrapper">
                    <img src="<?= $aset['url_gambar'] ?>" alt="<?= $aset['nama_alat'] ?>">
                </div>

                <div class="content-padding">
                    <div class="mb-4">
                        <?php 
                            $status_val = strtolower($aset['status']);
                            $badge_color = 'bg-success';
                            if($status_val == 'dipinjam') $badge_color = 'bg-info';
                            if($status_val == 'maintenance') $badge_color = 'bg-warning text-dark';
                        ?>
                        <span class="status-pill <?= $badge_color ?>"><?= $aset['status'] ?></span>
                        <div class="label-sm">Serial Number</div>
                        <div class="info-title" style="color: var(--accent-color);"><?= $aset['serial_number'] ?></div>
                    </div>

                    <div class="mb-2">
                        <div class="label-sm">Nama Asset / Model</div>
                        <div class="info-title"><?= $aset['nama_alat'] ?></div>
                        <div class="text-muted small mt-1">Merk: <strong><?= $aset['merk'] ?></strong></div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="label-sm">Ketersediaan Stok</div>
                            <div class="info-title"><?= $aset['jumlah'] ?> Unit</div>
                        </div>
                        <a href="edit.php?id_aset=<?= $aset['id_asset'] ?>" class="btn-edit-data">
                            <i class="bi bi-pencil-square me-2"></i>Edit Data
                        </a>
                    </div>
                </div>
            </div>

            <div class="footer-text">
                ID Aset: #<?= str_pad($aset['id_asset'], 5, '0', STR_PAD_LEFT) ?> | Terdaftar dalam sistem manajemen aset multimedia.
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>