<?php
include_once "func/gerir_sessao.php";
if (!validar_sessao()) {
   echo json_encode(0);
   return;
}

echo json_encode('
<h3>
   Doação de <ins id="valor_doacao">R$ </ins> via PIX
   <hr>
</h3>

<article>
   <img src="../img/qrcode.png">
</article>

<article open class="container-fluid">
   <header>Código:</header>
   00020126580014br.gov.bcb.pix0136c88b338d-d3e1-4983-8937-6fdfee1bb2655204000053039865802BR5925DOARPARANUTRIR6008CURITIBA62240520DoarParaNutrirDoacao6304C87E
</article>

<hr>

<a href="inicio.html">
   <button>
      Retornar para página inicial
   </button>
</a>
');
