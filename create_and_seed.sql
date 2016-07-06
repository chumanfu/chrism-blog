CREATE DATABASE IF NOT EXISTS `CHRISMBLOG`;
USE `CHRISMBLOG`;

CREATE TABLE `POSTS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '',
  `post` mediumblob NOT NULL,
  `createdby` int(11) NOT NULL DEFAULT 0,
  `createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `createdby` (`createdby`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `USERS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emailaddress` varchar(256) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `USERS`
	(`emailaddress`, `password`, `firstname`, `lastname`)
VALUES 
	('christopher.mitchell.79@gmail.com', SHA2('123chrismblog', 64), 'Chris', 'Mitchell');
