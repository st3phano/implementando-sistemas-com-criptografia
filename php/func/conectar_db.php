<?php
function conectar_db()
{
   include __DIR__ . "/../data/dir.php";
   include "$dir/db";

   return $conexao;
}
