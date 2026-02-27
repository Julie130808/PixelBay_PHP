<?php
$erreurs = [];
$succes = false;
$prenom = '';
$nom = '';
$email = '';
$motdepasse = '';
$age = '';
$checked = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $prenom = trim($_POST['prenom'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $motdepasse = $_POST['motdepasse'] ?? '';
    $confirmationmotdepasse = $_POST['confirmationmotdepasse'] ?? '';
    $checked = isset($_POST['checked']);
    $age = $_POST['age'] ?? '';

    
    if (empty($prenom) || strlen($prenom) < 2 || strlen($prenom) > 30) {
        $erreurs[] = "Le prénom doit contenir entre 2 et 30 caractères.";
    }

    if (empty($nom) || strlen($nom) < 2 || strlen($nom) > 30) {
        $erreurs[] = "Le nom doit contenir entre 2 et 30 caractères.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'adresse email n'est pas valide.";
    }

    if (strlen($motdepasse) < 8 || !preg_match('/[A-Z]/', $motdepasse) || !preg_match('/[a-z]/', $motdepasse) || !preg_match('/\d/', $motdepasse)) {
        $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.";
    }

    if ($motdepasse !== $confirmationmotdepasse) {
        $erreurs[] = "La confirmation du mot de passe ne correspond pas.";
    }

    if (!is_numeric($age) || $age < 16 || $age > 120) {
        $erreurs[] = "L'âge doit être un nombre entre 16 et 120.";
    }

    if (!$checked) {
        $erreurs[] = "Vous devez accepter les conditions d'utilisation.";
    }

    if (empty($erreurs)) {
        $succes = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire inscription</title>
    <style>
        .erreur { color: red; }
        .succes { color: green; font-weight: bold; }
        form { max-width: 400px; margin: auto; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 4px; }
        button { margin-top: 15px; padding: 10px 20px; }
        input[type="checkbox"] { width: auto; margin-top: 10px; }
    </style>
</head>
<body>

    <h1>Inscription</h1>

    <?php if ($succes): ?>
        <p class="succes">Votre inscription a été réussie !</p>
        <p>Prénom : <?= htmlspecialchars($prenom) ?></p>
        <p>Nom : <?= htmlspecialchars($nom) ?></p>
        <p>Email : <?= htmlspecialchars($email) ?></p>
        <p>Âge : <?= htmlspecialchars($age) ?></p>
        <p>Mot de passe : <?= str_repeat('*', strlen($motdepasse)) ?></p>
    <?php else: ?>
        <?php if (!empty($erreurs)): ?>
            <ul class="erreur">
                <?php foreach ($erreurs as $erreur): ?>
                    <li><?= htmlspecialchars($erreur) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

         <form action="" method="POST">
             <label for="prenom">Prénom:</label><br>
             <input type="text" name="prenom" id="prenom" placeholder="Votre prénom" 
             value="<?= htmlspecialchars($prenom) ?>" required minlength="2" maxlength="30"><br>

             <label for="nom">Nom:</label><br>
             <input type="text" name="nom" id="nom" placeholder="Votre nom" 
             value="<?= htmlspecialchars($nom) ?>" required minlength="2" maxlength="30"><br>

             <label for="email">Email:</label><br>
             <input type="email" name="email" id="email" placeholder="Votre email" 
             value="<?= htmlspecialchars($email) ?>" required><br>

             <label for="motdepasse">Mot de passe:</label><br>
             <input type="password" name="motdepasse" id="motdepasse" placeholder="Votre mot de passe" required><br>

             <label for="confirmationmotdepasse">Confirmer le mot de passe:</label><br>
             <input type="password" name="confirmationmotdepasse" id="confirmationmotdepasse" placeholder="Confirmez votre mot de passe" required><br>

             <label for="age">Âge:</label><br>
             <input type="number" name="age" id="age" placeholder="Votre âge" 
             value="<?= htmlspecialchars($age) ?>" required min="16" max="120"><br>

             <label>
             <input type="checkbox" name="checked" <?= $checked ? 'checked' : '' ?> required>
                J'accepte les conditions d'utilisation
             </label><br>

            <button type="submit">S'inscrire</button>

            </form>
        <?php endif; ?>
    
</body>
</html>