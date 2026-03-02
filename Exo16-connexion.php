<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $motdepasse = trim($_POST['motdepasse'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("L'adresse email n'est pas valide.");
    }

    if (empty($motdepasse)) {
        die("Le mot de passe est requis.");
    }

    $stmt = $pdo->prepare("SELECT id, nom, motdepasse, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($motdepasse, $user['motdepasse'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nom'];
        $_SESSION['user_role'] = $user['role'];
        header("Location: exo16-dashboard.php");
        exit;
    } else {
        die("Email ou mot de passe incorrect.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        form {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            width: 300px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .erreur {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <h2>Connexion</h2>

    <?php if (!empty($erreurs)): ?>
                <?php foreach ($erreurs as $erreur): ?>
                    <p class="erreur"><?= htmlspecialchars($erreur) ?></p>
                <?php endforeach; ?>

    <form action="connexion_traitement.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="motdepasse">Mot de passe:</label>
        <input type="password" id="motdepasse" name="motdepasse" required><br><br>

        <input type="submit" value="Se connecter">
        <p>Pas de compte ? <a href="exo16-inscription.php">Inscrivez-vous</a>.</p>
    </form>
    
</body>
</html>