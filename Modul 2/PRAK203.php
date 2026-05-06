<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PRAK203 - Konversi Suhu</title>
</head>
<body>
    <form method="POST">
        Nilai: <input type="number" step="any" name="nilai"><br>
        
        Dari:<br>
        <input type="radio" name="dari" value="Celcius" checked> Celcius<br>
        <input type="radio" name="dari" value="Fahrenheit"> Fahrenheit<br>
        <input type="radio" name="dari" value="Rheamur"> Rheamur<br>
        <input type="radio" name="dari" value="Kelvin"> Kelvin<br>
        
        Ke:<br>
        <input type="radio" name="ke" value="Celcius" checked> Celcius<br>
        <input type="radio" name="ke" value="Fahrenheit"> Fahrenheit<br>
        <input type="radio" name="ke" value="Rheamur"> Rheamur<br>
        <input type="radio" name="ke" value="Kelvin"> Kelvin<br>
        
        <button type="submit" name="konversi">Konversi</button>
    </form>
    <br>

    <?php
    if (isset($_POST['konversi'])) {
        $nilai = $_POST['nilai'];
        $dari = $_POST['dari'];
        $ke = $_POST['ke'];
        $hasil = 0;
        $simbol = "";

        if ($dari == "Celcius") {
            $suhu_c = $nilai;
        } elseif ($dari == "Fahrenheit") {
            $suhu_c = ($nilai - 32) * 5/9;
        } elseif ($dari == "Rheamur") {
            $suhu_c = $nilai * 5/4;
        } elseif ($dari == "Kelvin") {
            $suhu_c = $nilai - 273.15;
        }

        if ($ke == "Celcius") {
            $hasil = $suhu_c;
            $simbol = "°C";
        } elseif ($ke == "Fahrenheit") {
            $hasil = ($suhu_c * 9/5) + 32;
            $simbol = "°F";
        } elseif ($ke == "Rheamur") {
            $hasil = $suhu_c * 4/5;
            $simbol = "°R";
        } elseif ($ke == "Kelvin") {
            $hasil = $suhu_c + 273.15;
            $simbol = "K";
        }

        echo "<strong>Hasil Konversi: " . number_format($hasil, 1) . " $simbol</strong>";
    }
    ?>
</body>
</html>