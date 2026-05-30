<?php
session_start();

if (!isset($_SESSION['data_mahasiswa'])) {
    $_SESSION['data_mahasiswa'] = [];
}

if (isset($_POST['selesai'])) {
    $nama = $_POST['nama'];
    $matkul_input = $_POST['matkul'];
    $sks_input = $_POST['sks'];   
    
    $daftar_matkul = [];
    $totalSks = 0;

    for ($i = 0; $i < count($matkul_input); $i++) {
        if (!empty($matkul_input[$i])) {
            $daftar_matkul[] = [
                "nama" => $matkul_input[$i],
                "sks" => (int)$sks_input[$i]
            ];
            $totalSks += (int)$sks_input[$i];
        }
    }

    if (!empty($nama) && !empty($daftar_matkul)) {
        $keterangan = ($totalSks < 7) ? "Revisi KRS" : "Tidak Revisi";

        $_SESSION['data_mahasiswa'][] = [
            "nama" => $nama,
            "matkul" => $daftar_matkul,
            "total_sks" => $totalSks,
            "keterangan" => $keterangan
        ];
    }
}

if (isset($_POST['reset'])) {
    session_destroy();
    header("Location: PRAK403.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PRAK403</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 8px; }
        th { background-color: #f2f2f2; }
        .form-section { margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; width: fit-content; }
        .matkul-row { margin-bottom: 5px; }
        .revisi { background-color: red; color: white; }
        .tidak-revisi { background-color: green; color: white; }
    </style>
</head>
<body>

    <div class="form-section">
        <h3>Input Data Mahasiswa</h3>
        <form method="POST">
            Nama Mahasiswa: <input type="text" name="nama" required><br><br>
            
            <strong>Daftar Mata Kuliah & SKS:</strong><br>
            <?php for($i=1; $i<=4; $i++):?>
                <div class="matkul-row">
                    <?= $i ?>. Matkul: <input type="text" name="matkul[]" <?= ($i == 1) ? 'required' : '' ?>> 
                    SKS: <input type="number" name="sks[]" style="width: 50px;" <?= ($i == 1) ? 'required' : '' ?>>
                </div>
            <?php endfor; ?>
            <p><small>*Minimal isi 1 mata kuliah</small></p>
            
            <br>
            <button type="submit" name="selesai">Selesai (Tambah Mahasiswa)</button>
            
            <button type="submit" name="tabel" formnovalidate>Tampilkan Tabel</button>
            <button type="submit" name="reset" formnovalidate>Reset Data</button>
        </form>
    </div>

    <?php if (isset($_POST['tabel']) && !empty($_SESSION['data_mahasiswa'])): ?>
    <h3>Hasil Output</h3>
    <table>
        <tr>
            <th>No</th><th>Nama</th><th>Mata Kuliah diambil</th><th>SKS</th><th>Total SKS</th><th>Keterangan</th>
        </tr>
        <?php foreach ($_SESSION['data_mahasiswa'] as $i => $mhs): ?>
            <?php foreach ($mhs["matkul"] as $j => $mk): ?>
                <tr>
                    <td><?= ($j == 0) ? ($i + 1) : "" ?></td>
                    <td><?= ($j == 0) ? htmlspecialchars($mhs["nama"]) : "" ?></td>
                    <td><?= htmlspecialchars($mk["nama"]) ?></td>
                    <td><?= $mk["sks"] ?></td>
                    <td><?= ($j == 0) ? $mhs["total_sks"] : "" ?></td>
                    
                    <?php if ($j == 0): ?>
                        <td class="<?= ($mhs["total_sks"] < 7) ? 'revisi' : 'tidak-revisi' ?>">
                            <?= $mhs["keterangan"] ?>
                        </td>
                    <?php else: ?>
                        <td></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </table>
    <?php elseif (isset($_POST['tabel'])): ?>
        <p>Data masih kosong. Silakan input data dan klik 'Selesai' terlebih dahulu.</p>
    <?php endif; ?>

</body>
</html>