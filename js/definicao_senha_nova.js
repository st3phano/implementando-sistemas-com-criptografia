window.onload = async function () {
   window_on_load_generico();
   await definir_aes();

   preencher_input_com_url("codigo_email");
}

async function definir_senha_nova() {
   const form_definicao_senha_nova = document.getElementById("form_definicao_senha_nova");
   const form_data = new FormData(form_definicao_senha_nova)

   if (!validar_regex_definir_senha_nova(form_data)) {
      return;
   }

   hashing_senhas(form_data, ["senha", "confirmar_senha"]);

   const senha_definida = await enviar_post(form_data, "../php/definir_senha_nova.php");
   if (senha_definida) {
      exibir_mensagem_erro_input("codigo_email", "codigo_email_incorreto", false);
      exibir_modal_ok("Senha definida com sucesso.",
         "location.href = '../html/autenticacao_usuario.html'");
   }
   else {
      exibir_mensagem_erro_input("codigo_email", "codigo_email_incorreto");
   }
}

function validar_regex_definir_senha_nova(form_data) {
   let regex_valido = true;

   const codigo_email = form_data.get("codigo_email")
   const regex_codigo_email = /^[0-9A-F]{32}$/;
   if (!regex_codigo_email.test(codigo_email)) {
      exibir_mensagem_erro_input("codigo_email", "codigo_email_incorreto");
      regex_valido = false;
   }
   else {
      exibir_mensagem_erro_input("codigo_email", "codigo_email_incorreto", false);
   }

   if (!validar_regex_senha(form_data.get("senha"))) {
      exibir_mensagem_erro_input("senha", "senha_fraca");
      regex_valido = false;
   }
   else {
      exibir_mensagem_erro_input("senha", "senha_fraca", false);
   }

   if (form_data.get("senha") !== form_data.get("confirmar_senha")) {
      exibir_mensagem_erro_input("confirmar_senha", "senha_diferente");
      regex_valido = false;
   }
   else {
      exibir_mensagem_erro_input("confirmar_senha", "senha_diferente", false);
   }

   return regex_valido;
}
