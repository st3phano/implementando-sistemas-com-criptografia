<?php
include_once "func/gerir_sessao.php";

if (iniciar_sessao() && session_unset() && session_destroy()) {
   echo json_encode(1);
} else {
   echo json_encode(0);
}
