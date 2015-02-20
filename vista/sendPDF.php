<!-- Bloque para adjuntar un archivo al PDF -->

<div class="anadirImagen">
        <span class="spanCerrar glyphicon glyphicon-remove"></span>
        <div class="Imagen input-group">
           <form id="uploadForm" action="modelo/upload.php" method="post">
                <input type="file" id="inputImage" name="userImage" class="form-control">
                <span class="input-group-btn">
                    <button type="submit" value="submit" id="boton-enviarCorreo" name="" class="btn btn-default">Enviar</button>
                </span>
            </form>
        </div>
        <div id="divPreview">
            <img src="" id="preview" alt="">
            <p class="alert alert-danger" role='alert' id="notImage">No has seleccionado ninguna imagen</p>
        </div>
</div>
