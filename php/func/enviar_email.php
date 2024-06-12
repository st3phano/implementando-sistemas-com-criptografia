<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "PHPMailer691/src/Exception.php";
require_once "PHPMailer691/src/PHPMailer.php";
require_once "PHPMailer691/src/SMTP.php";

function enviar_email($email_destinatario, $assunto, $corpo)
{
   include __DIR__ . "/../data/email.php";
   include __DIR__ . "/../data/dir.php";
   include "$dir/mail_debug";

   $mail = new PHPMailer();
   $mail->Mailer = "smtp";
   $mail->isSMTP();
   $mail->CharSet = "UTF-8";
   $mail->SMTPDebug = 0;
   $mail->SMTPAuth = true;
   $mail->SMTPSecure = "tls";
   $mail->Host = "smtp.gmail.com";
   $mail->Port = 587;
   $mail->Username = $usuario_gmail;
   $mail->Password = $senha_gmail;
   $mail->SetFrom($endereco_gmail, $remetente_gmail);
   $mail->addAddress($email_destinatario);

   $mail->Subject = $assunto;
   $mail->msgHTML($corpo);

   if ($mail->send()) {
      return 1;
   } else {
      return 0;
   }
}
