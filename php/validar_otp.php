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

$otp_digitado = $post["otp"];
$regex_otp = "/^[0-9A-F]{4}$/";
if (!preg_match($regex_otp, $otp_digitado)) {
   responder_post(0);
   return;
}


try {
   include_once "func/conectar_db.php";
   $conexao_mysql = conectar_db();

   $otp_valido = mysqli_fetch_column(
      mysqli_query(
         $conexao_mysql,
         "CALL validar_otp('$email', '$otp_digitado');"
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


if ($otp_valido) {
   include_once "func/gerir_sessao.php";
   iniciar_sessao();
   session_regenerate_id(); // previne session fixation attack

   $_SESSION["email"] = $email;
   $_SESSION["ip"] = $_SERVER["REMOTE_ADDR"];
   $_SESSION["ttl"] = time() + DURACAO_SESSAO_SEGUNDOS;

   responder_post(1);
} else {
   responder_post(0);
}
