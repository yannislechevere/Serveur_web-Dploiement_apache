<?php
// register.php
include 'includes/header.php';
require_once 'includes/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $login = trim($_POST['login']);
    $password = $_POST['password'];

    if ($nom && $prenom && $email && $login && $password) {
        // Vérifie unicité email/login
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ? OR login = ?");
        $stmt->execute([$email, $login]);
        if ($stmt->fetchColumn() > 0) {
            $message = "Erreur : email ou login déjà utilisé.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(16));

            $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, email, login, password, token) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $email, $login, $hash, $token]);

            $lienValidation = "http://" . $_SERVER['HTTP_HOST'] . "/validate.php?token=$token";
            $message = "Inscription réussie ! Cliquez sur le lien de validation (simulation) :<br><a href='$lienValidation'>$lienValidation</a>";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<h2>Inscription</h2>

<?php if ($message): ?>
    <p><?= $message ?></p>
<?php endif; ?>

<form method="post">
    <label>Nom : <input type="text" name="nom" required></label><br>
    <label>Prénom : <input type="text" name="prenom" required></label><br>
    <label>Email : <input type="email" name="email" required></label><br>
    <label>Login : <input type="text" name="login" required></label><br>
    <label>Mot de passe : <input type="password" name="password" required></label><br>
    <button type="submit">S'inscrire</button>
</form>

<?php include 'includes/footer.php'; ?>
