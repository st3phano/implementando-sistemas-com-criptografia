CREATE TABLE `usuario` (
   `id` int unsigned NOT NULL AUTO_INCREMENT,
   `nome` varchar(32) NOT NULL,
   `cnpj` char(14) NOT NULL,
   `telefone` char(11) NOT NULL,
   `email` varchar(128) NOT NULL,
   `codigo_email` char(32) DEFAULT NULL,
   `codigo_email_gerado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   `hash_senha` char(64) DEFAULT NULL,
   `otp_sms` char(4) DEFAULT NULL,
   `otp_sms_gerado_em` timestamp NULL DEFAULT NULL,
   `tentativas_otp` tinyint NOT NULL DEFAULT '0',
   `valor_total_doado` int NOT NULL DEFAULT '0',
   PRIMARY KEY (`id`),
   UNIQUE KEY `CNPJ` (`cnpj`),
   UNIQUE KEY `TELEFONE` (`telefone`),
   UNIQUE KEY `EMAIL` (`email`),
   UNIQUE KEY `CODIGO_EMAIL` (`codigo_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
