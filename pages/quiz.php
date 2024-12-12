<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require '../includes/connect_db.php';

$quiz_id = $_GET['id'] ?? 1;

$stmt = $pdo->prepare("SELECT * FROM question WHERE quiz_id = :quiz_id ORDER BY RAND()");
$stmt->execute(['quiz_id' => $quiz_id]);
$question = $stmt->fetchAll();

$stmt = $pdo->prepare("SELECT title FROM quizze WHERE id = :quiz_id");
$stmt->execute(['quiz_id' => $quiz_id]);
$quiz_title = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz: <?= htmlspecialchars($quiz_title) ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <script defer src="../js/script.js"></script>
</head>
<body>
    <h1><?= htmlspecialchars($quiz_title) ?></h1>
    <div id="quiz-container">
        <?php foreach ($question as $index => $question): ?>
            <div class="question" data-question-id="<?= $question['id'] ?>">
                <h2><?= htmlspecialchars($question['question_text']) ?></h2>
                <ul>
                    <?php
                    $stmt = $pdo->prepare("SELECT * FROM answer WHERE question_id = :question_id");
                    $stmt->execute(['question_id' => $question['id']]);
                    $answer = $stmt->fetchAll();
                    foreach ($answer as $answer):
                    ?>
                    <li data-correct="<?= $answer['is_correct'] ?? 0 ?>"><?= htmlspecialchars($answer['answer_text']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
    <button id="next-btn">Suivant</button>
</body>
</html>
