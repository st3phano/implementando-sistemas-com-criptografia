<?php
$criptografado_no_js = $_POST["criptografado_no_js"];
// echo $criptografado_no_js . "\n";

$key = "tamanho_de_32_bytes_para_aes_256";
$iv = "tamanho_16_bytes";

// Por padrão em openssl_decrypt():
// - Recebe uma string codificada em base 64,
// especificando OPENSSL_RAW_DATA em $options recebe a string sem codificação.
// - Utiliza a técnica de padding PKCS7,
// especificando OPENSSL_ZERO_PADDING em $options não utiliza padding.
$descriptografado_no_php = openssl_decrypt($criptografado_no_js, "aes-256-cbc", $key, 0, $iv);
// CBC (Cipher Block Chaining): IV influencia no resultado do primeiro bloco,
// em seguida cada bloco encriptado influencia no resultado do próximo bloco

// echo $descriptografado_no_php . "\n";

$key = "trocando_so_para_variar_um_pouco";
$iv = "so_16_bytes_aqui";

$mensagem = $descriptografado_no_php . ", retornando do php para o javascript";
$criptografado_no_php = openssl_encrypt($mensagem, "aes-256-cbc", $key, 0, $iv);
echo json_encode($criptografado_no_php);
