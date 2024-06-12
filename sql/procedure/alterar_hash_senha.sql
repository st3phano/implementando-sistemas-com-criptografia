DELIMITER $$
CREATE DEFINER=`root`@`localhost`
PROCEDURE `alterar_hash_senha`
(IN `codigo_digitado` CHAR(32), IN `hash_senha_digitada` CHAR(64))
BEGIN
   UPDATE usuario
   SET hash_senha = hash_senha_digitada,
       codigo_email = NULL
   WHERE codigo_email = codigo_digitado
         AND TIMESTAMPDIFF(DAY, codigo_email_gerado_em, CURRENT_TIMESTAMP) < 1;

   SELECT ROW_COUNT();
END $$
DELIMITER ;
