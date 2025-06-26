<?php
// 404.php
http_response_code(404);
include 'includes/header.php';
?>

<h2>Erreur 404 – Page introuvable</h2>
<p>Désolé, la page que vous cherchez n’existe pas ou a été déplacée.</p>
<p><a href="/index.php">Retour à l'accueil</a></p>

<?php include 'includes/footer.php'; ?>
