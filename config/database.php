<?php
// ============================================================
// config/database.php — Connexion PDO à MariaDB
// ============================================================

define('DB_HOST', 'mysql03.univ-lyon2.fr');
define('DB_NAME', 'php_mthomas5');
define('DB_USER', 'php_mthomas5');
define('DB_PASS', 'iVe7ZqHEXrhiQ9279JBIHxYuG');
define('DB_CHARSET', 'utf8mb4');

// Connexion unique à la base de données
// Appelée dans le constructeur de la classe Model
function getConnexion(): PDO {
    static $pdo = null;

    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
    }
    return $pdo;
}
?>