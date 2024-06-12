CREATE USER IF NOT EXISTS 'php'@'localhost'
IDENTIFIED BY 'h1R>3ENHa)';

GRANT EXECUTE
ON PROCEDURE doar_para_nutrir.cadastrar_usuario
TO 'php'@'localhost';

GRANT EXECUTE
ON PROCEDURE doar_para_nutrir.atualizar_codigo_email
TO 'php'@'localhost';

GRANT EXECUTE
ON PROCEDURE doar_para_nutrir.alterar_hash_senha
TO 'php'@'localhost';

GRANT EXECUTE
ON PROCEDURE doar_para_nutrir.validar_credenciais
TO 'php'@'localhost';

GRANT EXECUTE
ON PROCEDURE doar_para_nutrir.validar_otp
TO 'php'@'localhost';

GRANT SELECT
ON doar_para_nutrir.dados_instituicao
TO 'php'@'localhost';

GRANT SELECT
ON doar_para_nutrir.itens_instituicao
TO 'php'@'localhost';

GRANT EXECUTE
ON PROCEDURE doar_para_nutrir.registrar_doacao
TO 'php'@'localhost';

GRANT SELECT
ON doar_para_nutrir.datas_disponiveis_entrega
TO 'php'@'localhost';
