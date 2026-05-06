<!DOCTYPE html>
<html>
<head>
    <title>PRAK302</title>
</head>
<body>
    <form method="POST">
        Tinggi: <input type="number" name="tinggi"><br>
        Alamat Gambar: <input type="text" name="alamat_gambar"><br>
        <button type="submit" name="submit">Cetak</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $tinggi = $_POST['tinggi'];
        $gambar = $_POST['alamat_gambar'];
        $i = 1;
        
        while ($i <= $tinggi) {
            $j = 1;
            while ($j < $i) {
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
                $j++;
            }
            $k = $tinggi;
            while ($k >= $i) {
                echo "<img src='$gambar' width='20px' height='20px'>";
                $k--;
            }
            echo "<br>";
            $i++;
        }
    }
    ?>
</body>
</html>