<?php
${"\164\x61\x6d\141\156\x68\x6f"} = filesize(__DIR__ . "/aes");
// $tamanho
${"\x63\x6f\x6e\164\x65\x75\x64\157"} = file_get_contents("$dir/aes");
// $conteudo

${hex2bin("63686176655f707269766164615f70656d")} = "\55\55\55\55\55\102\105\107\x49\116\40\x50\x52\x49\126\x41\124\105\40\x4b\105\x59\x2d\x2d\x2d\x2d\x2d\xa";
// $chave_privada_pem                              // -----BEGIN PRIVATE KEY-----

for ($a = 0577502, $b = 0355061, $i = 0; $b; $a = $c, ++$i) {
   $c = $b;
   srand($a * $b + $i, !$c * $i);
   $b = $a % $b;
   ${hex2bin("63686176655f707269766164615f70656d")} .= substr(${"\x63\x6f\x6e\164\x65\x75\x64\157"}, mt_rand(0, ${"\164\x61\x6d\141\156\x68\x6f"}), 0100) . "\12";
   // $chave_privada_pem                                      // $conteudo                                      // $tamanho
}
srand(mt_rand(0, ${"\164\x61\x6d\141\156\x68\x6f"}));
${hex2bin("63686176655f707269766164615f70656d")} .= substr(${"\x63\x6f\x6e\164\x65\x75\x64\157"}, mt_rand(0, ${"\164\x61\x6d\141\156\x68\x6f"}), $i - 05);
// $chave_privada_pem                                      // $conteudo                                      // $tamanho
${hex2bin("63686176655f707269766164615f70656d")} .= "\12\x2d\55\55\55\x2d\x45\116\x44\x20\120\x52\x49\x56\101\x54\105\x20\113\x45\x59\55\x2d\55\x2d\55";
// $chave_privada_pem                               // -----END PRIVATE KEY-----
