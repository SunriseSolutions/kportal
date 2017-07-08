-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Sam 08 Juillet 2017 à 15:49
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `kportal`
--

-- --------------------------------------------------------

--
-- Structure de la table `h5p__content`
--

CREATE TABLE `h5p__content` (
  `id` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `parameters` longtext COLLATE utf8_unicode_ci NOT NULL,
  `filtered` longtext COLLATE utf8_unicode_ci NOT NULL,
  `keywords` longtext COLLATE utf8_unicode_ci,
  `description` longtext COLLATE utf8_unicode_ci,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `embed_type` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `content_type` varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author` varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL,
  `license` varchar(7) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  `id_library` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `h5p__content`
--

INSERT INTO `h5p__content` (`id`, `created_at`, `updated_at`, `enabled`, `parameters`, `filtered`, `keywords`, `description`, `title`, `embed_type`, `content_type`, `author`, `license`, `slug`, `id_library`) VALUES
('1', '2017-05-30 09:40:43', '2017-06-22 02:54:22', 1, '{"media":{"params":{"contentName":"Image","file":{"path":"images/file-592da00abe776.jpg","mime":"image/jpeg","copyright":{"license":"U"},"width":800,"height":800},"alt":"sample ALternative Text","title":"sample hover text"},"library":"H5P.Image 1.0","subContentId":"d9fa0034-a59f-447e-a2c6-61da8c09e8d5"},"answers":[{"correct":false,"tipsAndFeedback":{"tip":"<p>sapmle tip for q1</p>\\n","chosenFeedback":"<div>sample displayed message if answer is selected</div>\\n","notChosenFeedback":"<div>sample msg if not selected</div>\\n"},"text":"<div>option 1 text incorrect</div>\\n"},{"correct":true,"tipsAndFeedback":{"tip":"<p>tip</p>\\n","chosenFeedback":"<div>selected</div>\\n","notChosenFeedback":"<div>why not selected</div>\\n"},"text":"<div>option 1 text <strong>correct</strong></div>\\n"}],"UI":{"checkAnswerButton":"Check","showSolutionButton":"Show solution","tryAgainButton":"Retry","tipsLabel":"Show tip","scoreBarLabel":"Score","tipAvailable":"Tip available","feedbackAvailable":"Feedback available","readFeedback":"Read feedback","wrongAnswer":"Wrong answer","correctAnswer":"Correct answer","feedback":"You got @score of @total points","shouldCheck":"Should have been checked","shouldNotCheck":"Should not have been checked","noInput":"Please answer before viewing the solution"},"behaviour":{"enableRetry":true,"enableSolutionsButton":true,"type":"auto","singlePoint":true,"randomAnswers":true,"showSolutionsRequiresInput":true,"disableImageZooming":false,"confirmCheckDialog":false,"confirmRetryDialog":false,"autoCheck":true,"passPercentage":100},"confirmCheck":{"header":"Finish ?","body":"Are you sure you wish to finish ?","cancelLabel":"Cancel","confirmLabel":"Finish"},"confirmRetry":{"header":"Retry ?","body":"Are you sure you wish to retry ?","cancelLabel":"Cancel","confirmLabel":"Confirm"},"question":"<p>Question 1 short-code</p>\\n"}', '{"media":{"params":{"contentName":"Image","file":{"path":"images\\/file-592da00abe776.jpg","mime":"image\\/jpeg","copyright":{"license":"U"},"width":800,"height":800},"alt":"sample ALternative Text","title":"sample hover text"},"library":"H5P.Image 1.0","subContentId":"d9fa0034-a59f-447e-a2c6-61da8c09e8d5"},"answers":[{"correct":false,"tipsAndFeedback":{"tip":"<p>sapmle tip for q1<\\/p>\\n","chosenFeedback":"<div>sample displayed message if answer is selected<\\/div>\\n","notChosenFeedback":"<div>sample msg if not selected<\\/div>\\n"},"text":"<div>option 1 text incorrect<\\/div>\\n"},{"correct":true,"tipsAndFeedback":{"tip":"<p>tip<\\/p>\\n","chosenFeedback":"<div>selected<\\/div>\\n","notChosenFeedback":"<div>why not selected<\\/div>\\n"},"text":"<div>option 1 text <strong>correct<\\/strong><\\/div>\\n"}],"UI":{"checkAnswerButton":"Check","showSolutionButton":"Show solution","tryAgainButton":"Retry","tipsLabel":"Show tip","scoreBarLabel":"Score","tipAvailable":"Tip available","feedbackAvailable":"Feedback available","readFeedback":"Read feedback","wrongAnswer":"Wrong answer","correctAnswer":"Correct answer","feedback":"You got @score of @total points","shouldCheck":"Should have been checked","shouldNotCheck":"Should not have been checked","noInput":"Please answer before viewing the solution"},"behaviour":{"enableRetry":true,"enableSolutionsButton":true,"type":"auto","singlePoint":true,"randomAnswers":true,"showSolutionsRequiresInput":true,"disableImageZooming":false,"confirmCheckDialog":false,"confirmRetryDialog":false,"autoCheck":true,"passPercentage":100},"confirmCheck":{"header":"Finish ?","body":"Are you sure you wish to finish ?","cancelLabel":"Cancel","confirmLabel":"Finish"},"confirmRetry":{"header":"Retry ?","body":"Are you sure you wish to retry ?","cancelLabel":"Cancel","confirmLabel":"Confirm"},"question":"<p>Question 1 short-code<\\/p>\\n"}', NULL, NULL, 'Quiz 1', 'div', NULL, NULL, NULL, 'quiz-1', '6');

-- --------------------------------------------------------

--
-- Structure de la table `h5p__content_library`
--

CREATE TABLE `h5p__content_library` (
  `id_library` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `id_content` varchar(24) COLLATE utf8_unicode_ci NOT NULL,
  `drop_css` tinyint(1) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL,
  `dependency_type` varchar(31) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'preloaded'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `h5p__content_library`
--

INSERT INTO `h5p__content_library` (`id_library`, `id_content`, `drop_css`, `position`, `dependency_type`) VALUES
('1', '1', 0, 5, 'preloaded'),
('2', '1', 0, 2, 'preloaded'),
('3', '1', 0, 3, 'preloaded'),
('4', '1', 0, 1, 'preloaded'),
('5', '1', 0, 7, 'preloaded'),
('6', '1', 0, 9, 'preloaded'),
('7', '1', 0, 8, 'preloaded'),
('8', '1', 0, 6, 'preloaded'),
('9', '1', 0, 4, 'preloaded');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `h5p__content`
--
ALTER TABLE `h5p__content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B8BB3E457F1D31CC` (`id_library`);

--
-- Index pour la table `h5p__content_library`
--
ALTER TABLE `h5p__content_library`
  ADD PRIMARY KEY (`id_library`,`id_content`),
  ADD KEY `IDX_1C53CB247F1D31CC` (`id_library`),
  ADD KEY `IDX_1C53CB24205899D9` (`id_content`);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `h5p__content`
--
ALTER TABLE `h5p__content`
  ADD CONSTRAINT `FK_B8BB3E457F1D31CC` FOREIGN KEY (`id_library`) REFERENCES `h5p__library` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `h5p__content_library`
--
ALTER TABLE `h5p__content_library`
  ADD CONSTRAINT `FK_1C53CB24205899D9` FOREIGN KEY (`id_content`) REFERENCES `h5p__content` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_1C53CB247F1D31CC` FOREIGN KEY (`id_library`) REFERENCES `h5p__library` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
