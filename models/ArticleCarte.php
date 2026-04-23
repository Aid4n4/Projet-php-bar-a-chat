<?php
// ============================================================
// models/ArticleCarte.php — Gestion des articles de la carte
// ============================================================

require_once 'models/Model.php';

class ArticleCarte extends Model {

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

    // Retourne un seul article par son id
    public function getById($id) {
        $requete = $this->pdo->prepare(
            "SELECT * FROM Article_Carte WHERE id_article = :id"
        );
        $requete->execute([":id" => $id]);
        return $requete->fetch();
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
            "INSERT INTO Article_Carte (nom, description, prix, id_categorie)
             VALUES (:nom, :description, :prix, :id_categorie)"
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
?>
