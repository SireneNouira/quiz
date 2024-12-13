<?php


session_start();
require '../utils/connect_db.php';



if (isset($_GET["user_id"]) && isset($_GET["quiz_id"]) ) {
  $userId = $_GET["user_id"];
  $quizId = $_GET["quiz_id"];
} else {
  die('ID manquant');
}


$sql = "SELECT * FROM quizze WHERE id = :id";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $quizId]);


    $quiz = $stmt->fetch(PDO::FETCH_ASSOC); 

    if (!$quiz) {
        die("Quiz introuvable.");
    }


} catch (PDOException $error) {
    echo "Erreur lors de la requête : " . $error->getMessage();
    exit;
}


$sql = "SELECT * FROM question WHERE quiz_id = :id";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $quizId]);


    $question = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    if (!$question) {
        die("Question introuvable.");
    }


} catch (PDOException $error) {
    echo "Erreur lors de la requête : " . $error->getMessage();
    exit;
}


$questionId = $question[0]['id'];


$sql = "SELECT * FROM answer WHERE question_id = :id";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $questionId]);


    $answer = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    if (!$answer) {
        die("Question introuvable.");
    }


} catch (PDOException $error) {
    echo "Erreur lors de la requête : " . $error->getMessage();
    exit;
}





?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script  defer src="../js/script.js"></script>
    <title>Document</title>
</head>
<body>

<div id="quiz-container">


    <h3 id="question-text" <?= $question[0]['id']; ?>>
        <?= htmlspecialchars($question[0]['question_text']); ?>
    </h3>

    <div id="answers">
        <h3 class="answer" <?= $answer[0]['id']; ?>>
            <?= htmlspecialchars($answer[0]['answer_text']); ?>
        </h3>


        <h3 class="answer"<?= $answer[1]['id']; ?>>
            <?= htmlspecialchars($answer[1]['answer_text']); ?>
        </h3>

        
        <h3 class="answer" <?= $answer[2]['id']; ?>>
            <?= htmlspecialchars($answer[2]['answer_text']); ?>
        </h3>



    </div>


</div>


<?php
$questionData = [
    'id' => $question[0]['id'],
    'question_text' => $question[0]['question_text'],
    'answers' => $answer
];
?>
<script>
    const quizData = <?php echo json_encode($questionData); ?>;
</script>


</body>
</html>