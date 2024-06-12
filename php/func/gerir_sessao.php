<?php
const DURACAO_SESSAO_SEGUNDOS = 900;

function iniciar_sessao()
{
   if (session_status() == PHP_SESSION_ACTIVE) {
      return true;
   }

   return session_start([
      "cookie_lifetime" => 0,                      // salva na memória e não no disco
      "cookie_httponly" => 1,                      // previne XSS, sem document.cookie
      "cookie_samesite" => "strict",               // previne CSRF
      "gc_maxlifetime" => DURACAO_SESSAO_SEGUNDOS  // previne destruir a sessão antes do ttl
   ]);
}

function validar_sessao()
{
   iniciar_sessao();

   if (!isset($_SESSION["ip"]) || !isset($_SESSION["ttl"])) {
      return 0;
   }

   if ($_SESSION["ip"] != $_SERVER["REMOTE_ADDR"]) {
      return 0;
   }
   if ($_SESSION["ttl"] < time()) {
      session_unset();
      session_destroy();
      return 0;
   }

   return 1;
}
