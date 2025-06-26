<?php
// includes/db.php

$host = 'localhost';
$dbname = 'sae203';        // Change si ta base a un autre nom
$user = 'root';
$password = 'lannion';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
