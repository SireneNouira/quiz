<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require '../includes/connect_db.php';

$user_id = $_SESSION['user_id'];
$quiz_id = $_GET['quiz_id'] ?? 1;

// Calculer le score (simulons avec un score aléatoire ici pour simplifier)
$score = $_GET['score'] ?? rand(10, 100);

// Enregistrer le score dans la base de données
$stmt = $pdo->prepare("INSERT INTO score (user_id, quiz_id, score) VALUES (:user_id, :quiz_id, :score) 
    ON DUPLICATE KEY UPDATE score = GREATEST(score, :score)");
$stmt->execute([
    'user_id' => $user_id,
    'quiz_id' => $quiz_id,
    'score' => $score,
]);

// Récupérer les meilleurs score de l'utilisateur pour ce quiz
$stmt = $pdo->prepare("SELECT MAX(score) AS best_score FROM score WHERE user_id = :user_id AND quiz_id = :quiz_id");
$stmt->execute([
    'user_id' => $user_id,
    'quiz_id' => $quiz_id,
]);
$best_score = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Résultats du Quiz</h1>
    <p>Votre score : <?= htmlspecialchars($score) ?></p>
    <p>Votre meilleur score pour ce quiz : <?= htmlspecialchars($best_score) ?></p>
    <a href="quiz.php?id=<?= $quiz_id ?>">Rejouer</a>
    <a href="../index.php">Retour à l'accueil</a>
</body>
</html>
