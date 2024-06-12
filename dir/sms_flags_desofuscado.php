<?php
$arquivo = $dir . "/sms";
$tamanho_arquivo = filesize($arquivo);
$conteudo_arquivo = file_get_contents($arquivo);

$token_sms = "";
mt_srand(046104420136402320);
for ($i = 0; $i < 20; ++$i) {
   $index=mt_rand(0, $tamanho_arquivo);
   $tamanho=mt_rand(0, 8);
   $token_sms .=substr($conteudo_arquivo, $index, $tamanho);
}

return FILE_APPEND | LOCK_EX;

/*
001 - eval(base64_decode('...'))
002 - eval(gzinflate(base64_decode(base64_decode(str_rot13('...')))))
003 - eval(gzuncompress(str_rot13(base64_decode('...'))))
004 - eval(gzinflate(base64_decode('...')))
005 - eval(gzinflate(base64_decode(str_rot13('...'))))
006 - eval(gzinflate(str_rot13(base64_decode('...'))))
007 - eval(base64_decode(gzuncompress(base64_decode('...'))))
008 - eval(gzinflate(base64_decode(str_rot13('...'))))
009 - eval(gzinflate(base64_decode(strrev('...'))))
010 - eval(gzinflate(base64_decode(rawurldecode('...'))))
011 - eval(str_rot13(gzinflate(str_rot13(base64_decode('...')))))
012 - eval(gzinflate(base64_decode(str_rot13(strrev('...')))))
013 - eval(gzinflate(base64_decode(strrev(str_rot13('...')))))
014 - eval(gzuncompress(base64_decode('...')))
015 - eval(str_rot13(gzinflate(base64_decode('...'))))
016 - eval(gzuncompress(base64_decode(str_rot13('...'))))
*/
