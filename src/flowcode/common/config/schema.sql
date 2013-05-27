SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE `item_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `id_father` int(11) DEFAULT NULL,
  `id_page` bigint(20) DEFAULT NULL,
  `linkurl` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL,
  `linktarget` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `menu_item_menu` (
  `id_menu` int(11) NOT NULL,
  `id_item_menu` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `page` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `permalink` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `name` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `description` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `htmlcontent` text COLLATE latin1_spanish_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `type` int(3) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  KEY `permalink` (`permalink`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

CREATE TABLE IF NOT EXISTS `post` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `permalink` varchar(300) COLLATE latin1_spanish_ci DEFAULT NULL,
  `title` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `description` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `body` text COLLATE latin1_spanish_ci NOT NULL,
  `intro` text COLLATE latin1_spanish_ci NOT NULL,
  `type` char(1) COLLATE latin1_spanish_ci NOT NULL,
  `date` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

CREATE TABLE IF NOT EXISTS `post_tag` (
  `id_tag` bigint(20) NOT NULL,
  `id_post` bigint(20) NOT NULL,
  PRIMARY KEY (`id_tag`,`id_post`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

CREATE TABLE IF NOT EXISTS `tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `password` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `role` varchar(255) COLLATE latin1_spanish_ci NOT NULL DEFAULT 'user',
  `mail` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `name` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

CREATE  TABLE `role` (
  `id` BIGINT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE  TABLE `permission` (
  `id` BIGINT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE  TABLE `user_role` (
  `id_user` BIGINT NOT NULL ,
  `id_role` BIGINT NOT NULL ,
  PRIMARY KEY (`id_user`, `id_role`) )
ENGINE = InnoDB;

CREATE  TABLE `role_permission` (
  `id_role` BIGINT NOT NULL ,
  `id_permission` BIGINT NOT NULL ,
  PRIMARY KEY (`id_role`, `id_permission`) )
ENGINE = InnoDB;


