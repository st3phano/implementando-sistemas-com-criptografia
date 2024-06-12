DELIMITER $$
CREATE DEFINER=`root`@`localhost`
PROCEDURE `validar_credenciais`
(IN `email_digitado` VARCHAR(128), IN `hash_senha_digitada` CHAR(64))
BEGIN
   UPDATE usuario
   SET otp_sms = gerar_otp_sms(),
       otp_sms_gerado_em = CURRENT_TIMESTAMP,
       tentativas_otp = 0
   WHERE hash_senha IS NOT NULL
         AND email = email_digitado
         AND hash_senha = hash_senha_digitada;

   IF ROW_COUNT() = 1 THEN
      SELECT telefone, otp_sms
      FROM usuario
      WHERE email = email_digitado;
   ELSE
      SELECT 0;
   END IF;
END $$
DELIMITER ;
