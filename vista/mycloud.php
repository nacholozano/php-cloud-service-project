<?php

    if ( isset ( $_POST["breadcumb"] ) ){

        $_SESSION["folder"] = $rutaUsers."users".$_POST["breadcumb"];
        /* Asignando un valor vacío a esta variable soluciono el problema
        de no poder volver a las misma carpeta que estuve antes
        */

    }else if( isset ( $_POST["direccion"] ) ){
        /*
        Miro si existe porque al recargar la pagina reenviar la variable 'direccion'
        y si no comprubo que existe me muestra una carpeta que no existe
        */

        if ( file_exists($_SESSION["folder"].$_POST["direccion"]) ){
            $_SESSION["folder"] = $_SESSION['folder'].$_POST["direccion"]."/";
        }

    }else if( isset ( $_POST["bread-this"] ) ) {

        /* Si recibo el parámetro 'bread-this' no cambio el valor de $_SESSION['folder']
            Por lo tanto, después de hacer una operación como borrar, regresaría a la carpeta
            en la que he realizado la acción  */

    }else{
        $_SESSION["folder"] = $rutaUsers."users/" . $_SESSION["user"] . "/";
    }

?>

<div class="operaciones row">

<div class="col-md-12">

   <div class="panel panel-warning">
       <div class="panel-heading">Operaciones</div>

       <div class="panel-body">

       <div class="col-md-4">
        <form action="index.php" method="post">

            <input type="hidden" name="url" value="mycloud">
            <input type="hidden" name="operation" value="newFolder">
            <input type="hidden" name='bread-this' value=' '>

            <div class="input-group">

                <input type="text" name="newFolder" class="form-control" placeholder="Nueva carpeta">
                <span class="input-group-btn">
                    <button id="button-op" type="submit" class="btn btn-default col-xs-12" data-toggle="tooltip" data-placement="left" title="Creará una nueva carpeta en la ubicación actual"

                    <?php
                        if( $_SESSION["folder"] == $rutaUsers."users/".$_SESSION["user"]."/pdf/" || $_SESSION["folder"] == $rutaUsers."users/".$_SESSION["user"]."/backup/" ){
                            ?>
                         disabled="true"
                    <?php
                        }
                    ?>

                    >N</button>
                </span>
            </div>
        </form>
       </div>

       <div class="col-md-4">
        <form action="index.php" method="post" class="form-inline" enctype="multipart/form-data">
            <div class="form-group uploadFile">
                <input type="hidden" name="url" value="mycloud">
                <input type="hidden" name="operation" value="uploadFile">
                <input type="hidden" name='bread-this' value=' '>

                <div class="input-group divSubir">
                      <input class="form-control" type="file" name="fileUpload" id="fileUpload">
                    <span class="input-group-btn">
                    <button id="button-op" type="submit" class="btn btn-default buttonUp" data-toggle="tooltip" data-placement="bottom" title="El archivo será subido a la ubicación actual"

                    <?php
                        if( $_SESSION["folder"] == $rutaUsers."users/".$_SESSION["user"]."/pdf/" || $_SESSION["folder"] == $rutaUsers."users/".$_SESSION["user"]."/backup/" ){
                            ?>
                         disabled="true"
                    <?php
                        }
                    ?>

                    >Subir archivo</button>
                    </span>
                </div>
            </div>
        </form>
       </div>

       <div class="col-md-2">
        <form action="index.php" method="post">
            <input type="hidden" name="url" value="mycloud">
            <input type="hidden" name="operation" value="createPDF">
            <input type="hidden" name='bread-this' value=' '>
            <button id="button-op" type="submit" class="btn btn-default col-xs-12" data-toggle="tooltip" data-placement="left" title="Genera un pdf recopilando información de tú unidad">Generar PDF</button>
        </form>
       </div>

       <div class="col-md-2">
        <form action="index.php" method="post">
            <input type="hidden" name="url" value="logout">
            <button id="button-op" type="submit" class="btn btn-default col-xs-12">Cerrar sesión</button>
        </form>
       </div>

       </div>

   </div>

</div>

</div>

<div class="breadc row">
    <div class="col-md-12 bread-c">
        <div class="panel panel-warning">
            <div class="panel-heading">Breadcrumb</div>
            <div class="panel-body">
                <?php breadcrumbs($_SESSION["folder"]);?>
            </div>
        </div>
    </div>
 </div>


<?php

    if( $_POST["operation"] === "newFolder"  ){
        newFolder( $_SESSION["folder"] , $_POST["newFolder"] );
    }

    if( $_POST["operation"] === "uploadFile" ){
        upload( $_SESSION["folder"] );
    }

    if( $_POST["operation"] === "createPDF" ){
        $nombre = createPDF($rutaUsers);

        if( checkSpace($rutaUsers,$sizeCloud) ){
            include_once "vista/errors/notSpace.php";
            $folder = $rutaUsers."users/".$_SESSION["user"]."/pdf/";
            myDelete($folder,$nombre);
        }else{
            include_once "vista/success/pdfCreated.php";
        }
    }

    if( $_POST["operation"] === "borrar" ){
        myDelete($_SESSION["folder"],$_POST["direcBorrar"]);
    }

    if( $_POST["operation"] === "rename"  ){
        if( $_POST['newName'] !== "" && $_POST['newName'] !== "." && $_POST['newName'] !== ".." ){
            myRename($_SESSION["folder"]);
        }
    }

    if( $_POST["operation"] === "backup"  ){
        $rutaBackup = backup($rutaUsers);

        if( checkSpace($rutaUsers,$sizeCloud) ){
            include_once "vista/errors/notSpace.php";
            myDelete($rutaBackup,"");
        }else{
            include_once "vista/success/backupCreated.php";
        }
    }

?>

<div class="row">

   <div class="carpeta col-md-11 col-xs-9">
    <div class=" panel panel-warning">
          <div class="panel-heading">Contenido</div>
          <ul class="grupo-folder list-group">
              <?php viewFolder($_SESSION["folder"],$rutaUsers); ?>
          </ul>
    </div>
   </div>

    <div class="backup col-md-1 col-xs-3">

        <form action="index.php" method="post">
            <div class="panel panel-warning">
                <div class="panel-heading">Backup</div>
                <ul class="grupo-backup list-group">
                    <?php formBackUp($_SESSION["folder"]) ?>
                </ul>
            <input type="hidden" name="url" value="mycloud">
            <input type='hidden' name='bread-this' value=" ">
            <input type="hidden" name="operation" value="backup">
            <div class="panel-footer">
                <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Creará un backup de lo seleccionado">B</button>
            </div>
            </div>
        </form>

    </div>


</div>
