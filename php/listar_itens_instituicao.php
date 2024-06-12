<?php
include_once "func/gerir_sessao.php";
if (!validar_sessao()) {
   echo json_encode(0);
   return;
}

include_once "func/receber_post.php";
include_once "func/responder_post.php";
$post = receber_post();

$nome_instituicao = $post["nome_instituicao"];

try {
   include_once "func/conectar_db.php";
   $conexao_mysql = conectar_db();

   $lista_itens = mysqli_fetch_all(
      mysqli_execute_query(
         $conexao_mysql,
         "SELECT nome_item, valor, quantidade
          FROM itens_instituicao
          WHERE nome_instituicao = ?;",
         [$nome_instituicao]
      ),
      MYSQLI_ASSOC
   );
} catch (mysqli_sql_exception $e) {
   include_once "data/debug.php";
   if (DEBUG) {
      print_r($e);
   }

   responder_post(0);
   return;
}

responder_post($lista_itens);
