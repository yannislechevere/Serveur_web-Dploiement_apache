<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Informations de connexion
$host = 'localhost';
$user = 'phpuser';
$password = 'lannion';

// Connexion à MySQL
$conn = new mysqli($host, $user, $password);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Requête SQL
$sql = "SHOW DATABASES";
$result = $conn->query($sql);

// Affiche les résultats
if ($result->num_rows > 0) {
    echo "<h2>Bases de données disponibles :</h2><ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row["Database"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Aucune base de données trouvée.";
}

$conn->close();
?>
