# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.38)
# Database: challenge
# Generation Time: 2015-03-23 20:42:27 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table Tbl_Book
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Tbl_Book`;

CREATE TABLE `Tbl_Book` (
  `id_book` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `author` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_book`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Tbl_Book` WRITE;
/*!40000 ALTER TABLE `Tbl_Book` DISABLE KEYS */;

INSERT INTO `Tbl_Book` (`id_book`, `title`, `author`)
VALUES
	(1,'Steve Jobs','Walter Isaacson'),
	(2,'Radical','David Platt'),
	(3,'Ender\'s Game','Orson Scott Card'),
	(4,'The Hobbits','J.R.R Tolkien'),
	(5,'The Coral Island','R.M Ballantyne'),
	(6,'Harry Potter','J.K Rownling');

/*!40000 ALTER TABLE `Tbl_Book` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table Tbl_Borrow
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Tbl_Borrow`;

CREATE TABLE `Tbl_Borrow` (
  `id_borrow` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `id_book` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_borrow`),
  KEY `id_user` (`id_user`),
  KEY `id_book` (`id_book`),
  CONSTRAINT `tbl_borrow_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `Tbl_User` (`id_user`),
  CONSTRAINT `tbl_borrow_ibfk_2` FOREIGN KEY (`id_book`) REFERENCES `Tbl_Book` (`id_book`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


# Dump of table Tbl_User
# ------------------------------------------------------------

DROP TABLE IF EXISTS `Tbl_User`;

CREATE TABLE `Tbl_User` (
  `id_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(50) NOT NULL DEFAULT '',
  `admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `Tbl_User` WRITE;
/*!40000 ALTER TABLE `Tbl_User` DISABLE KEYS */;

INSERT INTO `Tbl_User` (`id_user`, `name`, `email`, `password`, `admin`)
VALUES
	(1,'Administrateur','admin@infomaniak.com','d033e22ae348aeb5660fc2140aec35850c4da997',1),
	(2,'Utilisateur','info@infomaniak.com','59bd0a3ff43b32849b319e645d4798d8a5d1e889',0);

/*!40000 ALTER TABLE `Tbl_User` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
