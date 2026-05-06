<?php
$pesan_nama = $pesan_nim = $pesan_jk = "";
$nama = $nim = $jk = "";

if (isset($_POST['submit'])) {
    if (empty($_POST['nama'])) {
        $pesan_nama = "nama tidak boleh kosong";
    } else {
        $nama = $_POST['nama'];
    }

    if (empty($_POST['nim'])) {
        $pesan_nim = "nim tidak boleh kosong";
    } else {
        $nim = $_POST['nim'];
    }

    if (empty($_POST['jk'])) {
        $pesan_jk = "jenis kelamin tidak boleh kosong";
    } else {
        $jk = $_POST['jk'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PRAK202 - Form Validasi</title>
    <style> .error { color: red; } </style>
</head>
<body>
    <form method="POST">
        Nama: <input type="text" name="nama" value="<?= $nama ?>"> 
        <span class="error">* <?= $pesan_nama ?></span><br>
        
        Nim: <input type="text" name="nim" value="<?= $nim ?>"> 
        <span class="error">* <?= $pesan_nim ?></span><br>
        
        Jenis Kelamin: <span class="error">* <?= $pesan_jk ?></span><br>
        <input type="radio" name="jk" value="Laki-Laki" <?= ($jk == 'Laki-Laki') ? 'checked' : '' ?>> Laki-Laki<br>
        <input type="radio" name="jk" value="Perempuan" <?= ($jk == 'Perempuan') ? 'checked' : '' ?>> Perempuan<br>
        
        <button type="submit" name="submit">Submit</button>
    </form>
    <br>

    <?php
    if (!empty($nama) && !empty($nim) && !empty($jk)) {
        echo "<strong>Output:</strong><br>";
        echo "$nama <br>";
        echo "$nim <br>";
        echo "$jk <br>";
    }
    ?>
</body>
</html>