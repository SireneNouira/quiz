<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require '../includes/connect_db.php';

// Récupérer le classement des meilleurs score
$stmt = $pdo->query("
    SELECT user.pseudo, score.score 
    FROM score 
    JOIN user ON score.user_id = user.id 
    ORDER BY score.score DESC 
    LIMIT 10
");
$leaderboard = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Classement des Meilleurs score</h1>
    <table>
        <thead>
            <tr>
                <th>Position</th>
                <th>Pseudo</th>
                <th>Score</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($leaderboard as $index => $entry): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($entry['pseudo']) ?></td>
                <td><?= htmlspecialchars($entry['score']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../index.php">Retour à l'accueil</a>
</body>
</html>
