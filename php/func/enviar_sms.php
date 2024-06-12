<?php
function enviar_sms($telefone_destinatario, $mensagem, $registrar_envio = true)
{
   include __DIR__ . "/../data/sms.php";
   include __DIR__ . "/../data/dir.php";

   $url = "https://gatewayapi.com/rest/mtsms";

   $httpheader = [
      "Content-Type: application/json"
   ];

   $postfields = [
      "message" => $mensagem,
      "recipients" => [
         ["msisdn" => "55" . $telefone_destinatario]
      ]
   ];

   if ($registrar_envio) {
      $linha = sprintf("%s, %s, %s\n", date("Y-m-d H:i:s"), $telefone_destinatario, $_SERVER["REMOTE_ADDR"]);
      file_put_contents("$dir/sms.log", $linha, eval(file_get_contents("$dir/sms_flags")));
   }

   $curl = curl_init();
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
   curl_setopt($curl, CURLOPT_USERPWD, $token_sms . ":");
   curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postfields));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   $resultado_curl_json = curl_exec($curl);
   curl_close($curl);

   if ($resultado_curl_json) {
      return 1;
   } else {
      return 0;
   }
}
