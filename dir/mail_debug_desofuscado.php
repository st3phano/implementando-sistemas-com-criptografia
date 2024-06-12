<?php
$conteudo_arquivo = file_get_contents(__DIR__ . "/mail");

for ($a = 3571, $i = 0, $b = 2207; $b; $a = $c, ++$i) {
   $c = $b;
   $senha_gmail[$i] = $conteudo_arquivo[$a - $b];
   $b = $a % $b;
}
