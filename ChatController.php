<?php

require_once 'models/Chat.php';

class ChatController {
    private Chat $model;

    public function __construct() {
        $this->model = new Chat();
    }

    public function liste(): void {
        $chat = $this->model->getAll();

        include 'views/templates/header.php';
        include 'views/chats/liste.php';
        include 'views/templates/footer.php';
    }

    public function fiche(int $id): void {
        $chat = $this->model->getById($id);

        if (!$chat) {
            http_response_code(404);
            include 'views/templates/header.php';
            include 'views/erreur/404.php';
            include 'views/templates/footer.php';
            return;
        }

        include 'views/templates/header.php';
        include 'views/chats/fiche.php';
        include 'views/templates/footer.php';
    }

    public function addChat(): void {
        $this->requireAdmin();

        $erreurs = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['nom'])) {
                $erreurs[] = 'Le nom est obligatoire.';
            }
            if (empty($erreurs)) {
                $data = [ 
                ':nom'               => htmlspecialchars(trim($_POST['nom'])),
                ':race'              => htmlspecialchars(trim($_POST['race'] ?? '')),
                ':date_de_naissance' => $_POST['date_de_naissance'] ?? null,
                ':sexe'              => $_POST['sexe'],
                ':car_joueur'        => (int) ($_POST['car_joueur']    ?? 0),
                ':car_calin'         => (int) ($_POST['car_calin']     ?? 0),
                ':car_gourmand'      => (int) ($_POST['car_gourmand']  ?? 0),
                ':car_paresseux'     => (int) ($_POST['car_paresseux'] ?? 0),
                ':desc_vie_avant'    => $_POST['desc_vie_avant']  ?? '',
                ':desc_vie_au_bar'   => $_POST['desc_vie_au_bar'] ?? '',
                ':desc_aime'         => $_POST['desc_aime']       ?? '',
                ':desc_nom'          => $_POST['desc_nom']        ?? '',
                ':photo'             => null,
            ];

            $this->model->insert($data);
            header('Location: index.php?page=admin');
            exit;
            }
        }

        include 'views/templates/header.php';
        include 'views/admin/form_chat.php';
        include 'views/templates/footer.php';
    }

    public function editChat(int $id): void {
        $this->requireAdmin();

        $chat = $this->model->getById($id);
        $erreurs = [];

        if (!chat) {
            header('Location: index.php?page=admin');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (empty($_POST['nom'])) {
                $erreurs[] = 'Le nom est obligatoire.';
            }
            if (empty($erreurs)) {
                $data = [
                ':nom'               => htmlspecialchars(trim($_POST['nom'])),
                ':race'              => htmlspecialchars(trim($_POST['race'] ?? '')),
                ':date_de_naissance' => $_POST['date_de_naissance'] ?? null,
                ':sexe'              => $_POST['sexe'],
                ':car_joueur'        => (int) ($_POST['car_joueur']    ?? 0),
                ':car_calin'         => (int) ($_POST['car_calin']     ?? 0),
                ':car_gourmand'      => (int) ($_POST['car_gourmand']  ?? 0),
                ':car_paresseux'     => (int) ($_POST['car_paresseux'] ?? 0),
                ':desc_vie_avant'    => $_POST['desc_vie_avant']  ?? '',
                ':desc_vie_au_bar'   => $_POST['desc_vie_au_bar'] ?? '',
                ':desc_aime'         => $_POST['desc_aime']       ?? '',
                ':desc_nom'          => $_POST['desc_nom']        ?? '',
                ':photo'             => $chat['photo'], 
                ];

                $this->model->update($id, $data);
                header('Location: index.php?page=admin');
                exit;
            }
        }

        include 'views/templates/header.php';
        include 'views/admin/form_chat.php';
        include 'views/templates/footer.php';
    }
    public function deleteChat(int $id) : void {
        $this->requireAdmin();
        $this->model->delete($id);
        header('Location: index.php?page=admin');
        exit;
    }

    private function requireAdmin(): void {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
    }
}
?>