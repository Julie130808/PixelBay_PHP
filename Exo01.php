<?php
const nom_boutique = "PixelBay";
$stock = 500;

echo 'Boutique : ' . nom_boutique . '<br>';
echo 'Stock initial : ' . $stock . ' jeux <br>';

$jeuxVendus = (500/100)*25;
$newStock = $stock-$jeuxVendus;
$prixMoyen = 45;
$chiffreAffaire = $jeuxVendus*$prixMoyen;

echo 'Jeux vendus : ' . $jeuxVendus . ' jeux <br>';
echo 'Nouveau stock : ' . $newStock . ' jeux <br>';
echo 'Chiffre d\'affaires : ' . $chiffreAffaire . '€';
?>