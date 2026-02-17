<?php
$chiffreAffaires = 20;
echo 'CA du jour : ' . $chiffreAffaires . ' € <br>';
if ($chiffreAffaires>5000) {
    echo 'Décision : Journée exceptionnelle ! Commander de nouveaux stocks.';
    } else if ($chiffreAffaires>2000 && $chiffreAffaires<5000){
    echo 'Décision : Bonne journée. Maintenir la stratégie actuelle.';
    } else if ($chiffreAffaires>500 && $chiffreAffaires<2000) {
    echo 'Décision : Journée moyenne. Lancer une promotion sur les réseaux sociaux.';
    } else {
    echo 'Décision : Journée difficile. Organiser un événement en magasin.';
}
?>