CREATE TABLE `item` (
   `id` smallint unsigned NOT NULL AUTO_INCREMENT,
   `nome` varchar(128) NOT NULL,
   `valor` decimal(7,2) NOT NULL,
   PRIMARY KEY (`id`),
   UNIQUE KEY `NOME` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
