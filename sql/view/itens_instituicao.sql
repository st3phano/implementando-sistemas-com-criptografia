CREATE OR REPLACE VIEW itens_instituicao AS
SELECT instituicao.nome AS nome_instituicao,
       item.nome AS nome_item,
       item.valor,
       instituicao_item.quantidade
FROM instituicao_item
INNER JOIN item ON instituicao_item.id_item = item.id
INNER JOIN instituicao ON instituicao_item.id_instituicao = instituicao.id;
