<?php
/* Muestra el contenido de la ruta $folder */
function viewFolder($folder,$rutaUsers){

    $directorios = scandir($folder);

    for ($i = 0; $i < sizeof($directorios); $i++) {

        if( $directorios[$i] !== "." && $directorios[$i] !== ".." ){
?>
        <li class="contenidoList list-group-item">
        <div class="col-md-5 boton-carpeta">

<?php
        if( is_dir( $folder.$directorios[$i] ) ) {
?>
        <form action='index.php' method='post'>
            <span class="iconoTipo glyphicon glyphicon-folder-open"></span>
            <input type='hidden' name='direccion' value='<?php echo $directorios[$i]?>'>
            <input type='hidden' name='url' value='mycloud'>
            <button type='submit' class="btn btn-default boton-carpeta"><?php echo $directorios[$i]?></button>
        </form>

<?php
            }else{
?>
           <span class="iconoTipo glyphicon glyphicon-file"></span>
            <a href="./otros/safeDownload.php?archivo=<?php echo $directorios[$i]?>">
            <?php echo $directorios[$i] ?>
            </a>


<?php
            /* la fecha de creacion solo sale bien en los archivos
            si subo un archivo en la carpeta1 , la fecha de creacion que muestra
            para la carpeta1 es la misma que la del archivo que he subido
            */

            }
?>
       </div>

       <div class="col-md-2 fecha">
                <?php echo date("m-d-Y H:i:s",filectime($folder.$directorios[$i])) ?>
        </div>

            <!-- la fecha de creacion solo sale bien en los archivos
            si subo un archivo en la carpeta1 , la fecha de creacion que muestra
            para la carpeta1 es la misma que la del archivo que he subido
            -->

       <div class="col-md-1 divCorreo">
           <button class="btn btn-default boton-envio col-md-11 col-xs-12" title="Enviará el pdf al correo asignado a la cuenta">Enviar</button>
       </div>

       <div class="col-md-1 divBorrar">
        <form action='index.php' method='post'>
            <input type='hidden' name='direcBorrar' value="<?php echo $directorios[$i]?>">
            <input type='hidden' name='url' value='mycloud'>
            <input type='hidden' name='operation' value='borrar'>
            <input type='hidden' name='bread-this' value=' '>

            <button type='submit' class="btn btn-default col-md-11 col-xs-12"

            <?php
                if( $folder.$directorios[$i] === $rutaUsers."users/".$_SESSION["user"]."/pdf" || $folder.$directorios[$i] === $rutaUsers."users/".$_SESSION["user"]."/backup" ){
            ?>
                disabled="disabled"
            <?php
                }
            ?>

            >Borrar</button>

        </form>
        </div>

        <div>
        <form action='index.php' method='post'>

            <input type='hidden' name='url' value='mycloud'>
            <input type='hidden' name='operation' value='rename'>
            <input type='hidden' name='bread-this' value=' '>
            <input type='hidden' name='direcNombre' value='<?php echo $directorios[$i]?>'>

            <div class="input-group col-md-3 input-renombrar">
                <input type='text' name='newName' class="form-control" placeholder="Renombrar">
                <span class="input-group-btn">

                <button type='submit' class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Renombrará esta carpeta"

            <?php
                if( $folder.$directorios[$i] === $rutaUsers."users/".$_SESSION["user"]."/pdf" || $folder.$directorios[$i] === $rutaUsers."users/".$_SESSION["user"]."/backup" ){
            ?>
                disabled="disabled"
            <?php
                }
            ?>


            >R</button>

                </span>
            </div>
        </form>
        </div>

       </li>

<?php
        }
    }
}

/* realiza migas de pan de la carpeta $folder
explode divide la ruta completa en cada subcarpeta que la compone
despues uno la primera con la segunda , la union de las 2 anteriores con la tercera,etc
*/
function breadcrumbs($folder){

    $directorios = explode("/",$folder);

    $breadcumb = "/";

    for ($i = 4; $i < sizeof($directorios); $i++) {

        if( $directorios[$i] !== "" ){

        $breadcumb .= $directorios[$i] . "/" ;
?>
        <div class="pull-left">
         <span class="flecha glyphicon glyphicon-chevron-right pull-left "></span>
           <form action='index.php' method='post' class="pull-left">
            <input type='hidden' name='breadcumb' value='<?php echo $breadcumb ?>'>
            <input type='hidden' name='url' value='mycloud'>
            <button type='submit' class="btn btn-default col-md-12 col-xs-12"> <?php echo $directorios[$i]?> </button>
         </form>
        </div>
<?php   }
    }
}

/* Muestra el mismo número de checkbox que contenido tenga la carpeta actual */

function formBackUp($folder){

    $directorios = scandir($folder);

    for ($i = 0; $i < sizeof($directorios); $i++) {

        if( $directorios[$i] !== "." && $directorios[$i] !== ".." ){
?>
       <li class="backupList list-group-item">
        <input class='check' type='checkbox' name='toBackup[]' id="toBackup" value='<?php echo $directorios[$i] ?>' >
       </li>
<?php
        }
    }
}
