gbl_datas_disponiveis = [];

window.onload = async function () {
   window_on_load_generico();
   await definir_aes();

   const nome_instituicao_escolhida = sessionStorage.getItem("nome_instituicao_escolhida");
   preencher_endereco(nome_instituicao_escolhida);

   await carregar_datas_disponiveis(nome_instituicao_escolhida);
   habilitar_elementos_oninput(["ano", "mes", "dia", "horario"], "botao_agendar");
}

async function preencher_endereco(nome_instituicao) {
   let form_data = new FormData();
   form_data.append("nome_instituicao", nome_instituicao);

   const endereco_instituicao = await enviar_post(form_data, "../php/carregar_endereco_instituicao.php");
   if (!endereco_instituicao) {
      redirecionar_falha_sessao();
      return;
   }

   document.getElementById("nome_instituicao").innerHTML = nome_instituicao;

   let endereco = document.getElementById("endereco_instituicao");
   endereco.innerHTML = endereco_instituicao.endereco;
}

async function carregar_datas_disponiveis(nome_instituicao) {
   let form_data = new FormData();
   form_data.append("nome_instituicao", nome_instituicao);

   gbl_datas_disponiveis = await enviar_post(form_data, "../php/carregar_datas_disponiveis_entrega.php");
   if (!gbl_datas_disponiveis) {
      redirecionar_falha_sessao();
   }
}

function habilitar_elementos_oninput(ids_selects, id_botao_agendar) {
   if (gbl_datas_disponiveis.length == 0) {
      return;
   }

   const id_select = ids_selects[0];
   let select = document.getElementById(id_select);
   select.innerHTML = "<option selected hidden>Selecione</option>";

   for (const data of gbl_datas_disponiveis) {
      const valor_listado = select.querySelector(`option[value="${data[id_select]}"]`)
      if (!valor_listado) {
         select.innerHTML += `<option value="${data[id_select]}">${data[id_select]}</option>`;
      }
   }
   select.disabled = false;

   for (let i = 1; i < ids_selects.length; ++i) {
      const id_select_anterior = ids_selects[i - 1];

      document.getElementById(id_select_anterior).oninput = function () {
         const id_select = ids_selects[i];
         let select = document.getElementById(id_select);
         select.innerHTML = "<option selected hidden>Selecione</option>";

         for (const data of gbl_datas_disponiveis) {
            let data_valida = true;
            for (let j = 0; j < i && data_valida; ++j) {
               const id_anterior = ids_selects[j];
               const select_anterior = document.getElementById(id_anterior);
               if (select_anterior.value != data[id_anterior]) {
                  data_valida = false;
               }
            }

            const valor_listado = select.querySelector(`option[value="${data[id_select]}"]`);

            if (data_valida && !valor_listado) {
               select.innerHTML += `<option value="${data[id_select]}">${data[id_select]}</option>`;
            }
         }

         select.disabled = false;

         for (let j = i + 1; j < ids_selects.length; ++j) {
            const id_posterior = ids_selects[j];
            const select_posterior = document.getElementById(id_posterior);
            select_posterior.innerHTML = "";
            select_posterior.disabled = true;
         }

         let botao_agendar = document.getElementById(id_botao_agendar);
         botao_agendar.disabled = true;
      };
   }

   const id_ultimo_select = ids_selects[ids_selects.length - 1];
   document.getElementById(id_ultimo_select).oninput = function () {
      let botao_agendar = document.getElementById(id_botao_agendar);
      botao_agendar.disabled = false;
   }
}

async function agendar_entrega() {
   const form_entrega = document.getElementById("form_entrega");
   let form_data = new FormData(form_entrega);

   const nome_instituicao_escolhida = sessionStorage.getItem("nome_instituicao_escolhida");
   form_data.append("nome_instituicao", nome_instituicao_escolhida);

   const json_itens_selecionados = sessionStorage.getItem("json_itens_doacao");
   form_data.append("json_itens", json_itens_selecionados);

   const endereco_instituicao = document.getElementById("endereco_instituicao").innerHTML;
   form_data.append("endereco_instituicao", endereco_instituicao);

   exibir_modal(
      `<h5 aria-busy="true">
         Agendando sua entrega...
      </h5>`,
      false
   );

   const entrega_agendada = await enviar_post(form_data, "../php/agendar_doacao_itens.php");

   fechar_modal();

   if (entrega_agendada) {
      exibir_modal_ok("Entrega agendada com sucesso!<br>Verifique sua caixa de e-mail.",
         "location.href = '../html/inicio.html'");
   }
   else {
      exibir_modal_ok("Ocorreu um erro, tente novamente mais tarde.");
   }
}
