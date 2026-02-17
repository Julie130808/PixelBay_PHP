<?php
$jeux = ["Zelda", "Assassin Screed", "Mario 64", "LOL", "Tintin"]; 

echo 'Le deuxième jeu est : ' . $jeux[1] . '<br>';

$jeux [2] = "Mario Bros";

echo 'Le nouveau troisième jeu est : ' . $jeux[2] . '<br>';

$jeuStar = [
    "titre" => "Link",
    "prix" => 20, 
    "genre" => "Aventure",
    "stock" => 50
];

foreach ($jeuStar as $key => $value) {
    echo "[$key] : $value <br>";
}
?>