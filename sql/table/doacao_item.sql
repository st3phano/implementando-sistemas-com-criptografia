CREATE TABLE `doacao_item` (
   `id_doacao` int unsigned NOT NULL,
   `id_item` smallint unsigned NOT NULL,
   `valor_item` decimal(7,2) NOT NULL,
   `quantidade` smallint unsigned NOT NULL,
   PRIMARY KEY (`id_doacao`, `id_item`),
   FOREIGN KEY (`id_doacao`) REFERENCES `doacao` (`id`),
   FOREIGN KEY (`id_item`) REFERENCES `item` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
