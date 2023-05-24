-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : mariadb:3306
-- Généré le : mar. 23 mai 2023 à 15:28
-- Version du serveur : 10.11.2-MariaDB-1:10.11.2+maria~ubu2204
-- Version de PHP : 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pokemon_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `attaque`
--

CREATE TABLE `attaque` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `puissance` int(11) NOT NULL,
  `précision` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `PP` int(11) NOT NULL,
  `Catégorie` enum('Physique','Spéciale','Statut','') NOT NULL,
  `effet_statut_id` int(11) DEFAULT NULL,
  `probabilite_effet` int(11) DEFAULT NULL,
  `niveauatq_coup_critique` int(11) NOT NULL DEFAULT 1,
  `Modification_coup_critique` int(11) DEFAULT NULL,
  `modification_attaque` float DEFAULT NULL,
  `modification_defense` float DEFAULT NULL,
  `modification_attaque_speciale` float DEFAULT NULL,
  `modification_defense_speciale` float DEFAULT NULL,
  `modification_vitesse` float DEFAULT NULL,
  `modification_attaque_allie` int(11) DEFAULT NULL,
  `modification_defense_allie` int(11) DEFAULT NULL,
  `modification_attaque_speciale_allie` int(11) DEFAULT NULL,
  `modification_defense_speciale_allie` int(11) DEFAULT NULL,
  `modification_vitesse_allie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `attaque`
--

INSERT INTO `attaque` (`id`, `nom`, `puissance`, `précision`, `type_id`, `description`, `PP`, `Catégorie`, `effet_statut_id`, `probabilite_effet`, `niveauatq_coup_critique`, `Modification_coup_critique`, `modification_attaque`, `modification_defense`, `modification_attaque_speciale`, `modification_defense_speciale`, `modification_vitesse`, `modification_attaque_allie`, `modification_defense_allie`, `modification_attaque_speciale_allie`, `modification_defense_speciale_allie`, `modification_vitesse_allie`) VALUES
(1, 'Charge', 35, 100, 9, 'Charge l\'ennemi avec un violent plaquage.', 56, 'Physique', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Rugissement', 0, 100, 9, 'Le lanceur pousse un cri tout mimi pour tromper la vigilance de l\'ennemi et baisser son Attaque', 61, 'Statut', NULL, NULL, 1, NULL, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'Griffe', 40, 100, 9, 'Lacère l\'ennemi avec des griffes acérées pour lui infliger des dégâts.', 56, 'Physique', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Fouet Lianes', 35, 100, 10, 'Fouette l\'ennemi avec de fines lianes pour infliger des dégâts.', 16, 'Physique', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Mimi-Queue', 0, 100, 9, 'Le lanceur remue son adorable queue pour tromper la vigilance de l\'ennemi et baisser sa Défense.', 48, 'Statut', NULL, NULL, 0, NULL, NULL, -1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'Pistolet à O', 40, 100, 4, 'De l\'eau est projetée sur l\'ennemi en arc de cercle.', 40, 'Spéciale', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Flammèche', 40, 100, 6, 'L\'ennemi est attaqué par de faibles flammes. Peut aussi le brûler.', 40, 'Spéciale', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Mur de fer', 0, 100, 1, 'L\'épiderme du lanceur devient dur comme du fer, ce qui augmente considérablement sa Défense.', 24, 'Statut', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL),
(9, 'Hydrocanon', 120, 80, 4, 'Envoie un puissant jet d\'eau pour frapper l\'ennemi.', 8, 'Spéciale', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `effet_statut`
--

CREATE TABLE `effet_statut` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `effet_statut`
--

INSERT INTO `effet_statut` (`id`, `nom`, `description`) VALUES
(1, 'Empoisonné', 'Le Pokémon subit des dégâts à chaque tour (attention l\'empoisonnement grave n\'existe pas encore)'),
(2, 'Brûlé', 'Le Pokémon subit des dégâts à chaque tour et voit son Attaque physique diminué'),
(3, 'Paralysé', 'Le Pokémon voit sa Vitesse réduite et peut être incapable d\'attaquer'),
(4, 'Endormi', 'Le Pokémon ne peut pas attaquer tant qu\'il dort'),
(5, 'Gelé', 'Le Pokémon ne peut pas attaquer tant qu\\\'il est gelé'),
(6, 'Confusion', 'Le Pokémon peut attaquer contre l\'adversaire ou contre lui même'),
(7, 'Malédiction', 'Le Pokémon subit des dégâts en échange de maudire son adversaire'),
(8, 'Peur', 'Le Pokémon ne peut pas attaquer pendant 1 tour'),
(9, 'Clairvoyance', 'Le Pokémon peut être attaquer par des attaques de type normal ou combat et son esquive est réduit à 0'),
(10, 'Vampigraine', 'Le Pokémon est infecté est perd des pv chaque tour pour soigner le Pokémon adverse');

-- --------------------------------------------------------

--
-- Structure de la table `efficacite_type`
--

CREATE TABLE `efficacite_type` (
  `id` int(11) NOT NULL,
  `attaque_type_id` int(11) NOT NULL,
  `defense_type_id` int(11) NOT NULL,
  `multiplicateur` float NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `efficacite_type`
--

INSERT INTO `efficacite_type` (`id`, `attaque_type_id`, `defense_type_id`, `multiplicateur`) VALUES
(1, 1, 1, 0.5),
(2, 1, 2, 1),
(3, 1, 3, 1),
(4, 1, 4, 0.5),
(5, 1, 5, 0.5),
(6, 1, 6, 0.5),
(7, 1, 7, 2),
(8, 1, 8, 1),
(9, 1, 9, 1),
(10, 1, 10, 1),
(11, 1, 11, 1),
(12, 1, 12, 1),
(13, 1, 13, 2),
(14, 1, 14, 1),
(15, 1, 15, 1),
(16, 1, 16, 1),
(17, 1, 17, 1),
(18, 2, 1, 2),
(19, 2, 2, 1),
(20, 2, 3, 1),
(21, 2, 4, 1),
(22, 2, 5, 1),
(23, 2, 6, 1),
(24, 2, 7, 2),
(25, 2, 8, 0.5),
(26, 2, 9, 2),
(27, 2, 10, 1),
(28, 2, 11, 0.5),
(29, 2, 12, 0.5),
(30, 2, 13, 2),
(31, 2, 14, 1),
(32, 2, 15, 0),
(33, 2, 16, 2),
(34, 2, 17, 0.5),
(35, 3, 1, 0.5),
(36, 3, 2, 1),
(37, 3, 3, 2),
(38, 3, 4, 1),
(39, 3, 5, 1),
(40, 3, 6, 1),
(41, 3, 7, 1),
(42, 3, 8, 1),
(43, 3, 9, 1),
(44, 3, 10, 1),
(45, 3, 11, 1),
(46, 3, 12, 1),
(47, 3, 13, 1),
(48, 3, 14, 1),
(49, 3, 15, 1),
(50, 3, 16, 1),
(51, 3, 17, 1),
(52, 4, 1, 1),
(53, 4, 2, 1),
(54, 4, 3, 1),
(55, 4, 4, 0.5),
(56, 4, 5, 1),
(57, 4, 6, 2),
(58, 4, 7, 1),
(59, 4, 8, 1),
(60, 4, 9, 1),
(61, 4, 10, 0.5),
(62, 4, 11, 1),
(63, 4, 12, 1),
(64, 4, 13, 2),
(65, 4, 14, 2),
(66, 4, 15, 1),
(67, 4, 16, 1),
(68, 4, 17, 1),
(69, 5, 1, 1),
(70, 5, 2, 1),
(71, 5, 3, 0.5),
(72, 5, 4, 2),
(73, 5, 5, 0.5),
(74, 5, 6, 1),
(75, 5, 7, 1),
(76, 5, 8, 1),
(77, 5, 9, 1),
(78, 5, 10, 0.5),
(79, 5, 11, 1),
(80, 5, 12, 1),
(81, 5, 13, 1),
(82, 5, 14, 0),
(83, 5, 15, 1),
(84, 5, 16, 1),
(85, 5, 17, 2),
(86, 6, 1, 2),
(87, 6, 2, 1),
(88, 6, 3, 0.5),
(89, 6, 4, 0.5),
(90, 6, 5, 1),
(91, 6, 6, 0.5),
(92, 6, 7, 2),
(93, 6, 8, 2),
(94, 6, 9, 1),
(95, 6, 10, 2),
(96, 6, 11, 1),
(97, 6, 12, 1),
(98, 6, 13, 0.5),
(99, 6, 14, 1),
(100, 6, 15, 1),
(101, 6, 16, 1),
(102, 6, 17, 1),
(103, 7, 1, 0.5),
(104, 7, 2, 1),
(105, 7, 3, 2),
(106, 7, 4, 0.5),
(107, 7, 5, 1),
(108, 7, 6, 0.5),
(109, 7, 7, 0.5),
(110, 7, 8, 1),
(111, 7, 9, 1),
(112, 7, 10, 2),
(113, 7, 11, 1),
(114, 7, 12, 1),
(115, 7, 13, 1),
(116, 7, 14, 2),
(117, 7, 15, 1),
(118, 7, 16, 1),
(119, 7, 17, 2),
(120, 8, 1, 0.5),
(121, 8, 2, 0.5),
(122, 8, 3, 1),
(123, 8, 4, 1),
(124, 8, 5, 1),
(125, 8, 6, 0.5),
(126, 8, 7, 1),
(127, 8, 8, 1),
(128, 8, 9, 1),
(129, 8, 10, 2),
(130, 8, 11, 0.5),
(131, 8, 12, 2),
(132, 8, 13, 1),
(133, 8, 14, 1),
(134, 8, 15, 0.5),
(135, 8, 16, 2),
(136, 8, 17, 0.5),
(137, 9, 1, 0.5),
(138, 9, 2, 1),
(139, 9, 3, 1),
(140, 9, 4, 1),
(141, 9, 5, 1),
(142, 9, 6, 1),
(143, 9, 7, 1),
(144, 9, 8, 1),
(145, 9, 9, 1),
(146, 9, 10, 1),
(147, 9, 11, 1),
(148, 9, 12, 1),
(149, 9, 13, 0.5),
(150, 9, 14, 1),
(151, 9, 15, 0),
(152, 9, 16, 1),
(153, 9, 17, 1),
(154, 10, 1, 0.5),
(155, 10, 2, 1),
(156, 10, 3, 0.5),
(157, 10, 4, 2),
(158, 10, 5, 1),
(159, 10, 6, 0.5),
(160, 10, 7, 1),
(161, 10, 8, 0.5),
(162, 10, 9, 1),
(163, 10, 10, 0.5),
(164, 10, 11, 0.5),
(165, 10, 12, 1),
(166, 10, 13, 2),
(167, 10, 14, 2),
(168, 10, 15, 1),
(169, 10, 16, 1),
(170, 10, 17, 0.5),
(171, 11, 1, 0),
(172, 11, 2, 1),
(173, 11, 3, 1),
(174, 11, 4, 1),
(175, 11, 5, 1),
(176, 11, 6, 1),
(177, 11, 7, 1),
(178, 11, 8, 1),
(179, 11, 9, 1),
(180, 11, 10, 2),
(181, 11, 11, 0.5),
(182, 11, 12, 1),
(183, 11, 13, 0.5),
(184, 11, 14, 0.5),
(185, 11, 15, 0.5),
(186, 11, 16, 1),
(187, 11, 17, 1),
(188, 12, 1, 0.5),
(189, 12, 2, 2),
(190, 12, 3, 1),
(191, 12, 4, 1),
(192, 12, 5, 1),
(193, 12, 6, 1),
(194, 12, 7, 1),
(195, 12, 8, 1),
(196, 12, 9, 1),
(197, 12, 10, 1),
(198, 12, 11, 2),
(199, 12, 12, 0.5),
(200, 12, 13, 1),
(201, 12, 14, 1),
(202, 12, 15, 1),
(203, 12, 16, 0),
(204, 12, 17, 1),
(205, 13, 1, 0.5),
(206, 13, 2, 0.5),
(207, 13, 3, 1),
(208, 13, 4, 1),
(209, 13, 5, 1),
(210, 13, 6, 2),
(211, 13, 7, 2),
(212, 13, 8, 2),
(213, 13, 9, 1),
(214, 13, 10, 1),
(215, 13, 11, 1),
(216, 13, 12, 1),
(217, 13, 13, 1),
(218, 13, 14, 0.5),
(219, 13, 15, 1),
(220, 13, 16, 1),
(221, 13, 17, 2),
(222, 14, 1, 2),
(223, 14, 2, 1),
(224, 14, 3, 1),
(225, 14, 4, 1),
(226, 14, 5, 2),
(227, 14, 6, 2),
(228, 14, 7, 1),
(229, 14, 8, 0.5),
(230, 14, 9, 1),
(231, 14, 10, 0.5),
(232, 14, 11, 2),
(233, 14, 12, 1),
(234, 14, 13, 2),
(235, 14, 14, 1),
(236, 14, 15, 1),
(237, 14, 16, 1),
(238, 14, 17, 0),
(239, 15, 1, 0.5),
(240, 15, 2, 1),
(241, 15, 3, 1),
(242, 15, 4, 1),
(243, 15, 5, 1),
(244, 15, 6, 1),
(245, 15, 7, 1),
(246, 15, 8, 1),
(247, 15, 9, 0),
(248, 15, 10, 1),
(249, 15, 11, 1),
(250, 15, 12, 2),
(251, 15, 13, 1),
(252, 15, 14, 1),
(253, 15, 15, 2),
(254, 15, 16, 0.5),
(255, 15, 17, 1),
(256, 16, 1, 0.5),
(257, 16, 2, 0.5),
(258, 16, 3, 1),
(259, 16, 4, 1),
(260, 16, 5, 1),
(261, 16, 6, 1),
(262, 16, 7, 1),
(263, 16, 8, 1),
(264, 16, 9, 1),
(265, 16, 10, 1),
(266, 16, 11, 1),
(267, 16, 12, 2),
(268, 16, 13, 1),
(269, 16, 14, 1),
(270, 16, 15, 2),
(271, 16, 16, 0.5),
(272, 16, 17, 1),
(273, 17, 1, 0.5),
(274, 17, 2, 2),
(275, 17, 3, 1),
(276, 17, 4, 1),
(277, 17, 5, 0.5),
(278, 17, 6, 1),
(279, 17, 7, 1),
(280, 17, 8, 2),
(281, 17, 9, 1),
(282, 17, 10, 2),
(283, 17, 11, 1),
(284, 17, 12, 1),
(285, 17, 13, 0.5),
(286, 17, 14, 1),
(287, 17, 15, 1),
(288, 17, 16, 1),
(289, 17, 17, 1);

-- --------------------------------------------------------

--
-- Structure de la table `objet`
--

CREATE TABLE `objet` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `effet` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `pokemon`
--

CREATE TABLE `pokemon` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `pv` int(11) DEFAULT NULL,
  `atq` int(11) DEFAULT NULL,
  `def` int(11) DEFAULT NULL,
  `atqspe` int(11) DEFAULT NULL,
  `defspe` int(11) DEFAULT NULL,
  `vit` int(11) DEFAULT NULL,
  `sexe` enum('null','feminin','masculin','') NOT NULL,
  `niveauAtq` int(11) NOT NULL DEFAULT 0,
  `niveauDef` int(11) NOT NULL DEFAULT 0,
  `niveauAtqspe` int(11) NOT NULL,
  `niveauDefspe` int(11) NOT NULL DEFAULT 0,
  `niveauVit` int(11) NOT NULL DEFAULT 0,
  `atq_base` int(11) NOT NULL,
  `def_base` int(11) NOT NULL,
  `atqspe_base` int(11) NOT NULL,
  `defspe_base` int(11) NOT NULL,
  `vit_base` int(11) NOT NULL,
  `niveau_coup_critique` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `pokemon`
--

INSERT INTO `pokemon` (`id`, `nom`, `pv`, `atq`, `def`, `atqspe`, `defspe`, `vit`, `sexe`, `niveauAtq`, `niveauDef`, `niveauAtqspe`, `niveauDefspe`, `niveauVit`, `atq_base`, `def_base`, `atqspe_base`, `defspe_base`, `vit_base`, `niveau_coup_critique`) VALUES
(1, 'Bulbizarre', 231, 134, 134, 166, 166, 126, 'null', 0, 0, 0, 0, 0, 134, 134, 166, 166, 126, 1),
(2, 'Herbizarre', 261, 160, 162, 196, 196, 156, 'null', 0, 0, 0, 0, 0, 160, 162, 196, 196, 156, 1),
(3, 'Florizarre', 301, 100, 202, 236, 236, 196, 'null', -2, 0, 0, 0, 0, 200, 202, 236, 236, 196, 1),
(4, 'Salamèche', 219, 140, 122, 156, 136, 166, 'null', 0, 0, 0, 0, 0, 140, 122, 156, 136, 166, 1),
(5, 'Reptincel', 257, 164, 152, 196, 166, 196, 'null', 0, 0, 0, 0, 0, 164, 152, 196, 166, 196, 1),
(6, 'Dracaufeu', 297, 204, 192, 254, 206, 236, 'null', 0, 0, 0, 0, 0, 204, 192, 254, 206, 236, 5),
(7, 'Carapuce', 229, 132, 166, 136, 164, 122, 'null', 0, 0, 0, 0, 0, 132, 166, 136, 164, 122, 1),
(8, 'Carabaffe', 259, 162, 196, 166, 196, 152, 'null', 0, 0, 0, 0, 0, 162, 196, 166, 196, 152, 1),
(9, 'Tortank', 299, 202, 472, 206, 246, 192, 'null', 0, 2, 0, 0, 0, 202, 236, 206, 246, 192, 1);

-- --------------------------------------------------------

--
-- Structure de la table `pokemon_attaque`
--

CREATE TABLE `pokemon_attaque` (
  `pokemon_id` int(11) NOT NULL,
  `attaque_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `pokemon_attaque`
--

INSERT INTO `pokemon_attaque` (`pokemon_id`, `attaque_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(2, 4),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(3, 4),
(4, 3),
(4, 2),
(4, 7),
(5, 3),
(5, 7),
(5, 2),
(6, 3),
(6, 7),
(6, 2),
(7, 1),
(7, 5),
(7, 6),
(8, 1),
(8, 5),
(8, 6),
(9, 1),
(9, 5),
(9, 6),
(7, 8),
(8, 8),
(9, 8),
(7, 9),
(8, 9),
(9, 9);

-- --------------------------------------------------------

--
-- Structure de la table `pokemon_objet`
--

CREATE TABLE `pokemon_objet` (
  `pokemon_id` int(11) NOT NULL,
  `objet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `pokemon_type`
--

CREATE TABLE `pokemon_type` (
  `pokemon_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `pokemon_type`
--

INSERT INTO `pokemon_type` (`pokemon_id`, `type_id`) VALUES
(1, 11),
(1, 10),
(2, 10),
(2, 11),
(3, 11),
(3, 10),
(4, 6),
(5, 6),
(6, 6),
(7, 4),
(8, 4),
(9, 4),
(6, 17);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id`, `nom`) VALUES
(1, 'Acier'),
(2, 'Combat'),
(3, 'Dragon'),
(4, 'Eau'),
(5, 'Electrik'),
(6, 'Feu'),
(7, 'Glace'),
(8, 'Insect'),
(9, 'Normal'),
(10, 'Plante'),
(11, 'Poison'),
(12, 'Psy'),
(13, 'Roche'),
(14, 'Sol'),
(15, 'Spectre'),
(16, 'Tenebre'),
(17, 'Vol');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `attaque`
--
ALTER TABLE `attaque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attaque_effet_statut_fk` (`effet_statut_id`);

--
-- Index pour la table `effet_statut`
--
ALTER TABLE `effet_statut`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `efficacite_type`
--
ALTER TABLE `efficacite_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attaque_type_id` (`attaque_type_id`),
  ADD KEY `defense_type_id` (`defense_type_id`);

--
-- Index pour la table `objet`
--
ALTER TABLE `objet`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pokemon`
--
ALTER TABLE `pokemon`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pokemon_attaque`
--
ALTER TABLE `pokemon_attaque`
  ADD KEY `attaque_id` (`attaque_id`),
  ADD KEY `pokemon_id` (`pokemon_id`);

--
-- Index pour la table `pokemon_objet`
--
ALTER TABLE `pokemon_objet`
  ADD KEY `objet_id` (`objet_id`),
  ADD KEY `pokemon_id` (`pokemon_id`);

--
-- Index pour la table `pokemon_type`
--
ALTER TABLE `pokemon_type`
  ADD KEY `pokemon_id` (`pokemon_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `attaque`
--
ALTER TABLE `attaque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `efficacite_type`
--
ALTER TABLE `efficacite_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=290;

--
-- AUTO_INCREMENT pour la table `objet`
--
ALTER TABLE `objet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pokemon`
--
ALTER TABLE `pokemon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `attaque`
--
ALTER TABLE `attaque`
  ADD CONSTRAINT `attaque_effet_statut_fk` FOREIGN KEY (`effet_statut_id`) REFERENCES `effet_statut` (`id`);

--
-- Contraintes pour la table `efficacite_type`
--
ALTER TABLE `efficacite_type`
  ADD CONSTRAINT `efficacite_type_ibfk_1` FOREIGN KEY (`attaque_type_id`) REFERENCES `type` (`id`),
  ADD CONSTRAINT `efficacite_type_ibfk_2` FOREIGN KEY (`defense_type_id`) REFERENCES `type` (`id`);

--
-- Contraintes pour la table `pokemon_attaque`
--
ALTER TABLE `pokemon_attaque`
  ADD CONSTRAINT `pokemon_attaque_ibfk_1` FOREIGN KEY (`attaque_id`) REFERENCES `attaque` (`id`),
  ADD CONSTRAINT `pokemon_attaque_ibfk_2` FOREIGN KEY (`pokemon_id`) REFERENCES `pokemon` (`id`);

--
-- Contraintes pour la table `pokemon_objet`
--
ALTER TABLE `pokemon_objet`
  ADD CONSTRAINT `pokemon_objet_ibfk_1` FOREIGN KEY (`objet_id`) REFERENCES `objet` (`id`),
  ADD CONSTRAINT `pokemon_objet_ibfk_2` FOREIGN KEY (`pokemon_id`) REFERENCES `pokemon` (`id`);

--
-- Contraintes pour la table `pokemon_type`
--
ALTER TABLE `pokemon_type`
  ADD CONSTRAINT `pokemon_type_ibfk_1` FOREIGN KEY (`pokemon_id`) REFERENCES `pokemon` (`id`),
  ADD CONSTRAINT `pokemon_type_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
