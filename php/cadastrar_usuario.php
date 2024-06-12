<?php
include_once "func/receber_post.php";
include_once "func/responder_post.php";
$post = receber_post();


$nome = $post["nome"];
$regex_nome = "/^[0-9A-Za-z]{1,32}$/";
if (!preg_match($regex_nome, $nome)) {
   responder_post(0);
   return;
}

$cnpj = $post["cnpj"];
$regex_cnpj = "/^[0-9]{14}$/";
if (!preg_match($regex_cnpj, $cnpj)) {
   responder_post(0);
   return;
}

$telefone = $post["telefone"];
$regex_telefone = "/^[0-9]{11}$/";
if (!preg_match($regex_telefone, $telefone)) {
   responder_post(0);
   return;
}

$email = $post["email"];
include_once "func/validar_regex.php";
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

   $usuario_cadastrado = mysqli_fetch_column(
      mysqli_query(
         $conexao_mysql,
         "CALL cadastrar_usuario('$nome', '$cnpj', '$telefone', '$email', '$codigo_email');"
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

if ($usuario_cadastrado) {
   responder_post(1);
} else {
   responder_post(0);
}
