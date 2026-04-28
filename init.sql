-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql03.univ-lyon2.fr
-- Généré le : mar. 28 avr. 2026 à 13:44
-- Version du serveur : 5.7.29
-- Version de PHP : 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `php_mthomas5`
--

-- --------------------------------------------------------

--
-- Structure de la table `Admin`
--

CREATE TABLE `Admin` (
  `id_admin` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Admin`
--

INSERT INTO `Admin` (`id_admin`, `login`, `mot_de_passe`) VALUES
(1, 'admin', '$2y$10$EHo0l.yEmxzldChXveV3I.veE3VrnbdswGMATVQXVPZaMrwxBslJO');

-- --------------------------------------------------------

--
-- Structure de la table `Article_Carte`
--

CREATE TABLE `Article_Carte` (
  `id_article` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `description` text,
  `prix` decimal(5,2) NOT NULL,
  `id_categorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Article_Carte`
--

INSERT INTO `Article_Carte` (`id_article`, `nom`, `description`, `prix`, `id_categorie`) VALUES
(1, 'Espresso', 'Un double expresso avec toutes les notes aromatiques de notre café bio.', 5.50, 2),
(2, 'Americano', 'Un double expresso allongé à l\'eau chaude. Simple, léger, efficace.', 5.50, 2),
(3, 'Cappuccino', 'L\'incontournable : expresso, lait onctueux et mousse de lait.', 5.90, 2),
(4, 'Café au Lait', 'Un double expresso avec du lait chaud et onctueux moussé.', 5.90, 2),
(5, 'Latte Macchiato', 'Du lait chaud et un double expresso avec une mousse de lait saupoudrée de cacao.', 6.90, 2),
(6, 'Cappuccino Ourson', 'Un cappuccino servi avec un ourson guimauve fondant.', 6.90, 2),
(7, 'Earl Grey', 'Thé noir classique aux notes de bergamote, élégant et intemporel.', 5.50, 1),
(8, 'Menthe Fraîche', 'Infusion de menthe poivrée bio, fraîche et désaltérante.', 5.50, 1),
(9, 'Citron Gingembre', 'Infusion chaude au citron et gingembre frais, parfaite pour se réchauffer.', 5.50, 1),
(10, 'Rooibos Vanille', 'Un rooibos doux aux notes de vanille et caramel, sans théine.', 5.50, 1),
(11, 'Thé Vert Jasmin', 'Thé vert délicat aux fleurs de jasmin, léger et parfumé.', 5.50, 1),
(12, 'Thé Chaï', 'Un mélange épicé de thé noir, cannelle, gingembre et cardamome avec une mousse de lait.', 6.90, 1),
(13, 'Thé Glacé Maison', 'Thé vert au citron infusé à froid pendant 8 heures, servi bien frais.', 5.50, 3),
(14, 'Limonade Gingembre', 'Limonade maison infusée au gingembre frais et à la menthe.', 5.50, 3),
(15, 'Limonade Rose', 'Limonade maison délicatement parfumée au sirop de rose.', 5.50, 3),
(16, 'Jus de Fruits Bio', 'Jus de fruits bio et artisanal, demandez-nous les saveurs du moment !', 5.90, 3),
(17, 'Soda', 'Cannette de soda 33cl, voir disponibilités au bar.', 4.50, 3),
(18, 'Eau', 'Eau plate ou pétillante selon disponibilité.', 3.50, 3),
(19, 'Cheesecake', 'La spécialité de la maison ! Un cheesecake onctueux préparé par notre chef pâtissier, voir parfums en vitrine.', 7.00, 4),
(20, 'Cookie', 'Un gros cookie aux pépites de chocolat Valrhona, moelleux à l\'intérieur et croquant à l\'extérieur.', 5.00, 4),
(21, 'Tarte du Jour', 'Tarte maison selon l\'humeur de notre chef pâtissier et au gré des saisons.', 6.00, 4),
(22, 'Moelleux au Chocolat', 'Moelleux au chocolat noir servi juste chaud, fondant à souhait.', 6.00, 4),
(23, 'Planche Charcuterie', 'Sélection de charcuteries fines, cornichons et pain artisanal.', 12.00, 5),
(24, 'Planche Fromages', 'Sélection de fromages affinés, noix et confiture maison.', 12.00, 5),
(25, 'Planche Mixte', 'Un mix de charcuterie et fromages pour les indécis.', 14.00, 5),
(26, 'Toast Avocat', 'Toast sur pain artisanal grillé, avocat, graines de courge et fleur de sel.', 8.00, 5);

-- --------------------------------------------------------

--
-- Structure de la table `Categorie_Carte`
--

CREATE TABLE `Categorie_Carte` (
  `id_categorie` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Categorie_Carte`
--

INSERT INTO `Categorie_Carte` (`id_categorie`, `nom`) VALUES
(1, 'Thés & infusions'),
(2, 'Cafés'),
(3, 'Boissons froides'),
(4, 'Pâtisseries'),
(5, 'Planches & salé');

-- --------------------------------------------------------

--
-- Structure de la table `Chat`
--

CREATE TABLE `Chat` (
  `id_chat` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `race` varchar(100) DEFAULT NULL,
  `date_de_naissance` date DEFAULT NULL,
  `sexe` enum('Mâle','Femelle') NOT NULL,
  `car_joueur` int(11) DEFAULT '0',
  `car_calin` int(11) DEFAULT '0',
  `car_gourmand` int(11) DEFAULT '0',
  `car_paresseux` int(11) DEFAULT '0',
  `desc_vie_avant` text,
  `desc_vie_au_bar` text,
  `desc_aime` text,
  `desc_nom` text,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Chat`
--

INSERT INTO `Chat` (`id_chat`, `nom`, `race`, `date_de_naissance`, `sexe`, `car_joueur`, `car_calin`, `car_gourmand`, `car_paresseux`, `desc_vie_avant`, `desc_vie_au_bar`, `desc_aime`, `desc_nom`, `photo`) VALUES
(2, 'Brindille', 'Européen bicolore', '2020-03-15', 'Mâle', 2, 2, 4, 4, 'Brindille a grandi dans une famille lyonnaise qui lui a tout appris de l\'art de la sieste. Dès son plus jeune âge, il a su identifier le fauteuil le plus confortable de chaque pièce et s\'y installer avant tout le monde. Un talent inné.', 'Au Ronron Café, Brindille a immédiatement repéré les meilleurs spots ensoleillés et les a déclarés siens. Il s\'y installe ventre en l\'air, pattes en éventail, avec l\'air de quelqu\'un qui a tout compris à la vie. Les visiteurs l\'adorent. Lui les tolère.', 'Les fauteuils moelleux, les rayons de soleil, les longues siestes entrecoupées de courtes siestes. Il n\'aime pas qu\'on lui dise qu\'il prend toute la place.', 'Brindille... pour un chat qui s\'étale sur toute la largeur d\'un fauteuil IKEA ? Le nom a été choisi quand il était chaton et tenait dans une poche. Depuis, il a quelque peu... évolué. On garde le nom pour les souvenirs.', 'Brindille.jpg'),
(3, 'Cirius', 'Européen noir', '2022-06-10', 'Mâle', 3, 2, 3, 3, 'Mystérieux comme son pelage de jais, Cirius n\'aime pas trop parler de son passé. On sait juste qu\'il a été chouchouté, qu\'il a développé un goût prononcé pour les coussins en cuir vintage, et qu\'il a décidé un beau jour qu\'un bar à chats était son destin.', 'Cirius observe tout depuis son perchoir favori avec l\'air d\'un philosophe qui aurait des doutes sur l\'humanité. Ne vous y trompez pas — si vous passez son test du regard, il daignera peut-être s\'approcher et accepter quelques grattouilles derrière les oreilles.', 'Se faire admirer de loin, les fauteuils en cuir, regarder les visiteurs dans les yeux pour les déstabiliser. Il n\'aime pas l\'indifférence — paradoxalement.', 'Cirius comme l\'étoile la plus brillante du ciel — et il le sait. Avec ses yeux vert doré qui vous transpercent l\'âme, il n\'a pas besoin de faire des efforts pour impressionner.', 'Cirius.jpg'),
(4, 'Lucifer', 'Européen gris et blanc', '2005-06-02', 'Mâle', 3, 4, 2, 3, 'Lucifer a été adopté tout chaton dans une famille qui aimait beaucoup... l\'habiller. Il a développé une patience à toute épreuve et un regard qui dit clairement \"je me souviens de tout\". Malgré tout, c\'est un chat fondamentalement doux.', 'Au Ronron Café, Lucifer s\'est rapidement imposé comme le chat le plus photogénié de la bande. Les visiteurs craquent pour son minois expressif. Il accepte les caresses avec bienveillance, pose volontiers pour les photos, et fait semblant de ne pas remarquer qu\'on le prend en photo depuis 10 minutes.', 'Les séances photo (même s\'il fait semblant du contraire), les coins tranquilles, les croquettes premium. Il n\'aime pas qu\'on lui mette des vêtements. Enfin, c\'est ce qu\'il dit.', 'Lucifer... avec cette petite robe à pois roses. On ne sait pas trop qui a eu l\'idée, mais lui non plus n\'a pas eu son mot à dire. Il l\'accepte avec une dignité remarquable. Ou peut-être qu\'il attend le bon moment pour se venger.', 'Lucifer.jpg'),
(5, 'Nasca', 'Chartreux', '2018-11-08', 'Femelle', 1, 2, 3, 5, 'Nasca a toujours su ce qu\'elle voulait dans la vie : la paix, la chaleur, et qu\'on la laisse tranquille. Elle a grandi dans un foyer calme qui a su respecter ses exigences. Elle arrive au Ronron Café avec ses habitudes, ses opinions, et son expression qui dit \"non merci\" en permanence.', 'Nasca a élu domicile dans le panier le plus douillet du bar, niché entre des pelotes de laine. Elle y passe l\'essentiel de ses journées à somnoler avec l\'air renfrogné d\'un chat qui a vu des choses. En réalité elle est parfaitement heureuse — c\'est juste son visage normal.', 'La laine, la chaleur, les espaces confinés et douillets. Elle n\'aime pas être dérangée. Ni le matin. Ni l\'après-midi. Ni le soir en fait.', 'Nasca comme les lignes de Nazca — mystérieuse, ancienne et incomprise du commun des mortels. Elle-même trouve ce nom parfaitement approprié.', 'Nasca.jpg'),
(6, 'Nugget', 'Européen bicolore', '2021-09-20', 'Femelle', 5, 4, 3, 1, 'Nugget est arrivée au monde avec un jouet tigre dans les pattes et n\'a pas lâché depuis. Son ancien foyer confirme qu\'elle dormait, mangeait, jouait — dans cet ordre précis — et ne souffrait aucune exception à ce programme.', 'Au Ronron Café, Nugget a immédiatement colonisé la maison en peluche du coin. C\'est son QG, son château, son bureau. Elle y reçoit les visiteurs qui ont l\'honneur de s\'accroupir pour la voir. Elle les observe avec ses grands yeux jaunes, décide si vous êtes dignes, et parfois sort pour une séance de câlins express avant de regagner sa tanière.', 'Sa maison en peluche, son tigre en tissu, les visiteurs qui s\'accroupissent poliment pour la saluer. Elle n\'aime pas les inconnus trop brusques ni qu\'on touche à son tigre.', 'Nugget parce qu\'elle est petite, dotée de caractère, et qu\'on aurait tendance à vouloir la croquer. Elle vit très bien avec ce prénom, contrairement à ce qu\'on pourrait craindre.', 'Nugget.jpg'),
(10, 'Freya', 'Norvégienne', '2020-05-14', 'Femelle', 5, 3, 2, 1, 'Freya a grandi en plein air, les pattes dans la terre et le nez dans le vent. Grimper aux arbres ? Une formalité. Chasser des feuilles mortes ? Un art. Sa famille d\'accueil avait bien essayé de lui expliquer qu\'un appartement c\'est aussi bien qu\'un jardin. Elle a poliment refusé d\'y croire.', 'Au Ronron Café, Freya a d\'abord inspecté chaque recoin du sol au plafond — littéralement. Elle a élu domicile sur les plateformes les plus hautes, d\'où elle surveille son royaume d\'un œil jaune doré perçant. Elle descend quand bon lui semble, pas avant.', 'Grimper, explorer, chasser tout ce qui bouge. Elle adore les jouets à plumes et les espaces en hauteur. Elle n\'aime pas rester immobile plus de 5 minutes — sauf quand le soleil tape exactement au bon endroit.', 'Freya comme la déesse nordique de l\'amour et de la beauté — et au vu de son pelage de reine des forêts, le nom s\'imposait de lui-même. Elle règne sur le Ronron Café avec l\'élégance naturelle de celle qui n\'a jamais douté de sa magnificence.', 'Freya.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `Horaire`
--

CREATE TABLE `Horaire` (
  `id_horaire` int(11) NOT NULL,
  `jour` enum('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche') NOT NULL,
  `heure_ouverture` time DEFAULT NULL,
  `heure_fermeture` time DEFAULT NULL,
  `est_ouvert` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Horaire`
--

INSERT INTO `Horaire` (`id_horaire`, `jour`, `heure_ouverture`, `heure_fermeture`, `est_ouvert`) VALUES
(1, 'Lundi', NULL, NULL, 0),
(2, 'Mardi', '12:00:00', '19:00:00', 1),
(3, 'Mercredi', '12:00:00', '19:00:00', 1),
(4, 'Jeudi', '12:00:00', '19:00:00', 1),
(5, 'Vendredi', '12:00:00', '19:00:00', 1),
(6, 'Samedi', '12:00:00', '21:00:00', 1),
(7, 'Dimanche', '10:00:00', '18:00:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Info_Pratique`
--

CREATE TABLE `Info_Pratique` (
  `id_info` int(11) NOT NULL,
  `cle` varchar(50) NOT NULL,
  `valeur` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Info_Pratique`
--

INSERT INTO `Info_Pratique` (`id_info`, `cle`, `valeur`) VALUES
(1, 'adresse', '10 rue des Chats, 69000 Lyon'),
(2, 'telephone', '04 72 XX XX XX'),
(3, 'email', 'contact@monbarachats.fr'),
(4, 'instagram', '@monbarachats'),
(5, 'description', 'Le Ronron Café, c\'est l\'endroit où vous venez pour une boisson et repartez le cœur léger. Entre les ronronnements de nos résidents et l\'odeur du café fraîchement torréfié, difficile de ne pas sourire. Bienvenue dans notre petite famille à poils !');

-- --------------------------------------------------------

--
-- Structure de la table `Reservation`
--

CREATE TABLE `Reservation` (
  `id_reservation` int(11) NOT NULL,
  `date_reservation` date NOT NULL,
  `heure` time NOT NULL,
  `nb_personnes` int(11) NOT NULL,
  `nom_client` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `commentaire` text,
  `statut` enum('en_attente','confirmee','annulee') DEFAULT 'en_attente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Index pour la table `Article_Carte`
--
ALTER TABLE `Article_Carte`
  ADD PRIMARY KEY (`id_article`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Index pour la table `Categorie_Carte`
--
ALTER TABLE `Categorie_Carte`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `Chat`
--
ALTER TABLE `Chat`
  ADD PRIMARY KEY (`id_chat`);

--
-- Index pour la table `Horaire`
--
ALTER TABLE `Horaire`
  ADD PRIMARY KEY (`id_horaire`);

--
-- Index pour la table `Info_Pratique`
--
ALTER TABLE `Info_Pratique`
  ADD PRIMARY KEY (`id_info`),
  ADD UNIQUE KEY `cle` (`cle`);

--
-- Index pour la table `Reservation`
--
ALTER TABLE `Reservation`
  ADD PRIMARY KEY (`id_reservation`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Article_Carte`
--
ALTER TABLE `Article_Carte`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `Categorie_Carte`
--
ALTER TABLE `Categorie_Carte`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Chat`
--
ALTER TABLE `Chat`
  MODIFY `id_chat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `Horaire`
--
ALTER TABLE `Horaire`
  MODIFY `id_horaire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `Info_Pratique`
--
ALTER TABLE `Info_Pratique`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Reservation`
--
ALTER TABLE `Reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Article_Carte`
--
ALTER TABLE `Article_Carte`
  ADD CONSTRAINT `Article_Carte_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `Categorie_Carte` (`id_categorie`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
