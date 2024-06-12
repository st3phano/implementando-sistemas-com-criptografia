<?php
$key_aes = $_POST["key_aes"];
$iv_aes = $_POST["iv_aes"];
// echo json_encode($key_aes);
// echo json_encode($iv_aes);

$chave_privada = file_get_contents("rsa_2048_priv.pem");
$chave_privada_openssl = openssl_pkey_get_private($chave_privada);

openssl_private_decrypt(
   base64_decode($key_aes),
   $key_aes,
   $chave_privada_openssl
);
$key_aes = hex2bin($key_aes);

openssl_private_decrypt(
   base64_decode($iv_aes),
   $iv_aes,
   $chave_privada_openssl
);
$iv_aes = hex2bin($iv_aes);

$criptografado_no_php = openssl_encrypt(
   $key_aes . $iv_aes,
   "aes-256-cbc",
   $key_aes,
   0,
   $iv_aes
);
echo json_encode($criptografado_no_php);
