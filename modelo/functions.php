<?php

include_once "../conf-app.php";
/* Registrar usuario en la base de datos y crear su carpeta*/
function signup($user, $pass, $rutaUsers){

    $conn = conection() ;
    $sql = "INSERT INTO Users (user, password) VALUES ('" . $user . "', '" . $pass . "')";
    $conn->query($sql);

    mkdir($rutaUsers.'users/'.$user.'/backup/',0755,true);
    mkdir($rutaUsers.'users/'.$user.'/pdf/',0755);

}

/* Destruir la sesión */
function destroySession(){
    session_unset();
    session_destroy();
}

/* Crear una nueva carpeta en la carpeta actual
    $folder --> carpeta donde crear al carpeta, en este caso al actual
    $newFolder --> nombre de la nueva carpeta
*/
function newFolder($folder,$newFolder){
    mkdir($folder."/".$newFolder,0755);
}


/* Subir ficheros a la carpeta actual
    $folder -->  carpeta actual
*/
function upload($folder,$rutaUsers){

    $target_dir = $folder ;  //ruta donde se va a guardar
    $target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);  //coger la ruta
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);  //extension

    if (file_exists($target_file)) {
        include_once 'vista/errors/fileExists.php';
        $uploadOk = 0;
    }else{
        move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file);
    }

}

/* Crear PDF recorriendo recursivamente las carpetas
    $folder --> carpeta principal del usuario que está logeado
*/
function createPDF($rutaUsers){

    require_once('mpdf60/mpdf.php');

    /* PDF name */
    $nombre = "Unidad de ".$_SESSION["user"]."(".date('d-m-Y-h-i-s-a', time()).").pdf";

    $numFiles = 0;
    $size = 0;
    /*$parent = "$/&__%";*/
    $it = new RecursiveDirectoryIterator($rutaUsers."users/".$_SESSION["user"]."/");

    $mpdf=new mPDF();
    $mpdf->WriteHTML("Información de la unidad de ".$_SESSION["user"]);
    $mpdf->WriteHTML("<br>");

    foreach(new RecursiveIteratorIterator($it) as $file) {
        if ( !(strpos($file,'/..') ) ) {

            $rutaLimpia = str_replace($rutaUsers."users/".$_SESSION["user"]."/","",$file);
            if ( is_dir($file) ){
                $rutaLimpia = substr($rutaLimpia,0,-2);
            }
            $mpdf->WriteHTML($rutaLimpia);
        }

        if ( is_file( $file ) ) {
            $size = $size + filesize($file);
            $numFiles = $numFiles + 1;
        }
    }

    /* Según el tamaño muestro una unidad u otra */

    switch ($size) {
        case $size>1024:
            $size = ($size/1024)." Kb";
            break;
        case $size>1048576:
            $size = ($size/1048576)." Mb";
            break;
        case $size>1073741824:
            $size = ($size/1073741824)." Gb";
            break;
        default:
            $size = $size." b";
    }

    $mpdf->WriteHTML("<br>Tamaño ocupado: ".$size." (Tamaño sin incluir este PDF)");
    $mpdf->WriteHTML("Número de archivos: ".$numFiles);

    $mpdf->Output($rutaUsers."users/".$_SESSION["user"]."/pdf/".$nombre ,"F");

    return $nombre;
}

/* Borrado recursivo de las carpetas
    $folder --> carpeta actual
    $name --> nombre de la carpeta que queremos borrar
*/
function myDelete($folder,$name){

    if( is_dir($folder.$name) ){

        $it = new RecursiveDirectoryIterator($folder.$name, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it,
                     RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($folder.$name);

    }else{
        unlink($folder.$name);
    }
}

/* Backup de los archivos/carpetas seleccionados/as */

function backup($rutaUsers){
    include_once "./pclzip-2-8-2/pclzip.lib.php";
    $datetime = date('d-m-Y-h-i-s-a', time());

    $arrayBackup = $_POST["toBackup"];

    for ($i = 0; $i < sizeof($arrayBackup) ; $i++) {
        $arrayBackup[$i] = $_SESSION["folder"].$arrayBackup[$i];
    }

    $rutaBackup = $rutaUsers."users/".$_SESSION["user"]."/backup/".$datetime.".zip";

    $zip = new PclZip($rutaBackup);
    $zip->create($arrayBackup,PCLZIP_OPT_REMOVE_PATH,$_SESSION["folder"]);

    return $rutaBackup;
}

/* Función para renombrar carpetas
    $folder --> carpeta actual
    $_POST["direcNombre"] --> nombre de la carpeta a renombrar
    $_POST['newName'] --> nuevo nombre
*/
function myRename($folder){
    rename( $folder.$_POST['direcNombre'] , $folder.$_POST['newName'] );
}

function checkSpace($rutaUsers,$sizeCloud){

    $limite = false;

    $size = 0;
    $it = new RecursiveDirectoryIterator($rutaUsers."users/".$_SESSION["user"]."/");

    foreach( new RecursiveIteratorIterator($it) as $fileIt ) {
        if ( is_file( $fileIt ) ) {
            $size = $size + filesize($fileIt);
        }
    }

    if ( $size > $sizeCloud ){
           $limite = true;
    }

    return $limite;

}

?>
