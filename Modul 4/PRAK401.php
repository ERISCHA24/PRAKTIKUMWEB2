<!DOCTYPE html>
<html>
<head>
    <title>PRAK401</title>
    <style>
        table, tr, td { border: 1px solid black; border-collapse: collapse; padding: 5px; text-align: center; }
    </style>
</head>
<body>
    <form method="POST">
        Panjang: <input type="number" name="panjang" value="<?= isset($_POST['panjang']) ? $_POST['panjang'] : '' ?>"><br>
        Lebar: <input type="number" name="lebar" value="<?= isset($_POST['lebar']) ? $_POST['lebar'] : '' ?>"><br>
        Nilai: <input type="text" name="nilai" value="<?= isset($_POST['nilai']) ? $_POST['nilai'] : '' ?>"><br>
        <button type="submit" name="cetak">Cetak</button>
    </form>

    <?php
    if (isset($_POST['cetak'])) {
        $panjang = $_POST['panjang'];
        $lebar = $_POST['lebar']; 
        $nilai = $_POST['nilai'];
        $isiMatriks = explode(" ", $nilai);

        if (count($isiMatriks) == ($panjang * $lebar)) {
            echo "<table>";
            $index = 0;
            for ($i = 0; $i < $panjang; $i++) {
                echo "<tr>";
                for ($j = 0; $j < $lebar; $j++) {
                    echo "<td>" . htmlspecialchars($isiMatriks[$index]) . "</td>";
                    $index++;
                }
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Panjang nilai tidak sesuai dengan ukuran matriks"; // [cite: 24]
        }
    }
    ?>
</body>
</html>