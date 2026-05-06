<!DOCTYPE html>
<html>
<head>
    <title>PRAK305</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="input_string">
        <button type="submit" name="submit">submit</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $string = $_POST['input_string'];
        $panjang_string = strlen($string);
        
        for ($i = 0; $i < $panjang_string; $i++) {
            $karakter = $string[$i];
            
            for ($j = 0; $j < $panjang_string; $j++) {
                if ($j == 0) {
                    echo strtoupper($karakter);
                } else {
                    echo strtolower($karakter);
                }
            }
        }
    }
    ?>
</body>
</html>