<?php
// ============================================================
// models/Admin.php — Gestion des sessions admin
// ============================================================

require_once 'models/Model.php';

class Admin extends Model {

    // Vérifie les identifiants du formulaire de connexion
    // Retourne true si corrects, false sinon
    public function verifierLogin($login, $mdp) {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Admin WHERE login = :login"
        );
        $requete->execute([":login" => $login]);
        $admin = $requete->fetch();

        // password_verify() compare le mdp saisi avec le hash stocké en base
        if ($admin && password_verify($mdp, $admin["mot_de_passe"])) {
            $_SESSION["admin_id"] = $admin["id_admin"];
            $_SESSION["admin_login"] = $admin["login"];
            return true;
        }
        return false;
    }

    // Vérifie si une session admin est active
    public function estConnecte() {
        return isset($_SESSION["admin_id"]);
    }
}
?>