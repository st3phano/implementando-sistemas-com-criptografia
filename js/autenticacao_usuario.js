window.onload = async function () {
   window_on_load_generico();
   await definir_aes();
}

async function validar_credenciais() {
   const form_autenticacao_usuario = document.getElementById("form_autenticacao_usuario");
   const form_data = new FormData(form_autenticacao_usuario);

   if (!validar_regex_credenciais(form_data)) {
      return;
   }

   hashing_senhas(form_data, ["senha"]);

   exibir_modal(
      `<h5 aria-busy="true">
         Autenticando...
      </h5>`,
      false
   );

   const credenciais_validas = await enviar_post(form_data, "../php/validar_credenciais.php");

   fechar_modal();

   if (credenciais_validas) {
      exibir_modal_otp("validar_otp()");
   }
   else {
      exibir_modal_ok("Credenciais incorretas.");
   }
}

function validar_regex_credenciais(form_data) {
   let regex_valido = true;

   if (!validar_regex_email(form_data.get("email"))) {
      exibir_mensagem_erro_input("email", "email_invalido");
      regex_valido = false;
   }
   else {
      exibir_mensagem_erro_input("email", "email_invalido", false);
   }

   if (!validar_regex_senha(form_data.get("senha"))) {
      exibir_mensagem_erro_input("senha", "senha_invalida");
      regex_valido = false;
   }
   else {
      exibir_mensagem_erro_input("senha", "senha_invalida", false);
   }

   return regex_valido;
}

function exibir_modal_otp(onclick_autenticar) {
   exibir_modal(
      `<header>
         <h5>
            Digite o código enviado por SMS
         </h5>
      </header>
      <form role="group" onsubmit="event.preventDefault(); ${onclick_autenticar};">
         <input type="text" placeholder="Código" name="otp" id="otp">
         <input type="button" onclick="${onclick_autenticar}" value="Autenticar">
      </form>
   `);
   document.getElementById("otp").focus();
}

async function validar_otp() {
   let form_data = new FormData();
   form_data.append("email", document.getElementById("email").value);
   form_data.append("otp", document.getElementById("otp").value.toUpperCase());

   const otp = form_data.get("otp");
   const regex_otp = /^[0-9A-F]{4}$/;
   if (!regex_otp.test(otp)) {
      exibir_mensagem_erro_otp();
      return;
   }

   const otp_valido = await enviar_post(form_data, "../php/validar_otp.php");
   if (otp_valido) {
      location.href = "../html/inicio.html";
   }
   else {
      exibir_mensagem_erro_otp();
   }
}

function exibir_mensagem_erro_otp() {
   const otp = document.getElementById("otp");
   otp.placeholder = "Código incorreto.";
   otp.value = "";
   otp.setAttribute("aria-invalid", "true");
   otp.focus();
}

async function enviar_email_senha_nova() {
   const form_autenticacao_usuario = document.getElementById("form_autenticacao_usuario");
   const form_data = new FormData(form_autenticacao_usuario);
   form_data.delete("senha");

   if (!validar_regex_email(form_data.get("email"))) {
      exibir_mensagem_erro_input("email", "email_invalido");
      return;
   }
   else {
      exibir_mensagem_erro_input("email", "email_invalido", false);
   }

   exibir_modal(
      `<h5 aria-busy="true">
         Só um instante...
      </h5>`,
      false
   );

   const email_enviado = await enviar_post(form_data, "../php/iniciar_senha_nova.php");

   fechar_modal();

   if (email_enviado) {
      exibir_modal_ok("Enviamos um código para o endereço de e-mail digitado.");
   }
   else {
      exibir_modal_ok("Ocorreu um erro, tente novamente mais tarde.");
   }
}
