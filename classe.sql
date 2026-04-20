CREATE DATABASE IF NOT EXISTS bar_a_chats
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bar_a_chats;


CREATE TABLE admin (
    id_admin     INT AUTO_INCREMENT PRIMARY KEY,
    login        VARCHAR(50)  NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL  -- hash bcrypt via password_hash()
);


CREATE TABLE chat (
    id_chat              INT AUTO_INCREMENT PRIMARY KEY,
    nom                  VARCHAR(100) NOT NULL,
    race                 VARCHAR(100),
    date_de_naissance    DATE,
    sexe                 ENUM('M', 'F') NOT NULL,
    car_joueur           TINYINT DEFAULT 0,  -- valeur de 0 à 5
    car_calin            TINYINT DEFAULT 0,
    car_gourmand         TINYINT DEFAULT 0,
    car_paresseux        TINYINT DEFAULT 0,
    desc_vie_avant       TEXT,
    desc_vie_au_bar      TEXT,
    desc_aime            TEXT,
    desc_nom             TEXT,
    photo                VARCHAR(255)
);


CREATE TABLE categorie_carte (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom          VARCHAR(100) NOT NULL
);


CREATE TABLE article_carte (
    id_article   INT AUTO_INCREMENT PRIMARY KEY,
    nom          VARCHAR(150) NOT NULL,
    description  TEXT,
    prix         DECIMAL(5,2) NOT NULL,
    id_categorie INT NOT NULL,
    FOREIGN KEY (id_categorie) REFERENCES categorie_carte(id_categorie)
        ON DELETE CASCADE  -- si on supprime la catégorie, ses articles disparaissent
);


CREATE TABLE horaire (
    id_horaire       INT AUTO_INCREMENT PRIMARY KEY,
    jour             ENUM('Lundi','Mardi','Mercredi','Jeudi',
                          'Vendredi','Samedi','Dimanche') NOT NULL,
    heure_ouverture  TIME,
    heure_fermeture  TIME,
    est_ouvert       BOOLEAN DEFAULT TRUE
);

CREATE TABLE reservation (
    id_reservation   INT AUTO_INCREMENT PRIMARY KEY,
    date_reservation DATE NOT NULL,
    heure            TIME NOT NULL,
    nb_personnes     INT  NOT NULL,
    nom_client       VARCHAR(150) NOT NULL,
    email            VARCHAR(150) NOT NULL,
    telephone        VARCHAR(20),
    commentaire      TEXT,
    statut           ENUM('en_attente','confirmee','annulee')
                     DEFAULT 'en_attente'
);


CREATE TABLE info_pratique (
    id_info INT  AUTO_INCREMENT PRIMARY KEY,
    cle     VARCHAR(50) NOT NULL UNIQUE,  -- ex: 'adresse', 'telephone'
    valeur  TEXT NOT NULL
);

-- Données initiales
INSERT INTO info_pratique (cle, valeur) VALUES
    ('adresse',     '12 rue de la Presqu''île, Lyon 2e'),
    ('telephone',   '04 72 XX XX XX'),
    ('email',       'contact@monbar.fr'),
    ('instagram',   '@monbarachats'),
    ('description', 'Un bar à chats cosy au cœur de Lyon...');

-- Horaires initiaux (7 jours)
INSERT INTO horaire (jour, heure_ouverture, heure_fermeture, est_ouvert) VALUES
    ('Lundi',    NULL,    NULL,    FALSE),
    ('Mardi',    '12:00', '19:00', TRUE),
    ('Mercredi', '12:00', '19:00', TRUE),
    ('Jeudi',    '12:00', '19:00', TRUE),
    ('Vendredi', '12:00', '19:00', TRUE),
    ('Samedi',   '12:00', '21:00', TRUE),
    ('Dimanche', '10:00', '18:00', TRUE);

-- Compte admin initial (mot de passe à changer !)
INSERT INTO admin (login, mot_de_passe) VALUES
    ('admin', '$2y$10$...');  -- générer avec password_hash('motdepasse', PASSWORD_BCRYPT)
