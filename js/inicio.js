window.onload = function () {
   window_on_load_generico();

   listar_instituicoes();
}

async function listar_instituicoes() {
   const retorno_php = await fetch("../php/listar_instituicoes.php", {
      method: "GET"
   });
   const lista_instituicoes = await retorno_php.json();

   for (const instituicao of lista_instituicoes) {
      document.getElementById("instituicoes")
         .innerHTML +=
         `<article>
            <header>
               ${instituicao.nome}
            </header>
            <p>
               ${instituicao.descricao_curta}
            </p>
            <footer role="button" class="outline" onclick="direcionar_para_doacao('${instituicao.nome}')">
               Fazer uma doação
            </footer>
         </article>`;
   }
}

function direcionar_para_doacao(nome_instituicao_escolhida) {
   sessionStorage.setItem("nome_instituicao_escolhida", nome_instituicao_escolhida);
   location.href = "doacao_instituicao.html";
}
