<?php
// inscription.php

// Connexion à la base de données
$host = "localhost";
$user = "phpuser";
$password = "lannion";
$dbname = "users";

$conn = new mysqli($host, $user, $password, $dbname);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifie que le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    // Hash du mot de passe
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Prépare et exécute la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO connexions (nom, email, mot_de_passe) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nom, $email, $mot_de_passe_hash);

    if ($stmt->execute()) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>