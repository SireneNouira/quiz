<?php
session_start();
require_once './utils/connect_db.php';

if (isset($_GET["id"])) {
  $userId = $_GET["id"];
} else {
  die('ID manquant');
}

$sql = "SELECT * FROM `user` WHERE id = :id";

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':id' => $userId,
  ]);

  $user = $stmt->fetch(PDO::FETCH_ASSOC); // ou fetch si vous savez que vous n'allez avoir qu'un seul résultat

} catch (PDOException $error) {
  echo "Erreur lors de la requete : " . $error->getMessage();
}
$sql = 'SELECT * FROM quizze';
try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $error) {
  echo "Erreur lors de la requete : " . $error->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <header>
    <div class="logo">
      <img src="css/quizzlogo.png" alt="logo">
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
    <article class="input-field2 ">
      <h1>HELLO <?= strtoupper($user['pseudo']); ?> </h1>
      <div class="flex">

        <?php
        foreach ($quizzes as $quiz) { ?>
          <div class="card">
            <h2><?= $quiz['title']; ?></h2>
            <img src="./img/iconquizfinal.png" alt="logo-musqiue">
            <p><?= $quiz['description']; ?></p>
            <button type='submit' name='jouer' class="login-btn2">Jouer</button>
          </div>
        <?php
        }
        ?>

      </div>
      <a href="./logout.php" class="login-btn ">DECONNEXION</a>
    </article>
  </main>

  <footer>
    <div class="footer-text">JOUEZ - APPRENEZ - PROGRESSEZ</div>
  </footer>
</body>

</html>