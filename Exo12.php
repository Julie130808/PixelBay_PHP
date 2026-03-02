<?php
require_once 'data.php';

$genreFiltre = $_GET['genre'] ?? 'tout';
$prixFiltre = $_GET['prix'] ?? 'tout';

$resultats = [];

foreach ($catalogue as $jeu) {
    $genreOk = ($genreFiltre === 'tout' || $jeu['genre'] === $genreFiltre);

    $prixOk = true;
    if ($prixFiltre === 'moins30') {
        $prixOk = $jeu['prix'] < 30;
    } elseif ($prixFiltre === '30-50') {
        $prixOk = $jeu['prix'] >= 30 && $jeu['prix'] <= 50;
    } elseif ($prixFiltre === 'plus50') {
        $prixOk = $jeu['prix'] > 50;
    }

    if ($genreOk && $prixOk) {
        $resultats[] = $jeu;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue</title>
    <style>
        table { width: 80%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        h1 { text-align: center; }
        .filtre { width: 80%; margin: 20px auto; }
        .filtre label { margin-right: 10px; }
        .filtre select { margin-right: 20px; }
    </style>
</head>
<body>
    <h1>Catalogue de Jeux Vidéo</h1>
    <form method="get" class="filtre">
        <label for="genre">Filtrer par genre:</label>
        <select name="genre" id="genre">
            <option value="tout">Tous les genres</option>
            <option value="Action" <?= $genreFiltre === 'Action' ? 'selected' : '' ?>>Action</option>
            <option value="Adventure" <?= $genreFiltre === 'Adventure' ? 'selected' : '' ?>>Aventure</option>
            <option value="RPG" <?= $genreFiltre === 'RPG' ? 'selected' : '' ?>>RPG</option>
            <option value="Course" <?= $genreFiltre === 'Course' ? 'selected' : '' ?>>Course</option>
            <option value="Indie" <?= $genreFiltre === 'Indie' ? 'selected' : '' ?>>Indie</option>
            <option value="Sci-Fi" <?= $genreFiltre === 'Sci-Fi' ? 'selected' : '' ?>>Sci-Fi</option>
            <option value="Horror" <?= $genreFiltre === 'Horror' ? 'selected' : '' ?>>Horror</option>
            <option value="Fantasy" <?= $genreFiltre === 'Fantasy' ? 'selected' : '' ?>>Fantasy</option>
            <option value="Racing" <?= $genreFiltre === 'Racing' ? 'selected' : '' ?>>Racing</option>
            <option value="Stealth" <?= $genreFiltre === 'Stealth' ? 'selected' : '' ?>>Stealth</option>
        </select>

        <label for="prix">Filtrer par prix:</label>
        <select name="prix" id="prix">
            <option value="tout">Tous les prix</option>
            <option value="moins30" <?= $prixFiltre === 'moins30' ? 'selected' : '' ?>>Moins de 30€</option>
            <option value="30-50" <?= $prixFiltre === '30-50' ? 'selected' : '' ?>>Entre 30€ et 50€</option>
            <option value="plus50" <?= $prixFiltre === 'plus50' ? 'selected' : '' ?>>Plus de 50€</option>
        </select>

        <button type="submit">Filtrer</button>
    </form>

    <?php if (empty($resultats)): ?>
        <p style="text-align: center;">Aucun jeu ne correspond aux critères de filtrage.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr><th>Titre</th>
                <th>Prix (€)</th>
                <th>Genre</th>
                <th>Stock</th></tr>
            </thead>
            <tbody>
                <?php foreach ($resultats as $jeu): ?>
                    <tr><td><?= htmlspecialchars($jeu['titre']) ?></td>
                    <td><?= number_format($jeu['prix'], 2) ?></td>
                    <td><?= htmlspecialchars($jeu['genre']) ?></td>
                    <td><?= htmlspecialchars($jeu['stock']) ?></td></tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>
</html>