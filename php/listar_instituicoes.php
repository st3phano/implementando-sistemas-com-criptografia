<?php
try {
   include_once "func/conectar_db.php";
   $conexao_mysql = conectar_db();

   $lista_instituicoes = mysqli_fetch_all(
      mysqli_query(
         $conexao_mysql,
         "SELECT nome, descricao_curta
          FROM dados_instituicao;"
      ),
      MYSQLI_ASSOC
   );
} catch (mysqli_sql_exception $e) {
   include_once "data/debug.php";
   if (DEBUG) {
      print_r($e);
   }

   echo json_encode(0);
}

echo json_encode($lista_instituicoes);
