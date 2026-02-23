<?php
$catalogue = [
    ["titre" => "Cyber Race", "prix" => 49.99, "genre" => "Course"],
    ["titre" => "Dungeon Crawl", "prix" => 39.99, "genre" => "RPG"],
    ["titre" => "Battle Arena", "prix" => 29.99, "genre" => "Action"],
    ["titre" => "Pixel Quest", "prix" => 19.99, "genre" => "Aventure"],
    ["titre" => "Cyber Punk 2084", "prix" => 59.99, "genre" => "RPG"],
    ["titre" => "Racing Thunder", "prix" => 34.99, "genre" => "Course"]
];

$searchResults = [];

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $query = strtolower($_GET['q']);
    foreach ($catalogue as $game) {
        if (strpos(strtolower($game['titre']), $query) !== false) {
            $searchResults[] = $game;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche - PixelBay</title>
</head>
<body>
    <h1>Recherche PixelBay</h1>
    <form action="" method="GET">
        <input type="text" name="q" placeholder="Rechercher un jeu..."
               value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
        <button type="submit">Rechercher</button>
    </form>

    <?php if (isset($_GET['q']) && !empty($_GET['q'])): ?>
        <h2>Résultats pour "<?php echo htmlspecialchars($_GET['q']) ?>"</h2>
        <?php if (count($searchResults) > 0): ?>
            <ul>
                <?php foreach ($searchResults as $game): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($game['titre']) ?></strong><br>
                        Prix: <?php echo number_format($game['prix'], 2) ?> €<br>
                        Genre: <?php echo htmlspecialchars($game['genre']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Aucun résultat trouvé.</p>
        <?php endif; ?>
    <?php endif; ?> 
</body>
</html>