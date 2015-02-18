<?php
/* Calcular el porcentaje ocupado (no se limita realmente) */

session_start();

include_once "../../conf-app.php";

$size = 0;
$it = new RecursiveDirectoryIterator($rutaUsers."users/".$_SESSION["user"]."/");

foreach( new RecursiveIteratorIterator($it) as $file ) {

    if ( is_file( $file ) ) {
        $size = $size + filesize($file);
    }
}

$size =  ($size * 100) / 2000 ;

echo $size."%";
