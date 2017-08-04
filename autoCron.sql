-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 01 juin 2017 à 17:46
-- Version du serveur :  5.7.18-0ubuntu0.16.04.1
-- Version de PHP :  7.0.18-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `autoCron`
--

-- --------------------------------------------------------

--
-- Structure de la table `jobExecutions`
--

CREATE TABLE `jobExecutions` (
  `id` int(10) UNSIGNED NOT NULL,
  `uidJob` int(10) UNSIGNED DEFAULT NULL,
  `startDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `endDate` datetime DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `updateAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `jobExecutions`
--

INSERT INTO `jobExecutions` (`id`, `uidJob`, `startDate`, `endDate`, `status`, `updateAt`) VALUES
(21, 973337697, '2017-05-24 16:34:38', '2017-05-24 16:34:38', 2, '2017-05-24 16:34:38'),
(22, 973337697, '2017-05-24 16:34:38', '2017-05-24 16:34:38', 2, '2017-05-24 16:34:38'),
(23, 973337697, '2017-05-24 16:34:38', '2017-05-24 16:34:38', 2, '2017-05-24 16:34:38');

-- --------------------------------------------------------

--
-- Structure de la table `jobExecutionsBenchMark`
--

CREATE TABLE `jobExecutionsBenchMark` (
  `id` int(10) UNSIGNED NOT NULL,
  `idJobExecution` int(10) UNSIGNED DEFAULT NULL,
  `maxCpu` smallint(5) UNSIGNED NOT NULL,
  `MinCpu` smallint(5) UNSIGNED NOT NULL,
  `avgCpu` float UNSIGNED NOT NULL,
  `medianCpu` float UNSIGNED NOT NULL,
  `maxRam` mediumint(8) UNSIGNED NOT NULL,
  `minRam` mediumint(8) UNSIGNED NOT NULL,
  `avgRam` double UNSIGNED NOT NULL,
  `medianRam` double UNSIGNED NOT NULL,
  `time` int(10) UNSIGNED NOT NULL,
  `updateAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `uid` int(10) UNSIGNED NOT NULL,
  `jobName` varchar(255) NOT NULL,
  `createDate` datetime DEFAULT NULL,
  `maxParallelExecution` smallint(6) NOT NULL DEFAULT '0',
  `benchmark` tinyint(1) NOT NULL,
  `updateAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `jobs`
--

INSERT INTO `jobs` (`uid`, `jobName`, `createDate`, `maxParallelExecution`, `benchmark`, `updateAt`) VALUES
(973337697, 'test autocron', '2017-05-16 22:15:26', 0, 0, '2017-05-26 11:00:42');

-- --------------------------------------------------------

--
-- Structure de la table `jobsOptions`
--

CREATE TABLE `jobsOptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `uidJob` int(10) UNSIGNED DEFAULT NULL,
  `benchmark` tinyint(1) NOT NULL,
  `updateAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `jobStepExecutions`
--

CREATE TABLE `jobStepExecutions` (
  `id` int(10) UNSIGNED NOT NULL,
  `uidStep` int(10) UNSIGNED DEFAULT NULL,
  `idJobExecution` int(10) UNSIGNED DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `startDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `message` text,
  `updateAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `jobStepExecutions`
--

INSERT INTO `jobStepExecutions` (`id`, `uidStep`, `idJobExecution`, `status`, `startDate`, `endDate`, `message`, `updateAt`) VALUES
(20, 1123008820, 21, 2, '2017-05-24 16:34:38', '2017-05-24 16:34:38', '{\"dbmessage\":\"coucou db\",\"0\":\"hello world\"}', '2017-05-24 16:34:38');

-- --------------------------------------------------------

--
-- Structure de la table `jobStepParameterLinks`
--

CREATE TABLE `jobStepParameterLinks` (
  `id` int(10) UNSIGNED NOT NULL,
  `uidStep` int(10) UNSIGNED DEFAULT NULL,
  `uidParameter` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `jobStepParameterLinks`
--

INSERT INTO `jobStepParameterLinks` (`id`, `uidStep`, `uidParameter`) VALUES
(1, 1123008820, 3762985997);

-- --------------------------------------------------------

--
-- Structure de la table `jobStepParameters`
--

CREATE TABLE `jobStepParameters` (
  `uid` int(10) UNSIGNED NOT NULL,
  `content` mediumtext NOT NULL,
  `updateAt` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `jobStepParameters`
--

INSERT INTO `jobStepParameters` (`uid`, `content`, `updateAt`) VALUES
(3762985997, 'test=coucou', '2017-05-24 15:00:31');

-- --------------------------------------------------------

--
-- Structure de la table `JobSteps`
--

CREATE TABLE `JobSteps` (
  `uid` int(10) UNSIGNED NOT NULL,
  `uidJob` int(10) UNSIGNED DEFAULT NULL,
  `stepName` varchar(100) NOT NULL,
  `namespace` varchar(100) NOT NULL DEFAULT '\\',
  `class` varchar(100) NOT NULL,
  `position` smallint(5) UNSIGNED NOT NULL,
  `updateAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `JobSteps`
--

INSERT INTO `JobSteps` (`uid`, `uidJob`, `stepName`, `namespace`, `class`, `position`, `updateAt`) VALUES
(1123008820, 973337697, 'test Smartcron step 1', '\\', 'TestCron', 0, '2017-05-24 14:48:08');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `jobExecutions`
--
ALTER TABLE `jobExecutions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idJob` (`uidJob`),
  ADD KEY `status` (`status`),
  ADD KEY `updateAt` (`updateAt`);

--
-- Index pour la table `jobExecutionsBenchMark`
--
ALTER TABLE `jobExecutionsBenchMark`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idJobExecution` (`idJobExecution`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `updateAt` (`updateAt`);

--
-- Index pour la table `jobsOptions`
--
ALTER TABLE `jobsOptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idJob` (`uidJob`),
  ADD KEY `updateAt` (`updateAt`);

--
-- Index pour la table `jobStepExecutions`
--
ALTER TABLE `jobStepExecutions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idStep` (`uidStep`),
  ADD KEY `idJobExecution` (`idJobExecution`),
  ADD KEY `status` (`status`);

--
-- Index pour la table `jobStepParameterLinks`
--
ALTER TABLE `jobStepParameterLinks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idStep` (`uidStep`),
  ADD KEY `idParameters` (`uidParameter`);

--
-- Index pour la table `jobStepParameters`
--
ALTER TABLE `jobStepParameters`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `updateAt` (`updateAt`);

--
-- Index pour la table `JobSteps`
--
ALTER TABLE `JobSteps`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `idJob` (`uidJob`),
  ADD KEY `updateAt` (`updateAt`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `jobExecutions`
--
ALTER TABLE `jobExecutions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT pour la table `jobExecutionsBenchMark`
--
ALTER TABLE `jobExecutionsBenchMark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `jobsOptions`
--
ALTER TABLE `jobsOptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `jobStepExecutions`
--
ALTER TABLE `jobStepExecutions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `jobStepParameterLinks`
--
ALTER TABLE `jobStepParameterLinks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `jobExecutions`
--
ALTER TABLE `jobExecutions`
  ADD CONSTRAINT `job execution` FOREIGN KEY (`uidJob`) REFERENCES `jobs` (`uid`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Contraintes pour la table `jobExecutionsBenchMark`
--
ALTER TABLE `jobExecutionsBenchMark`
  ADD CONSTRAINT `job execution benchmark` FOREIGN KEY (`idJobExecution`) REFERENCES `jobExecutions` (`id`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Contraintes pour la table `jobsOptions`
--
ALTER TABLE `jobsOptions`
  ADD CONSTRAINT `job options` FOREIGN KEY (`uidJob`) REFERENCES `jobs` (`uid`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Contraintes pour la table `jobStepExecutions`
--
ALTER TABLE `jobStepExecutions`
  ADD CONSTRAINT `job step execution` FOREIGN KEY (`uidStep`) REFERENCES `JobSteps` (`uid`) ON DELETE CASCADE ON UPDATE SET NULL,
  ADD CONSTRAINT `job steps execution 2` FOREIGN KEY (`idJobExecution`) REFERENCES `jobExecutions` (`id`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Contraintes pour la table `jobStepParameterLinks`
--
ALTER TABLE `jobStepParameterLinks`
  ADD CONSTRAINT `job step parameter` FOREIGN KEY (`uidStep`) REFERENCES `JobSteps` (`uid`) ON DELETE CASCADE ON UPDATE SET NULL,
  ADD CONSTRAINT `job step parameter 2` FOREIGN KEY (`uidParameter`) REFERENCES `jobStepParameters` (`uid`) ON DELETE CASCADE ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
