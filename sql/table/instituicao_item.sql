CREATE TABLE `instituicao_item` (
   `id_instituicao` smallint unsigned NOT NULL,
   `id_item` smallint unsigned NOT NULL,
   `quantidade` smallint unsigned NOT NULL,
   PRIMARY KEY (`id_instituicao`, `id_item`),
   FOREIGN KEY (`id_instituicao`) REFERENCES `instituicao` (`id`),
   FOREIGN KEY (`id_item`) REFERENCES `item` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
