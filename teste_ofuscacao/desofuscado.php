<?php
// $aWYoIWZ1bmN0aW9uX2V4 = file(__FILE__);
$arquivo_array = file(__FILE__); // copia o conteúdo do próprio arquivo para o primeiro elemento de um array

// eval(base64_decode("aWYoIWZ1bmN0aW9uX2V4aXN0cygiYVdZb0lXWjFibU4wYVc5dVgyViIpKXtmdW5jdGlvbiBhV1lvSVdaMWJtTjBhVzl1WDJWKCRnLCRiPTApeyRhPWltcGxvZGUoIlxuIiwkZyk7JGQ9YXJyYXkoNjE2LDIzNiw0MCk7aWYoJGI9PTApICRmPXN1YnN0cigkYSwkZFswXSwkZFsxXSk7ZWxzZWlmKCRiPT0xKSAkZj1zdWJzdHIoJGEsJGRbMF0rJGRbMV0sJGRbMl0pO2Vsc2UgJGY9dHJpbShzdWJzdHIoJGEsJGRbMF0rJGRbMV0rJGRbMl0pKTtyZXR1cm4oJGYpO319"));
if (!function_exists("funcao1")) {
   function funcao1($arquivo_array, $b = 0)
   {
      $arquivo_string = implode("\n", $arquivo_array); // transforma o array com um elemento em uma string

      $d = array(616, 236, 40);
      if ($b == 0) {
         $f = substr($arquivo_string, $d[0], $d[1]); // arquivo_string[616 até 616+236]
         /*
         if (!function_exists("funcao2")) {
            function funcao2($argumento_1, $argumento_2)
            {
               if ($argumento_2 == sha1($argumento_1)) {
                  return (gzinflate(base64_decode($argumento_1)));
               } else {
                  echo ("Error: File Modified");
               }
            }
         }
         */
      } elseif ($b == 1) {
         $f = substr($arquivo_string, $d[0] + $d[1], $d[2]); // arquivo_string[616+236 até 616+236+40]
      } else {
         $f = trim(substr($arquivo_string, $d[0] + $d[1] + $d[2])); // arquivo_string[616+236+40 até final]
      }

      return ($f);
   }
}

// eval(base64_decode(aWYoIWZ1bmN0aW9uX2V($aWYoIWZ1bmN0aW9uX2V4)));
funcao_01($arquivo_array, 0);

// eval(aWYoIWZ1bmN0aW9uX2V4a(aWYoIWZ1bmN0aW9uX2V($aWYoIWZ1bmN0aW9uX2V4, 2), aWYoIWZ1bmN0aW9uX2V($aWYoIWZ1bmN0aW9uX2V4, 1)));
funcao_02(
   funcao_01($arquivo_array, 2),
   funcao_01($arquivo_array, 1)
);

__halt_compiler();

aWYoIWZ1bmN0aW9uX2V4aXN0cygiYVdZb0lXWjFibU4wYVc5dVgyVjRhIikpe2Z1bmN0aW9uIGFXWW9JV1oxYm1OMGFXOXVYMlY0YSgkYSwkaCl7aWYoJGg9PXNoYTEoJGEpKXtyZXR1cm4oZ3ppbmZsYXRlKGJhc2U2NF9kZWNvZGUoJGEpKSk7fWVsc2V7ZWNobygiRXJyb3I6IEZpbGUgTW9kaWZpZWQiKTt9fX0=f93b0254319c88a3a827eae76d86dcea08f515dbS03OyFdQys9UsgYA
