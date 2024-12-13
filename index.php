<?php
session_start();
require './utils/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = trim($_POST['pseudo']);
    if (!empty($pseudo)) {
        $stmt = $pdo->prepare("SELECT id FROM user WHERE pseudo = :pseudo");
        $stmt->execute(['pseudo' => $pseudo]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
        } else {
            $stmt = $pdo->prepare("INSERT INTO user (pseudo) VALUES (:pseudo)");
            $stmt->execute(['pseudo' => $pseudo]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
        }
        header("Location: index.php");
        exit();
    }
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
      <div class="login-container">
        <div class="logo-container">
       <img src="css/quizzlogo.png" alt="logo" class="logomain">
        </div>
        <form class="input-field" method="POST" action="">
        <label for="pseudo" >Pseudo :</label>
        <input type="text" name="pseudo" placeholder="PSEUDO..." class="input-field" id="pseudo" required>
        <button type="submit" class="login-btn">Se connecter</button>
    </form>
        <!-- <input type="text" placeholder="PSEUDO..." class="input-field">
        <div class="divloginbutton">      
          <a href="choixquizz.html" class="login-btn">CONNEXION</a>
        </div>   -->
      </div>
    </main>
  
    <footer>
      <div class="footer-text">JOUEZ - APPRENEZ - PROGRESSEZ</div>
    </footer>
  </body>
  </html>

