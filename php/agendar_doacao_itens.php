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

$json_itens = $post["json_itens"];
const TAMANHO_MENOR_JSON = 9;
if (strlen($json_itens) < TAMANHO_MENOR_JSON) {
   responder_post(0);
   return;
}

$ano = $post["ano"];
$mes = $post["mes"];
$dia = $post["dia"];
$horario = $post["horario"];
$data_mysql = "$ano-$mes-$dia $horario";

$email_usuario = $_SESSION["email"];

try {
   include_once "func/conectar_db.php";
   $conexao_mysql = conectar_db();

   $doacao_registrada = mysqli_fetch_column(
      mysqli_query(
         $conexao_mysql,
         "CALL registrar_doacao('$email_usuario', '$nome_instituicao', '$json_itens', '$data_mysql');"
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

if ($doacao_registrada) {
   $endereco_instituicao = $post["endereco_instituicao"];
   $data_email = "$dia/$mes/$ano";

   include_once "func/enviar_email_entrega_doacao.php";
   enviar_email_entrega_doacao(
      $email_usuario,
      $nome_instituicao,
      $endereco_instituicao,
      $data_email,
      $horario,
      $json_itens
   );

   responder_post(1);
} else {
   responder_post(0);
}
