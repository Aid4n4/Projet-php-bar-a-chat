<?php
// ============================================================
// controleur.class.php — Classe contrôleur
// ============================================================

class Appli {

    private $tbs;   // objet TinyButStrong pour afficher les vues
    private $admin; // objet Admin pour gérer les sessions

    public function __construct($tbs, $pdo) {
        $this->tbs = $tbs;
        $this->admin = new Admin($pdo);
    }

    public function moteur($pdo) {
        // On lit le paramètre "page" dans l'URL
        // Ex: controleur.php?page=residents
        // Si aucun paramètre → page par défaut = "accueil"
        $page = isset($_GET["page"]) ? $_GET["page"] : "accueil";

        // Instanciation des modèles
        $accChat       = new Chat($pdo);
        $accCategorie  = new CategorieCarte($pdo);
        $accArticle    = new ArticleCarte($pdo);
        $accHoraire    = new Horaire($pdo);
        $accReservation = new Reservation($pdo);
        $accInfo       = new InfoPratique($pdo);

        // Routing : on affiche la bonne page selon l'URL
        switch ($page) {

            case "accueil":
                // On récupère les horaires et infos pratiques pour les afficher
                $horaires = $accHoraire->getAll();
                $infos    = $accInfo->getAll();

                $this->tbs->LoadTemplate("vues/vue-accueil.php");
                $this->tbs->MergeBlock("horaire", $horaires);
                $this->tbs->MergeBlock("info", $infos);
                $this->tbs->Show();
                break;

            case "residents":
                $chats = $accChat->getAll();

                $this->tbs->LoadTemplate("vues/vue-residents.php");
                $this->tbs->MergeBlock("chat", $chats);
                $this->tbs->Show();
                break;

            case "fiche":
                // On récupère l'id dans l'URL et on le cast en int pour sécuriser
                $id   = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
                $chat = $accChat->getById($id);

                $this->tbs->LoadTemplate("vues/vue-fiche-chat.php");
                $this->tbs->MergeBlock("chat", [$chat]);
                $this->tbs->Show();
                break;

            case "carte":
                $categories = $accCategorie->getAll();
                $articles   = $accArticle->getAll();

                $this->tbs->LoadTemplate("vues/vue-carte.php");
                $this->tbs->MergeBlock("categorie", $categories);
                $this->tbs->MergeBlock("article", $articles);
                $this->tbs->Show();
                break;

            case "reservation":
                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    // Le visiteur a soumis le formulaire → on insère la réservation
                    $accReservation->insert([
                        ":date_reservation" => $_POST["date_reservation"],
                        ":heure"            => $_POST["heure"],
                        ":nb_personnes"     => (int) $_POST["nb_personnes"],
                        ":nom_client"       => htmlspecialchars($_POST["nom_client"]),
                        ":email"            => htmlspecialchars($_POST["email"]),
                        ":telephone"        => htmlspecialchars($_POST["telephone"] ?? ""),
                        ":commentaire"      => $_POST["commentaire"] ?? "",
                    ]);
                    // Redirection pour éviter de soumettre deux fois le formulaire
                    header("Location: controleur.php?page=reservation&ok=1");
                    exit;
                }

                // GET → on affiche juste le formulaire
                $this->tbs->LoadTemplate("vues/vue-reservation.php");
                $this->tbs->Show();
                break;

            case "infos":
                $horaires = $accHoraire->getAll();
                $infos    = $accInfo->getAll();
                
                $this->tbs->LoadTemplate("vues/vue-infos.php");
                $this->tbs->MergeBlock("horaire", $horaires);
                $this->tbs->MergeBlock("info", $infos);
                $this->tbs->Show();
                break;

            case "login":
                // Si déjà connecté → on redirige directement vers le dashboard
                if ($this->admin->estConnecte()) {
                    header("Location: controleur.php?page=admin");
                    exit;
                }

                $erreur = "";

                if ($_SERVER["REQUEST_METHOD"] === "POST") {
                    // On vérifie les identifiants saisis dans le formulaire
                    if ($this->admin->verifierLogin($_POST["login"], $_POST["mot_de_passe"])) {
                        // Connexion réussie → dashboard
                        header("Location: controleur.php?page=admin");
                        exit;
                    } else {
                        // Identifiants incorrects → message d'erreur
                        $erreur = "Identifiants incorrects.";
                    }
                }

                // GET ou échec → on affiche le formulaire de connexion
                $this->tbs->LoadTemplate("vues/vue-login.php");
                $this->tbs->MergeField("erreur", $erreur);
                $this->tbs->Show();
                break;
            
            case "logout":
                // On détruit la session et toutes ses variables
                session_destroy();
                // On redirige vers le formulaire de connexion
                header("Location: controleur.php?page=login");
                exit;

            case "admin":
                // Vérification que l'admin est connecté
                // Si non → redirection vers le login
                if (!$this->admin->estConnecte()) {
                    header("Location: controleur.php?page=login");
                    exit;
                }

                // On lit l'action demandée, "dashboard" par défaut
                $action = isset($_GET["action"]) ? $_GET["action"] : "dashboard";

                switch ($action) {

                    // ── Dashboard ────────────────────────────
                    case "dashboard":
                        $chats        = $accChat->getAll();
                        $reservations = $accReservation->getAll();

                        $this->tbs->LoadTemplate("vues/vue-admin.php");
                        $this->tbs->MergeBlock("chat", $chats);
                        $this->tbs->MergeBlock("reservation", $reservations);
                        $this->tbs->Show();
                        break;

                    // ── Gestion des chats ────────────────────
                    case "form_ajout_chat":
                        $this->tbs->LoadTemplate("vues/vue-form-chat.php");
                        $this->tbs->Show();
                        break;

                    case "ajout_chat":
                        $accChat->insert([
                            ":nom"               => htmlspecialchars($_POST["nom"]),
                            ":race"              => htmlspecialchars($_POST["race"] ?? ""),
                            ":date_de_naissance" => $_POST["date_de_naissance"] ?? null,
                            ":sexe"              => $_POST["sexe"],
                            ":car_joueur"        => (int) ($_POST["car_joueur"]    ?? 0),
                            ":car_calin"         => (int) ($_POST["car_calin"]     ?? 0),
                            ":car_gourmand"      => (int) ($_POST["car_gourmand"]  ?? 0),
                            ":car_paresseux"     => (int) ($_POST["car_paresseux"] ?? 0),
                            ":desc_vie_avant"    => $_POST["desc_vie_avant"]  ?? "",
                            ":desc_vie_au_bar"   => $_POST["desc_vie_au_bar"] ?? "",
                            ":desc_aime"         => $_POST["desc_aime"]       ?? "",
                            ":desc_nom"          => $_POST["desc_nom"]        ?? "",
                            ":photo"             => null,
                        ]);
                        header("Location: controleur.php?page=admin&action=dashboard");
                        exit;

                    case "form_edit_chat":
                        $id   = (int) ($_GET["id"] ?? 0);
                        $chat = $accChat->getById($id);

                        $this->tbs->LoadTemplate("vues/vue-form-chat.php");
                        $this->tbs->MergeBlock("chat", [$chat]);
                        $this->tbs->Show();
                        break;

                    case "edit_chat":
                        $id   = (int) ($_POST["id"] ?? 0);
                        $data = [
                            ":nom"               => htmlspecialchars($_POST["nom"]),
                            ":race"              => htmlspecialchars($_POST["race"] ?? ""),
                            ":date_de_naissance" => $_POST["date_de_naissance"] ?? null,
                            ":sexe"              => $_POST["sexe"],
                            ":car_joueur"        => (int) ($_POST["car_joueur"]    ?? 0),
                            ":car_calin"         => (int) ($_POST["car_calin"]     ?? 0),
                            ":car_gourmand"      => (int) ($_POST["car_gourmand"]  ?? 0),
                            ":car_paresseux"     => (int) ($_POST["car_paresseux"] ?? 0),
                            ":desc_vie_avant"    => $_POST["desc_vie_avant"]  ?? "",
                            ":desc_vie_au_bar"   => $_POST["desc_vie_au_bar"] ?? "",
                            ":desc_aime"         => $_POST["desc_aime"]       ?? "",
                            ":desc_nom"          => $_POST["desc_nom"]        ?? "",
                            ":photo"             => null,
                        ];
                        $accChat->update($id, $data);
                        header("Location: controleur.php?page=admin&action=dashboard");
                        exit;

                    case "suppr_chat":
                        $accChat->delete((int) ($_GET["id"] ?? 0));
                        header("Location: controleur.php?page=admin&action=dashboard");
                        exit;

                    // ── Gestion des articles ─────────────────
                    case "form_ajout_article":
                        $categories = $accCategorie->getAll();
                        $this->tbs->LoadTemplate("vues/vue-form-article.php");
                        $this->tbs->MergeBlock("categorie", $categories);
                        $this->tbs->Show();
                        break;

                    case "ajout_article":
                        $accArticle->insert([
                            ":nom"          => htmlspecialchars($_POST["nom"]),
                            ":description"  => $_POST["description"] ?? "",
                            ":prix"         => (float) $_POST["prix"],
                            ":id_categorie" => (int) $_POST["id_categorie"],
                        ]);
                        header("Location: controleur.php?page=admin&action=dashboard");
                        exit;

                    case "suppr_article":
                        $accArticle->delete((int) ($_GET["id"] ?? 0));
                        header("Location: controleur.php?page=admin&action=dashboard");
                        exit;

                    // ── Gestion des horaires ─────────────────
                    case "form_horaires":
                        $horaires = $accHoraire->getAll();
                        $this->tbs->LoadTemplate("vues/vue-form-horaires.php");
                        $this->tbs->MergeBlock("horaire", $horaires);
                        $this->tbs->Show();
                        break;

                    case "edit_horaires":
                        // $_POST["horaires"] est un tableau indexé par id_horaire
                        foreach ($_POST["horaires"] as $id => $data) {
                            $accHoraire->updateById((int) $id, [
                                ":heure_ouverture" => $data["heure_ouverture"] ?: null,
                                ":heure_fermeture" => $data["heure_fermeture"] ?: null,
                                ":est_ouvert"      => isset($data["est_ouvert"]) ? 1 : 0,
                            ]);
                        }
                        header("Location: controleur.php?page=admin&action=dashboard");
                        exit;

                    // ── Gestion des infos pratiques ──────────
                    case "form_infos":
                        $infos = $accInfo->getAll();
                        $this->tbs->LoadTemplate("vues/vue-form-infos.php");
                        $this->tbs->MergeBlock("info", $infos);
                        $this->tbs->Show();
                        break;

                    case "edit_infos":
                        // $_POST["infos"] est un tableau indexé par clé
                        foreach ($_POST["infos"] as $cle => $valeur) {
                            $accInfo->update($cle, $valeur);
                        }
                        header("Location: controleur.php?page=admin&action=dashboard");
                        exit;

                    // ── Gestion des réservations ─────────────
                    case "reservations":
                        $reservations = $accReservation->getAll();
                        $this->tbs->LoadTemplate("vues/vue-reservations-admin.php");
                        $this->tbs->MergeBlock("reservation", $reservations);
                        $this->tbs->Show();
                        break;

                    case "statut_reservation":
                        $accReservation->updateStatut(
                            (int) ($_GET["id"] ?? 0),
                            $_GET["statut"] ?? "en_attente"
                        );
                        header("Location: controleur.php?page=admin&action=reservations");
                        exit;

                    case "suppr_reservation":
                        $accReservation->delete((int) ($_GET["id"] ?? 0));
                        header("Location: controleur.php?page=admin&action=reservations");
                        exit;

                    default:
                        header("Location: controleur.php?page=admin&action=dashboard");
                        exit;
                }
                break;

            default:
                // page inconnue → retour à l'accueil
                header("Location: controleur.php?page=accueil");
                exit;
        }
    }

}