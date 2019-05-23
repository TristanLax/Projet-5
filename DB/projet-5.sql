-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 15 mai 2019 à 11:39
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet-5`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_date` datetime NOT NULL,
  `edit_date` datetime DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526C4B89032C` (`post_id`),
  KEY `IDX_9474526CF675F31B` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `post_id`, `content`, `comment_date`, `edit_date`, `author_id`) VALUES
(9, 21, '<p>Test !</p>', '2019-04-23 13:24:49', NULL, 9),
(10, 20, '<p>Integer maximus facilisis justo. Curabitur ex elit, fringilla eu viverra sit amet, lacinia nec felis. Etiam vestibulum, sapien eget tempor ornare, augue lorem finibus orci, ac semper lorem nunc ac enim. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean vulputate purus purus, sit amet tempus turpis accumsan non. Nullam in libero vel metus efficitur sollicitudin in quis dui. Donec dictum lectus ac lorem consectetur, a consequat magna egestas. Quisque id fringilla lacus. Phasellus pulvinar orci eros.</p>', '2019-04-26 11:27:39', NULL, 9),
(11, 20, '<p>Test commentaire !</p>', '2019-04-30 16:52:03', NULL, 9),
(12, 20, '<pre>\r\n<code>Second test !</code></pre>', '2019-04-30 16:53:42', '2019-05-07 14:12:26', 9),
(13, 20, '<p>Et encore un nouveau test !</p>', '2019-05-03 12:17:45', NULL, 9),
(14, 24, '<p>Morbi id fermentum ligula, non lobortis libero. Nunc pulvinar mattis ex et ultricies. Nulla ut nibh dapibus, viverra nibh ut, facilisis nulla. Aenean sollicitudin velit magna. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec a vehicula felis. Duis venenatis felis et augue gravida sodales. Integer placerat nisi ornare, iaculis dui id, dapibus lacus. Sed pretium eu nunc nec convallis. Sed nec fermentum velit. Donec blandit nulla in est convallis volutpat. Praesent id scelerisque lectus. Nulla dapibus diam id turpis mattis, vitae tincidunt nisi bibendum.</p>', '2019-05-07 13:10:54', NULL, 9),
(15, 20, '<p>Test commentaire !</p>', '2019-05-07 13:48:10', NULL, 10),
(16, 20, '<p>Pellentesque luctus elementum odio, nec cursus est accumsan vel. Aliquam nec iaculis elit. Phasellus ante ante, malesuada non lectus sit amet, blandit imperdiet ex. Duis consequat, arcu vel aliquet pharetra, massa ex consectetur augue, ut viverra erat mi ac orci. Nunc eu justo fringilla, aliquam nulla non, cursus lectus. Integer nulla nunc, bibendum at velit in, rutrum imperdiet ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In ut suscipit ligula, in accumsan orci. Curabitur quam odio, euismod sit amet lacinia et, venenatis eget arcu. Sed luctus dapibus rhoncus. Nunc fringilla urna et sollicitudin pulvinar. Aenean consectetur neque risus, efficitur mollis metus consequat nec. Quisque cursus, mauris ut vestibulum elementum, risus enim pulvinar libero, sit amet pharetra justo elit ac mauris.</p>', '2019-05-07 13:48:17', NULL, 10);

-- --------------------------------------------------------

--
-- Structure de la table `comment_reports`
--

CREATE TABLE IF NOT EXISTS `comment_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_report_unique` (`user_id`,`comment_id`),
  KEY `IDX_26CC555A76ED395` (`user_id`),
  KEY `IDX_26CC555F8697D13` (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment_reports`
--

INSERT INTO `comment_reports` (`id`, `user_id`, `comment_id`) VALUES
(1, 9, 14),
(2, 9, 15),
(3, 9, 16);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_date` datetime NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FF624B39D` (`sender_id`),
  KEY `IDX_B6BD307FCD53EDB6` (`receiver_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `title`, `content`, `add_date`, `sender_id`, `receiver_id`) VALUES
(1, 'Test', '<p>Ceci est un test de message priv&eacute; !</p>', '2019-04-23 13:34:52', 9, 10),
(2, 'Test reception', 'Test de reception de message! ', '2019-04-16 13:12:12', 10, 9),
(6, 'Test envoi de message', '<p>Ceci est un envoi de message envers Demo de Tanamassar!</p>', '2019-04-29 13:08:18', 9, 10),
(7, 'Test après modifications', '<p>Ceci est un test d&#39;eznvoi de message apr&egrave;s modifications des controlleurs !</p>', '2019-04-29 13:26:09', 9, 9);

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20190218134110', '2019-02-18 13:47:28'),
('20190218141233', '2019-02-18 14:13:20'),
('20190218142603', '2019-02-18 14:26:22'),
('20190225133404', '2019-02-25 13:35:32'),
('20190225143937', '2019-02-25 14:42:08'),
('20190226112820', '2019-02-26 11:28:33'),
('20190228155402', '2019-02-28 15:55:53'),
('20190304133621', '2019-03-04 13:37:46'),
('20190307133531', '2019-03-07 13:35:54'),
('20190318150429', '2019-03-18 15:05:46'),
('20190318153257', '2019-03-18 15:34:41'),
('20190321141701', '2019-03-21 14:17:46'),
('20190321145257', '2019-03-21 14:53:12'),
('20190321150818', '2019-03-21 15:11:30'),
('20190321160602', '2019-03-21 16:06:30'),
('20190321163814', '2019-03-21 16:38:30'),
('20190321164242', '2019-03-21 16:43:09'),
('20190321165113', '2019-03-21 16:51:28'),
('20190321170244', '2019-03-21 17:03:07'),
('20190408140535', '2019-04-08 14:06:05'),
('20190416130714', '2019-04-16 13:07:57'),
('20190416135504', '2019-04-16 13:55:10'),
('20190416140615', '2019-04-16 14:06:33'),
('20190416142451', '2019-04-16 14:25:10'),
('20190418153834', '2019-04-18 15:41:12'),
('20190418165402', '2019-04-18 16:54:15'),
('20190423122519', '2019-04-23 12:33:13');

-- --------------------------------------------------------

--
-- Structure de la table `picture`
--

CREATE TABLE IF NOT EXISTS `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_16DB4F894B89032C` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `picture`
--

INSERT INTO `picture` (`id`, `post_id`, `filename`) VALUES
(1, 22, '5ca73690c9a90425260367.jpg'),
(2, 23, '5ca736a277df8657208341.jpg'),
(7, 27, '5cb478de14118312884991.jpg'),
(8, 28, '5cb481c444a70638503678.jpg'),
(9, 21, '5cc701978d680024796763.jpg'),
(10, 21, '5cc701978e238186185347.jpg'),
(11, 21, '5cc701978f5c0786517143.jpg'),
(18, 20, '5cc822b578820697332709.jpg'),
(19, 20, '5ccb126b74a68935388625.jpg'),
(20, 20, '5ccb126b761d8794592326.jpg'),
(21, 20, '5ccb126b76d90012682563.jpg'),
(22, 20, '5ccb13d5bda60730059993.jpg'),
(23, 20, '5ccb13d5be230804953571.jpg'),
(25, 29, '5cd17fb18ade0872540923.jpg'),
(26, 29, '5cd17fb18c168701184028.jpg'),
(27, 29, '5cd17fb18d108731803661.jpg'),
(28, 29, '5cd17fb18d8d8824202053.jpg'),
(29, 30, '5cd17fdc8e490900031890.jpg'),
(30, 30, '5cd17fdc8f048965351105.jpg'),
(31, 31, '5cd180afbb350212514250.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `add_date` datetime NOT NULL,
  `edit_date` datetime DEFAULT NULL,
  `mainfile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8DF675F31B` (`author_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `add_date`, `edit_date`, `mainfile`, `author_id`) VALUES
(20, 'Bonjour', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla sollicitudin ligula ac sodales accumsan. Nam ut dui sagittis, maximus risus quis, sodales lacus. Nulla facilisi. Praesent ante mauris, faucibus nec ornare eu, eleifend vel leo. Aliquam in ligula at quam lacinia suscipit nec non lacus. Curabitur auctor tincidunt lacus, nec tincidunt mauris vehicula ac. Ut placerat ex eget auctor placerat. Proin vestibulum varius pharetra. Suspendisse tempus euismod dolor a imperdiet. Praesent arcu arcu, auctor sit amet finibus vel, ullamcorper scelerisque eros. Cras at magna dolor. Pellentesque posuere arcu ac arcu placerat varius. Sed nisl magna, tincidunt in rutrum et, pharetra vitae dui. Nullam ut placerat est. Suspendisse maximus quam sit amet tortor maximus commodo.</p>', '2019-03-11 15:54:12', '2019-05-07 14:13:08', '5cc87d570aa50364661132.jpg', 9),
(21, 'Test', '<p>Test ! Et un peu de blabla supplementaire ! Ceci est un post !</p>', '2019-04-05 11:05:22', '2019-04-30 12:23:19', '5cc83e37ecb80658621047.jpg', 9),
(22, 'Test 2', '<p>Second test de message, avec les images .</p>', '2019-04-05 11:05:52', '2019-04-05 11:05:52', '5ca73690c7768571236725.jpg', 9),
(23, 'Test 3', '<p>Test 3 ! Curabitur in faucibus metus. Nulla sed posuere ex.</p>', '2019-04-05 11:06:10', '2019-04-05 11:06:10', '5ca736a276a70174807502.jpg', 9),
(24, 'Test 4', '<p>Test 4 ! Sed ullamcorper congue tellus, id tincidunt augue fermentum ac.</p>', '2019-04-05 11:58:23', '2019-04-05 11:58:23', '5ca742dfc3118405692958.jpg', 9),
(27, 'Test 7', '<p>Blabla. Pellentesque luctus elementum odio, nec cursus est accumsan vel. Aliquam nec iaculis elit. Phasellus ante ante, malesuada non lectus sit amet, blandit imperdiet ex.</p>', '2019-04-15 12:28:13', '2019-04-15 12:28:13', '5cb478de129a8935826343.jpg', 9),
(28, 'Test demo', '<p>Test demo, 2</p>', '2019-04-15 13:06:12', '2019-04-29 12:43:25', '5cc6f16d776f0380288774.jpg', 10),
(29, 'Blablabla', '<p>Mauris lectus augue, convallis eget ante vel, commodo semper odio. Suspendisse placerat auctor eros eget maximus. Sed id sagittis sapien. Quisque elit sapien, gravida sed dignissim a, lacinia non augue. Aenean tincidunt tempus aliquam. Curabitur posuere metus vel dapibus lobortis. In ultrices id velit quis iaculis. Cras vel euismod est, pharetra viverra magna. Donec ligula est, tincidunt sed mattis eget, efficitur eu odio. Nam posuere, libero ut tempor convallis, ligula tortor lacinia felis, sit amet tincidunt nibh turpis et felis. Vestibulum vel nulla rutrum, lobortis mi ut, ultrices purus.</p>', '2019-05-07 12:53:05', '2019-05-07 12:53:05', '5cd17fb189288786173754.jpg', 9),
(30, 'Vivamus egestas finibus accumsan.', '<p>Vivamus egestas finibus accumsan. Cras tristique lobortis convallis. Cras sem purus, interdum consectetur tempor at, dapibus sit amet risus. Fusce dictum, nunc ac hendrerit consequat, nulla justo egestas risus, fringilla rhoncus libero mi sit amet augue. Duis imperdiet cursus quam nec finibus. Nullam diam ligula, lacinia non iaculis ut, pulvinar at sem. Vestibulum maximus, risus luctus pretium venenatis, turpis est commodo lectus, non vehicula sem neque vulputate ipsum. Suspendisse et mauris quis quam dignissim tincidunt at ac libero. Cras vitae turpis hendrerit, pharetra lectus ac, varius ipsum. Nulla facilisi.</p>\r\n\r\n<p>Vivamus et massa id felis rutrum malesuada. Donec dignissim dolor ac blandit mollis. Suspendisse dignissim neque at mauris ultricies sollicitudin. In commodo magna nec bibendum sagittis. Suspendisse potenti. Nulla orci neque, ornare eget nibh sed, laoreet elementum odio. Pellentesque ac mi vel sapien eleifend fringilla. Sed ut enim sed neque varius gravida in id est. Etiam feugiat ullamcorper arcu hendrerit dictum. In congue massa vitae nulla interdum efficitur. In eleifend dignissim massa, id venenatis dui faucibus quis. Donec tellus nibh, auctor id aliquam non, porta ut mauris.</p>', '2019-05-07 12:53:48', '2019-05-07 12:53:48', '5cd17fdc8d4f0664819774.jpg', 10),
(31, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', '<p>Pellentesque quis velit laoreet, mollis purus vel, sagittis tortor. Morbi in augue ipsum. Sed a lectus dui. Phasellus volutpat finibus dui, non venenatis magna volutpat sed. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lacus sapien, vulputate vel condimentum ac, vehicula non mauris. Nullam quis congue metus. Mauris rhoncus sollicitudin laoreet. Etiam tempus at mauris ac sagittis. In bibendum lobortis erat quis volutpat. Quisque sagittis urna quis nibh scelerisque sollicitudin. Sed elit ipsum, mattis nec sodales tincidunt, elementum non odio. Curabitur interdum, ipsum ac faucibus sollicitudin, orci tellus pellentesque magna, sed pellentesque arcu sapien ac lectus. Aliquam cursus tortor vitae nisl imperdiet, id consequat tortor porttitor.</p>', '2019-05-07 12:57:19', '2019-05-07 12:57:19', '5cd180afb9be0015963262.jpg', 9),
(32, 'Morbi id fermentum ligula', '<p>Morbi id fermentum ligula, non lobortis libero. Nunc pulvinar mattis ex et ultricies. Nulla ut nibh dapibus, viverra nibh ut, facilisis nulla. Aenean sollicitudin velit magna. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec a vehicula felis. Duis venenatis felis et augue gravida sodales. Integer placerat nisi ornare, iaculis dui id, dapibus lacus. Sed pretium eu nunc nec convallis. Sed nec fermentum velit. Donec blandit nulla in est convallis volutpat. Praesent id scelerisque lectus. Nulla dapibus diam id turpis mattis, vitae tincidunt nisi bibendum.</p>', '2019-05-07 12:58:00', '2019-05-07 12:58:00', '5cd180d8d2668620973114.jpg', 9),
(33, 'Pellentesque luctus elementum odio', '<p>Pellentesque luctus elementum odio, nec cursus est accumsan vel. Aliquam nec iaculis elit. Phasellus ante ante, malesuada non lectus sit amet, blandit imperdiet ex. Duis consequat, arcu vel aliquet pharetra, massa ex consectetur augue, ut viverra erat mi ac orci. Nunc eu justo fringilla, aliquam nulla non, cursus lectus. Integer nulla nunc, bibendum at velit in, rutrum imperdiet ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In ut suscipit ligula, in accumsan orci. Curabitur quam odio, euismod sit amet lacinia et, venenatis eget arcu. Sed luctus dapibus rhoncus. Nunc fringilla urna et sollicitudin pulvinar. Aenean consectetur neque risus, efficitur mollis metus consequat nec. Quisque cursus, mauris ut vestibulum elementum, risus enim pulvinar libero, sit amet pharetra justo elit ac mauris.</p>', '2019-05-07 13:24:26', '2019-05-07 13:24:27', '5cd1870b29f18375314706.jpg', 9),
(34, 'Integer commodo molestie dolor at tempus', '<p>Integer commodo molestie dolor at tempus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Curabitur iaculis nisl sollicitudin est blandit, at vestibulum quam placerat. Maecenas non libero pharetra, hendrerit sapien eget, tempor felis. Nunc at scelerisque tortor. Nunc consequat tempor ullamcorper. Donec quis semper odio, fringilla pulvinar lorem. Ut lacus ex, imperdiet in sodales vel, cursus nec neque. Fusce scelerisque molestie blandit.</p>', '2019-05-07 13:24:55', '2019-05-07 13:24:55', '5cd187273d3b0000294648.jpg', 9),
(35, 'Donec rhoncus dolor faucibus', '<p>Donec rhoncus dolor faucibus, pellentesque augue eu, volutpat velit. Nunc vestibulum posuere lorem, ac hendrerit enim cursus eget. Vestibulum tincidunt metus quis mi mollis, in porttitor nisi dapibus. Mauris rhoncus aliquam sapien. Aliquam luctus massa quis erat maximus pellentesque. Cras faucibus, erat sed placerat elementum, augue dolor fringilla massa, efficitur consequat sapien elit ac tellus. Nulla magna ante, hendrerit ut dolor sed, fermentum euismod erat. In vitae odio tempor turpis vehicula sodales. Integer nisl justo, cursus vel sem et, tincidunt aliquet augue. Mauris aliquet vestibulum mauris, a consectetur risus efficitur sit amet. Nunc consequat lacus sed erat pharetra, sed pellentesque odio efficitur.</p>', '2019-05-07 13:25:13', '2019-05-07 13:25:13', '5cd18739db6f0543356951.jpg', 9),
(36, 'Dernier test de pagination !', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut bibendum imperdiet ligula in iaculis. Ut tempus tempus velit, eget lacinia ex aliquet ut. Morbi viverra nec nibh sit amet imperdiet. Aenean consequat orci sit amet nibh finibus scelerisque. Praesent at mattis sem. In sit amet nunc et ante volutpat ultricies. Morbi facilisis ipsum id nunc laoreet, vitae ultrices tortor viverra. Etiam fermentum lorem quis tellus sagittis, non venenatis lacus volutpat. Curabitur in faucibus metus. Nulla sed posuere ex.</p>', '2019-05-07 13:26:43', '2019-05-07 13:26:43', '5cd1879357990542601235.jpg', 9);

-- --------------------------------------------------------

--
-- Structure de la table `post_reports`
--

CREATE TABLE IF NOT EXISTS `post_reports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_report_unique` (`user_id`,`post_id`),
  KEY `IDX_CCF71076A76ED395` (`user_id`),
  KEY `IDX_CCF710764B89032C` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `post_reports`
--

INSERT INTO `post_reports` (`id`, `user_id`, `post_id`) VALUES
(13, 9, 20),
(14, 9, 21),
(15, 9, 22),
(16, 9, 23),
(19, 9, 30),
(20, 9, 31),
(21, 9, 32);

-- --------------------------------------------------------

--
-- Structure de la table `post_votes`
--

CREATE TABLE IF NOT EXISTS `post_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_vote_unique` (`user_id`,`post_id`),
  KEY `IDX_C690F620A76ED395` (`user_id`),
  KEY `IDX_C690F6204B89032C` (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `post_votes`
--

INSERT INTO `post_votes` (`id`, `user_id`, `post_id`) VALUES
(26, 9, 20),
(17, 9, 23),
(27, 9, 29),
(12, 10, 20),
(15, 10, 21);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `roles`, `filename`, `updated_at`) VALUES
(9, 'Tanamassar', '$2y$13$0X9wWUdRlvaLhEVyXSI.feX96r2lIbJdY2ExQQStlD.6eL7.mLhia', 'Tanamassar@gmail.com', '{\"0\":\"ROLE_ADMIN\"}', '5cc87d43716d8349204358.jpg', '2019-04-30 16:52:19'),
(10, 'demo', '$2y$12$dyj.ciXBNdbmYHoMlex5POwsaO7wox2Cv3ZCSYzYHwIHtGTV954jK', 'Test.com', '{\"0\":\"ROLE_USER\"}', '5cc2f488ac760431264239.jpg', '2019-04-26 12:07:36'),
(27, 'Test', '$2y$13$bTwBi/Z8NaMIwERdSC5pPudCbCI/9.e2vX/4/JuoLTBgoxCzZfSWC', 'Test@hotmail.fr', '{\"0\":\"ROLE_USER\"}', NULL, '2019-05-15 11:35:35');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C4B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `FK_9474526CF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `comment_reports`
--
ALTER TABLE `comment_reports`
  ADD CONSTRAINT `FK_26CC555A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_26CC555F8697D13` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_B6BD307FCD53EDB6` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_B6BD307FF624B39D` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `FK_16DB4F894B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`);

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_5A8A6C8DF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `post_reports`
--
ALTER TABLE `post_reports`
  ADD CONSTRAINT `FK_CCF710764B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `FK_CCF71076A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `post_votes`
--
ALTER TABLE `post_votes`
  ADD CONSTRAINT `FK_C690F6204B89032C` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `FK_C690F620A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
