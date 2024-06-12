<?php
include_once "func/receber_post.php";
include_once "func/responder_post.php";
$post = receber_post();

include_once "func/validar_regex.php";
$email = $post["email"];
if (!validar_regex_email($email)) {
   responder_post(0);
   return;
}


include_once "func/enviar_email_codigo.php";
$codigo_email = enviar_email_codigo($email);
if ($codigo_email == 0) {
   responder_post(0);
   return;
}


try {
   include_once "func/conectar_db.php";
   $conexao_mysql = conectar_db();

   $codigo_email_atualizado = mysqli_fetch_column(
      mysqli_query(
         $conexao_mysql,
         "CALL atualizar_codigo_email('$email', '$codigo_email');"
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

if ($codigo_email_atualizado) {
   responder_post(1);
} else {
   responder_post(0);
}
