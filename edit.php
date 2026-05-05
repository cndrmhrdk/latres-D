<?php
    require "config/db.php";

    if(!isset($_GET['id_aset'])){
        header("Location: index.php");
        exit;
    }

    $id_asset = $_GET['id_aset'];

    $cek_duplikat = false;
    $sukses = false;

    $sql = "SELECT * FROM assets where id_asset = ?";
    $statement = $connect->prepare($sql);
    $statement->bind_param("i", $id_asset);
    $statement->execute();
    $result = $statement->get_result();

    $data_alat = $result->fetch_assoc();

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $serial_number = $_POST['serial_number'];
        $nama_alat = $_POST['nama_alat'];
        $merk_alat = $_POST['merk'];
        $status = $_POST['status'];
        $jumlah_unit = $_POST['jumlah_unit'];
        $url_gambar = $_POST['link_foto_alat'];

        $sql = "SELECT id_asset FROM assets WHERE serial_number = ? AND id_asset != ?";
        $statement = $connect->prepare($sql);
        $statement->bind_param("si", $serial_number, $id_asset);
        $statement->execute();
        $result_for_cek = $statement->get_result();

        if($result_for_cek->num_rows > 0){
            $cek_duplikat = true;
        } else {     
            $sql = "UPDATE assets 
                    SET serial_number = ?, nama_alat = ?, merk = ?, status = ?, jumlah = ?, url_gambar = ? 
                    WHERE id_asset = ?";
                    
            $statement = $connect->prepare($sql);
            $statement->bind_param("ssssisi", $serial_number, $nama_alat, $merk_alat, $status, $jumlah_unit, $url_gambar, $id_asset);
            $statement->execute();

            $sukses = true;
        }  
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
    <title>Edit Alat | Agency Multimedia</title>

    <style>
        :root {
            --bg-dark: #0d0d0f;
            --card-dark: #16161a;
            --accent-color: #82f7ff;
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-muted: #8b949e;
        }

        body {
            background-color: var(--bg-dark);
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .form-container {
            background-color: var(--card-dark);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        }

        .header-section {
            margin-bottom: 30px;
            text-align: center;
        }

        .header-section h2 {
            font-weight: 700;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        label {
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 8px;
            display: block;
        }

        .form-control, .form-select {
            background-color: #0d0d0f !important;
            border: 1px solid var(--glass-border) !important;
            color: #fff !important;
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 0 4px rgba(130, 247, 255, 0.1) !important;
            outline: none;
        }

        .btn-kirim {
            background-color: #ffffff;
            color: #000;
            border: none;
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            font-weight: 700;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .btn-kirim:hover {
            background-color: var(--accent-color);
            transform: translateY(-2px);
        }

        .btn-back {
            color: var(--text-muted);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            font-size: 0.9rem;
            margin-bottom: 20px;
            transition: color 0.3s;
        }

        .btn-back:hover {
            color: #fff;
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 25px;
            }
        }

        input::placeholder{
            color: white !important;
            opacity: 50% !important;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <a href="index.php" class="btn-back">
            <i class="bi bi-arrow-left me-2"></i> Kembali ke Dashboard
        </a>

        <div class="header-section">
            <h2>Edit Informasi Alat</h2>
            <!-- <p class="small opacity-25">Masukkan detail spesifikasi alat multimedia baru</p> -->
        </div>

        <?php if($cek_duplikat): ?>
            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-4 p-3 mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Serial Number sudah terdaftar!
            </div>
        <?php elseif($sukses): ?>
            <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success rounded-4 p-3 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> Berhasil diedit!
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Serial Number</label>
                    <input type="text" class="form-control" name="serial_number" placeholder="<?= $data_alat['serial_number'] ?>" value="<?= $data_alat['serial_number'] ?>" required autocomplete="off">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Nama Alat</label>
                    <input type="text" class="form-control" name="nama_alat" placeholder="<?= $data_alat['nama_alat'] ?>" value="<?= $data_alat['nama_alat'] ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Merk</label>
                    <input type="text" class="form-control" name="merk" placeholder="<?= $data_alat['merk'] ?>" value="<?= $data_alat['merk'] ?>"  required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select class="form-select" name="status" required>
                        <option value="" disabled selected>Pilih status</option>
                        <option value="Tersedia" <?= $data_alat['status'] == 'Tersedia' ? 'selected' : '' ?>>Tersedia</option>
                        <option value="Dipinjam" <?= $data_alat['status'] == 'Dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                        <option value="Maintenance" <?= $data_alat['status'] == 'Maintenance' ? 'selected' : '' ?>>Maintenance</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label>Jumlah Unit</label>
                <input type="number" class="form-control" name="jumlah_unit" placeholder="<?= $data_alat['jumlah'] ?>" value="<?= $data_alat['jumlah'] ?>"  required min="1">
            </div>

            <div class="mb-4">
                <label>Link Foto Alat (URL)</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-secondary border-opacity-25 text-muted"><i class="bi bi-image"></i></span>
                    <input type="text" class="form-control" name="link_foto_alat" placeholder="<?= $data_alat['url_gambar'] ?>" value="<?= $data_alat['url_gambar'] ?>"  required>
                </div>
            </div>

            <button type="submit" class="btn-kirim">
                <i class="bi bi-floppy2-fill"></i> Simpan Perubahan
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>