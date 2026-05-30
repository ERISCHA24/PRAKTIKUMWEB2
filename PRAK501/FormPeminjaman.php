<?php
require_once 'Model.php';

$id     = $_GET['id'] ?? null;
$data   = null;
$isEdit = false;
$errors = [];

$members = getAllMember();
$bukus   = getAllBuku();

if ($id) {
    $data   = getPeminjamanById($id);
    $isEdit = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_member    = trim($_POST['id_member']    ?? '');
    $id_buku      = trim($_POST['id_buku']      ?? '');
    $tgl_pinjam   = trim($_POST['tgl_pinjam']   ?? '');
    $tgl_kembali  = trim($_POST['tgl_kembali']  ?? '');
    $id_post      = $_POST['id_peminjaman'] ?? null;

    if (empty($id_member))   $errors[] = 'Member wajib dipilih.';
    if (empty($id_buku))     $errors[] = 'Buku wajib dipilih.';
    if (empty($tgl_pinjam))  $errors[] = 'Tanggal pinjam wajib diisi.';
    if (empty($tgl_kembali)) $errors[] = 'Tanggal kembali wajib diisi.';

    if (!empty($tgl_pinjam) && !empty($tgl_kembali)) {
        if (strtotime($tgl_kembali) < strtotime($tgl_pinjam)) {
            $errors[] = 'Tanggal kembali tidak boleh lebih awal dari tanggal pinjam.';
        }
    }

    if (empty($errors)) {
        if ($id_post) {
            updatePeminjaman($id_post, $id_member, $id_buku, $tgl_pinjam, $tgl_kembali);
            header("Location: Peminjaman.php?pesan=ubah_berhasil");
        } else {
            insertPeminjaman($id_member, $id_buku, $tgl_pinjam, $tgl_kembali);
            header("Location: Peminjaman.php?pesan=simpan_berhasil");
        }
        exit;
    }

    $data = [
        'id_peminjaman' => $id_post,
        'id_member'     => $id_member,
        'id_buku'       => $id_buku,
        'tgl_pinjam'    => $tgl_pinjam,
        'tgl_kembali'   => $tgl_kembali,
    ];
    $isEdit = !empty($id_post);
}

$judulForm = $isEdit ? 'Edit Data Peminjaman' : 'Tambah Data Peminjaman';
$namaBtn   = $isEdit ? 'Simpan Perubahan' : 'Catat Peminjaman';
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
            color: #777;
            font-size: 0.9rem;
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

        .field { margin-bottom: 22px; }

        label {
            display: block;
            font-weight: 600;
            font-size: 0.88rem;
            color: var(--brown);
            margin-bottom: 7px;
        }

        label span.req { color: var(--rust); }

        input[type="date"],
        select {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #ddd;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            color: #333;
            transition: border-color 0.18s;
            outline: none;
            background: #fff;
        }

        input:focus, select:focus { border-color: var(--sage); }

        .row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        input:disabled {
            background: #f5f5f5;
            color: #aaa;
            cursor: not-allowed;
        }

        .hint {
            font-size: 0.78rem;
            color: #999;
            margin-top: 5px;
        }

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
            box-shadow: 0 8px 20px rgba(74,103,65,0.25);
        }

        input.error, select.error {
            border-color: #ef4444;
        }

        /* Responsive Fallback untuk device mobile/tablet */
        @media (max-width: 768px) {
            .container {
                width: 92%;
                min-width: unset;
                margin: 32px auto;
            }
            .form-card {
                padding: 32px 24px;
            }
            .row-2 {
                grid-template-columns: 1fr;
                gap: 0px;
            }
        }
    </style>
</head>
<body>

<nav>
    <span class="brand">📚 Perpustakaan Digital</span>
    <a href="Peminjaman.php">← Kembali </a>
</nav>

<div class="container">
    <div class="form-card">
        <h1><?= $judulForm ?></h1>
        <p class="sub">Pilih member dan buku, kemudian tentukan tanggal peminjaman.</p>

        <?php if (!empty($errors)): ?>
            <div class="alert-errors">
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST"
              action="FormPeminjaman.php<?= $isEdit ? '?id=' . ($data['id_peminjaman'] ?? '') : '' ?>"
              id="formPeminjaman">

            <?php if ($isEdit && isset($data['id_peminjaman'])): ?>
                <input type="hidden" name="id_peminjaman" value="<?= htmlspecialchars($data['id_peminjaman']) ?>">
            <?php endif; ?>

            <div class="field">
                <label>Nama Member <span class="req">*</span></label>
                <select name="id_member" id="id_member" required>
                    <option value="">-- Pilih Member --</option>
                    <?php foreach ($members as $m): ?>
                        <option value="<?= $m['id_member'] ?>"
                            <?= (isset($data['id_member']) && $data['id_member'] == $m['id_member']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['nama_member']) ?> (<?= htmlspecialchars($m['nomor_member']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="field">
                <label>Judul Buku <span class="req">*</span></label>
                <select name="id_buku" id="id_buku" required>
                    <option value="">-- Pilih Buku --</option>
                    <?php foreach ($bukus as $b): ?>
                        <option value="<?= $b['id_buku'] ?>"
                            <?= (isset($data['id_buku']) && $data['id_buku'] == $b['id_buku']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($b['judul_buku']) ?> – <?= htmlspecialchars($b['penulis']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="row-2">
                <div class="field">
                    <label>Tanggal Pinjam <span class="req">*</span></label>
                    <input type="date"
                           name="tgl_pinjam"
                           id="tgl_pinjam"
                           value="<?= htmlspecialchars($data['tgl_pinjam'] ?? date('Y-m-d')) ?>"
                           required>
                </div>

                <div class="field">
                    <label>Tanggal Kembali <span class="req">*</span></label>
                    <input type="date"
                           name="tgl_kembali"
                           id="tgl_kembali"
                           value="<?= htmlspecialchars($data['tgl_kembali'] ?? '') ?>"
                           required>
                    <p class="hint" id="hint_kembali">Harus ≥ tanggal pinjam</p>
                </div>
            </div>

            <button type="submit" class="btn-submit"><?= $namaBtn ?></button>
        </form>
    </div>
</div>

<script>
    const tglPinjamInput   = document.getElementById('tgl_pinjam');
    const tglKembaliInput  = document.getElementById('tgl_kembali');
    const hintKembali      = document.getElementById('hint_kembali');

    function updateMinKembali() {
        const tglPinjam = tglPinjamInput.value;

        if (tglPinjam) {
            tglKembaliInput.min = tglPinjam;

            if (tglKembaliInput.value && tglKembaliInput.value < tglPinjam) {
                tglKembaliInput.value = tglPinjam;
            }

            hintKembali.textContent = 'Minimal: ' + formatTanggal(tglPinjam);
            hintKembali.style.color = '#1e4d8c';
        }
    }

    function formatTanggal(dateStr) {
        if (!dateStr) return '';
        const [y, m, d] = dateStr.split('-');
        const bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        return `${parseInt(d)} ${bulan[parseInt(m)-1]} ${y}`;
    }

    document.getElementById('formPeminjaman').addEventListener('submit', function(e) {
        const tglPinjam  = tglPinjamInput.value;
        const tglKembali = tglKembaliInput.value;

        if (tglPinjam && tglKembali && tglKembali < tglPinjam) {
            e.preventDefault();
            tglKembaliInput.classList.add('error');
            hintKembali.textContent = '⚠ Tanggal kembali tidak boleh sebelum tanggal pinjam!';
            hintKembali.style.color = '#ef4444';
            tglKembaliInput.focus();
        }
    });

    tglKembaliInput.addEventListener('change', function() {
        const tglPinjam  = tglPinjamInput.value;
        const tglKembali = this.value;

        if (tglPinjam && tglKembali && tglKembali < tglPinjam) {
            this.classList.add('error');
            hintKembali.textContent = '⚠ Tanggal kembali tidak boleh sebelum tanggal pinjam!';
            hintKembali.style.color = '#ef4444';
        } else {
            this.classList.remove('error');
            hintKembali.textContent = tglPinjam ? 'Minimal: ' + formatTanggal(tglPinjam) : 'Harus ≥ tanggal pinjam';
            hintKembali.style.color = '#999';
        }
    });

    tglPinjamInput.addEventListener('change', updateMinKembali);

    updateMinKembali();
</script>

</body>
</html>