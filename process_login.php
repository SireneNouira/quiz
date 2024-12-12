<?php

require_once './utils/connect_db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer et sécuriser le pseudo envoyé via le formulaire
    $pseudo = trim($_POST['pseudo']);

    if (!empty($pseudo)) {
        try {
            // Vérifier si le pseudo existe déjà dans la base de données
            $stmt = $pdo->prepare("SELECT * FROM users WHERE pseudo = :pseudo");
            $stmt->execute(['pseudo' => $pseudo]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Si le pseudo existe, connecter l'utilisateur
                echo "Bienvenue, " . htmlspecialchars($pseudo) . " ! Vous êtes connecté.";
            } else {
                // Sinon, créer un nouvel utilisateur
                $stmt = $pdo->prepare("INSERT INTO users (pseudo) VALUES (:pseudo)");
                $stmt->execute(['pseudo' => $pseudo]);
                echo "Bienvenue, " . htmlspecialchars($pseudo) . " ! Votre compte a été créé.";
            }
        } catch (PDOException $error) {
            echo "Erreur lors du traitement : " . $error->getMessage();
        }
    } else {
        echo "Erreur : Le pseudo est obligatoire.";
    }
} else {
    echo "Erreur : Requête invalide.";
}
