<!DOCTYPE html>
<html>
<head>
    <title>PRAK301</title>
</head>
<body>
    <form method="POST">
        Jumlah Calon Suami: <input type="number" name="Suami"><br>
        <button type="submit" name="submit">Perlihatkan</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $jumlah = $_POST['Suami'];
        $i = 1;
        
        while ($i <= $jumlah) {
            echo "Calon Suami ke-$i <br>";
            $i++;
        }
    }
    ?>
</body>
</html>