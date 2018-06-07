-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 24/04/2018 às 23:29
-- Versão do servidor: 10.1.28-MariaDB
-- Versão do PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `estoque2`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `status`
--

CREATE TABLE status(
  id_status INT UNSIGNED NOT NULL,
  name_status VARCHAR(50) NOT NULL,
  PRIMARY KEY(id_status)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `status`
--

INSERT INTO `status` (`id_status`, `name_status`) VALUES
(1, "Ativo"),
(2, "Inativo");

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE `categories`(
  id_categories INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name_categories VARCHAR(100) NOT NULL,
  PRIMARY KEY(id_categories),
  `id_status` INT UNSIGNED NOT NULL DEFAULT 1,
    INDEX indice_status(id_status),
    CONSTRAINT fk_status_categories
    FOREIGN KEY(id_status)
    REFERENCES `estoque2`.`status`(id_status)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cod` VARCHAR(40) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `quantity` float NOT NULL,
  `min_quantity` float NOT NULL,
  `id_categories` int UNSIGNED NOT NULL,
   PRIMARY KEY (`id`),
   INDEX indice_categories(id_categories),
   CONSTRAINT fk_categories_products
   FOREIGN KEY(id_categories)
   REFERENCES categories(id_categories),
   `id_status` INT UNSIGNED NOT NULL DEFAULT 1,
    INDEX indice_status(id_status),
    CONSTRAINT fk_status_products
    FOREIGN KEY(id_status)
    REFERENCES status(id_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `products`
--


-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_number` varchar(11) NOT NULL,
  `user_pass` varchar(32) NOT NULL DEFAULT '',
  `user_token` varchar(32) DEFAULT NULL,
   nivel VARCHAR(50) NOT NULL,
   nome VARCHAR(70) NOT NULL,
   PRIMARY KEY (`id`),
   `id_status` INT UNSIGNED NOT NULL DEFAULT 1,
    INDEX indice_status(id_status),
    CONSTRAINT fk_status_users
    FOREIGN KEY(id_status)
    REFERENCES status(id_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `users`
--

INSERT INTO `users` (`id`, `user_number`, `user_pass`, `user_token`, `nivel`, `nome`) VALUES
(1, 123, '202cb962ac59075b964b07152d234b70', '752c1d8eada1593d04abe075b4e8d47a', 'ADM', 'MARCELO PEREIRA'),
(2, 321, 'caf1a3dfb505ffed0d024130f58c5cfa', '4fb650f7ea5f3f8ec43d4aedbba112b5', 'OP', 'DIEGO ARAUJO');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;




CREATE TABLE `estoque2`.`conjunct` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `cod_inventario` INT(10) UNSIGNED NOT NULL,
    `data_conjunct` DATETIME NOT NULL,
    `total_conjunct` INT UNSIGNED NOT NULL,
    PRIMARY KEY(id)    
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `estoque2`.`inventario`(
   `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
   `id_products` int(10) UNSIGNED NOT NULL,
   `cod` VARCHAR(40) NOT NULL,
    `name_products` VARCHAR(50) NOT NULL,
    `quantity` FLOAT NOT NULL,
    `min_quantity` FLOAT NOT NULL,
    `difference` FLOAT NOT NULL,
    PRIMARY KEY(id),
    `id_conjunct` INT(10) UNSIGNED NOT NULL,
    INDEX indice_id_produto (id_conjunct),
    CONSTRAINT fk_id_conjunct
    FOREIGN KEY (id_conjunct)
    REFERENCES `estoque2`.`conjunct`(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;



