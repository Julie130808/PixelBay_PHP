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
        $_SESSION['panier'] = array_values($_SESSION['panier']);
    }
    header("Location: exo18-panier.php");
    exit;
}

// Vider le panier
if (isset($_GET['vider'])) {
    $_SESSION['panier'] = [];
    header("Location: exo18-panier.php");
    exit;
}

$totalHT = 0;
foreach ($_SESSION['panier'] as $article) {
    $totalHT += $article['prix'] * $article['quantite'];
}
$tva = round($totalHT * 0.20, 2);
$totalTTC = round($totalHT + $tva, 2);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier - PixelBay</title>
    <style>
        table { border-collapse: collapse; width: 650px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #2196F3; color: white; }
        .total { font-weight: bold; background-color: #f0f0f0; }
        a { margin-right: 15px; }
        .supprimer { color: red; }
        .valider { background: #4CAF50; color: white; padding: 10px 20px;
                   text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 15px; }
    </style>
</head>
<body>
    <h1>Mon Panier</h1>
    <a href="exo18-boutique.php">Retour à la boutique</a>
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
                <td colspan="3">Total HT</td>
                <td colspan="2"><?= round($totalHT, 2) ?> €</td>
            </tr>
            <tr class="total">
                <td colspan="3">TVA (20%)</td>
                <td colspan="2"><?= $tva ?> €</td>
            </tr>
            <tr class="total">
                <td colspan="3">Total TTC</td>
                <td colspan="2"><?= $totalTTC ?> €</td>
            </tr>
        </table>

        <a class="valider" href="exo18-commande.php">Valider la commande</a>
    <?php endif; ?>
</body>
</html>