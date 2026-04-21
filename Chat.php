<?php
require_once 'models/Model.php';

class Chat extends Model {
    public function getAll(): array {
        $stmt = $this->pdo->query( 'SELECT * FROM chat ORDER BY nom');
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM chat WHERE id_chat = :id' );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    public function insert(array $data): bool {
        $stmt = $this->pdo->prepare(
            'INSERT INTO chat
            (nom, race, date_de_naissance, sexe, car_joueur, car_calin, car_gourmand, car_paresseux, desc_vie_avant, desc_vie_au_bar, desc_aime, desc_nom, photo)
            VALUES
            (:nom, :race, :date_de_naissance, :sexe, :car_joueur, :car_calin, :car_gourmand, :car_paresseux, :desc_vie_avant, :desc_vie_au_bar, :desc_aime, :desc_nom, :photo)'
        );
        return $stmt->execute($data);
    }

    public function update(int $id, array $data): bool {
        $data[':id'] = $id;
        $stmt = $this->pdo->prepare(
            'UPDATE chat SET
            nom               = :nom,
            race              = :race,
            date_de_naissance = :date_de_naissance,
            sexe              = :sexe,
            car_joueur        = :car_joueur,
            car_calin         = :car_calin,
            car_gourmand      = :car_gourmand,
            car_paresseux     = :car_paresseux,
            desc_vie_avant    = :desc_vie_avant,
            desc_vie_au_bar   = :desc_vie_au_bar,
            desc_aime         = :desc_aime,
            desc_nom          = :desc_nom,
            photo             = :photo
            WHERE id_chat = :id'
        );
        return $stmt->execute($data);
    }

    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare(
            'DELETE FROM chat WHERE id_chat = :id'
        );
        return $stmt->execute([':id' => $id]);
    }
}
?>