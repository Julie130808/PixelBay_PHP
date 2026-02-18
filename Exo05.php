<?php
$stockActuel = 12;
$stockCible = 100;
$parLivraison = 8;
$livraison = 0;

while ($stockActuel<$stockCible) {
    $stockActuel += $parLivraison;
    $livraison++;
    echo 'Livraison ' . $livraison . ': stock = ' . $stockActuel . '<br>';
}


$mois = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
         "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
$jeuxPhares = ["Cyber Race", "Pixel Quest", "Block Master", "Sky Pilot",
               "Dungeon Crawl", "Mystic Lands", "Battle Arena", "Escape Room",
               "Neural Rush", "Horror House", "Festival Games", "Winter Sports"];

for ($i=0; $i < count($mois); $i++) { 
    echo $mois[$i] . ' : ' . $jeuxPhares[$i] . '<br>';
}
?>