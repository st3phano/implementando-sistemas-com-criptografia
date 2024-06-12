<?php
$codigo_ofuscado = base64_encode(gzdeflate(''));

echo sha1($codigo_ofuscado) . "\n";

echo $codigo_ofuscado . "\n";

echo sha1($codigo_ofuscado) . $codigo_ofuscado;
