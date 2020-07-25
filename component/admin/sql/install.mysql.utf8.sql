DROP TABLE IF EXISTS `#__scoutorg_branches`;
CREATE TABLE `#__scoutorg_branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_branchtroops`;
CREATE TABLE `#__scoutorg_branchtroops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch` VARCHAR(64) NOT NULL,
  `troop` VARCHAR(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_customlistmembers`;
CREATE TABLE `#__scoutorg_customlistmembers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customlist` varchar(64) NOT NULL,
  `member` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_customlists`;
CREATE TABLE `#__scoutorg_customlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `description` text,
  `parent` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_groupmemberroles`;
CREATE TABLE `#__scoutorg_groupmemberroles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupmember` varchar(64) NOT NULL,
  `role` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_grouproles`;
CREATE TABLE `#__scoutorg_grouproles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_patrolmemberroles`;
CREATE TABLE `#__scoutorg_patrolmemberroles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patrolmember` varchar(64) NOT NULL,
  `role` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_patrolmembers`;
CREATE TABLE `#__scoutorg_patrolmembers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patrol` varchar(64) NOT NULL,
  `member` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_patrolroles`;
CREATE TABLE `#__scoutorg_patrolroles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_patrols`;
CREATE TABLE `#__scoutorg_patrols` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `troop` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_troopmemberroles`;
CREATE TABLE `#__scoutorg_troopmemberroles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `troopmember` varchar(64) NOT NULL,
  `role` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_troopmembers`;
CREATE TABLE `#__scoutorg_troopmembers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `troop` varchar(64) NOT NULL,
  `member` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_trooproles`;
CREATE TABLE `#__scoutorg_trooproles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_troops`;
CREATE TABLE `#__scoutorg_troops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_userprofilefields`;
CREATE TABLE `#__scoutorg_userprofilefields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `ordering` int(11) NOT NULL,
  `access` int(11) NOT NULL DEFAULT '0',
  `fieldtype` varchar(45) NOT NULL,
  `fieldcode` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `#__scoutorg_branches` (`name`)
VALUES ('Spårare'), ('Upptäckare'), ('Äventyrare'), ('Utmanare');
