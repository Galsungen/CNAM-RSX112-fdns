--
-- @author Galsungen - http://blog.galsungen.net
-- Année 2010
-- RSX112 - Sécurité et réseaux - Projet FDNS
--

-- Création de la base avec son encodage
CREATE DATABASE `gd_fdns` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;

-- Création d'un utilisateur dédié avec droits pour fonctionner avec cette base
GRANT SELECT,INSERT,UPDATE,DELETE ON `gd_fdns`.* TO gdbdd@localhost IDENTIFIED BY 'ToTo-852#963';

-- Création des tables et insertion des données de test
DROP TABLE IF EXISTS `gd_connexions`;
CREATE TABLE IF NOT EXISTS `gd_connexions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `date` date NOT NULL,
  `HHmmss` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(1, '1', '127.0.0.1', '2010-04-11', 154122);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(2, 'Alice', '127.0.0.1', '2010-04-11', 164324);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(3, 'Alice', '127.0.0.1', '2010-04-11', 164349);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(4, 'Alice', '127.0.0.1', '2010-04-11', 213136);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(5, 'Alice', '127.0.0.1', '2010-04-11', 213151);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(6, 'Alice', '127.0.0.1', '2010-04-11', 213213);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(7, 'Alice', '127.0.0.1', '2010-04-11', 213300);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(8, 'Alice', '127.0.0.1', '2010-04-18', 105706);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(9, 'Alice', '127.0.0.1', '2010-05-13', 170935);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(10, 'Alice', '127.0.0.1', '2010-05-14', 103150);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(11, 'Alice', '127.0.0.1', '2010-05-14', 163242);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(12, 'Alice', '127.0.0.1', '2010-05-14', 163325);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(13, 'Alice', '127.0.0.1', '2010-05-14', 163747);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(14, 'toto', '127.0.0.1', '2010-05-14', 184142);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(15, 'toto', '127.0.0.1', '2010-05-15', 135937);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(16, 'toto', '127.0.0.1', '2010-05-16', 170802);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(17, 'Delphine', '127.0.0.1', '2010-05-22', 160501);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(18, 'Bob', '127.0.0.1', '2010-05-22', 160559);
INSERT INTO `gd_connexions` (`id`, `login`, `ip`, `date`, `HHmmss`) VALUES(19, 'toto', '192.168.0.3', '2010-05-22', 162103);

DROP TABLE IF EXISTS `gd_dns`;
CREATE TABLE IF NOT EXISTS `gd_dns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`,`ip`),
  UNIQUE KEY `nom_2` (`nom`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

INSERT INTO `gd_dns` (`id`, `nom`, `ip`) VALUES(1, 'toto', '192.168.10.103');
INSERT INTO `gd_dns` (`id`, `nom`, `ip`) VALUES(2, 'titi', '192.168.10.104');
INSERT INTO `gd_dns` (`id`, `nom`, `ip`) VALUES(3, 'alf', '192.168.10.105');
INSERT INTO `gd_dns` (`id`, `nom`, `ip`) VALUES(9, 'alfy', '192.168.10.4');
INSERT INTO `gd_dns` (`id`, `nom`, `ip`) VALUES(5, 'altoa', '192.168.10.1');
INSERT INTO `gd_dns` (`id`, `nom`, `ip`) VALUES(6, 'tototo', '92.10.25.32');
INSERT INTO `gd_dns` (`id`, `nom`, `ip`) VALUES(10, 'srv_domain', '10.0.0.1');
INSERT INTO `gd_dns` (`id`, `nom`, `ip`) VALUES(11, 'srv-tux', '10.0.0.2');
INSERT INTO `gd_dns` (`id`, `nom`, `ip`) VALUES(12, 'xls', '10.0.1.15');
INSERT INTO `gd_dns` (`id`, `nom`, `ip`) VALUES(14, 'dudule', '10.3.2.1');

DROP TABLE IF EXISTS `gd_identification`;
CREATE TABLE IF NOT EXISTS `gd_identification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `role` varchar(10) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `mdp` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `login` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

INSERT INTO `gd_identification` (`id`, `login`, `role`, `mdp`) VALUES(1, 'Alice', 'ecrivain', '9b63ad9fa6e71793116a74d5d20bad50');
INSERT INTO `gd_identification` (`id`, `login`, `role`, `mdp`) VALUES(2, 'Bob', 'ecrivain', '51a59b5fe882ebac3c7a8165c212b20f');
INSERT INTO `gd_identification` (`id`, `login`, `role`, `mdp`) VALUES(3, 'Charly', 'lecteur', '8be28b98e175fa00ffc4753027621362');
INSERT INTO `gd_identification` (`id`, `login`, `role`, `mdp`) VALUES(4, 'toto', 'admin', '96149617d01ff13f22e1bf60536033b8');
INSERT INTO `gd_identification` (`id`, `login`, `role`, `mdp`) VALUES(5, 'Delphine', 'lecteur', '45330af3a9b66a301ccbc36e27bacb6a');
INSERT INTO `gd_identification` (`id`, `login`, `role`, `mdp`) VALUES(9, 'Alpha', 'admin', '8d9cef473989509ad1cd3a2849ed1aa7');

DROP TABLE IF EXISTS `gd_journal`;
CREATE TABLE IF NOT EXISTS `gd_journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `action` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `date` date NOT NULL,
  `HHmmss` varchar(20) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(1, 'Alice', 'Ajout enregistrement : 192.168.10.103 - toto', '127.0.0.1', 'toto', '2010-04-18', '112722');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(2, 'Alice', 'Ajout enregistrement : 192.168.10.1 - alfy', '127.0.0.1', 'alfy', '2010-04-18', '113315');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(3, 'Alice', 'Ajout enregistrement : 192.168.10.1 - altoa', '127.0.0.1', 'altoa', '2010-04-18', '115009');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(4, 'Alice', 'Ajout enregistrement : 192.168.10.4 - altoa', '127.0.0.1', 'altoa', '2010-04-18', '115027');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(5, 'Alice', 'Ajout enregistrement : 192.168.10.4 - altoa', '127.0.0.1', 'altoa', '2010-04-18', '120648');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(6, '', 'acces sans session', '127.0.0.1', '', '2010-04-18', '134226');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(7, '', 'consultation du journal des connexions', '', '', '0000-00-00', '');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(8, '', 'consultation du journal', '', '', '0000-00-00', '');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(9, '', 'consultation du journal des connexions', '127.0.0.1', '', '2010-05-13', '191421');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(10, '', 'consultation du journal', '127.0.0.1', '', '2010-05-13', '191423');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(11, '', 'consultation du journal des connexions', '127.0.0.1', '', '2010-05-13', '191639');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(12, 'Alice', 'consultation du journal', '127.0.0.1', '', '2010-05-13', '191640');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(13, '', 'consultation du journal des connexions', '127.0.0.1', '', '2010-05-13', '191643');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(14, 'Alice', 'consultation du journal', '127.0.0.1', '', '2010-05-13', '191644');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(15, 'Alice', 'consultation du journal des connexions', '127.0.0.1', '', '2010-05-13', '191709');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(16, 'Alice', 'consultation du journal', '127.0.0.1', '', '2010-05-13', '191710');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(17, 'Alice', 'consultation enregistrements pour l''ip : 192.168.1', '127.0.0.1', '', '2010-05-14', '154142');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(18, 'Alice', 'consultation enregistrements pour l''ip : 192.168.1', '127.0.0.1', '', '2010-05-14', '154159');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(19, 'Alice', 'consultation enregistrements pour l''ip : 192.168.1', '127.0.0.1', '', '2010-05-14', '154517');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(20, 'Alice', 'consultation enregistrements pour l''ip : 192.168.1', '127.0.0.1', '', '2010-05-14', '154624');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(21, 'Alice', 'consultation enregistrements pour l''ip : 192.168.1', '127.0.0.1', '', '2010-05-14', '154650');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(22, 'Alice', 'consultation enregistrements pour l''ip : 192.168.1', '127.0.0.1', '', '2010-05-14', '154839');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(23, 'Alice', 'consultation enregistrements pour l''ip : 192.168.1', '127.0.0.1', '', '2010-05-14', '154847');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(24, 'Alice', 'consultation enregistrements pour l''ip : 192.168.1', '127.0.0.1', '', '2010-05-14', '154907');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(25, 'Alice', 'consultation enregistrements pour l''ip : 192.168.1', '127.0.0.1', '', '2010-05-14', '154932');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(26, 'Alice', 'consultation enregistrements pour l''ip : 192.168.1', '127.0.0.1', '', '2010-05-14', '155035');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(27, 'Alice', 'consultation enregistrements pour l''ip : 192.168.1', '127.0.0.1', '', '2010-05-14', '155048');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(28, 'Alice', 'consultation enregistrements pour l''ip : 192.168.1', '127.0.0.1', '', '2010-05-14', '155125');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(29, 'Alice', 'consultation enregistrement pour le nom : alfy', '127.0.0.1', '', '2010-05-14', '155146');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(30, 'Alice', 'consultation enregistrement pour le nom : alfy', '127.0.0.1', '', '2010-05-14', '155421');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(31, 'Alice', 'consultation enregistrements pour le nom : hjkhkj.', '127.0.0.1', '', '2010-05-14', '155431');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(32, 'Alice', 'consultation du journal', '127.0.0.1', '', '2010-05-14', '155436');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(33, 'Alice', 'consultation enregistrements pour l''ip : 192.168.10.4. Pas de rÃ©sultats.', '127.0.0.1', '', '2010-05-14', '160157');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(34, 'Alice', 'consultation enregistrements pour l''ip : 192.168.10.1', '127.0.0.1', '', '2010-05-14', '160204');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(35, 'Alice', 'consultation enregistrement pour le nom : Alfy', '127.0.0.1', '', '2010-05-14', '160209');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(36, 'Alice', 'consultation enregistrements pour le nom : shqkjf. Pas de rÃ©sultat.', '127.0.0.1', '', '2010-05-14', '160214');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(37, 'Alice', 'consultation du journal des connexions', '127.0.0.1', '', '2010-05-14', '160218');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(38, 'Alice', 'consultation du journal', '127.0.0.1', '', '2010-05-14', '160224');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(39, 'Alice', 'consultation du journal des connexions', '127.0.0.1', '', '2010-05-14', '160230');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(40, 'Alice', 'consultation enregistrements pour l''ip : 192.168.10.1', '127.0.0.1', '', '2010-05-14', '160251');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(41, 'Alice', 'consultation enregistrements pour l''ip : 192.168.10.1', '127.0.0.1', '', '2010-05-14', '161029');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(42, 'Alice', 'Ajout enregistrement : 92.10.25.32 - tototo', '127.0.0.1', 'tototo', '2010-05-14', '170048');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(43, 'Alice', 'tototo est dÃ©jÃ  associÃ© Ã  92.10.25.32', '127.0.0.1', 'tototo', '2010-05-14', '170100');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(44, 'Alice', 'ip invalide', '127.0.0.1', 'ggtrd', '2010-05-14', '170105');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(45, 'Alice', 'Ajout enregistrement : nhdsgw - ggtrd', '127.0.0.1', 'ggtrd', '2010-05-14', '170105');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(46, 'Alice', 'ip invalide', '127.0.0.1', 'ggtrd', '2010-05-14', '170247');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(47, 'Alice', 'Ajout enregistrement : 192.168.10.1 - azertyuiop', '127.0.0.1', 'azertyuiop', '2010-05-14', '170346');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(48, 'Alice', 'azertyuiop est dÃ©jÃ  associÃ© Ã  192.168.10.1', '127.0.0.1', 'azertyuiop', '2010-05-14', '170354');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(49, 'Alice', 'azertyuiop est dÃ©jÃ  associÃ© Ã  192.168.10.1', '127.0.0.1', 'azertyuiop', '2010-05-14', '174128');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(50, 'Alice', 'azertyuiop est dÃ©jÃ  associÃ© Ã  192.168.10.1', '127.0.0.1', 'azertyuiop', '2010-05-14', '174133');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(51, 'Alice', 'azertyuiop est dÃ©jÃ  associÃ© Ã  192.168.10.1', '127.0.0.1', 'azertyuiop', '2010-05-14', '174135');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(52, 'Alice', 'acces non admin Ã  la page de gestion des utilisateurs.', '127.0.0.1', '', '2010-05-14', '183954');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(53, 'Alice', 'acces non admin Ã  la page de gestion des utilisateurs.', '127.0.0.1', '', '2010-05-14', '184033');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(54, '', 'toto ne peut pas se supprimer lui-mÃªme.', '', '', '0000-00-00', '');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(55, '', 'toto ne peut pas se supprimer lui-mÃªme.', '', '', '0000-00-00', '');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(56, '', 'toto ne peut pas se supprimer lui-mÃªme.', '', '', '0000-00-00', '');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(57, '', 'toto ne peut pas se supprimer lui-mÃªme.', '', '', '0000-00-00', '');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(58, '', 'toto ne peut pas se supprimer lui-mÃªme.', '', '', '0000-00-00', '');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(59, 'toto', 'toto ne peut pas se supprimer lui-mÃªme.', '127.0.0.1', '', '2010-05-14', '193548');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(60, 'toto', 'consultation enregistrements pour l''ip : 192.168.10.1', '127.0.0.1', '', '2010-05-15', '140430');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(61, 'toto', 'consultation enregistrements pour l''ip : 192.168.10.1', '127.0.0.1', '', '2010-05-15', '141423');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(62, 'toto', 'consultation enregistrements pour l''ip : 192.168.10.1', '127.0.0.1', '', '2010-05-15', '141512');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(63, 'toto', 'consultation enregistrements pour l''ip : 192.168.10.1', '127.0.0.1', '', '2010-05-15', '142017');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(64, '', 'Suppression de l''enregistrement azertyuiop effectuÃ©e avec succÃ¨s.', '127.0.0.1', '', '2010-05-15', '142032');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(65, 'toto', 'consultation enregistrements pour l''ip : 192.168.10.1', '127.0.0.1', '', '2010-05-15', '142118');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(66, 'toto', 'consultation enregistrement pour le nom : alfy', '127.0.0.1', '', '2010-05-15', '142123');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(67, '', 'Suppression de l''enregistrement alfy effectuÃ©e avec succÃ¨s.', '127.0.0.1', '', '2010-05-15', '142125');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(68, 'toto', 'consultation enregistrements pour l''ip : 192.168.10.4. Pas de rÃ©sultats.', '127.0.0.1', '', '2010-05-15', '142133');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(69, 'toto', 'Ajout enregistrement : 192.168.10.4 - alfy', '127.0.0.1', 'alfy', '2010-05-15', '142141');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(70, 'toto', 'consultation enregistrements pour l''ip : 192.168.10.4', '127.0.0.1', '', '2010-05-15', '142149');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(71, 'toto', 'consultation enregistrements pour l''ip : 192.168.10.4', '127.0.0.1', '', '2010-05-15', '143147');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(72, 'toto', 'consultation enregistrements pour l''ip : 192.168.10.4', '127.0.0.1', '', '2010-05-15', '143238');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(73, 'toto', 'consultation enregistrements pour l''ip : 192.168.10.4', '127.0.0.1', '', '2010-05-15', '143415');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(74, 'toto', 'consultation enregistrements pour l''ip : 192.168.10.4', '127.0.0.1', '', '2010-05-15', '143615');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(75, 'toto', 'consultation du journal', '127.0.0.1', '', '2010-05-15', '143802');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(76, 'toto', 'consultation du journal des connexions', '127.0.0.1', '', '2010-05-15', '143814');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(77, 'toto', 'Modification de toto avec succÃ¨s.', '127.0.0.1', '', '2010-05-16', '171008');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(78, 'toto', 'Modification de achauche avec succÃ¨s.', '127.0.0.1', '', '2010-05-16', '171020');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(79, 'toto', 'Suppression de titi.', '127.0.0.1', '', '2010-05-16', '171023');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(80, 'toto', 'Modification de Bob avec succÃ¨s.', '127.0.0.1', '', '2010-05-16', '171043');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(81, 'toto', 'Modification de Alice avec succÃ¨s.', '127.0.0.1', '', '2010-05-16', '171057');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(82, 'toto', 'Modification de Delphine avec succÃ¨s.', '127.0.0.1', '', '2010-05-16', '171111');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(83, 'toto', 'Modification de Charly avec succÃ¨s.', '127.0.0.1', '', '2010-05-16', '171122');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(84, 'Delphine', 'consultation enregistrements pour l''ip : 192.168.10.4', '127.0.0.1', '', '2010-05-22', '160509');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(85, 'Delphine', 'consultation enregistrement pour le nom : toto', '127.0.0.1', '', '2010-05-22', '160517');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(86, 'Bob', 'Ajout enregistrement : 10.0.0.1 - srv_domain', '127.0.0.1', 'srv_domain', '2010-05-22', '160610');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(87, 'Bob', 'Ajout enregistrement : 10.0.0.2 - srv-tux', '127.0.0.1', 'srv-tux', '2010-05-22', '160624');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(88, 'Bob', 'ip invalide', '127.0.0.1', 'xls', '2010-05-22', '160632');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(89, 'Bob', 'Ajout enregistrement : 10.0.1.15 - xls', '127.0.0.1', 'xls', '2010-05-22', '160639');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(90, 'Bob', 'consultation enregistrements pour l''ip : 10.0.0.2', '127.0.0.1', '', '2010-05-22', '160701');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(91, 'Bob', 'consultation enregistrements pour l''ip : 10.0.0.2', '127.0.0.1', '', '2010-05-22', '160717');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(92, 'Bob', 'Consultation d''une mauvaise ip : sssss', '127.0.0.1', '', '2010-05-22', '161314');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(93, 'Bob', 'Consultation d''une mauvaise ip : %', '127.0.0.1', '', '2010-05-22', '161319');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(94, 'Bob', 'consultation enregistrements pour l''ip : 10.0.0.1', '127.0.0.1', '', '2010-05-22', '161325');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(95, 'Bob', 'Consultation d''une mauvaise ip : fqsdfqsdf', '127.0.0.1', '', '2010-05-22', '161537');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(96, 'Bob', 'Consultation d''une mauvaise ip : %', '127.0.0.1', '', '2010-05-22', '161543');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(97, 'Bob', 'consultation enregistrements pour le nom : 45465. Pas de rÃ©sultat.', '127.0.0.1', '', '2010-05-22', '161547');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(98, 'Bob', 'Ajout enregistrement : 255.255.255.255 - Broadcast', '127.0.0.1', 'Broadcast', '2010-05-22', '161637');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(99, 'Bob', 'consultation enregistrements pour l''ip : 255.255.255.255', '127.0.0.1', '', '2010-05-22', '161644');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(100, '', 'Suppression de l''enregistrement Broadcast effectuÃ©e avec succÃ¨s.', '127.0.0.1', '', '2010-05-22', '161646');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(101, 'Bob', 'consultation du journal', '127.0.0.1', '', '2010-05-22', '161650');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(102, 'toto', 'Ajout enregistrement : 10.3.2.1 - dudule', '192.168.0.3', 'dudule', '2010-05-22', '162119');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(103, 'toto', 'Ajout enregistrement : 255.255.255.255 - Broadcast2', '192.168.0.3', 'Broadcast2', '2010-05-22', '162143');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(104, 'toto', 'consultation enregistrements pour l''ip : 255.255.255.255', '192.168.0.3', '', '2010-05-22', '162150');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(105, '', 'Suppression de l''enregistrement Broadcast2 effectuÃ©e avec succÃ¨s.', '192.168.0.3', '', '2010-05-22', '162152');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(106, 'toto', 'consultation enregistrements pour l''ip : 10.3.2.1', '192.168.0.3', '', '2010-05-22', '162201');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(107, 'toto', 'consultation du journal', '192.168.0.3', '', '2010-05-22', '162203');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(108, 'toto', 'consultation du journal des connexions', '192.168.0.3', '', '2010-05-22', '162215');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(109, 'toto', 'Ajout de Aline avec succÃ¨s.', '192.168.0.3', '', '2010-05-22', '162243');
INSERT INTO `gd_journal` (`id`, `utilisateur`, `action`, `ip`, `nom`, `date`, `HHmmss`) VALUES(110, 'toto', 'Suppression de Aline.', '192.168.0.3', '', '2010-05-22', '162247');

