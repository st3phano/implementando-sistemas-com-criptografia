<?php
function gerar_corpo_email_codigo($codigo)
{
   $url = "http://localhost/html/definicao_senha_nova.html";

   $corpo = "
      Olá, <br>
      <br>
      Utilize o seguinte link para definir sua senha: <br>
      <a href='$url?codigo_email=$codigo'>
         $url?codigo_email=$codigo
      </a> <br>
      <br>
      Caso o link acima não esteja visível, copie o código: <br>
      <b>$codigo</b> <br>
      E cole no campo 'Código' da página: <br>
      <a href='$url'>
         $url
      </a> <br>
      <br>
      Atenciosamente, <br>
      Equipe Doar para Nutrir
   ";

   return $corpo;
}
