<?php
$criptografado_no_js = $_POST["criptografado_no_js"];
// echo $criptografado_no_js;

// $chave_privada = file_get_contents("rsa_2048_priv.pem");
$chave_privada_openssl = openssl_pkey_get_private("file://./rsa_2048_priv.pem");

openssl_private_decrypt(
   base64_decode($criptografado_no_js),
   $descriptografado_no_php,
   $chave_privada_openssl
);

echo json_encode($descriptografado_no_php);
