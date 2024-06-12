<?php
function gerar_corpo_email_entrega_doacao(
   $nome_instituicao,
   $endereco_instituicao,
   $data,
   $horario,
   $json_itens
) {
   $corpo = "
      Olá, <br> <br>
      Sua entrega entrega de doação para <b>$nome_instituicao</b> foi agendada para: <br>
      Dia: <b>$data</b> <br>
      Horario: <b>$horario</b> <br>
      No endereço: <b>$endereco_instituicao</b> <br>
      <br>
      <table style='text-align: center;'>
         <thead>
            <tr>
               <th scope='col'>Item</th>
               <th scope='col' style='width: 100px;'></th>
               <th scope='col'>Quantidade</th>
            </tr>
         </thead>
         <tbody>
   ";

   $itens = json_decode($json_itens, true);
   foreach ($itens as $item => $quantidade) {
      $corpo .= "
         <tr>
            <td scope='row'>$item</td>
            <td></td>
            <td>$quantidade</td>
         </tr>
      ";
   }

   $corpo .= "
         </tbody>
      </table>
      <br>
      Atenciosamente, <br>
      Equipe Doar para Nutrir
   ";

   return $corpo;
}
