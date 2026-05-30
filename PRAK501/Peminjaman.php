<?php
require_once 'Model.php';

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    deletePeminjaman($id);
    header("Location: Peminjaman.php?pesan=hapus_berhasil");
    exit;
}

if (isset($_GET['selesai'])) {
    $id = $_GET['selesai'];
    
    // Mengeksekusi fungsi baru Anda dan mengecek hasilnya
    $eksekusi = selesaikanPeminjaman($id);
    
    if ($eksekusi) {
        header("Location: Peminjaman.php?pesan=selesai_berhasil");
    } else {
        header("Location: Peminjaman.php?pesan=selesai_gagal");
    }
    exit;
}

$peminjamans = getAllPeminjaman();
$pesan       = $_GET['pesan'] ?? '';

function hitungStatus($row) {
    if (($row['status'] ?? 'aktif') === 'selesai') return 'selesai';
    $today = date('Y-m-d');
    if ($today > $row['tgl_kembali']) return 'overdue';
    if ($today === $row['tgl_kembali']) return 'today';
    return 'aktif';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peminjaman – Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream: #F5F0E8;
            --brown: #3D2B1F;
            --gold:  #C8960C;
            --rust:  #A63D2F;
            --sage:  #4A6741;
            --blue:  #1e4d8c;
            --light: #FAF8F4;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: var(--cream);
            font-family: 'DM Sans', sans-serif;
            display: flex;
        }

        .sidebar {
            width: 15%;
            min-width: 250px; 
            min-height: 100vh;
            background: var(--brown);
            padding: 40px 24px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex-shrink: 0;
            box-shadow: 4px 0 24px rgba(61,43,31,0.05);
        }

        .sidebar h2 {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: 1.3rem;
            margin-bottom: 8px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }

        .sidebar a {
            display: block;
            padding: 12px 16px;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
            transform: translateX(4px);
        }

        .sidebar a.tambah {
            background: var(--gold);
            color: var(--brown);
            font-weight: 600;
            margin-top: 12px;
            text-align: center;
        }

        .sidebar a.tambah:hover { 
            opacity: 0.9; 
            transform: translateY(-2px);
        }

        .main {
            flex: 1;
            padding: 48px 56px;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 36px;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--brown);
        }

        .alert {
            padding: 14px 24px;
            border-radius: 12px;
            margin-bottom: 28px;
            font-weight: 500;
            font-size: 0.92rem;
        }
        .alert-success { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
        .alert-error   { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }

        .table-wrap {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(61,43,31,0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background: var(--brown);
            color: #fff;
        }

        thead th {
            padding: 18px 20px;
            text-align: left;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        tbody tr {
            border-bottom: 1px solid #f2ede4;
            transition: background 0.15s;
        }

        tbody tr:hover { background: var(--light); }

        tbody td {
            padding: 16px 20px;
            font-size: 0.92rem;
            color: #444;
            vertical-align: middle;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            background: #ede8df;
            color: var(--brown);
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .btn-hapus  { background: var(--rust);  color: #fff; }
        .btn-hapus:hover  { opacity: 0.9; transform: translateY(-1px); }
        .btn-ubah   { background: var(--gold);  color: var(--brown); }
        .btn-ubah:hover   { opacity: 0.9; transform: translateY(-1px); }
        .btn-selesai { background: var(--sage); color: #fff; }
        .btn-selesai:hover { background: #3a5432; }
        .btn-disabled { background: #e5e7eb; color: #9ca3af; cursor: not-allowed; pointer-events: none; }

        .empty-state {
            text-align: center;
            padding: 56px;
            color: #aaa;
            font-size: 1rem;
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <h2>📚 Perpustakaan</h2>
    <a href="Index.php">🏠 Beranda</a>
    <a href="Member.php">👤 Member</a>
    <a href="Buku.php">📖 Buku</a>
    <a href="Peminjaman.php" class="active">🔖 Peminjaman</a>
    <a href="FormPeminjaman.php" class="tambah">+ Tambah Peminjaman</a>
</aside>

<main class="main">
    <div class="page-header">
        <h1 class="page-title">Data Peminjaman</h1>
    </div>

    <?php if ($pesan === 'hapus_berhasil'): ?>
        <div class="alert alert-success">✅ Data peminjaman berhasil dihapus.</div>
    <?php elseif ($pesan === 'simpan_berhasil'): ?>
        <div class="alert alert-success">✅ Data peminjaman berhasil disimpan.</div>
    <?php elseif ($pesan === 'ubah_berhasil'): ?>
        <div class="alert alert-success">✅ Data peminjaman berhasil diperbarui.</div>
    <?php elseif ($pesan === 'selesai_berhasil'): ?>
        <div class="alert alert-success">✅ Peminjaman berhasil diselesaikan.</div>
    <?php elseif ($pesan === 'selesai_gagal'): ?>
        <div class="alert alert-danger">❌ Gagal menyelesaikan peminjaman atau data tidak ditemukan/sudah selesai.</div>
    <?php endif; ?>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Member</th>
                    <th>No. Member</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($peminjamans)): ?>
                    <tr><td colspan="8" class="empty-state">Belum ada data peminjaman.</td></tr>
                <?php else: ?>
                    <?php foreach ($peminjamans as $p): ?>
                    <?php $status = hitungStatus($p); ?>
                    <tr class="<?= $status === 'selesai' ? 'row-selesai' : '' ?>">
                        <td><span class="badge badge-id"><?= htmlspecialchars($p['id_peminjaman']) ?></span></td>
                        <td><strong><?= htmlspecialchars($p['nama_member']) ?></strong></td>
                        <td><?= htmlspecialchars($p['nomor_member']) ?></td>
                        <td><?= htmlspecialchars($p['judul_buku']) ?></td>
                        <td><?= htmlspecialchars($p['tgl_pinjam']) ?></td>
                        <td><?= htmlspecialchars($p['tgl_kembali']) ?></td>
                        <td>
                            <?php if ($status === 'selesai'): ?>
                                <span class="badge badge-selesai">✔ Selesai</span>
                            <?php elseif ($status === 'overdue'): ?>
                                <span class="badge badge-overdue">⚠ Terlambat</span>
                            <?php elseif ($status === 'today'): ?>
                                <span class="badge badge-today">⏰ Hari Ini</span>
                            <?php else: ?>
                                <span class="badge badge-aktif">✓ Aktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="actions">
                                <?php if ($status !== 'selesai'): ?>
                                    <a href="Peminjaman.php?selesai=<?= $p['id_peminjaman'] ?>"
                                        class="btn btn-selesai"
                                        onclick="return confirm('Tandai peminjaman ini sebagai selesai?')">Selesai</a>
                                    <a href="FormPeminjaman.php?id=<?= $p['id_peminjaman'] ?>"
                                       class="btn btn-ubah">Ubah</a>
                                <?php else: ?>
                                    <span class="btn btn-disabled">Selesai</span>
                                <?php endif; ?>
                                <a href="Peminjaman.php?hapus=<?= $p['id_peminjaman'] ?>"
                                   class="btn btn-hapus"
                                   onclick="return confirm('Yakin hapus data peminjaman ini?')">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>