DELIMITER $$
CREATE DEFINER=`root`@`localhost`
PROCEDURE `cadastrar_usuario`
(IN `nome_digitado` VARCHAR(32), IN `cnpj_digitado` CHAR(14),
 IN `telefone_digitado` CHAR(11), IN `email_digitado` VARCHAR(128),
 IN `codigo_email_gerado` CHAR(32))
BEGIN
   INSERT INTO usuario
   (nome, cnpj, telefone,
    email, codigo_email)
   VALUES
   (nome_digitado, cnpj_digitado, telefone_digitado,
    email_digitado, codigo_email_gerado);

   SELECT ROW_COUNT();
END $$
DELIMITER ;
