/*
 * Copyright 2018 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  Dim 28 oct. 2018 à 18:29
-- Version du serveur :  5.7.24-0ubuntu0.18.04.1-log
-- Version de PHP :  7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `phpQuiz`
--

-- --------------------------------------------------------

--
-- Structure de la table `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `good` tinyint(1) NOT NULL,
  `reason` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `answer`
--

INSERT INTO `answer` (`id`, `question_id`, `name`, `text`, `good`, `reason`) VALUES
(1, 1, 'Hyperlinks and Text Markup Language', '', 0, ''),
(2, 1, 'Hyper Text Markup Language', '', 1, ''),
(3, 2, 'The World Wide Web Consortium', '', 1, ''),
(4, 2, 'Google', '', 0, ''),
(5, 2, 'Microsoft', '', 0, ''),
(6, 2, 'Mozilla', '', 0, ''),
(7, 3, '<heading>', '', 0, ''),
(8, 3, '<h1>', '', 1, ''),
(9, 4, '<lb>', '', 0, ''),
(10, 4, '<br />', '', 1, ''),
(11, 5, '<body bg=\"yellow\">', '', 0, ''),
(12, 5, '<background>yellow</background>', '', 0, ''),
(13, 6, 'file:///opt/dev/cours_html/index.html', '', 1, ''),
(14, 6, 'local:///opt/dev/cours_html/index.html', '', 0, ''),
(15, 7, '<html>\r\n?? here ??\r\n<head></head>\r\n<body></body>\r\n</html>', '', 0, ''),
(16, 7, '<html>\r\n<header> ?? here ?? </header>\r\n<body></body>\r\n</html>', '', 0, ''),
(17, 8, '/', '', 1, ''),
(18, 8, '*', '', 0, ''),
(19, 9, '<par>', '', 0, ''),
(20, 9, '<text>', '', 0, ''),
(21, 10, '<td>', '', 0, ''),
(22, 10, '<th>', '', 0, ''),
(23, 11, '<merge-h>', '', 0, ''),
(24, 11, '<thead>', '', 0, ''),
(25, 12, '<merge-v>', '', 0, ''),
(26, 12, '<tfoot>', '', 0, ''),
(27, 13, '<table><tr><tt>', '', 0, ''),
(28, 13, '<table><head><tfoot>', '', 0, ''),
(29, 1, 'Home Tool Markup Language', '', 0, ''),
(30, 3, '<head>', '', 0, ''),
(31, 3, '<h6>', '', 0, ''),
(32, 4, '<break>', '', 0, ''),
(33, 4, '<br>', '', 0, ''),
(34, 5, '<body class=\"myStyle\">', '.myStyle { \r\nbackground-color:yellow;\r\n}', 1, ''),
(35, 7, '<html>\r\n<head> ?? here ?? </head>\r\n<body></body>\r\n</html>', '', 1, ''),
(36, 8, '<', '', 0, ''),
(37, 8, '^', '', 0, ''),
(38, 9, '<p>', '', 1, ''),
(39, 10, '<tr>', '', 1, ''),
(40, 10, '<thead>', '', 0, ''),
(41, 11, 'cellspan', '', 0, ''),
(42, 11, 'colspan', '', 1, ''),
(43, 12, 'rowspan', '', 1, ''),
(44, 12, 'vspan', '', 0, ''),
(45, 13, '<thead><body><tr>', '', 0, ''),
(46, 13, '<table><tr><td>', '', 1, '');

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`id`, `quiz_id`, `name`, `text`) VALUES
(1, 1, 'What does HTML stand for?', ''),
(2, 1, 'Who is making the Web standards?', ''),
(3, 1, 'Choose the correct HTML element for the largest heading', ''),
(4, 1, 'What is the correct HTML element for inserting a line break?', ''),
(5, 1, 'What is the correct HTML for adding a background color?', ''),
(6, 1, 'To access a file on local, do you use?', ''),
(7, 1, 'Where do you put these tags?', '<meta charset=\"utf-8\"> \r\n<title>Techno web module</title>'),
(8, 1, 'Which character is used to indicate an end tag?', ''),
(9, 1, 'What is the tag for the paragraphe', ''),
(10, 1, 'In a table, what is the tag for a row?', ''),
(11, 1, 'In a table, how do you merge cells horizontally?', ''),
(12, 1, 'In a table, how do you merge cells vertically?', ''),
(13, 1, 'Which of these elements are all <table> elements?', '');

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `open` tinyint(1) NOT NULL,
  `questions_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `quiz`
--

INSERT INTO `quiz` (`id`, `session_id`, `name`, `code`, `open`, `questions_count`) VALUES
(1, 1, 'HTML Quiz', 'HTML', 1, 10);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `name`, `code`) VALUES
(1, 'admin', 'ADMIN'),
(2, 'Student', 'STUDENT');

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`id`, `name`, `code`) VALUES
(1, '2018 session', '2018');

-- --------------------------------------------------------

--
-- Structure de la table `solution`
--

CREATE TABLE `solution` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `workgroup_id` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `workgroup_id`, `session_id`, `role_id`, `lastname`, `firstname`, `email`, `login`, `password`) VALUES
(1, NULL, NULL, 1, 'admin', 'admin', 'admin@admin.com', 'admin', 'pxwLUp0iSuTYM'),
(2, NULL, 1, 2, 'test', 'test', 'test@test.com', 'test', '098f6bcd4621d373cade4e832627b4f6');

-- --------------------------------------------------------

--
-- Structure de la table `user_quiz`
--

CREATE TABLE `user_quiz` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `date` bigint(20) UNSIGNED NOT NULL,
  `good_answer_count` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `user_quiz_answer`
--

CREATE TABLE `user_quiz_answer` (
  `id` int(11) NOT NULL,
  `date` bigint(20) UNSIGNED NOT NULL,
  `user_quiz_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `workgroup`
--

CREATE TABLE `workgroup` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_DADD4A251E27F6BF` (`question_id`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6F7494E853CD175` (`quiz_id`);

--
-- Index pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A412FA92613FECDF` (`session_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `solution`
--
ALTER TABLE `solution`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9F3329DB1E27F6BF` (`question_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8D93D6495FD78018` (`workgroup_id`),
  ADD KEY `IDX_8D93D649613FECDF` (`session_id`),
  ADD KEY `IDX_8D93D649D60322AC` (`role_id`);

--
-- Index pour la table `user_quiz`
--
ALTER TABLE `user_quiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_quiz_fk1` (`user_id`),
  ADD KEY `user_quiz_fk2` (`quiz_id`);

--
-- Index pour la table `user_quiz_answer`
--
ALTER TABLE `user_quiz_answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_quiz_answer_fk1` (`answer_id`),
  ADD KEY `user_quiz_answer_fk2` (`user_quiz_id`);

--
-- Index pour la table `workgroup`
--
ALTER TABLE `workgroup`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT pour la table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `solution`
--
ALTER TABLE `solution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user_quiz`
--
ALTER TABLE `user_quiz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user_quiz_answer`
--
ALTER TABLE `user_quiz_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `workgroup`
--
ALTER TABLE `workgroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `FK_DADD4A251E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`);

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_B6F7494E853CD175` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`);

--
-- Contraintes pour la table `quiz`
--
ALTER TABLE `quiz`
  ADD CONSTRAINT `FK_A412FA92613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`);

--
-- Contraintes pour la table `solution`
--
ALTER TABLE `solution`
  ADD CONSTRAINT `FK_9F3329DB1E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6495FD78018` FOREIGN KEY (`workgroup_id`) REFERENCES `workgroup` (`id`),
  ADD CONSTRAINT `FK_8D93D649613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  ADD CONSTRAINT `FK_8D93D649D60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Contraintes pour la table `user_quiz`
--
ALTER TABLE `user_quiz`
  ADD CONSTRAINT `user_quiz_fk1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_quiz_fk2` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`);

--
-- Contraintes pour la table `user_quiz_answer`
--
ALTER TABLE `user_quiz_answer`
  ADD CONSTRAINT `user_quiz_answer_fk1` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`),
  ADD CONSTRAINT `user_quiz_answer_fk2` FOREIGN KEY (`user_quiz_id`) REFERENCES `user_quiz` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;