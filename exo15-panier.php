<?php
session_start();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Supprimer un article
if (isset($_GET['supprimer'])) {
    $index = intval($_GET['supprimer']);
    if (isset($_SESSION['panier'][$index])) {
        unset($_SESSION['panier'][$index]);
        // array_values() réindexe le tableau à partir de 0 après suppression
        $_SESSION['panier'] = array_values($_SESSION['panier']);
    }
    header("Location: exo15-panier.php");
    exit;
}

// Vider le panier
if (isset($_GET['vider']) && $_GET['vider'] === '1') {
    $_SESSION['panier'] = [];
    header("Location: exo15-panier.php");
    exit;
}

// Calculer le total
$total = 0;
foreach ($_SESSION['panier'] as $article) {
    $total += $article['prix'] * $article['quantite'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier - PixelBay</title>
    <style>
        table { border-collapse: collapse; width: 600px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #2196F3; color: white; }
        .total { font-weight: bold; background-color: #f0f0f0; }
        a { margin-right: 15px; }
        .supprimer { color: red; }
    </style>
</head>
<body>
    <h1>Mon Panier</h1>
    <a href="exo15-boutique.php">Retour à la boutique</a>
    <a href="?vider=1" class="supprimer">Vider le panier</a>

    <?php if (empty($_SESSION['panier'])): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Article</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Sous-total</th>
                <th>Action</th>
            </tr>
            <?php foreach ($_SESSION['panier'] as $index => $article): ?>
            <tr>
                <td><?= htmlspecialchars($article['titre']) ?></td>
                <td><?= $article['prix'] ?> €</td>
                <td><?= $article['quantite'] ?></td>
                <td><?= round($article['prix'] * $article['quantite'], 2) ?> €</td>
                <td><a href="?supprimer=<?= $index ?>" class="supprimer">Supprimer</a></td>
            </tr>
            <?php endforeach; ?>
            <tr class="total">
                <td colspan="3">Total</td>
                <td colspan="2"><?= round($total, 2) ?> €</td>
            </tr>
        </table>
    <?php endif; ?>
</body>
</html>
