<?php
// Démarrer la session
session_start();

// Gérer la réinitialisation
if (isset($_GET['reset'])) {
    $_SESSION['compteur'] = 0;
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

// Incrémenter le compteur
if (!isset($_SESSION['compteur'])) {
    $_SESSION['compteur'] = 0;
}
$_SESSION['compteur']++;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compteur de visites - PixelBay</title>
</head>
<body>
    <h1>Bienvenue chez PixelBay</h1>
    <!-- Affichez le compteur et le lien de reset -->
    <p>Nombre de visites : <?php echo $_SESSION['compteur']; ?></p>
    <a href="?reset=true">Réinitialiser le compteur</a>
</body>
</html>