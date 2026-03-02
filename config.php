<?php
$host = 'mysql-server';
$dbname = 'pixelbay';
$username = 'root';
$password = 'root';
// Votre connexion PDO ici
new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

fetch(PDO::FETCH_ASSOC);

?>