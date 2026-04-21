<?php
require_once 'config/database.php';

abstract class Model {
    protected PDO $pdo;

    public function __construct() {
        $this->pdo = getConnexion();
    }
}
?>