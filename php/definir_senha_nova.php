<?php
include_once "func/receber_post.php";
include_once "func/responder_post.php";
$post = receber_post();


$codigo_email = $post["codigo_email"];
$regex_codigo_email = "/^[0-9A-F]{32}$/";
if (!preg_match($regex_codigo_email, $codigo_email)) {
   responder_post(0);
   return;
}

$hash_senha = $post["senha"];
include_once "func/validar_regex.php";
if (!validar_regex_hash_senha($hash_senha)) {
   responder_post(0);
   return;
}


try {
   include_once "func/conectar_db.php";
   $conexao_mysql = conectar_db();

   $hash_senha_alterado = mysqli_fetch_column(
      mysqli_query(
         $conexao_mysql,
         "CALL alterar_hash_senha('$codigo_email', '$hash_senha');"
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

if ($hash_senha_alterado) {
   responder_post(1);
} else {
   responder_post(0);
}
