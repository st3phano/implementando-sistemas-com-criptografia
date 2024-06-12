<?php
include_once "func/gerir_sessao.php";

if (validar_sessao()) {
   echo json_encode('<button onclick="encerrar_sessao()" class="secondary">Sair</button>');
} else {
   echo json_encode('<button onclick="location.href=\'autenticacao_usuario.html\'">Entrar</button>');
}
