CREATE TABLE `data_entrega` (
   `id` int unsigned NOT NULL AUTO_INCREMENT,
   `id_instituicao` smallint unsigned NOT NULL,
   `data` datetime NOT NULL,
   `disponivel` boolean NOT NULL DEFAULT TRUE,
   PRIMARY KEY (`id`),
   UNIQUE (`data`, `id_instituicao`),
   FOREIGN KEY (`id_instituicao`) REFERENCES `instituicao` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
