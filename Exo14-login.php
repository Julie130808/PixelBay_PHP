<?php
session_start();

// Si déjà connecté, rediriger vers le dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: exo14-dashboard.php");
    exit;
}

$utilisateurs = [
    ["email" => "admin@pixelbay.com", "mdp" => "admin123", "nom" => "Admin PixelBay", "role" => "admin"],
    ["email" => "employe@pixelbay.com", "mdp" => "employe123", "nom" => "Jean Dupont", "role" => "employé"]
];

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $mdp = $_POST['mdp'] ?? '';

    $utilisateurTrouve = null;
    foreach ($utilisateurs as $user) {
        if ($user['email'] === $email && $user['mdp'] === $mdp) {
            $utilisateurTrouve = $user;
            break;
        }
    }

    if ($utilisateurTrouve) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $utilisateurTrouve['email'];
        $_SESSION['user_name'] = $utilisateurTrouve['nom'];
        $_SESSION['user_role'] = $utilisateurTrouve['role'];
        header("Location: exo14-dashboard.php");
        exit;
    } else {
        $erreur = "Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - PixelBay</title>
    <style>
        form { max-width: 400px; margin: 50px auto; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 4px; }
        button { margin-top: 15px; padding: 10px 20px; }
        .erreur { color: red; }
    </style>
</head>
<body>
    <form action="" method="POST">
        <h1>Connexion PixelBay</h1>

        <?php if (!empty($erreur)): ?>
            <p class="erreur"><?= $erreur ?></p>
        <?php endif; ?>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>

        <label for="mdp">Mot de passe :</label>
        <input type="password" name="mdp" id="mdp" required>

        <button type="submit">Se connecter</button>
    </form>
</body>
</html> 