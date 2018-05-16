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
-- Estrutura para tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `fone` int(25) UNSIGNED NOT NULL,
  `cnpj` varchar(100) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id`, `nome`, `endereco`, `fone`, `cnpj`) VALUES
(1, 'Farmácia', '517', 3459, '0001'),
(2, 'Mercado', '123', 123, '123'),
(3, 'Loja', '654', 654, '654'),
(4, 'Distribuidora', '513 cj 15', 88888, '00222'),
(5, 'Ponto frio', '513', 5555, '000'),
(6, 'Shoping Sul', '21312', 1312312, '0025'),
(7, 'Americanas', 'qr 100', 989898, '011151510000');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE `categories`(
  id_categories INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cod` int(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `quantity` float NOT NULL,
  `min_quantity` float NOT NULL,
  `id_categories` int(11) UNSIGNED NOT NULL,
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
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_number` int(11) UNSIGNED NOT NULL,
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
(2, 321, 'caf1a3dfb505ffed0d024130f58c5cfa', '4fb650f7ea5f3f8ec43d4aedbba112b5', 'OP', 'HANNA PIMENTA');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;




CREATE TABLE `estoque2`.`conjunct` (
    `id` INT(30) UNSIGNED NOT NULL AUTO_INCREMENT,
    `data_conjunct` DATETIME NOT NULL,
    `total_conjunct` INT NOT NULL,
    PRIMARY KEY(id)    
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `estoque2`.`inventario`(
   `id` INT(30) UNSIGNED NOT NULL AUTO_INCREMENT,
   `cod` INT(30) NOT NULL,
    `name_products` VARCHAR(50) NOT NULL,
    `quantity` FLOAT NOT NULL,
    `min_quantity` FLOAT NOT NULL,
    `difference` FLOAT NOT NULL,
    PRIMARY KEY(id),
    `id_conjunct` INT(30) UNSIGNED NOT NULL,
    INDEX indice_id_produto (id_conjunct),
    CONSTRAINT fk_id_conjunct
    FOREIGN KEY (id_conjunct)
    REFERENCES `estoque2`.`conjunct`(id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;



