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
foreach ($question as $quest) {
    var_dump($quest);
    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../css/style.css">
    <script  defer src="../js/script.js"></script>
    <title>Document</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../css/quizzlogo.png" alt="logo">
        </div>
        <nav>
            <ul>
                <li><a href="#">A propos</a></li>
                <li><a href="#">Scores</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <article class="input-field3">
            <div>
                <h1>TITRE QUIZ</h1>
                <h2>1/2</h2>
            </div>
          
                <div id="quiz-container">


<h3 class="question" id="question-text" <?= $question[0]['id']; ?>>
    <?= htmlspecialchars($question[0]['question_text']); ?>
</h3>

<div id="answers">
    <h3 class="reponses" <?= $answer[0]['id']; ?>>
        <?= htmlspecialchars($answer[0]['answer_text']); ?>
    </h3>


    <h3 class="reponses"<?= $answer[1]['id']; ?>>
        <?= htmlspecialchars($answer[1]['answer_text']); ?>
    </h3>


    <h3 class="reponses" <?= $answer[2]['id']; ?>>
        <?= htmlspecialchars($answer[2]['answer_text']); ?>
    </h3>



</div>
<div>
    <p id="question-display">Question ID: <span id="current-id"><?php echo $questionId; ?></span></p>
    <button id="next-button">Next Question</button>
</div>


</div>
            </div>
            <a href="../choixquizz.php?id=<?= $userId ?>" class="login-btn3">REVENIR AU QUIZZ</a>
        </article>
    </main>

    <footer>
        <div class="footer-text">JOUEZ - APPRENEZ - PROGRESSEZ</div>
    </footer>


 
</body>
</html>