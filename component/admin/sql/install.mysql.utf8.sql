DROP TABLE IF EXISTS `#__scoutorg_branches`;
CREATE TABLE `#__scoutorg_branches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS '#__scoutorg_branchtroops'
CREATE TABLE `#__scoutorg_branchtroops` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `branch_source` VARCHAR(45) NOT NULL,
  `branch_id` VARCHAR(45) NOT NULL,
  `troop_source` VARCHAR(45) NOT NULL,
  `troop_id` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_customlistmembers`;
CREATE TABLE `#__scoutorg_customlistmembers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customlist_source` varchar(45) NOT NULL,
  `customlist_id` varchar(45) NOT NULL,
  `member_source` varchar(45) NOT NULL,
  `member_id` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_customlists`;
CREATE TABLE `#__scoutorg_customlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `description` text,
  `parent_source` varchar(45) NOT NULL,
  `parent_id` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_groupmemberroles`;
CREATE TABLE `#__scoutorg_groupmemberroles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_source` varchar(45) NOT NULL
  `member_id` varchar(45) NOT NULL,
  `role_source` varchar(45) NOT NULL,
  `role_id` varchar(45) NOT NULL,
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
  `patrolmember_source` varchar(45) NOT NULL,
  `patrolmember_id` varchar(45) NOT NULL,
  `role_source` varchar(45) NOT NULL,
  `role_id` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_patrolmembers`;
CREATE TABLE `#__scoutorg_patrolmembers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patrol_source` varchar(45) NOT NULL,
  `patrol_id` varchar(45) NOT NULL,
  `member_source` varchar(45) NOT NULL,
  `member_id` varchar(45) NOT NULL,
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
  `troop_source` varchar(45) NOT NULL,
  `troop_id` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_troopmemberroles`;
CREATE TABLE `#__scoutorg_troopmemberroles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `troopmember_source` varchar(45) NOT NULL,
  `troopmember_id` varchar(11) NOT NULL,
  `role_source` varchar(45) NOT NULL,
  `role_id` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `#__scoutorg_troopmembers`;
CREATE TABLE `#__scoutorg_troopmembers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `troop_source` varchar(45) NOT NULL,
  `troop_id` varchar(45) NOT NULL,
  `member_source` varchar(45) NOT NULL,
  `member_id` varchar(45) NOT NULL,
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

INSERT INTO `#__scoutorg_branches` (`name`)
VALUES ('Spårare'), ('Upptäckare'), ('Äventyrare'), ('Utmanare');
