<?php
function enviar_email_codigo($email)
{
   $numero_caracteres_codigo = 32;
   $codigo = strtoupper(
      bin2hex(
         random_bytes($numero_caracteres_codigo / 2)
      )
   );

   include_once __DIR__ . "/enviar_email.php";
   include_once __DIR__ . "/gerar_corpo_email_codigo.php";
   $email_enviado = enviar_email(
      $email,
      "Seu código para definição de senha",
      gerar_corpo_email_codigo($codigo)
   );

   if ($email_enviado) {
      return $codigo;
   } else {
      return 0;
   }
}
