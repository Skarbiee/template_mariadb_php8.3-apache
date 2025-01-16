<?php
// Connexion à la base de données
$dsn = 'mysql:host=mariadb;dbname=project_db;charset=utf8';
$username = 'user';
$password = 'password';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connexion échouée : ' . $e->getMessage());
}

// Récupération des données
$stmt = $pdo->query('SELECT users.username, users_infos.bio FROM users JOIN users_infos ON users.id = users_infos.user_id');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP Docker</title>
</head>

<body>
    <h1>Bienvenue sur notre site web !</h1>
    <h2>Liste des utilisateurs</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><strong><?= htmlspecialchars($user['username']) ?></strong> : <?= htmlspecialchars($user['bio']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <h2>Image :</h2>
    <img src="data:image/jpeg;base64,<?= base64_encode(file_get_contents('assets/imgs/skarbie.jpg')); ?> " alt="Exemple d'image">
    <h2>Main champion</h2>
    <img src="data:image/jpeg;base64,<?= base64_encode(file_get_contents('assets/imgs/caitlyn.jpg')); ?> " alt="Exemple d'image">
</body>

</html>