<?php

require_once './utils/connect_db.php';

$sql = "SELECT * FROM `questions` ";

try {
    $stmt = $pdo->query($sql);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC); // ou fetch si vous savez que vous n'allez avoir qu'un seul résultat

} catch (PDOException $error) {
    echo "Erreur lors de la requete : " . $error->getMessage();
}


$sql = "SELECT * FROM `answers` ";

try {
    $stmt = $pdo->query($sql);
    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC); // ou fetch si vous savez que vous n'allez avoir qu'un seul résultat

} catch (PDOException $error) {
    echo "Erreur lors de la requete : " . $error->getMessage();
}


?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - Question 1</title>
  
</head>
<body>

    <div class="quiz-container">
    <p class="question"> <?= $questions[0]['question_text']; ?> </p>

        <button class="answer-button"><?= $answers[0]['answer_text']; ?> </button>
        <button class="answer-button"><?= $answers[1]['answer_text']; ?> </button>
        <button class="answer-button"><?= $answers[2]['answer_text']; ?> </button>
    </div>

</body>
</html>

