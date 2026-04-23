<?php
// ============================================================
// models/Reservation.php — Gestion des réservations
// ============================================================

require_once 'models/Model.php';

class Reservation extends Model {

    // Retourne toutes les réservations, les plus récentes en premier
    public function getAll() {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Reservation ORDER BY date_reservation DESC, heure DESC"
        );
        $requete->execute();
        return $requete->fetchAll();
    }

    public function getById($id) {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Reservation WHERE id_reservation = :id"
        );
        $requete->execute([":id" => $id]);
        return $requete->fetch();
    }

    // Le statut n'est pas dans $data : défini à 'en_attente' par défaut dans init.sql
    public function insert($data) {
        $requete = $this->pdo->prepare(
            "INSERT INTO Reservation
                (date_reservation, heure, nb_personnes,
                 nom_client, email, telephone, commentaire)
             VALUES
                (:date_reservation, :heure, :nb_personnes,
                 :nom_client, :email, :telephone, :commentaire)"
        );
        return $requete->execute($data);
    }

    // L'admin ne modifie que le statut (en_attente / confirmee / annulee)
    public function updateStatut($id, $statut) {
        $requete = $this->pdo->prepare(
            "UPDATE Reservation SET statut = :statut WHERE id_reservation = :id"
        );
        return $requete->execute([":statut" => $statut, ":id" => $id]);
    }

    public function delete($id) {
        $requete = $this->pdo->prepare(
            "DELETE FROM Reservation WHERE id_reservation = :id"
        );
        return $requete->execute([":id" => $id]);
    }
}
?>