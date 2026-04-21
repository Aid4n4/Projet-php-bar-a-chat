-- ============================================================
-- init.sql — Initialisation de la base de données du bar à chats
-- Projet : Bar à chats — L3 Info 2025-2026
-- ============================================================

-- Table : Admin
CREATE TABLE Admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL
);

-- Table : Chat
CREATE TABLE Chat (
    id_chat INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    race VARCHAR(100),
    date_de_naissance DATE NOT NULL,
    sexe ENUM('Mâle', 'Femelle') NOT NULL,
    car_joueur INT DEFAULT 0,
    car_calin INT DEFAULT 0,
    car_gourmand INT DEFAULT 0,
    car_paresseux INT DEFAULT 0,
    desc_vie_avant TEXT,
    desc_vie_au_bar TEXT,
    desc_aime TEXT,
    desc_nom TEXT,
    photo VARCHAR(255) NOT NULL
);

-- Table : Categorie_Carte
CREATE TABLE Categorie_Carte (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

-- Table : Article_Carte
-- id_categorie est une clé étrangère vers Categorie_Carte
-- ON DELETE CASCADE : si on supprime une catégorie, ses articles sont supprimés automatiquement
CREATE TABLE Article_Carte (
    id_article INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT,
    prix DECIMAL(5,2) NOT NULL,
    id_categorie INT NOT NULL,

    FOREIGN KEY (id_categorie) REFERENCES Categorie_Carte(id_categorie) ON DELETE CASCADE
);

-- Table : Horaire
CREATE TABLE Horaire (
    id_horaire INT AUTO_INCREMENT PRIMARY KEY,
    jour ENUM('Lundi','Mardi','Mercredi','Jeudi', 'Vendredi','Samedi','Dimanche') NOT NULL,
    heure_ouverture TIME,
    heure_fermeture TIME,
    est_ouvert BOOLEAN DEFAULT TRUE
);

-- Table : Reservation
CREATE TABLE Reservation (
    id_reservation INT AUTO_INCREMENT PRIMARY KEY,
    date_reservation DATE NOT NULL,
    heure TIME NOT NULL,
    nb_personnes INT NOT NULL,
    nom_client VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telephone VARCHAR(20),
    commentaire TEXT,
    statut ENUM('en_attente','confirmee','annulee') DEFAULT 'en_attente'
);

-- Table : Info_Pratique
-- Système clé/valeur : chaque ligne = une info modifiable par l'admin
CREATE TABLE Info_Pratique (
    id_info INT AUTO_INCREMENT PRIMARY KEY,
    cle VARCHAR(50) NOT NULL UNIQUE,
    valeur TEXT NOT NULL
);

-- ============================================================
-- Données initiales
-- ============================================================

-- Compte admin
-- Hash généré avec : password_hash('admin123', PASSWORD_BCRYPT) en PHP
INSERT INTO Admin (login, mot_de_passe) VALUES
    ('admin', '$2y$10$EHo0l.yEmxzldChXveV3I.veE3VrnbdswGMATVQXVPZaMrwxBslJO');

-- Catégories de la carte
INSERT INTO Categorie_Carte (nom) VALUES
    ('Thés & infusions'),
    ('Cafés'),
    ('Boissons froides'),
    ('Pâtisseries'),
    ('Planches & salé');

-- Horaires
INSERT INTO Horaire (jour, heure_ouverture, heure_fermeture, est_ouvert) VALUES
    ('Lundi',    NULL,    NULL,    FALSE),
    ('Mardi',    '12:00', '19:00', TRUE),
    ('Mercredi', '12:00', '19:00', TRUE),
    ('Jeudi',    '12:00', '19:00', TRUE),
    ('Vendredi', '12:00', '19:00', TRUE),
    ('Samedi',   '12:00', '21:00', TRUE),
    ('Dimanche', '10:00', '18:00', TRUE);

-- Informations pratiques
INSERT INTO Info_Pratique (cle, valeur) VALUES
    ('adresse',     '10 rue des Chats, 69000 Lyon'),
    ('telephone',   '04 72 XX XX XX'),
    ('email',       'contact@monbarachats.fr'),
    ('instagram',   '@monbarachats'),
    ('description', 'Un bar à chats cosy au cœur de Lyon où vous pouvez déguster de délicieuses boissons tout en caressant nos adorables félins.');
