<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: exo14-login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - PixelBay</title>
</head>
<body>
    <h1>Tableau de bord PixelBay</h1>
    <p>Bienvenue, <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong></p>
    <p>Rôle : <strong><?= htmlspecialchars($_SESSION['user_role']) ?></strong></p>
    <p><a href="exo14-logout.php">Se déconnecter</a></p>
</body>
</html>