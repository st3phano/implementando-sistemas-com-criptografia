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

   $endereco_instituicao = mysqli_fetch_assoc(
      mysqli_execute_query(
         $conexao_mysql,
         "SELECT endereco
          FROM dados_instituicao
          WHERE nome = ?;",
         [$nome_instituicao]
      )
   );
} catch (mysqli_sql_exception $e) {
   include_once "data/debug.php";
   if (DEBUG) {
      print_r($e);
   }

   responder_post(0);
   return;
}

responder_post($endereco_instituicao);
