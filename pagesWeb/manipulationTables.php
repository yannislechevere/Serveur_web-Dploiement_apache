<?php
$host = 'localhost';
$user = 'userphp';
$password = 'lannion';
$dbname = 'chauvel2';

try {
    $pdo = new PDO("mysql:host=$host", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Base de données '$dbname' créée ou déjà existante.<br>";

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS etudiant (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nom VARCHAR(100) NOT NULL,
            date_naissance DATE NOT NULL,
            classement INT NOT NULL
        )
    ");
    echo "Table 'etudiant' créée ou déjà existante.<br>";

    $pdo->exec("
        INSERT INTO etudiant (nom, date_naissance, classement) VALUES
        ('Alice Dupont', '2000-05-10', 1),
        ('Bob Martin', '1999-08-15', 2),
        ('Claire Durand', '2001-02-20', 3)
    ");
    echo "3 étudiants insérés.<br>";

    $pdo->exec("DELETE FROM etudiant WHERE id = 2");
    echo "Étudiant avec ID = 2 supprimé.<br>";

    $stmt = $pdo->query("SELECT MIN(id) as min_id FROM etudiant");
    $row = $stmt->fetch();
    $min_id = $row['min_id'];

    if ($min_id !== null) {
        $pdo->prepare("UPDATE etudiant SET date_naissance = :date WHERE id = :id")
            ->execute([':date' => '1990-01-01', ':id' => $min_id]);
        echo "Date de naissance de l'étudiant avec ID = $min_id mise à jour au 1er janvier 1990.<br>";
    } else {
        echo "Aucun étudiant trouvé pour mise à jour.<br>";
    }

} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>