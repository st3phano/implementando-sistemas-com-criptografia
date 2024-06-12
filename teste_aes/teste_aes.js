async function testar_aes() {
   // Transforma string UTF-8 em objeto WordArray, que é um array de "words" de 32 bits
   let key = CryptoJS.enc.Utf8.parse("tamanho_de_32_bytes_para_aes_256"); // 32 bytes == 256 bits
   let iv = CryptoJS.enc.Utf8.parse("tamanho_16_bytes");

   const mensagem = "enviando do javascript para o php";

   // Por padrão no CryptoJS:
   // - mode: CryptoJS.mode.CBC
   // - padding: CryptoJS.pad.Pkcs7
   // encrypt() retorna um objeto CipherParams,
   // quando usado no lugar de uma string é automaticamente convertido,
   // o formato padrão da string resultante é OpenSSL-compatible
   const criptografado_no_js = CryptoJS.AES.encrypt(mensagem, key, { iv: iv });
   // console.log(criptografado_no_js);
   // console.log(criptografado_no_js.toString());

   let form_data = new FormData();
   form_data.append("criptografado_no_js", criptografado_no_js);
   // console.log(form_data.get("criptografado_no_js"));

   const retorno_php = await fetch("teste_aes.php", {
      method: "POST",
      body: form_data
   });
   const criptografado_no_php = await retorno_php.json();
   // console.log(criptografado_no_php);

   key = CryptoJS.enc.Utf8.parse("trocando_so_para_variar_um_pouco");
   iv = CryptoJS.enc.Utf8.parse("so_16_bytes_aqui");

   // decrypt() e encrypt() aceitam tanto strings como objetos CipherParams como "mensagem",
   // as strings passadas são automaticamente convertidas para um objeto CipherParams
   const descriptografado_no_js = CryptoJS.AES.decrypt(criptografado_no_php, key, { iv: iv });
   // console.log(descriptografado_no_js.toString());
   console.log(descriptografado_no_js.toString(CryptoJS.enc.Utf8));
}
