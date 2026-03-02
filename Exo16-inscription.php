<?php
session_start();
require_once 'config.php';

$erreurs = [];
$succes = false;
$nom = '';
$email = '';
$motdepasse = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage
    $nom = trim($_POST['nom'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $motdepasse = trim($_POST['motdepasse'] ?? '');
    $motdepasse_confirm = trim($_POST['motdepasse_confirm'] ?? '');

    // Validation
    if (empty($nom) || strlen($nom) < 2 || strlen($nom) > 50) {
        $erreurs[] = "Le nom doit contenir entre 2 et 50 caractères.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email n'est pas valide.";
    }

    if (empty($motdepasse) || strlen($motdepasse) < 6) {
        $erreurs[] = "Le mot de passe doit contenir au moins 6 caractères.";
    }

    if ($motdepasse !== $motdepasse_confirm) {
        $erreurs[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($erreurs)) {
            // Vérification de l'existence de l'email
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $erreurs[] = "Cette adresse email est déjà utilisée.";
            } else {
                // Insertion dans la base de données
                $motdepasse_hash = password_hash($motdepasse, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (nom, email, motdepasse) VALUES (?, ?, ?)");
                $stmt->execute([$nom, $email, $motdepasse_hash]);
                $succes = true;
            }
        } else {
            $erreurs[] = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
        }
    $succes = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
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
        input[type="text"],
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
    </style>
</head>
<body>

    <?php if ($succes): ?>
        <p>Inscription réussie ! Vous pouvez maintenant <a href="exo16-connexion.php">vous connecter</a>.</p>
    <?php else: ?>
        <?php if (!empty($erreurs)): ?>
            <ul>
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <h2>Inscription</h2>

    <form action="inscription_traitement.php" method="post">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" 
        value="<?= htmlspecialchars($nom ?? '') ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" 
        value="<?= htmlspecialchars($email ?? '') ?>" required><br><br>

        <label for="motdepasse">Mot de passe:</label>
        <input type="password" id="motdepasse" name="motdepasse" required><br><br>
        <value="<?= htmlspecialchars($motdepasse ?? '') ?>" required><br><br>

        <label for="motdepasse_confirm">Confirmez le mot de passe:</label>
        <input type="password" id="motdepasse_confirm" name="motdepasse_confirm" required><br><br>
        <value="<?= htmlspecialchars($motdepasse_confirm ?? '') ?>" required><br><br>

        <input type="submit" value="S'inscrire">
        <p>Déjà un compte ? <a href="exo16-connexion.php">Connectez-vous</a>.</p>

    </form>

</body>
</html>