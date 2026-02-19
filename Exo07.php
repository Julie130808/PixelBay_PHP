<?php
$collection = [
    [
        "titre" => "Cyber Race",
        "prix" => 49.99,
        "genre" => "Course",
        "stock" => 30,
        "scores" => [85, 90, 78, 92, 88]
    ],
    [
        "titre" => "Shadow Odyssey",
        "prix" => 54.99,
        "genre" => "RPG",
        "stock" => 25,
        "scores" => [88, 92, 76, 95, 84]
    ],
    [
        "titre" => "Iron Siege", 
        "prix" => 44.99, 
        "genre" => "Stratégie", 
        "stock" => 18, 
        "scores" => [79, 85, 91, 83, 87]
    ],
    [
        "titre" => "Neon Strike", 
        "prix" => 39.99, 
        "genre" => "Action", "stock" => 42, 
        "scores" => [93, 88, 76, 90, 82]
    ],
];

function calculerMoyenneScores($scores){
        return array_sum($scores) / count($scores);
}

echo 'Les jeux de la collection sont : <br>';

foreach ($collection as $jeu) {
    echo '<br>';
foreach ($jeu as $key => $value) {
    if (is_array($value)) {
        echo $key . ': ' . implode(', ', $value) . '<br>';
        echo 'moyenne : ' . calculerMoyenneScores($value) . '<br>';
    } else {
        echo "$key : $value <br>";
    }
}
}

function trouverMeilleurJeu($collection){
    $meilleurJeu = null;
    $meilleureMoyenne = 0;

    foreach ($collection as $jeu) {
        $moyenne = calculerMoyenneScores($jeu['scores']);
        if ($moyenne > $meilleureMoyenne) {
            $meilleureMoyenne = $moyenne;
            $meilleurJeu = $jeu;
        }
    }
    return $meilleurJeu;
}

echo '<br>' . 'Le meilleur jeu de la collection est : ' . trouverMeilleurJeu($collection)['titre'] . '<br>' . 'avec une moyenne de : ' . calculerMoyenneScores(trouverMeilleurJeu($collection)['scores']);

?>