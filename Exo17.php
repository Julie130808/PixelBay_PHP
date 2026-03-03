<?php
require_once 'config.php';

// Genres disponibles
$genres = ['Course', 'RPG', 'Action', 'Aventure', 'Puzzle'];

// Récupérer les filtres
$genreFiltre = $_GET['genre'] ?? 'tout';
$prixFiltre = $_GET['prix'] ?? 'tout';

// Construire la requête avec filtres
$conditions = [];
$params = [];

if ($genreFiltre !== 'tout') {
    $conditions[] = "genre = :genre";
    $params['genre'] = $genreFiltre;
}

if ($prixFiltre === 'moins30') {
    $conditions[] = "prix < 30";
} elseif ($prixFiltre === '30-50') {
    $conditions[] = "prix >= 30 AND prix <= 50";
} elseif ($prixFiltre === 'plus50') {
    $conditions[] = "prix > 50";
}

$sql = "SELECT * FROM jeux";
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$sql .= " ORDER BY titre";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$resultats = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Catalogue BDD - PixelBay</title>
    <style>
        table { border-collapse: collapse; width: 700px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #2196F3; color: white; }
        form { margin-bottom: 20px; }
        select, button { padding: 8px; }
        .stock-faible { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Catalogue PixelBay (Base de données)</h1>

    <form action="" method="GET">
        <label for="genre">Genre :</label>
        <select name="genre" id="genre">
            <option value="tout">Tous les genres</option>
            <?php foreach ($genres as $genre): ?>
                <option value="<?= htmlspecialchars($genre) ?>"
                    <?= $genreFiltre === $genre ? 'selected' : '' ?>>
                    <?= htmlspecialchars($genre) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="prix">Prix :</label>
        <select name="prix" id="prix">
            <option value="tout" <?= $prixFiltre === 'tout' ? 'selected' : '' ?>>Tous</option>
            <option value="moins30" <?= $prixFiltre === 'moins30' ? 'selected' : '' ?>>Moins de 30 €</option>
            <option value="30-50" <?= $prixFiltre === '30-50' ? 'selected' : '' ?>>30 - 50 €</option>
            <option value="plus50" <?= $prixFiltre === 'plus50' ? 'selected' : '' ?>>Plus de 50 €</option>
        </select>

        <button type="submit">Filtrer</button>
    </form>

    <p><?= count($resultats) ?> jeu(x) trouvé(s)</p>

    <table>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Prix</th>
            <th>Genre</th>
            <th>Stock</th>
        </tr>
        <?php foreach ($resultats as $jeu): ?>
        <tr>
            <td><?= $jeu['id'] ?></td>
            <td><?= htmlspecialchars($jeu['titre']) ?></td>
            <td><?= $jeu['prix'] ?> €</td>
            <td><?= htmlspecialchars($jeu['genre']) ?></td>
            <td class="<?= $jeu['stock'] < 20 ? 'stock-faible' : '' ?>">
                <?= $jeu['stock'] ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>