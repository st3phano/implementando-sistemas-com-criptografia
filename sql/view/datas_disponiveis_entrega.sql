CREATE OR REPLACE VIEW datas_disponiveis_entrega AS
SELECT instituicao.nome AS nome_instituicao,
       DATE_FORMAT(data_entrega.data, '%Y') as ano,
       DATE_FORMAT(data_entrega.data, '%m') as mes,
       DATE_FORMAT(data_entrega.data, '%d') as dia,
       DATE_FORMAT(data_entrega.data, '%H:%i') as horario
FROM data_entrega
INNER JOIN instituicao ON data_entrega.id_instituicao = instituicao.id
WHERE data_entrega.disponivel = TRUE;
