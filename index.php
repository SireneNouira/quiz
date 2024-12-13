<?php
session_start();
require './utils/connect_db.php';

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
