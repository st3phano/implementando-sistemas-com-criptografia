window.onload = async function () {
   window_on_load_generico();
   await definir_aes();

   const nome_instituicao_escolhida = sessionStorage.getItem("nome_instituicao_escolhida");
   preencher_descricao(nome_instituicao_escolhida);
   preencher_tabela_itens(nome_instituicao_escolhida);
}

async function preencher_descricao(nome_instituicao) {
   let form_data = new FormData();
   form_data.append("nome_instituicao", nome_instituicao);

   const descricao_instituicao = await enviar_post(form_data, "../php/carregar_descricao_instituicao.php");
   if (!descricao_instituicao) {
      redirecionar_falha_sessao();
      return;
   }

   document.getElementById("nome_instituicao").innerHTML = `${nome_instituicao} <hr>`;

   let descricao_longa = document.getElementById("descricao_longa_instituicao");
   descricao_longa.innerHTML = `${descricao_instituicao.descricao_longa} <br>`;

   if (descricao_instituicao.telefone) {
      descricao_longa.innerHTML += `<br><i>Telefone:</i> ${descricao_instituicao.telefone}`;
   }
   descricao_longa.innerHTML += `<br><i>E-mail:</i> ${descricao_instituicao.email}`;
}

async function preencher_tabela_itens(nome_instituicao) {
   let form_data = new FormData();
   form_data.append("nome_instituicao", nome_instituicao);

   const lista_itens = await enviar_post(form_data, "../php/listar_itens_instituicao.php");
   if (!lista_itens) {
      redirecionar_falha_sessao();
      return;
   }

   for (let i = 0; i < lista_itens.length; ++i) {
      const item = lista_itens[i];

      document.getElementById("tabela_itens_instituicao")
         .innerHTML +=
         `<tr>
            <th scope="row">${item.nome_item}</th>
            <td class="mobile">${item.valor}</td>
            <td>
               <input type="range" min="0" max="${item.quantidade}" value="0" data-tooltip="0"
                  name="${item.nome_item}" id="range_item_${i}">
            </td>
            <td id="valor_total_item_${i}">0.00</td>
         </tr>`;
   }

   for (let i = 0; i < lista_itens.length; ++i) {
      sincronizar_range_com_valor_total_item(i, lista_itens[i].valor);
      sincronizar_range_com_valor_total_tabela(i, lista_itens);
   }
}

function sincronizar_range_com_valor_total_item(i_item, valor_item) {
   document.getElementById(`range_item_${i_item}`).oninput = function () {
      this.setAttribute("data-tooltip", this.value);

      const valor_total_item = valor_item * this.value;
      document.getElementById(`valor_total_item_${i_item}`).innerHTML = valor_total_item.toFixed(2);
   };
}

function sincronizar_range_com_valor_total_tabela(i_item, lista_itens) {
   document.getElementById(`range_item_${i_item}`).onchange = function () {
      let valor_total_tabela = 0;

      for (let i = 0; i < lista_itens.length; ++i) {
         const valor_total_item = parseFloat(document.getElementById(`valor_total_item_${i}`).innerHTML);
         valor_total_tabela += valor_total_item;
      }

      document.getElementById("valor_total_tabela").innerHTML = valor_total_tabela.toFixed(2);
   };
}

async function registrar_doacao_valor() {
   const nome_instituicao = sessionStorage.getItem("nome_instituicao_escolhida");
   const json_itens_selecionados = gerar_json_itens_selecionados();

   if (!json_valido(json_itens_selecionados)) {
      exibir_modal_ok("Por favor, selecione ao menos um item.");
      return;
   }

   let form_data = new FormData();
   form_data.append("nome_instituicao", nome_instituicao);
   form_data.append("json_itens", json_itens_selecionados);

   exibir_modal(
      `<h5 aria-busy="true">
         Registrando doação...
      </h5>`,
      false
   );

   const doacao_registrada = await enviar_post(form_data, "../php/registrar_doacao_valor.php");

   fechar_modal();

   if (doacao_registrada) {
      const valor_doacao = document.getElementById("valor_total_tabela").innerHTML;
      sessionStorage.setItem("valor_doacao", valor_doacao);
      location.href = "../html/envio_valor.html";
   }
   else {
      exibir_modal_ok("Por favor, selecione ao menos um item.");
   }
}

function iniciar_doacao_itens() {
   const json_itens_selecionados = gerar_json_itens_selecionados();

   if (!json_valido(json_itens_selecionados)) {
      exibir_modal_ok("Por favor, selecione ao menos um item.");
   }
   else {
      sessionStorage.setItem("json_itens_doacao", json_itens_selecionados);
      location.href = "../html/agendamento_entrega.html";
   }
}

function gerar_json_itens_selecionados() {
   const form_data = new FormData(document.getElementById("form_itens_selecionados"));

   let itens_selecionados = {};
   for (const [item, quantidade] of form_data) {
      if (quantidade > 0) {
         itens_selecionados[item] = quantidade;
      }
   }

   return JSON.stringify(itens_selecionados);
}

function json_valido(json_string) {
   const TAMANHO_MENOR_JSON = 9;
   if (json_string.length < TAMANHO_MENOR_JSON) {
      return false;
   }

   return true;
}
