window.onload = async function () {
   window_on_load_generico();

   const retorno_php = await fetch("../php/exibir_envio_valor.php", {
      method: "GET"
   });

   const inner_html_main = await retorno_php.json();
   if (!inner_html_main) {
      redirecionar_falha_sessao();
      return;
   }

   document.querySelector("main").innerHTML += inner_html_main;

   const valor_doacao = sessionStorage.getItem("valor_doacao");
   if (valor_doacao) {
      document.getElementById("valor_doacao").innerHTML += valor_doacao;
   }
}
