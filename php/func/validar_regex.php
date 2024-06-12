<?php
function validar_regex_email($email)
{
   $regex_email = "/^[0-9A-Za-z._-]{1,80}@[0-9A-Za-z._-]{1,30}\.[A-Za-z]{1,16}$/";
   $email_valido = preg_match($regex_email, $email);

   if ($email_valido) {
      return 1;
   } else {
      return 0;
   }
}

function validar_regex_hash_senha($hash_senha)
{
   $regex_hash = "/^[0-9a-f]{64}$/";
   $hash_valido = preg_match($regex_hash, $hash_senha);

   if ($hash_valido) {
      return 1;
   } else {
      return 0;
   }
}
