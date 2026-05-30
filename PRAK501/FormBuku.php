<?php
require_once 'Model.php';

$id     = $_GET['id'] ?? null;
$data   = null;
$isEdit = false;
$errors = [];

if ($id) {
    $data   = getBukuById($id);
    $isEdit = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul_buku   = trim($_POST['judul_buku']   ?? '');
    $penulis      = trim($_POST['penulis']      ?? '');
    $penerbit     = trim($_POST['penerbit']     ?? '');
    $tahun_terbit = trim($_POST['tahun_terbit'] ?? '');
    $id_post      = $_POST['id_buku'] ?? null;

    if (empty($judul_buku)) $errors[] = 'Judul buku wajib diisi.';
    if (empty($penulis))    $errors[] = 'Nama penulis wajib diisi.';
    if (!empty($tahun_terbit) && (!is_numeric($tahun_terbit) || $tahun_terbit < 1000 || $tahun_terbit > date('Y'))) {
        $errors[] = 'Tahun terbit tidak valid.';
    }

    if (empty($errors)) {
        if ($id_post) {
            updateBuku($id_post, $judul_buku, $penulis, $penerbit, $tahun_terbit);
            header("Location: Buku.php?pesan=ubah_berhasil");
        } else {
            insertBuku($judul_buku, $penulis, $penerbit, $tahun_terbit);
            header("Location: Buku.php?pesan=simpan_berhasil");
        }
        exit;
    }

    $data = [
        'id_buku'      => $id_post,
        'judul_buku'   => $judul_buku,
        'penulis'      => $penulis,
        'penerbit'     => $penerbit,
        'tahun_terbit' => $tahun_terbit,
    ];
    $isEdit = !empty($id_post);
}

$judulForm = $isEdit ? 'Edit Data Buku' : 'Tambah Data Buku';
$namaBtn   = $isEdit ? 'Simpan Perubahan' : 'Tambahkan Buku';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judulForm ?> – Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream: #F5F0E8;
            --brown: #3D2B1F;
            --gold:  #C8960C;
            --rust:  #A63D2F;
            --sage:  #4A6741;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: var(--cream);
            font-family: 'DM Sans', sans-serif;
            display: flex;
            flex-direction: column; 
        }

        nav {
            background: var(--brown);
            min-height: 7vh; 
            padding: 0 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 16px rgba(61,43,31,0.12);
        }

        nav .brand {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: 1.3rem; 
            font-weight: 700;
        }

        nav a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 0.95rem;
            padding: 10px 20px;
            border: 1.5px solid rgba(255,255,255,0.35);
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        nav a:hover { 
            background: rgba(255,255,255,0.1); 
            color: #fff; 
            border-color: #fff;
        }

        .container {
            flex: 1;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .form-card {
            background: #fff;
            border-radius: 24px;
            padding: 56px; 
            box-shadow: 0 12px 48px rgba(61,43,31,0.12);
            border-top: 6px solid var(--sage);
            width: 60%; 
            max-width: 750px; 
            min-width: 340px; 
        }

        .form-card h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem; 
            color: var(--brown);
            margin-bottom: 8px;
        }

        .form-card p.sub {
            color: #999;
            font-size: 0.92rem;
            margin-bottom: 36px;
        }

        .alert-errors {
            background: #fee2e2;
            border-left: 4px solid #ef4444;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 28px;
            font-size: 0.9rem;
            color: #991b1b;
        }

        .alert-errors ul { padding-left: 20px; }

        .field { margin-bottom: 24px; }

        label {
            display: block;
            font-weight: 600;
            font-size: 0.92rem;
            color: var(--brown);
            margin-bottom: 8px;
        }

        label span.req { color: var(--rust); }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 14px 18px; 
            border: 1.5px solid #dddad4;
            border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.98rem;
            color: #333;
            transition: all 0.18s ease;
            outline: none;
        }

        input:focus { 
            border-color: var(--sage); 
            box-shadow: 0 0 0 3px rgba(74,103,65,0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--sage);
            color: #fff;
            border: none;
            border-radius: 14px;
            font-family: 'DM Sans', sans-serif;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.22s ease;
            margin-top: 12px;
        }

        .btn-submit:hover {
            background: #3a5432;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(74,103,65,0.25);
        }
    </style>
</head>
<body>

<nav>
    <span class="brand">📚 Perpustakaan Digital</span>
    <a href="Buku.php">← Kembali</a>
</nav>

<div class="container">
    <div class="form-card">
        <h1><?= $judulForm ?></h1>
        <p class="sub">Isi informasi buku dengan lengkap dan benar.</p>

        <?php if (!empty($errors)): ?>
            <div class="alert-errors">
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="FormBuku.php<?= $isEdit ? '?id=' . ($data['id_buku'] ?? '') : '' ?>">
            <?php if ($isEdit && isset($data['id_buku'])): ?>
                <input type="hidden" name="id_buku" value="<?= htmlspecialchars($data['id_buku']) ?>">
            <?php endif; ?>

            <div class="field">
                <label>Judul Buku <span class="req">*</span></label>
                <input type="text" name="judul_buku"
                       value="<?= htmlspecialchars($data['judul_buku'] ?? '') ?>"
                       placeholder="Masukkan judul buku">
            </div>

            <div class="field">
                <label>Penulis <span class="req">*</span></label>
                <input type="text" name="penulis"
                       value="<?= htmlspecialchars($data['penulis'] ?? '') ?>"
                       placeholder="Nama penulis">
            </div>

            <div class="field">
                <label>Penerbit</label>
                <input type="text" name="penerbit"
                       value="<?= htmlspecialchars($data['penerbit'] ?? '') ?>"
                       placeholder="Nama penerbit">
            </div>

            <div class="field">
                <label>Tahun Terbit</label>
                <input type="number" name="tahun_terbit"
                       value="<?= htmlspecialchars($data['tahun_terbit'] ?? '') ?>"
                       min="1000" max="<?= date('Y') ?>"
                       placeholder="Contoh: 2023">
            </div>

            <button type="submit" class="btn-submit"><?= $namaBtn ?></button>
        </form>
    </div>
</div>

</body>
</html>