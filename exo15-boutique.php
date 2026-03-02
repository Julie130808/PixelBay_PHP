<?php
session_start();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

$catalogue = [
    ["id" => 1, "titre" => "Cyber Race", "prix" => 49.99],
    ["id" => 2, "titre" => "Dungeon Crawl", "prix" => 39.99],
    ["id" => 3, "titre" => "Battle Arena", "prix" => 29.99],
    ["id" => 4, "titre" => "Pixel Quest", "prix" => 19.99]
];

// Ajout au panier via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $idJeu = intval($_POST['ajouter']);

    // Chercher le jeu dans le catalogue
    foreach ($catalogue as $jeu) {
        if ($jeu['id'] === $idJeu) {
            // Vérifier si le jeu est déjà dans le panier
            $trouve = false;
            for ($i = 0; $i < count($_SESSION['panier']); $i++) {
                if ($_SESSION['panier'][$i]['id'] === $idJeu) {
                    $_SESSION['panier'][$i]['quantite']++;
                    $trouve = true;
                    break;
                }
            }

            if (!$trouve) {
                $_SESSION['panier'][] = [
                    "id" => $jeu['id'],
                    "titre" => $jeu['titre'],
                    "prix" => $jeu['prix'],
                    "quantite" => 1
                ];
            }
            break;
        }
    }
    header("Location: exo15-boutique.php");
    exit;
}

$nbArticles = 0;
foreach ($_SESSION['panier'] as $article) {
    $nbArticles += $article['quantite'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Boutique - PixelBay</title>
    <style>
        .catalogue { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; max-width: 600px; }
        .jeu { border: 2px solid #333; padding: 15px; border-radius: 8px; }
        .panier-lien { background: #4CAF50; color: white; padding: 10px 20px;
                       text-decoration: none; border-radius: 5px; display: inline-block; margin-bottom: 20px; }
        button { padding: 8px 15px; background: #2196F3; color: white; border: none;
                 border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Boutique PixelBay</h1>
    <a class="panier-lien" href="exo15-panier.php">Panier (<?= $nbArticles ?>)</a>

    <div class="catalogue">
        <?php foreach ($catalogue as $jeu): ?>
        <div class="jeu">
            <h3><?= htmlspecialchars($jeu['titre']) ?></h3>
            <p><?= $jeu['prix'] ?> €</p>
            <form action="" method="POST">
                <button type="submit" name="ajouter" value="<?= $jeu['id'] ?>">Ajouter au panier</button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
