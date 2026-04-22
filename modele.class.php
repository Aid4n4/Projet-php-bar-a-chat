<?php
// ============================================================
// modele.class.php — Classes modèles
// Contient toutes les classes qui interagissent avec la base de données.
// Chaque classe correspond à une table de la base de données.
// ============================================================

// ──────────────────────────────────────────────
// Classe Modele — Classe parente
// Toutes les autres classes héritent de celle-ci.
// Elle centralise la connexion PDO pour éviter de la répéter dans chaque classe.
// ──────────────────────────────────────────────
class Modele {

    protected $pdo; // accessible dans toutes les classes filles

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

}

// ──────────────────────────────────────────────
// Classe Admin — Gestion des sessions admin
// ──────────────────────────────────────────────
class Admin extends Modele{

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

// ──────────────────────────────────────────────
// Classe Chat — Gestion des résidents
// ──────────────────────────────────────────────
class Chat extends Modele {

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

// ──────────────────────────────────────────────
// Classe CategorieCarte — Gestion des catégories de la carte
// ──────────────────────────────────────────────
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

    // Prend $nom seul (pas un tableau) car une catégorie n'a qu'un seul attribut
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

    // Grâce au ON DELETE CASCADE (init.sql), les articles associés sont aussi supprimés automatiquement
    public function delete($id) {
        $requete = $this->pdo->prepare(
            "DELETE FROM Categorie_Carte WHERE id_categorie = :id"
        );
        return $requete->execute([":id" => $id]);
    }

}

// ──────────────────────────────────────────────
// Classe ArticleCarte — Gestion des articles de la carte
// ──────────────────────────────────────────────
class ArticleCarte extends Modele {

    // JOIN pour récupérer le nom de la catégorie en une seule requête
    public function getAll() {
        $requete = $this->pdo->prepare(
            "SELECT a.*, c.nom AS nom_categorie FROM Article_Carte a 
            JOIN Categorie_Carte c ON a.id_categorie = c.id_categorie 
            ORDER BY c.nom, a.nom"
        );
        $requete->execute();
        return $requete->fetchAll();
    }

    // Retourne les articles d'une catégorie précise
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

// ──────────────────────────────────────────────
// Classe Horaire — Gestion des horaires d'ouverture
// Les 7 jours sont pré-insérés dans init.sql, pas de insert() ni delete()
// ──────────────────────────────────────────────
class Horaire extends Modele {

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

// ──────────────────────────────────────────────
// Classe Reservation — Gestion des réservations
// ──────────────────────────────────────────────
class Reservation extends Modele {

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
        return $requete->execute([":statut" =>$statut, ":id" => $id]);
    }

    public function delete($id) {
        $requete = $this->pdo->prepare(
            "DELETE FROM Reservation WHERE id_reservation = :id"
        );
        return $requete->execute([":id" =>$id]);
    }

}

// ──────────────────────────────────────────────
// Classe InfoPratique — Gestion des infos pratiques
// Système clé/valeur : cle="adresse" → valeur="10 rue des Chats"
// Données pré-insérées dans init.sql, pas de insert() ni delete()
// ──────────────────────────────────────────────
class InfoPratique extends Modele {

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
