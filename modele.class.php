<?php

class Modele {

    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

}

class Admin extends Modele{

    public function verifierLogin($login, $mdp) {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Admin WHERE login = :login"
        );
        $requete->execute([":login" => $login]);
        $admin = $requete->fetch();

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
        $requete = $this->pdo->prepare(
            "SELECT * FROM Chat ORDER BY nom"
        );
        $requete->execute();
        return $requete->fetchAll();
    }

    public function getById($id) {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Chat WHERE id_chat = :id"
        );
        $requete->execute([":id" => $id]);
        return $requete->fetch();
    }

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

    public function update($id, $data) {
        $data[":id"] = $id;
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

    public function delete($id) {
        $requete = $this->pdo->prepare(
            "DELETE FROM Chat WHERE id_chat = :id"
        );
        return $requete->execute([":id" => $id]);
    }

}

class CategorieCarte extends Modele {

    public function getAll() {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Categorie_Carte ORDER BY nom"
        );
        $requete->execute();
        return $requete->fetchAll();
    }

    public function getById($id) {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Categorie_Carte WHERE id_categorie = :id"
        );
        $requete->execute([":id" => $id]);
        return $requete->fetch();
    }

    public function insert($nom) {
        $requete =$this->pdo->prepare(
            "INSERT INTO Categorie_Carte (nom) VALUES (:nom)"
        );
        return $requete->execute([":nom" => $nom]);
    }

    public function update($id, $nom) {
        $requete = $this->pdo->prepare(
            "UPDATE Categorie_Carte SET nom = :nom WHERE id_categorie = :id"
        );
        return $requete->execute([":nom" =>$nom, ":id" => $id]);
    }

    public function delete($id) {
        $requete = $this->pdo->prepare(
            "DELETE FROM Categorie_Carte WHERE id_categorie = :id"
        );
        return $requete->execute([":id" => $id]);
    }

}

class ArticleCarte extends Modele {

    public function getAll() {
        $requete = $this->pdo->prepare(
            "SELECT a.*, c.nom AS nom_categorie FROM Article_Carte a 
            JOIN Categorie_Carte c ON a.id_categorie = c.id_categorie 
            ORDER BY c.nom, a.nom"
        );
        $requete->execute();
        return $requete->fetchAll();
    }

    public function getByCategorie($id_cat) {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Article_Carte WHERE id_categorie = :id_cat ORDER BY nom"
        );
        $requete->execute([":id_cat" => $id_cat]);
        return $requete->fetchAll();
    }

    public function insert($data) {
        $requete = $this->pdo->prepare(
            "INSERT INTO Article_Carte (nom, description, prix, id_categorie) VALUES (:nom, :description, :prix, :id_categorie)"
        );
        return $requete->execute($data);
    }

    public function update($id, $data) {
        $data[":id"] = $id;
        $requete = $this->pdo->prepare(
            "UPDATE Article_Carte SET
                nom = :nom,
                description = :description,
                prix = :prix,
                id_categorie = :id_categorie
            WHERE id_article = :id"
        );
        return $requete->execute($data);
    }

    public function delete($id) {
        $requete = $this->pdo->prepare(
            "DELETE FROM Article_Carte WHERE id_article = :id"
        );
        return $requete->execute([":id" => $id]);
    }

}

class Horaire extends Modele {

    public function getAll() {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Horaire"
        );
        $requete->execute();
        return $requete->fetchAll();
    }

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

class Reservation extends Modele {

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

    public function updateStatut($id, $statut) {
        $requete = $this->pdo->prepare(
            "UPDATE Reservation SET statut = :statut WHERE id_reservation = :id"
        );
        return $requete->execute([":statut" =>$statut, ":id" => $id]);
    }

    public function delete($id) {
        $requete = $this->pdo->prepare(
            "DELETE FROM Reservation WHERE id_reservation = :id"
        );
        return $requete->execute([":id" =>$id]);
    }

}

class InfoPratique extends Modele {

    public function getAll() {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Info_Pratique"
        );
        $requete->execute();
        return $requete->fetchAll();
    }

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
