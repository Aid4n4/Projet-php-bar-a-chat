<?php

class Modele {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
}

class Admin extends Modele{

    public function verifierLogin($login, $mdp) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Admin WHERE login = :login"
        );
        $stmt->execute([":login" => $login]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($mdp, $admin["mot_de_passe"])) {
            $_SESSION["admin_id"] = $admin["id_admin"];
            $_SESSION["admin_login"] = $admin["login"];
            return true;
        }
        return false;
    }

    public function estConnecte() {
        return isset($_SESSION["admin_id"]);
    }
}

class Chat extends Modele {

    public function getAll() {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Chat ORDER BY nom"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Chat WHERE id_chat = :id"
        );
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public function insert($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO Chat
                (nom, race, date_de_naissance, sexe,
                 car_joueur, car_calin, car_gourmand, car_paresseux,
                 desc_vie_avant, desc_vie_au_bar, desc_aime, desc_nom, photo)
             VALUES
                (:nom, :race, :date_de_naissance, :sexe,
                 :car_joueur, :car_calin, :car_gourmand, :car_paresseux,
                 :desc_vie_avant, :desc_vie_au_bar, :desc_aime, :desc_nom, :photo)"
        );
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $data[":id"] = $id;
        $stmt = $this->pdo->prepare(
            "UPDATE Chat SET
                nom = :nom, race = :race,
                date_de_naissance = :date_de_naissance, sexe = :sexe,
                car_joueur = :car_joueur, car_calin = :car_calin,
                car_gourmand = :car_gourmand, car_paresseux = :car_paresseux,
                desc_vie_avant = :desc_vie_avant, desc_vie_au_bar = :desc_vie_au_bar,
                desc_aime = :desc_aime, desc_nom = :desc_nom, photo = :photo
             WHERE id_chat = :id"
        );
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare(
            "DELETE FROM Chat WHERE id_chat = :id"
        );
        return $stmt->execute([":id" => $id]);
    }
}

class CategorieCarte extends Modele {

    public function getAll() {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Categorie_Carte ORDER BY nom"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Categorie_Carte WHERE id_categorie = :id"
        );
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public function insert($nom) {
        $stmt =$this->pdo->prepare(
            "INSERT INTO Categorie_Carte (nom) VALUES (:nom)"
        );
        return $stmt->execute([":nom" => $nom]);
    }

    public function update($id, $nom) {
        $stmt = $this->pdo->prepare(
            "UDPATE Categorie_Carte SET nom = :nom WHERE id_categorie = :id"
        );
        return $stmt->execute([":nom" =>$nom, ":id" => $id]);
    }

    public function delete ($id) {
        $stmt = $this->pdo->prepare(
            "DELETE FROM Categorie_Carte WHERE id_categorie = :id"
        );
        return $stmt->execute([":id" => $id]);
    }

}

class ArticleCarte extends Modele {

    public function getAll() {
        $stmt->pdo->prepare(
            "SELECT a.*, c.nom AS nom_categorie FROM Article_Carte a 
            JOIN Categorie_Carte c ON a.id_categorie = c.id_categorie 
            ORDER BY c.nom, a.nom"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByCategorie($id_cat) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Article_Carte WHERE id_categorie = :id_cat ORDER BY nom"
        );
        $stmt->execute([":id_cat" => $id_cat]);
        return $stmt->fetchAll();
    }

    public function insert($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO Article_Carte (nom, description, prix, id_categorie) VALUES (:nom, :description, :prix, :id_categorie)"
        );
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $data[":id"] = $id;
        $stmt = $this->pdo->prepare(
            "UPDATE Article_Carte SET
                nom = :nom,
                description = :description,
                prix = :prix,
                id_categorie = :id_categorie
            WHERE id_article = :id"
        );
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare(
            "DELETE FROM Article_Carte WHERE id_article = :id"
        );
        return $stmt->execute([":id" => $id]);
    }

}

class Horaire extends Modele {

    public function getAll() {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Horaire"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateById($id, $data) {
        $data[":id"] = $id;
        $stmt = $this->pdo->prepare(
            "UPDATE Horaire SET
                heure_ouverture = :heure_ouverture,
                heure_fermeture = :heure_fermeture,
                est_ouvert = :est_ouvert
            WHERE id_horaire = :id"
        );
        return $stmt->execute($data);
    }
}

class Reservation extends Modele {

    public function getAll() {
        $stmt = $this->pdo->prepare(
            "SELCT * FROM Reservation ORDER BY date_reservation DESC, heure DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Reservation WHERE id_reservation = :id"
        );
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    public function insert($data) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO Reservation 
                (date_reservation, heure, nb_personnes,
                nom_client, email, telephone, commentaire)
             VALUES
                (:date_reservation, :heure, :nb_personnes,
                 :nom_client, :email, :telephone, :commentaire)"
        );
        return $stmt->execute($data);
    }

    public function updateStatut($id, $statut) {
        $stmt = $this->pdo->prepare(
            "UPDATE Reservation SET statut = :statut WHERE id_reservation = :id"
        );
        return $stmt->execute([":statut" =>$statut, ":id" => $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare(
            "DELETE FROM Reservation WHERE id_reservation = :id"
        );
        return $stmt->execute([":id" =>$id]);
    }
}

class InfoPratique extends Modele {

    public function getAll() {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Info_Pratique"
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getByKey($cle) {
        $stmt = $this->pdo->prepare(
            "SELECT valeur FROM Info_Pratique WHERE cle = :cle"
        );
        $stmt->execute([":cle" => $cle]);
        return $stmt->fetch();
    }

    public function update($cle, $valeur) {
        $stmt = $this->pdo->prepare(
            "UPDATE Info_Pratique SET valeur = :valeur WHERE che = :cle"
        );
        return $stmt->execute([":valeur" => $valeur, ":cle" => $cle]);
    }
}
?>