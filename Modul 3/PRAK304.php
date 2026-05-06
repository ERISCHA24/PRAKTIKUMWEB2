<?php
$bintang = 0;

if (isset($_POST['bintang'])) {
    $bintang = (int)$_POST['bintang'];
}
if (isset($_POST['tambah'])) {
    $bintang++;
}
if (isset($_POST['kurang']) && $bintang > 0) {
    $bintang--;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PRAK304</title>
</head>
<body>
    <?php if ($bintang == 0): ?>
        <form method="POST">
            Jumlah bintang <input type="number" name="bintang" min="1"><br>
            <button type="submit" name="submit">Submit</button>
        </form>
    <?php else: ?>
        <?php
        echo "Jumlah bintang $bintang <br><br>";
        $star = "star-images-9441.png";
        
        for ($i = 0; $i < $bintang; $i++) {
            echo "<img src='$star' width='50px' style='margin-right:5px;'>";
        }
        ?>
        <br><br>
        <form method="POST">
            <input type="hidden" name="bintang" value="<?= $bintang ?>">
            <button type="submit" name="tambah">Tambah</button>
            <button type="submit" name="kurang">Kurang</button>
        </form>
    <?php endif; ?>
</body>
</html>