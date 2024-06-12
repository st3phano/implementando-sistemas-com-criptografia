<?php
function enviar_email_entrega_doacao(
   $email,
   $nome_instituicao,
   $endereco_instituicao,
   $data,
   $horario,
   $json_itens
) {
   include_once __DIR__ . "/enviar_email.php";
   include_once __DIR__ . "/gerar_corpo_email_entrega_doacao.php";
   $email_enviado = enviar_email(
      $email,
      "Entrega de doação agendada",
      gerar_corpo_email_entrega_doacao(
         $nome_instituicao,
         $endereco_instituicao,
         $data,
         $horario,
         $json_itens
      )
   );

   if ($email_enviado) {
      return 1;
   } else {
      return 0;
   }
}
