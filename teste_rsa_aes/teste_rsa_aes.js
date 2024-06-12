async function testar_rsa_aes() {
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

   const key_aes = CryptoJS.lib.WordArray.random(32);
   const iv_aes = CryptoJS.lib.WordArray.random(16);
   const key_aes_string = key_aes.toString();
   const iv_aes_string = iv_aes.toString();
   console.log(key_aes_string);
   console.log(iv_aes_string);

   let form_data = new FormData();
   form_data.append("key_aes", js_encrypt.encrypt(key_aes_string));
   form_data.append("iv_aes", js_encrypt.encrypt(iv_aes_string));

   const retorno_php = await fetch("teste_rsa_aes.php", {
      method: "POST",
      body: form_data
   });

   const criptografado_no_php = await retorno_php.json();
   const descriptografado_no_js = CryptoJS.AES.decrypt(criptografado_no_php, key_aes, { iv: iv_aes })
      .toString();

   console.log(descriptografado_no_js);
   console.log(key_aes_string + iv_aes_string);
   if (descriptografado_no_js == key_aes_string + iv_aes_string) {
      sessionStorage.setItem("key_aes", key_aes_string);
      sessionStorage.setItem("iv_aes", iv_aes_string);
   }
}
