<?php
session_start();
require_once 'config.php';

if (empty($_SESSION['panier'])) {
    header("Location: exo18-boutique.php");
    exit;
}

$erreurs = [];
$panier = $_SESSION['panier'];

// Décrémenter le stock pour chaque article
// Note : en production, il faudrait utiliser une transaction ($pdo->beginTransaction(), $pdo->commit(), $pdo->rollBack())
// pour garantir que le stock n'est décrémenté que si TOUS les articles sont disponibles.
foreach ($panier as $article) {
    $stmt = $pdo->prepare("UPDATE jeux SET stock = stock - :quantite WHERE id = :id AND stock >= :quantite");
    $stmt->execute([
        'quantite' => $article['quantite'],
        'id' => $article['id']
    ]);

    if ($stmt->rowCount() === 0) {
        $erreurs[] = "Stock insuffisant pour : " . $article['titre'];
    }
}

$totalHT = 0;
foreach ($panier as $article) {
    $totalHT += $article['prix'] * $article['quantite'];
}
$totalTTC = round($totalHT * 1.20, 2);

// Vider le panier après la commande
if (empty($erreurs)) {
    $_SESSION['panier'] = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commande - PixelBay</title>
    <style>
        .confirmation { max-width: 500px; margin: 30px auto; padding: 20px;
                        border: 2px solid #4CAF50; border-radius: 8px; background: #e8f5e9; }
        .erreur { color: red; }
    </style>
</head>
<body>
    <?php if (!empty($erreurs)): ?>
        <h1>Erreur lors de la commande</h1>
        <ul class="erreur">
            <?php foreach ($erreurs as $erreur): ?>
                <li><?= $erreur ?></li>
            <?php endforeach; ?>
        </ul>
        <a href="exo18-panier.php">Retour au panier</a>
    <?php else: ?>
        <div class="confirmation">
            <h1>Commande confirmée !</h1>
            <h2>Récapitulatif</h2>
            <ul>
                <?php foreach ($panier as $article): ?>
                    <li><?= htmlspecialchars($article['titre']) ?>
                        x<?= $article['quantite'] ?>
                        - <?= round($article['prix'] * $article['quantite'], 2) ?> €</li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Total TTC : <?= $totalTTC ?> €</strong></p>
            <p>Merci pour votre achat chez PixelBay !</p>
            <a href="exo18-boutique.php">Retour à la boutique</a>
        </div>
    <?php endif; ?>
</body>
</html>