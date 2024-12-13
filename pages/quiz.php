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


// $questionId = [
//     $question[0] => ,
//     $question[2] => ['id']]
// ;
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
    <title>Document</title>
</head>
<body>
    <h1><?= $quiz['title'];?></h1>


    <p><?= $question[1]['question_text'];?></p>
    <p><?= $answer[0]['answer_text'];?></p>
    <p><?= $answer[1]['answer_text'];?></p>
    <p><?= $answer[2]['answer_text'];?></p>
</body>
</html>