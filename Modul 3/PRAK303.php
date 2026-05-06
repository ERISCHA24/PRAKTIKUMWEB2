<!DOCTYPE html>
<html>
<head>
    <title>PRAK303</title>
</head>
<body>
    <form method="POST">
        Batas Bawah: <input type="number" name="bawah"><br>
        Batas Atas: <input type="number" name="atas"><br>
        <button type="submit" name="submit">Cetak</button>
    </form>
    <br>

    <?php
    if (isset($_POST['submit'])) {
        $bawah = $_POST['bawah'];
        $atas = $_POST['atas'];
        
        $star = "star-images-9441.png";

        $i = $bawah;
        do {
            if (($i + 7) % 5 == 0) {
                echo "<img src='$star' width='15px'> ";
            } else {
                echo "$i ";
            }
            $i++;
        } while ($i <= $atas);
    }
    ?>
</body>
</html>