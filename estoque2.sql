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
(1, 'FarmÃ¡cia', '517', 3459, '0001'),
(2, 'Mercado', '123', 123, '123'),
(3, 'Loja', '654', 654, '654'),
(4, 'Distribuidora', '513 cj 15', 88888, '00222'),
(5, 'Ponto frio', '513', 5555, '000'),
(6, 'Shoping Sul', '21312', 1312312, '0025'),
(7, 'Americanas', 'qr 100', 989898, '011151510000');

-- --------------------------------------------------------

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cod` int(30) DEFAULT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `price` float NOT NULL,
  `quantity` float NOT NULL,
  `min_quantity` float NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `products`
--

INSERT INTO `products` (`id`, `cod`, `name`, `price`, `quantity`, `min_quantity`) VALUES
(1, 56464646, 'Produto de Teste', 15, 10, 12),
(2, 123456, 'Produto legal', 100, 7, 2);

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
   PRIMARY KEY (`id`)
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


CREATE TABLE `lote` (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    data_lote DATE,
    PRIMARY KEY(id),
    id_products INT UNSIGNED NOT NULL,
    INDEX indice_id_produto (id_products),
    CONSTRAINT fk_id_products
    FOREIGN KEY (id_products)
    REFERENCES products(id)
);

