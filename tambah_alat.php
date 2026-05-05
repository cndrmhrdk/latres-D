<?php
    require "config/db.php";

    if(!isset($_SESSION['id_user'])){
        header("Location: login.php");
        exit;
    }

    $cek_duplikat = false;
    $sukses = false;

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
    <title>Tambah Alat | Agency Multimedia</title>

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

        .info-panel {
            background: #1d1d22;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 30px;
            border: 1px solid var(--glass-border);
        }

        .info-panel h5 {
            color: var(--accent-color);
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .info-list {
            margin: 0;
            padding: 0;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 0;
            font-size: 0.85rem;
            color: var(--text-muted);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item i {
            color: var(--accent-color);
            font-size: 1.1rem;
        }

        .info-item strong {
            color: #fff;
        }

        .alert-note {
            background: rgba(255, 193, 7, 0.08);
            border: 1px solid rgba(255, 193, 7, 0.2);
            border-radius: 10px;
            padding: 12px 15px;
            margin-top: 15px;
            color: #ffc107;
            font-size: 0.8rem;
            line-height: 1.4;
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

        <!-- PANEL INFO TAMBAH ALAT (Sesuai Gambar Referensi) -->
        <div class="info-panel">
            <h5>
                <i class="bi bi-plus-square-fill me-2"></i> Mode Registrasi Alat
            </h5>
            
            <p class="small text-muted mb-2">Anda akan mendaftarkan unit baru. Pastikan untuk:</p>

            <div class="info-list">
                <div class="info-item">
                    <i class="bi bi-check2-circle"></i>
                    <span><strong>Serial Number:</strong> Pastikan sesuai dengan kode fisik yang tertempel pada unit.</span>
                </div>
                <div class="info-item">
                    <i class="bi bi-check2-circle"></i>
                    <span><strong>Kondisi Fisik:</strong> Pilih status sesuai keadaan barang saat masuk ke inventaris.</span>
                </div>
                <div class="info-item">
                    <i class="bi bi-check2-circle"></i>
                    <span><strong>Kelengkapan:</strong> Pastikan unit difoto dengan jelas dan link URL valid.</span>
                </div>
            </div>

            <div class="alert-note">
                <div class="d-flex gap-2">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>Penambahan unit baru akan segera tampil di galeri aset dan dapat langsung diproses untuk peminjaman.</span>
                </div>
            </div>
        </div>

        <div class="header-section">
            <h2>Tambah Unit Alat</h2>
            <p class="small opacity-25">Masukkan detail spesifikasi alat multimedia baru</p>
        </div>

        <?php if($cek_duplikat): ?>
            <div class="alert alert-danger border-0 bg-danger bg-opacity-10 text-danger rounded-4 p-3 mb-4">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Serial Number sudah terdaftar!
            </div>
        <?php elseif($sukses): ?>
            <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success rounded-4 p-3 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> Alat berhasil ditambahkan!
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Serial Number</label>
                    <input type="text" class="form-control" name="serial_number" placeholder="Contoh: CAM-NIKON-001" required autocomplete="off">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Nama Alat</label>
                    <input type="text" class="form-control" name="nama_alat" placeholder="Contoh: Nikon Z 6III" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Merk</label>
                    <input type="text" class="form-control" name="merk" placeholder="Contoh: Nikon" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Status Awal</label>
                    <select class="form-select" name="status" required>
                        <option value="" disabled selected>Pilih status</option>
                        <option value="Tersedia">Tersedia</option>
                        <option value="Dipinjam">Dipinjam</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label>Jumlah Unit</label>
                <input type="number" class="form-control" name="jumlah_unit" placeholder="Contoh: 1" required min="1">
            </div>

            <div class="mb-4">
                <label>Link Foto Alat (URL)</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-secondary border-opacity-25 text-muted"><i class="bi bi-image"></i></span>
                    <input type="text" class="form-control" name="link_foto_alat" placeholder="Contoh: https://contoh.com/kamera-nikon.png" required>
                </div>
            </div>

            <button type="submit" class="btn-kirim">
                <i class="bi bi-cloud-arrow-up-fill me-2"></i>Simpan ke Inventaris
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>