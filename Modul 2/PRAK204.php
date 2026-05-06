<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PRAK204 - Ejaan Bilangan</title>
</head>
<body>
    <form method="POST">
        Nilai: <input type="number" name="nilai"><br>
        <button type="submit" name="konversi">Konversi</button>
    </form>
    <br>

    <?php
    if (isset($_POST['konversi'])) {
        $nilai = $_POST['nilai'];
        $hasil = "";

        if ($nilai == 0) {
            $hasil = "Nol";
        } elseif ($nilai >= 1 && $nilai < 10) {
            $hasil = "Satuan";
        } elseif ($nilai >= 11 && $nilai < 20) {
            $hasil = "Belasan";
        } elseif ($nilai == 10 || ($nilai >= 20 && $nilai < 100)) {
            $hasil = "Puluhan";
        } elseif ($nilai >= 100 && $nilai < 1000) {
            $hasil = "Ratusan";
        } elseif ($nilai >= 1000) {
            $hasil = "Anda Menginput Melebihi Limit Bilangan";
        } else {
            $hasil = "Input tidak valid";
        }

        echo "<strong>Hasil: " . $hasil . "</strong>";
    }
    ?>
</body>
</html>