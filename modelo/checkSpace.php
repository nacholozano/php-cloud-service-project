<?php

session_start();

include_once "../conf-app.php";

$size = 0;
$it = new RecursiveDirectoryIterator($rutaUsers."users/".$_SESSION["user"]."/");

foreach( new RecursiveIteratorIterator($it) as $fileIt ) {
    if ( is_file( $fileIt ) ) {
        $size = $size + filesize($fileIt);
    }
}

$size = $size + $_POST["archivoParaSubir"] ;

echo $size;
