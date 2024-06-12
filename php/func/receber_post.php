<?php
function receber_post()
{
   include_once __DIR__ . "/gerir_sessao.php";
   iniciar_sessao();

   if (!isset($_SESSION["key_aes"]) || !isset($_SESSION["iv_aes"])) {
      echo json_encode(0);
      exit();
   }
   $key_aes = $_SESSION["key_aes"];
   $iv_aes = $_SESSION["iv_aes"];

   include __DIR__ . "/../data/aes.php";
   $post_criptografado = file_get_contents("php://input");
   $post_descriptografado = openssl_decrypt($post_criptografado, $metodo_aes, $key_aes, 0, $iv_aes);

   if (!$post_descriptografado) {
      echo json_encode(0);
      exit();
   }
   return json_decode($post_descriptografado, true);
}
