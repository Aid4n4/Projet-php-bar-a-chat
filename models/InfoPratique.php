<?php
// ============================================================
// models/InfoPratique.php — Gestion des infos pratiques
// Système clé/valeur : cle="adresse" → valeur="10 rue des Chats"
// Données pré-insérées dans init.sql, pas de insert() ni delete()
// ============================================================

require_once 'models/Model.php';

class InfoPratique extends Model {

    public function getAll() {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Info_Pratique"
        );
        $requete->execute();
        return $requete->fetchAll();
    }

    // Retourne la valeur d'une info par sa clé
    // Ex: getByKey("telephone") → "04 72 XX XX XX"
    public function getByKey($cle) {
        $requete = $this->pdo->prepare(
            "SELECT valeur FROM Info_Pratique WHERE cle = :cle"
        );
        $requete->execute([":cle" => $cle]);
        return $requete->fetch();
    }

    public function update($cle, $valeur) {
        $requete = $this->pdo->prepare(
            "UPDATE Info_Pratique SET valeur = :valeur WHERE cle = :cle"
        );
        return $requete->execute([":valeur" => $valeur, ":cle" => $cle]);
    }
}
?>