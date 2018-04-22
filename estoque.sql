# ************************************************************
# Sequel Pro SQL dump
# Versão 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.6.35)
# Base de Dados: estoque
# Tempo de Geração: 2018-03-10 15:04:25 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump da tabela products
# ------------------------------------------------------------

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cod` int(30) DEFAULT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `price` float NOT NULL,
  `quantity` float NOT NULL,
  `min_quantity` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;

INSERT INTO `products` (`id`, `cod`, `name`, `price`, `quantity`, `min_quantity`)
VALUES
	(1,56464646,'Produto de Teste',150,10,12),
	(2,123456,'Produto legal',100,7,2);

/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;


# Dump da tabela users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_number` int(10) NOT NULL,
  `user_pass` varchar(32) NOT NULL DEFAULT '',
  `user_token` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `user_number`, `user_pass`, `user_token`)
VALUES
	(1,123,'202cb962ac59075b964b07152d234b70','add664d8084dbee732a18470c468d369');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

DROP TABLE IF EXISTS `fornecedores`;
CREATE TABLE `fornecedores` (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  endereco VARCHAR(255) NOT NULL,
  fone INTEGER UNSIGNED NOT NULL,
  cnpj VARCHAR(100) NOT NULL,
  PRIMARY KEY(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*DROP TABLE IF EXISTS `tipo`;
CREATE TABLE tipo (
  idtipo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tipo VARCHAR(255) NULL,
  PRIMARY KEY(idtipo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;*/

