DELIMITER $$
CREATE DEFINER=`root`@`localhost`
PROCEDURE `validar_otp`
(IN `email_digitado` VARCHAR(128), IN `otp_digitado` CHAR(4))
BEGIN
   UPDATE usuario
   SET tentativas_otp = tentativas_otp + 1,
       otp_sms = NULL
   WHERE email = email_digitado
         AND otp_sms = otp_digitado
         AND tentativas_otp < 3
         AND TIMESTAMPDIFF(DAY, otp_sms_gerado_em, CURRENT_TIMESTAMP) < 1;

   IF ROW_COUNT() = 1 THEN
      SELECT 1;
   ELSE
      UPDATE usuario
      SET tentativas_otp = tentativas_otp + 1
      WHERE email = email_digitado;

      SELECT 0;
   END IF;
END $$
DELIMITER ;
