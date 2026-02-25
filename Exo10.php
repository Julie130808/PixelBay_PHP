<?php
$erreurs = [];
$succes = false;
$nom = '';
$email = '';
$sujet = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage
    $nom = trim($_POST['nom'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $sujet = trim($_POST['sujet'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if (empty($nom) || strlen($nom) < 2 || strlen($nom) > 50) {
        $erreurs[] = "Le nom doit contenir entre 2 et 50 caractères.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email n'est pas valide.";
    }

    if (empty($sujet)) {
        $erreurs[] = "Veuillez sélectionner un sujet.";
    }

    if (empty($message) || strlen($message) < 10) {
        $erreurs[] = "Le message doit contenir au moins 10 caractères.";
    }

    if (empty($erreurs)) {
        $succes = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact - PixelBay</title>
    <style>
        .erreur { color: red; }
        .succes { color: green; font-weight: bold; }
        form { max-width: 500px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; margin-top: 4px; }
        button { margin-top: 15px; padding: 10px 20px; }
    </style>
</head>
<body>
    <h1>Contactez PixelBay</h1>

    <?php if ($succes): ?>
        <p class="succes">Votre message a été envoyé avec succès !</p>
    <?php else: ?>
        <?php if (!empty($erreurs)): ?>
            <ul class="erreur">
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
         
        <form action="" method="POST">
            <label for="name">Nom:</label><br>
            <input type="text" name="nom" id="name" placeholder="Votre nom" 
            value="<?= htmlspecialchars($nom) ?>" required minlength="2" maxlength="50"><br>

            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" placeholder="Votre email" 
            value="<?= htmlspecialchars($email) ?>" required><br>

            <label for="subject">Sujet:</label><br>
            <select name="sujet" id="subject" required>
            <option value="">-- Choisir un sujet --</option>
            <option value="Question"<?= ($sujet === 'Question') ? 'selected' : '' ?>>Question</option>
            <option value="Réclamation"<?= ($sujet === 'Réclamation') ? 'selected' : '' ?>>Réclamation</option>
            <option value="Partenariat"<?= ($sujet === 'Partenariat') ? 'selected' : '' ?>>Partenariat</option>
            <option value="Autre"<?= ($sujet === 'Autre') ? 'selected' : '' ?>>Autre</option>
            </select><br>
            

            <label for="message">Message:</label><br>
            <textarea name="message" id="message" placeholder="Votre message" rows="5"
             required minlength="10"><?= htmlspecialchars($message) ?></textarea><br>

            <button type="submit">Envoyer</button>
        </form>
    <?php endif; ?>
</body>
</html>
