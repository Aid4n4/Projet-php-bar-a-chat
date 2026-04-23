<?php
// ============================================================
// models/Horaire.php — Gestion des horaires d'ouverture
// Les 7 jours sont pré-insérés dans init.sql pas de insert() ni delete()
// ============================================================

require_once 'models/Model.php';

class Horaire extends Model {

    // Retourne les horaires des 7 jours de la semaine
    public function getAll() {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Horaire"
        );
        $requete->execute();
        return $requete->fetchAll();
    }

    // Met à jour les horaires d'un jour précis par son id
    public function updateById($id, $data) {
        $data[":id"] = $id;
        $requete = $this->pdo->prepare(
            "UPDATE Horaire SET
                heure_ouverture = :heure_ouverture,
                heure_fermeture = :heure_fermeture,
                est_ouvert = :est_ouvert
             WHERE id_horaire = :id"
        );
        return $requete->execute($data);
    }
}
?>