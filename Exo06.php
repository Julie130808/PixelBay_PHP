<?php
$prixJeu = 59.99;
$nomJeu = "Cyber Race";
$pourcentage = 15;

function promotionEte ($prixJeu){
    $promoEte = $prixJeu -= ($prixJeu/100)*20;
    return $promoEte;
}

function promotionHiver ($prixJeu){
    $promoHiver = $prixJeu -= ($prixJeu/100)*30;
    return $promoHiver;
}

function promotionSpeciale ($prixJeu, $pourcentage){
    $promoSpeciale = $prixJeu -= ($prixJeu/100)*$pourcentage;
    return $promoSpeciale;
}

function afficherPrix ($nomJeu, $prixJeu, $prixReduit, $labelpromo){
    return $nomJeu . ' : ' . $prixJeu . ' € -> ' . round ($prixReduit, 2) . ' € (' . $labelpromo . ') <br>';
}

echo afficherPrix ($nomJeu, $prixJeu, promotionEte($prixJeu), 'Promo Eté -20%');
echo afficherPrix ($nomJeu, $prixJeu, promotionHiver($prixJeu), 'Promo Hiver -30%');
echo afficherPrix ($nomJeu, $prixJeu, promotionSpeciale($prixJeu, $pourcentage), 'Promo Spéciale -' . $pourcentage . '%');
?>