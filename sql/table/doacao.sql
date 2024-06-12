CREATE TABLE `doacao` (
   `id` int unsigned NOT NULL AUTO_INCREMENT,
   `id_usuario` int unsigned NOT NULL,
   `id_instituicao` smallint unsigned NOT NULL,
   `data_horario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   `valor_enviado` BOOLEAN NOT NULL DEFAULT FALSE,
   `id_data_entrega` int unsigned DEFAULT NULL,
   PRIMARY KEY (`id`),
   FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
   FOREIGN KEY (`id_instituicao`) REFERENCES `instituicao` (`id`),
   FOREIGN KEY (`id_data_entrega`) REFERENCES `data_entrega` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
