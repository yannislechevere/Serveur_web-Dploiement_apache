<?php
// connexion.php
session_start();

// Connexion à la base de données
$host = "localhost";
$user = "userphp";
$password = "lannion";
$dbname = "users";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = htmlspecialchars($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    // Préparer la requête
    $stmt = $conn->prepare("SELECT mot_de_passe FROM connexions WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Vérifie si l'utilisateur existe
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($mot_de_passe_hash);
        $stmt->fetch();

        // Vérifie le mot de passe
        if (password_verify($mot_de_passe, $mot_de_passe_hash)) {
            // Connexion réussie, redirection
            $_SESSION['email'] = $email;
            header("Location: mapage.html");
            exit();
        } else {
            echo "Mot de passe incorrect. <a href='connexion.html'>Réessayer</a>";
        }
    } else {
        echo "Email non trouvé. <a href='connexion.html'>Réessayer</a>";
    }

    $stmt->close();
}

$conn->close();
?>