<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit();
}
require 'includes/connect_db.php';

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Bienvenue sur le Quiz</h1>
    <a href="pages/quiz.php">Commencer un quiz</a>
    <a href="pages/leader.php">Classement</a>
    <a href="logout.php">Déconnexion</a>
</body>
</html>
