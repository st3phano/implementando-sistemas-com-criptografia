CREATE TABLE `instituicao` (
   `id` smallint unsigned NOT NULL AUTO_INCREMENT,
   `nome` varchar(128) NOT NULL,
   `descricao_curta` varchar(512) NOT NULL,
   `descricao_longa` text NOT NULL,
   `email` varchar(128) NOT NULL,
   `endereco` varchar(256) NOT NULL,
   `telefone` char(11) DEFAULT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY `NOME` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
