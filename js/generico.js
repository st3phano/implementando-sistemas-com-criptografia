var gbl_key_aes = null;
var gbl_iv_aes = null;

function window_on_load_generico() {
   preencher_cabecalho();
   preencher_rodape();
}

async function preencher_cabecalho() {
   const retorno_php = await fetch("../php/gerar_botao_sessao.php", {
      method: "GET"
   });
   const botao_sessao = await retorno_php.json();

   document.getElementById("cabecalho")
      .innerHTML =
      `<nav>
         <a id="logomarca" href="inicio.html">
            <img src="../img/logomarca.png">
         </a>
         <ul>
            <li>
               ${botao_sessao}
            </li>
            <details class="dropdown">
               <summary>Menu</summary>
               <ul dir="rtl">
                  <li><a href="cadastro_usuario.html">Cadastrar</a></li>
                  <li><a href="definicao_senha_nova.html">Senha Nova</a></li>
               </ul>
            </details>
         </ul>
      </nav>`;
}

function preencher_rodape() {
   document.getElementById("rodape")
      .innerHTML =
      `<small>
         • Feito com muito amor, carinho e <a href="https://picocss.com" class="secondary">picocss</a> •
         <br>
         • Cadastre sua instituição enviando um e-mail para <a href="mailto:doarparanutrir@gmail.com" class="secondary">doarparanutrir@gmail.com</a> •
      </small>`;
}

function preencher_input_com_url(parametro) {
   const parametros_url = new URLSearchParams(document.location.search);
   const valor_parametro = parametros_url.get(parametro);

   let input = document.querySelector(`input[name="${parametro}"]`);
   input.value = valor_parametro;
}

function validar_regex_email(email) {
   const regex_email = /^[0-9A-Za-z._-]{1,80}@[0-9A-Za-z._-]{1,30}\.[A-Za-z]{1,16}$/;
   return regex_email.test(email);
}

function validar_regex_senha(senha) {
   const simbolos = "!@$%^&*()_+=?.,";
   const regex_senha = new RegExp(`^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[${simbolos}])[0-9A-Za-z${simbolos}]{8,32}$`);
   return regex_senha.test(senha);
}

function exibir_mensagem_erro_input(id_input, id_mensagem_erro, exibir = true) {
   if (exibir) {
      document.getElementById(id_input).setAttribute("aria-invalid", "true");
      document.getElementById(id_mensagem_erro).style.display = "block";
   }
   else {
      document.getElementById(id_input).setAttribute("aria-invalid", "");
      document.getElementById(id_mensagem_erro).style.display = "none";
   }
}

function hashing_senhas(form_data, name_senhas) {
   for (const name of name_senhas) {
      const hash_senha = CryptoJS.SHA256(form_data.get(name));
      form_data.set(name, hash_senha)
   }
}

function exibir_modal(inner_html, exibir_caixa = true) {
   let modal = document.getElementById("modal");

   if (exibir_caixa) {
      modal.innerHTML =
         `<article>
            ${inner_html}
         </article>`;
   }
   else {
      modal.innerHTML = inner_html;
   }

   modal.open = true;
}

function exibir_modal_ok(mensagem_html, onclick_ok = "fechar_modal()") {
   exibir_modal(
      `<h5>
         ${mensagem_html}
      </h5>
      <footer>
         <input type="button" onclick="${onclick_ok}" value="OK">
      </footer>
   `);
}

function fechar_modal() {
   let modal = document.getElementById("modal");
   modal.open = false;
}

function redirecionar_falha_sessao() {
   sessionStorage.clear();
   exibir_modal_ok("É necessário se autenticar para continuar.",
      "location.href = '../html/autenticacao_usuario.html'");
}

async function encerrar_sessao() {
   const retorno_php = await fetch("../php/encerrar_sessao.php", {
      method: "GET"
   });

   const sessao_encerrada = await retorno_php.json();
   if (sessao_encerrada) {
      exibir_modal_ok("Sua sessão foi encerrada.",
         "location.href = '../html/inicio.html'");
   } else {
      exibir_modal_ok("Falha ao encerrar a sessão.");
   }
}

async function definir_aes() {
   let retorno_php = await fetch("../php/enviar_certificado_x509.php", {
      method: "GET"
   });
   const certificado_x509 = await retorno_php.json();
   const chave_publica_rsa = forge.pki.publicKeyToPem(
      forge.pki.certificateFromPem(certificado_x509).publicKey
   );

   const js_encrypt = new JSEncrypt();
   js_encrypt.setPublicKey(chave_publica_rsa);

   gbl_key_aes = CryptoJS.lib.WordArray.random(16);
   gbl_iv_aes = CryptoJS.lib.WordArray.random(16);
   const post_json_string = `{"key_aes":"${gbl_key_aes}","iv_aes":"${gbl_iv_aes}"}`;

   retorno_php = await fetch("../php/definir_aes.php", {
      method: "POST",
      headers: { "Content-Type": "text/plain;charset=UTF-8" },
      body: js_encrypt.encrypt(post_json_string)
   });

   let aes_definido = await retorno_php.json();
   aes_definido = CryptoJS.AES.decrypt(aes_definido, gbl_key_aes, {
      iv: gbl_iv_aes
   }).toString(CryptoJS.enc.Utf8);

   if (!aes_definido) {
      exibir_modal_ok("Falha ao estabelecer uma conexão segura.<br>Tente novamente mais tarde.",
         "location.href = '../html/inicio.html'");
   }
}

async function enviar_post(form_data, pagina_php) {
   const json_string = JSON.stringify(
      Object.fromEntries(form_data)
   );

   const json_string_criptografado = CryptoJS.AES.encrypt(json_string, gbl_key_aes, {
      iv: gbl_iv_aes
   });

   const retorno_php = await fetch(pagina_php, {
      method: "POST",
      headers: { "Content-Type": "text/plain;charset=UTF-8" },
      body: json_string_criptografado
   });

   const body_retorno_php = await retorno_php.json();
   if (!body_retorno_php) {
      return 0;
   }

   const retorno_php_descriptografado = CryptoJS.AES.decrypt(body_retorno_php, gbl_key_aes, {
      iv: gbl_iv_aes
   }).toString(CryptoJS.enc.Utf8);

   return JSON.parse(retorno_php_descriptografado);
}
