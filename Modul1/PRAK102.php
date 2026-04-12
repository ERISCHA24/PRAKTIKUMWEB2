<?php
$nim = "2410817120022"; 
$akhiran_nim = substr($nim, -1); 

$jari_jari = 4.2;
$tinggi = 5.4;
$panjang = 8.9;
$lebar = 14.7;
$sisi = 7.9;

switch ($akhiran_nim) {
    case 0:
    case 1:
        $volume = pi() * pow($jari_jari, 2) * $tinggi;
        break;
    case 2:
    case 3:
        $volume = (1/3) * pi() * pow($jari_jari, 2) * $tinggi;
        break;
    case 4:
    case 5:
        $volume = (4/3) * pi() * pow($jari_jari, 3);
        break;
    case 6:
    case 7:
        $luas_alas = 0.5 * $sisi * $sisi; 
        $volume = $luas_alas * $tinggi;
        break;
    case 8:
    case 9:
        $volume = (1/3) * $panjang * $lebar * $tinggi;
        break;
}

echo number_format($volume, 3, '.', '') . " m3";
?>