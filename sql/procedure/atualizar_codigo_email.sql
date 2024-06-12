DELIMITER $$
CREATE DEFINER=`root`@`localhost`
PROCEDURE `atualizar_codigo_email`
(IN `email_digitado` VARCHAR(128), IN `codigo_email_gerado` CHAR(32))
BEGIN
   UPDATE usuario
   SET codigo_email = codigo_email_gerado,
       codigo_email_gerado_em = CURRENT_TIMESTAMP
   WHERE email = email_digitado;

   SELECT ROW_COUNT();
END $$
DELIMITER ;
