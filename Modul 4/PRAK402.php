<?php
session_start();

if (!isset($_SESSION['daftar_mahasiswa'])) {
    $_SESSION['daftar_mahasiswa'] = [];
}

if (isset($_POST['selesai'])) {
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $uts = $_POST['uts'];
    $uas = $_POST['uas'];
    $nilaiAkhir = (0.4 * $uts) + (0.6 * $uas);

    if ($nilaiAkhir >= 80) $huruf = "A";
    elseif ($nilaiAkhir >= 70) $huruf = "B";  
    elseif ($nilaiAkhir >= 60) $huruf = "C";  
    elseif ($nilaiAkhir >= 50) $huruf = "D"; 
    else $huruf = "E"; 

    $_SESSION['daftar_mahasiswa'][] = [
        "Nama" => $nama,
        "NIM" => $nim,
        "UTS" => $uts,
        "UAS" => $uas,
        "Nilai Akhir" => $nilaiAkhir,
        "Huruf" => $huruf
    ];
}

if (isset($_POST['reset'])) {
    $_SESSION['daftar_mahasiswa'] = [];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PRAK402</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        form { margin-bottom: 20px; }
        .input-field { margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Input Data Mahasiswa</h2>
    <form method="POST">
        <div class="input-field">
            Nama: <input type="text" name="nama" required>
        </div>
        <div class="input-field">
            NIM: <input type="text" name="nim" required>
        </div>
        <div class="input-field">
            Nilai UTS: <input type="number" name="uts" step="0.1" required>
        </div>
        <div class="input-field">
            Nilai UAS: <input type="number" name="uas" step="0.1" required>
        </div>
        
        <button type="submit" name="selesai">Selesai</button>

        <button type="submit" name="tabel" formnovalidate>Tabel</button>
        <button type="submit" name="reset" formnovalidate>Hapus Semua Data</button>
    </form>

    <?php if (isset($_POST['tabel']) && !empty($_SESSION['daftar_mahasiswa'])): ?>
        <h2>Hasil Akhir</h2>
        <table>
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Nilai UTS</th>
                <th>Nilai UAS</th>
                <th>Nilai Akhir</th>
                <th>Huruf</th>
            </tr>
            <?php foreach ($_SESSION['daftar_mahasiswa'] as $mhs): ?>
            <tr>
                <td><?= htmlspecialchars($mhs["Nama"]) ?></td>
                <td><?= htmlspecialchars($mhs["NIM"]) ?></td>
                <td><?= $mhs["UTS"] ?></td>
                <td><?= $mhs["UAS"] ?></td>
                <td><?= number_format($mhs["Nilai Akhir"], 1) ?></td>
                <td><?= $mhs["Huruf"] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif (isset($_POST['tabel'])): ?>
        <p>Belum ada data yang dimasukkan. Silakan isi form dan klik 'Selesai' terlebih dahulu.</p>
    <?php endif; ?>
</body>
</html>