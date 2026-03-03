<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: exo16-connexion.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - PixelBay</title>
    <style>
        .dashboard { max-width: 500px; margin: 50px auto; padding: 20px;
                     border: 2px solid #2196F3; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Tableau de bord</h1>
        <p>Bienvenue, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong></p>
        <p>Rôle : <strong><?= htmlspecialchars($_SESSION['user_role']) ?></strong></p>
        <p>ID utilisateur : <?= htmlspecialchars($_SESSION['user_id']) ?></p>
        <p><a href="exo16-logout.php">Se déconnecter</a></p>
    </div>
</body>
</html>