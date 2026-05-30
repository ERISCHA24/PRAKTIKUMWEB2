<?php
require_once 'Model.php';

$id     = $_GET['id'] ?? null;
$data   = null;
$isEdit = false;
$errors = [];

if ($id) {
    $data   = getMemberById($id);
    $isEdit = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_member        = trim($_POST['nama_member'] ?? '');
    $nomor_member       = trim($_POST['nomor_member'] ?? '');
    $alamat             = trim($_POST['alamat'] ?? '');
    $tgl_mendaftar      = trim($_POST['tgl_mendaftar'] ?? '');
    $tgl_terkahir_bayar = trim($_POST['tgl_terkahir_bayar'] ?? '');
    $id_post            = $_POST['id_member'] ?? null;

    if (empty($nama_member))   $errors[] = 'Nama member wajib diisi.';
    if (empty($nomor_member))  $errors[] = 'Nomor member wajib diisi.';
    if (empty($tgl_mendaftar)) $errors[] = 'Tanggal mendaftar wajib diisi.';

    if (empty($errors)) {
        if ($id_post) {
            updateMember($id_post, $nama_member, $nomor_member, $alamat, $tgl_mendaftar, $tgl_terkahir_bayar);
            header("Location: Member.php?pesan=ubah_berhasil");
        } else {
            insertMember($nama_member, $nomor_member, $alamat, $tgl_mendaftar, $tgl_terkahir_bayar);
            header("Location: Member.php?pesan=simpan_berhasil");
        }
        exit;
    }

    $data = [
        'id_member'          => $id_post,
        'nama_member'        => $nama_member,
        'nomor_member'       => $nomor_member,
        'alamat'             => $alamat,
        'tgl_mendaftar'      => $tgl_mendaftar,
        'tgl_terkahir_bayar' => $tgl_terkahir_bayar,
    ];
    $isEdit = !empty($id_post);
}

$judulForm = $isEdit ? 'Edit Data Member' : 'Tambah Data Member';
$namaBtn   = $isEdit ? 'Simpan Perubahan' : 'Daftarkan Member';
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
            font-size: 0.88rem;
            margin-bottom: 32px;
        }

        .alert-errors {
            background: #fee2e2;
            border-left: 4px solid #ef4444;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 0.88rem;
            color: #991b1b;
        }

        .alert-errors ul { padding-left: 18px; }

        .field {
            margin-bottom: 22px;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 0.88rem;
            color: var(--brown);
            margin-bottom: 7px;
        }

        label span.req { color: var(--rust); }

        input[type="text"],
        input[type="date"],
        input[type="datetime-local"],
        textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #ddd;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            color: #333;
            transition: border-color 0.18s;
            outline: none;
        }

        input:focus, textarea:focus {
            border-color: var(--sage);
        }

        textarea { resize: vertical; min-height: 90px; }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: var(--sage);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
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
    <a href="Member.php">← Kembali</a>
</nav>

<div class="container">
    <div class="form-card">
        <h1><?= $judulForm ?></h1>
        <p class="sub">Lengkapi semua field yang wajib diisi (<span style="color:var(--rust)">*</span>)</p>

        <?php if (!empty($errors)): ?>
            <div class="alert-errors">
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="FormMember.php<?= $isEdit ? '?id=' . ($data['id_member'] ?? '') : '' ?>">
            <?php if ($isEdit && isset($data['id_member'])): ?>
                <input type="hidden" name="id_member" value="<?= htmlspecialchars($data['id_member']) ?>">
            <?php endif; ?>

            <div class="field">
                <label>Nama Member <span class="req">*</span></label>
                <input type="text" name="nama_member"
                       value="<?= htmlspecialchars($data['nama_member'] ?? '') ?>"
                       placeholder="Masukkan nama lengkap">
            </div>

            <div class="field">
                <label>Nomor Member <span class="req">*</span></label>
                <input type="text" name="nomor_member"
                       value="<?= htmlspecialchars($data['nomor_member'] ?? '') ?>"
                       maxlength="15"
                       placeholder="Contoh: M001">
            </div>

            <div class="field">
                <label>Alamat</label>
                <textarea name="alamat" placeholder="Masukkan alamat lengkap"><?= htmlspecialchars($data['alamat'] ?? '') ?></textarea>
            </div>

            <div class="field">
                <label>Tanggal Mendaftar <span class="req">*</span></label>
                <input type="datetime-local" name="tgl_mendaftar"
                       value="<?= htmlspecialchars(
                           isset($data['tgl_mendaftar']) && $data['tgl_mendaftar']
                               ? date('Y-m-d\TH:i', strtotime($data['tgl_mendaftar']))
                               : date('Y-m-d\TH:i')
                       ) ?>">
            </div>

            <div class="field">
                <label>Tanggal Terkahir Bayar</label>
                <input type="date" name="tgl_terkahir_bayar"
                       value="<?= htmlspecialchars($data['tgl_terkahir_bayar'] ?? '') ?>">
            </div>

            <button type="submit" class="btn-submit"><?= $namaBtn ?></button>
        </form>
    </div>
</div>

</body>
</html>