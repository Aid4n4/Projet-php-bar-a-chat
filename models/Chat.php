<?php
// ============================================================
// models/Chat.php — Gestion des résidents
// ============================================================

require_once 'models/Model.php';

class Chat extends Model {

    // Retourne tous les chats triés par nom
    public function getAll() {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Chat ORDER BY nom"
        );
        $requete->execute();
        return $requete->fetchAll();
    }

    // Retourne un seul chat par son id
    public function getById($id) {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Chat WHERE id_chat = :id"
        );
        $requete->execute([":id" => $id]);
        return $requete->fetch();
    }

    // Insère un nouveau chat — $data vient du formulaire admin
    public function insert($data) {
        $requete = $this->pdo->prepare(
            "INSERT INTO Chat
                (nom, race, date_de_naissance, sexe,
                 car_joueur, car_calin, car_gourmand, car_paresseux,
                 desc_vie_avant, desc_vie_au_bar, desc_aime, desc_nom, photo)
             VALUES
                (:nom, :race, :date_de_naissance, :sexe,
                 :car_joueur, :car_calin, :car_gourmand, :car_paresseux,
                 :desc_vie_avant, :desc_vie_au_bar, :desc_aime, :desc_nom, :photo)"
        );
        return $requete->execute($data);
    }

    // Met à jour un chat existant
    public function update($id, $data) {
        $data[":id"] = $id; // on ajoute l'id au tableau pour le WHERE
        $requete = $this->pdo->prepare(
            "UPDATE Chat SET
                nom = :nom, race = :race,
                date_de_naissance = :date_de_naissance, sexe = :sexe,
                car_joueur = :car_joueur, car_calin = :car_calin,
                car_gourmand = :car_gourmand, car_paresseux = :car_paresseux,
                desc_vie_avant = :desc_vie_avant, desc_vie_au_bar = :desc_vie_au_bar,
                desc_aime = :desc_aime, desc_nom = :desc_nom, photo = :photo
             WHERE id_chat = :id"
        );
        return $requete->execute($data);
    }

    // Supprime un chat par son id
    public function delete($id) {
        $requete = $this->pdo->prepare(
            "DELETE FROM Chat WHERE id_chat = :id"
        );
        return $requete->execute([":id" => $id]);
    }
}
?>