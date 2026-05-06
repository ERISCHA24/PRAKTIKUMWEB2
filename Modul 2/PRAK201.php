<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>PRAK201 - Urut Nama</title>
</head>
<body>
    <form method="POST">
        Nama: 1 <input type="text" name="nama1"><br>
        Nama: 2 <input type="text" name="nama2"><br>
        Nama: 3 <input type="text" name="nama3"><br>
        <button type="submit" name="urutkan">Urutkan</button>
    </form>
    <br>

    <?php
    if (isset($_POST['urutkan'])) {
        $nama1 = $_POST['nama1'];
        $nama2 = $_POST['nama2'];
        $nama3 = $_POST['nama3'];

        if ($nama1 < $nama2 && $nama1 < $nama3) {
            if ($nama2 < $nama3) {
                echo "$nama1 <br> $nama2 <br> $nama3";
            } else {
                echo "$nama1 <br> $nama3 <br> $nama2";
            }
        } elseif ($nama2 < $nama1 && $nama2 < $nama3) {
            if ($nama1 < $nama3) {
                echo "$nama2 <br> $nama1 <br> $nama3";
            } else {
                echo "$nama2 <br> $nama3 <br> $nama1";
            }
        } else {
            if ($nama1 < $nama2) {
                echo "$nama3 <br> $nama1 <br> $nama2";
            } else {
                echo "$nama3 <br> $nama2 <br> $nama1";
            }
        }
    }
    ?>
</body>
</html>