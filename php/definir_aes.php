<?php
$chave_privada_pem = file_get_contents("data/chave_privada.pem");

include_once "data/dir.php";
include_once "$dir/aes_debug";

$post_criptografado = base64_decode(
   file_get_contents("php://input")
);
$chave_privada = openssl_pkey_get_private($chave_privada_pem);
openssl_private_decrypt(
   $post_criptografado,
   $post_json_string,
   $chave_privada
);
$post = json_decode($post_json_string, true);

include_once "func/gerir_sessao.php";
iniciar_sessao();

$_SESSION["key_aes"] = hex2bin($post["key_aes"]);;
$_SESSION["iv_aes"] = hex2bin($post["iv_aes"]);;

include_once "func/responder_post.php";
responder_post(1);
