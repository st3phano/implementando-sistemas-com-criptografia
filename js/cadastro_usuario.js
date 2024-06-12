window.onload = async function () {
   window_on_load_generico();
   await definir_aes();
}

async function cadastrar_usuario() {
   const form_cadastro_usuario = document.getElementById("form_cadastro_usuario");
   const form_data = new FormData(form_cadastro_usuario);

   if (!validar_regex_cadastro(form_data)) {
      return;
   }

   exibir_modal(
      `<h5 aria-busy="true">
         Só um instante,<br>
         estamos finalizando seu cadastro...
      </h5>`,
      false
   );

   const cadastro_efetuado = await enviar_post(form_data, "../php/cadastrar_usuario.php");

   fechar_modal();

   if (cadastro_efetuado) {
      exibir_modal_ok("Enviamos um código para o endereço de e-mail digitado.",
         "location.href = '../html/autenticacao_usuario.html'");
   }
   else {
      exibir_modal_ok("Falha ao efetuar o cadastro.");
   }
}

function validar_regex_cadastro(form_data) {
   let regex_valido = true;

   const nome = form_data.get("nome")
   const regex_nome = /^[0-9A-Za-z]{1,32}$/;
   if (!regex_nome.test(nome)) {
      exibir_mensagem_erro_input("nome", "nome_invalido");
      regex_valido = false;
   }
   else {
      exibir_mensagem_erro_input("nome", "nome_invalido", false);
   }

   const cnpj = form_data.get("cnpj").replace(/[^0-9]/g, "");
   const regex_cnpj = /^[0-9]{14}$/;
   if (!regex_cnpj.test(cnpj)) {
      exibir_mensagem_erro_input("cnpj", "cnpj_invalido");
      regex_valido = false;
   }
   else {
      exibir_mensagem_erro_input("cnpj", "cnpj_invalido", false);
      form_data.set("cnpj", cnpj);
   }

   const telefone = form_data.get("telefone").replace(/[^0-9]/g, "");
   const regex_telefone = /^[0-9]{11}$/;
   if (!regex_telefone.test(telefone)) {
      exibir_mensagem_erro_input("telefone", "telefone_invalido");
      regex_valido = false;
   }
   else {
      exibir_mensagem_erro_input("telefone", "telefone_invalido", false);
      form_data.set("telefone", telefone);
   }

   const email = form_data.get("email");
   if (!validar_regex_email(email)) {
      exibir_mensagem_erro_input("email", "email_invalido");
      regex_valido = false;
   }
   else {
      exibir_mensagem_erro_input("email", "email_invalido", false);
   }

   return regex_valido;
}
