<?php
session_start();
require '../utils/connect_db.php';

if (!isset($_GET["user_id"]) || !isset($_GET["quiz_id"])) {
    die('ID manquant');
}

$userId = $_GET["user_id"];
$quizId = $_GET["quiz_id"];

// Réinitialiser si un nouveau quiz est sélectionné ou si le quiz actuel est terminé
if (!isset($_SESSION['current_quiz_id']) || $_SESSION['current_quiz_id'] != $quizId || isset($_SESSION['quiz_finished'])) {
    $_SESSION['current_quiz_id'] = $quizId; // Stocke l'ID du quiz actuel
    $_SESSION['current_question'] = 0;      // Réinitialise à la première question
    $_SESSION['score'] = 0;                // Réinitialise le score

    // Supprimer l'état "quiz terminé"
    unset($_SESSION['quiz_finished']);
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
    die("Erreur lors de la requête : " . $error->getMessage());
}


$sql = "SELECT * FROM question WHERE quiz_id = :id";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $quizId]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$questions) {
        die("Aucune question trouvée pour ce quiz.");
    }
} catch (PDOException $error) {
    die("Erreur lors de la requête : " . $error->getMessage());
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'])) {
    $selectedAnswerId = $_POST['answer'];

    
    $sql = "SELECT is_correct FROM answer WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $selectedAnswerId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['is_correct'] == 1) {
        $_SESSION['score']++; 
    }

    $_SESSION['current_question']++;
}


$currentIndex = $_SESSION['current_question'];

if ($currentIndex >= count($questions)) {
    $finished = true; 
    $_SESSION['quiz_finished'] = true;
} else {
    $finished = false;
    $currentQuestion = $questions[$currentIndex];

    
    $sql = "SELECT * FROM answer WHERE question_id = :id";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $currentQuestion['id']]);
        $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        die("Erreur lors de la récupération des réponses : " . $error->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Quiz</title>
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
                <h1><?= htmlspecialchars($quiz['title']); ?></h1>
                <h2>Question <?= $currentIndex + 1; ?>/<?= count($questions); ?></h2>
            </div>

            <div id="quiz-container">
                <?php if ($finished): ?>
                    <h3>Quiz terminé ! Votre score : <?= $_SESSION['score']; ?> / <?= count($questions); ?></h3>
                    <a href="../choixquizz.php?id=<?= $userId ?>" class="login-btn3">Revenir au menu</a>
                <?php else: ?>
                    
                    <h3 class="question" id="question-text">
                        <?= htmlspecialchars($currentQuestion['question_text']); ?>
                    </h3>

                    
                    <form method="post">
                        <div id="answers">
                            <?php foreach ($answers as $answer): ?>
                                <button class="reponses" name="answer" value="<?= $answer['id']; ?>">
                                    <?= htmlspecialchars($answer['answer_text']); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </article>
    </main>

    <footer>
        <div class="footer-text">JOUEZ - APPRENEZ - PROGRESSEZ</div>
    </footer>
</body>

</html>
