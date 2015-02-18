<?php

session_start();

$filename = $_SESSION["folder"] . $_GET["archivo"];
header("Expires: -1");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Content-Type: mime/type");
/* header("Content-type: application/zip;\n");*/
header("Content-Transfer-Encoding: binary");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0");
header("Pragma: no-cache");
$len = filesize($filename);
header("Content-Length: $len;\n");
$outname = $_GET["archivo"];
header("Content-Disposition: attachment; filename=".$outname.";\n\n");
readfile($filename);

//este código sirve para descargar archivos zip , si queremos descargar archivos con otra extensión debemos cambiar el Content-type

?>
