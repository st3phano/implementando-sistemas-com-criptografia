<?php
$dir = __DIR__ . "/../../dir";

if (
   isset($_SERVER["CONTEXT_DOCUMENT_ROOT"])
   && $_SERVER["CONTEXT_DOCUMENT_ROOT"] == "/var/www/html"
) {
   $dir = __DIR__ . "/../../../../dir";
}
