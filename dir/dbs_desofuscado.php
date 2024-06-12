<?php
$senha = "0123456789";
mt_srand(023204631024401640);
for ($i = 0; $i < strlen($senha); ++$i) {
   $senha[$i] = chr(mt_rand(32, 126));
}

echo $senha;
