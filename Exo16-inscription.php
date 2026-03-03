<?php
session_start();
require_once 'config.php';

$erreurs = [];
$succes = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = trim($_POST['prenom'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $mdp = $_POST['mdp'] ?? '';
    $mdpConfirm = $_POST['mdp_confirm'] ?? '';

    // Validation
    if (empty($prenom) || strlen($prenom) < 2) {
        $erreurs[] = "Le prénom doit contenir au moins 2 caractères.";
    }
    if (empty($nom) || strlen($nom) < 2) {
        $erreurs[] = "Le nom doit contenir au moins 2 caractères.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email n'est pas valide.";
    }
    if (strlen($mdp) < 8) {
        $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }
    if ($mdp !== $mdpConfirm) {
        $erreurs[] = "Les mots de passe ne correspondent pas.";
    }

    // Vérifier si l'email existe déjà
    if (empty($erreurs)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $response = $stmt->fetch(); // array
        if ($response) {
            $erreurs[] = "Cet email est déjà utilisé.";
        }
    }

    // Insertion en base
    if (empty($erreurs)) {
        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare(
            "INSERT INTO users (prenom, nom, email, password) VALUES (:prenom, :nom, :email, :password)"
        );
        $stmt->execute([
            'prenom' => $prenom,
            'nom' => $nom,
            'email' => $email,
            'password' => $mdpHash
        ]);
        $succes = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - PixelBay</title>
    <style>
        form { max-width: 400px; margin: 20px auto; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 4px; }
        button { margin-top: 15px; padding: 10px 20px; }
        .erreur { color: red; }
        .succes { color: green; }
    </style>
</head>
<body>
    <form action="" method="POST">
        <h1>Inscription PixelBay</h1>

        <?php if ($succes): ?>
            <p class="succes">Compte créé avec succès !
               <a href="exo16-connexion.php">Se connecter</a></p>
        <?php else: ?>

            <?php if (!empty($erreurs)): ?>
                <ul class="erreur">
                    <?php foreach ($erreurs as $erreur): ?>
                        <li><?= $erreur ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom"
                   value="<?= htmlspecialchars($prenom ?? '') ?>" required>

            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom"
                   value="<?= htmlspecialchars($nom ?? '') ?>" required>

            <label for="email">Email :</label>
            <input type="email" name="email" id="email"
                   value="<?= htmlspecialchars($email ?? '') ?>" required>

            <label for="mdp">Mot de passe :</label>
            <input type="password" name="mdp" id="mdp" required minlength="8">

            <label for="mdp_confirm">Confirmer :</label>
            <input type="password" name="mdp_confirm" id="mdp_confirm" required>

            <button type="submit">Créer mon compte</button>
            <p><a href="exo16-connexion.php">Déjà inscrit ? Se connecter</a></p>
        <?php endif; ?>
    </form>
</body>
</html>