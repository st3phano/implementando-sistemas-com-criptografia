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

$hash_senha = $post["senha"];
if (!validar_regex_hash_senha($hash_senha)) {
   responder_post(0);
   return;
}


try {
   include_once "func/conectar_db.php";
   $conexao_mysql = conectar_db();

   $telefone_otp = mysqli_fetch_row(
      mysqli_query(
         $conexao_mysql,
         "CALL validar_credenciais('$email', '$hash_senha');"
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

if ($telefone_otp[0] == 0) {
   responder_post(0);
   return;
}

$telefone = $telefone_otp[0];
$otp = $telefone_otp[1];

$mensagem = "Codigo Doar para Nutrir: $otp";

include_once "func/enviar_sms.php";
$sms_enviado = enviar_sms($telefone, $mensagem);
if ($sms_enviado) {
   responder_post(1);
} else {
   responder_post(0);
}
