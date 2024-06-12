DELIMITER $$
CREATE DEFINER=`root`@`localhost`
PROCEDURE `registrar_doacao`
(IN `email_usuario` VARCHAR(128), IN `nome_instituicao` CHAR(128),
 IN `itens` JSON, IN `data_entrega_itens` DATETIME)
BEGIN
   DECLARE id_usuario_doador INT UNSIGNED DEFAULT (SELECT id
                                                   FROM usuario
                                                   WHERE email = email_usuario);

   DECLARE id_instituicao_escolhida SMALLINT UNSIGNED DEFAULT (SELECT id
                                                               FROM instituicao
                                                               WHERE nome = nome_instituicao);

   DECLARE id_data_entrega_itens INT UNSIGNED DEFAULT NULL;

   DECLARE id_doacao_gerado INT UNSIGNED;

   DECLARE nome_itens JSON DEFAULT JSON_KEYS(itens);

   DECLARE i INT DEFAULT 0;
   DECLARE numero_itens INT DEFAULT JSON_LENGTH(itens);
   DECLARE transacao_valida BOOLEAN DEFAULT TRUE;

   DECLARE nome_item VARCHAR(128);
   DECLARE id_item SMALLINT UNSIGNED;
   DECLARE valor_item DECIMAL(7,2);
   DECLARE quantidade_item SMALLINT UNSIGNED;


   START TRANSACTION;

   IF data_entrega_itens IS NOT NULL THEN
      SELECT id INTO id_data_entrega_itens
      FROM data_entrega
      WHERE `data` = data_entrega_itens
         AND id_instituicao = id_instituicao_escolhida;

      UPDATE data_entrega
      SET disponivel = FALSE
      WHERE id = id_data_entrega_itens;
   END IF;

   INSERT INTO doacao
   (id_usuario, id_instituicao)
   VALUES
   (id_usuario_doador, id_instituicao_escolhida);

   SET id_doacao_gerado = LAST_INSERT_ID();

   WHILE i < numero_itens AND transacao_valida DO
      SET nome_item = JSON_UNQUOTE(
         JSON_EXTRACT(nome_itens, CONCAT('$[', i, ']'))
      );

      SELECT item.id, item.valor INTO id_item, valor_item
      FROM instituicao_item
      INNER JOIN item ON instituicao_item.id_item = item.id
      WHERE id_instituicao = id_instituicao_escolhida
         AND item.nome = nome_item;

      SET quantidade_item = JSON_UNQUOTE(
         JSON_EXTRACT(itens, CONCAT('$."', nome_item, '"'))
      );

      INSERT INTO doacao_item
      (id_doacao,
       id_item,
       valor_item,
       quantidade)
      VALUES
      (id_doacao_gerado,
       id_item,
       valor_item,
       quantidade_item);

      IF ROW_COUNT() <> 1 THEN
         SET transacao_valida = FALSE;
      ELSE
         SET i = i + 1;
      END IF;
   END WHILE;

   IF transacao_valida THEN
      COMMIT;
      SELECT 1;
   ELSE
      ROLLBACK;
      SELECT 0;
   END IF;
END $$
DELIMITER ;
