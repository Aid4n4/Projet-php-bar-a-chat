<?php
// ============================================================
// models/CategorieCarte.php — Gestion des catégories de la carte
// ============================================================

require_once 'models/Model.php';

class CategorieCarte extends Model {

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
        $requete = $this->pdo->prepare(
            "INSERT INTO Categorie_Carte (nom) VALUES (:nom)"
        );
        return $requete->execute([":nom" => $nom]);
    }

    public function update($id, $nom) {
        $requete = $this->pdo->prepare(
            "UPDATE Categorie_Carte SET nom = :nom WHERE id_categorie = :id"
        );
        return $requete->execute([":nom" => $nom, ":id" => $id]);
    }

    // Grâce au ON DELETE CASCADE (init.sql), les articles associés sont aussi supprimés automatiquement
    public function delete($id) {
        $requete = $this->pdo->prepare(
            "DELETE FROM Categorie_Carte WHERE id_categorie = :id"
        );
        return $requete->execute([":id" => $id]);
    }
}
?>