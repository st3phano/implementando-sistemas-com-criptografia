<?php
function responder_post($resposta)
{
   include_once __DIR__ . "/gerir_sessao.php";
   iniciar_sessao();

   if (!isset($_SESSION["key_aes"]) || !isset($_SESSION["iv_aes"])) {
      echo json_encode(0);
      return;
   }
   $key_aes = $_SESSION["key_aes"];
   $iv_aes = $_SESSION["iv_aes"];

   include __DIR__ . "/../data/aes.php";
   $resposta_criptografada = openssl_encrypt(json_encode($resposta), $metodo_aes, $key_aes, 0, $iv_aes);

   if (!$resposta_criptografada) {
      echo json_encode(0);
      return;
   }
   echo json_encode($resposta_criptografada);
}
