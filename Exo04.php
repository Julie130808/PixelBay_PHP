<?php
$codeRayon = "";
echo 'Code rayon : ' . $codeRayon . '<br>';

switch ($codeRayon) {
    case 'A':
        echo "Rayon Action-Aventure - Allée 1";
        break;

    case 'R':
        echo "Rayon RPG - Allée 2";
        break;

    case 'S':
        echo "Rayon Stratégie - Allée 3";
        break;

    case 'C':
        echo "Rayon Combat - Allée 4";
        break;

    case 'P':
        echo "Rayon Plateforme - Allée 5";
        break;

    default:
        echo " Code rayon inconnu";

        break;
}
?>