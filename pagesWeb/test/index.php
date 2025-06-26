<?php
// index.php
include 'includes/header.php';

// Date et heure actuelles (format français)
$date = date("d/m/Y");
$heure = date("H:i:s");

// Adresse IP du client
$ip = $_SERVER['REMOTE_ADDR'];

// Détection basique du terminal via user-agent
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$isMobile = preg_match('/(android|iphone|ipad|mobile)/i', $userAgent) ? true : false;
$terminal = $isMobile ? "Mobile" : "PC";
?>

<h2>Page d'accueil</h2>

<p>Nous sommes le <strong><?= $date ?></strong> et il est <strong><?= $heure ?></strong>.</p>
<p>Votre adresse IP est : <strong><?= $ip ?></strong></p>
<p>Vous naviguez depuis un terminal : <strong><?= $terminal ?></strong></p>

<p>Bienvenue sur notre site de voyage ! Explorez nos destinations et inscrivez-vous pour un accès personnalisé.</p>

<?php include 'includes/footer.php'; ?>
