async function testar_rsa() {
   const chave_publica = // 2048 bits
      `-----BEGIN PUBLIC KEY-----
      MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArMHwQU/dOCUsXDb+YRJh
      LCGQPoQYIqX04t/Q34txS0qneWEIGo3Ui4FIJLsFXafZwgdbSr4Hyzot1DQbLAXr
      2IxDobujij10o6lkG6XS4eF22L4oz32qUbbkUTo7SsbYirBq6zBxaRf3pvBs4/6p
      DYoZwfF6sdTCwMA5lp/C3TSC8SEpqqYQyAOseT74D9Et14o+I7D9NH4h/DmFCIm0
      4lAEVAaKaZo434GJXFz2+ArVYWboQUtx+Ndt9AUgo3pT7jsmQzsSHsZXrFSq7yIO
      Hsxe3iO6iJy07Rz2elAfutdQH633zo0npXCptseQyHHXMZbrs9aqwGaJs4Dlbo4H
      wwIDAQAB
      -----END PUBLIC KEY-----`;

   const js_encrypt = new JSEncrypt();
   js_encrypt.setPublicKey(chave_publica);

   const mensagem = "enviando do javascript para o php";
   const criptografado_no_js = js_encrypt.encrypt(mensagem);

   let form_data = new FormData();
   form_data.append("criptografado_no_js", criptografado_no_js);
   console.log(form_data.get("criptografado_no_js"));

   const retorno_php = await fetch("teste_rsa.php", {
      method: "POST",
      body: form_data
   });

   const descriptografado_no_php = await retorno_php.json();
   console.log(descriptografado_no_php);
}
