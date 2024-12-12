<?php
session_start();
require '../includes/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = trim($_POST['pseudo']);
    if (!empty($pseudo)) {
        $stmt = $pdo->prepare("SELECT id FROM user WHERE pseudo = :pseudo");
        $stmt->execute(['pseudo' => $pseudo]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
        } else {
            $stmt = $pdo->prepare("INSERT INTO user (pseudo) VALUES (:pseudo)");
            $stmt->execute(['pseudo' => $pseudo]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
        }
        header("Location: ../index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <form method="POST" action="">
        <label for="pseudo">Pseudo :</label>
        <input type="text" name="pseudo" id="pseudo" required>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
