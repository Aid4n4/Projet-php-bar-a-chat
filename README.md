# Le Ronron Café — Site web d'un bar à chats fictif

Projet universitaire réalisé en binôme dans le cadre de la licence Informatique (L3) à l'Université Lyon 2.  
Site web dynamique pour un bar à chats fictif, développé en PHP avec une architecture MVC.

---

## Aperçu

| Page d'accueil | Les résidents |
|:-:|:-:|
| ![Accueil](screenshots/accueil.png) | ![Résidents](screenshots/residents.png) |

| La carte | Réservation |
|:-:|:-:|
| ![Carte](screenshots/carte.png) | ![Réservation](screenshots/reservation.png) |

| Infos pratiques | Tableau de bord admin |
|:-:|:-:|
| ![Infos](screenshots/infos.png) | ![Admin](screenshots/admin.png) |

---

## Technologies utilisées

- **PHP** — logique serveur et routing
- **MariaDB** — base de données relationnelle
- **PDO** — accès sécurisé à la base (requêtes préparées)
- **CSS** — mise en page et design (palette rose/pêche/or, police Pacifico)
- **Architecture MVC** — séparation claire des responsabilités

---

## Fonctionnalités

- Présentation des chats résidents avec fiches détaillées
- Menu du café (boissons, snacks) organisé par catégories
- Formulaire de réservation en ligne
- Espace d'administration sécurisé (authentification par session)
- Upload de photos pour les chats et les produits
- Gestion des horaires d'ouverture
- CRUD complet sur toutes les entités (admin)

---

## Structure de la base de données

La base contient 7 tables :

- `chats` — fiches des chats résidents
- `categories_menu` — catégories du menu
- `produits` — items du menu
- `reservations` — réservations des clients
- `horaires` — horaires d'ouverture
- `infos_site` — informations générales du café
- `admins` — comptes administrateurs

---

## Architecture du projet

```
Projet-php-bar-a-chat/
├── config/          # Configuration BDD et constantes
├── controllers/     # Contrôleurs (logique métier)
├── models/          # Modèles (accès aux données)
├── views/           # Templates HTML/PHP
├── public/          # Assets publics (CSS, images, JS)
├── index.php        # Point d'entrée unique (front controller)
└── init.sql         # Script d'initialisation de la base de données
```

---

## Installation locale

### Prérequis

- PHP 8.x
- MariaDB / MySQL
- Un serveur local type XAMPP, WAMP ou Laragon

### Étapes

1. Clone le repo
   ```bash
   git clone https://github.com/Aid4n4/Projet-php-bar-a-chat.git
   ```

2. Importe la base de données
   ```bash
   mysql -u root -p < init.sql
   ```

3. Configure la connexion dans `config/`  
   Renseigne tes identifiants BDD (hôte, nom de base, utilisateur, mot de passe)

4. Lance ton serveur local et ouvre le projet dans ton navigateur

---

## Auteurs

- **Serena** — [@Aid4n4](https://github.com/Aid4n4)
- Projet réalisé en binôme — Université Lyon 2, 2024-2025
