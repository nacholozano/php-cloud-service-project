<!-- Bloque para adjuntar un archivo al PDF -->

<div class="anadirImagen">
        <span class="spanCerrar glyphicon glyphicon-remove"></span>
            <form id="uploadForm" action="modelo/upload.php" method="post">
              <div class="Imagen input-group">
                <input type="file" id="inputImage" name="userImage" class="form-control">
                <span class="input-group-btn">
                    <button type="submit" value="submit" id="boton-enviarCorreo" name="" class="btn btn-default">Enviar</button>
                </span>
              </div>
            </form>
        <div id="divPreview">
            <img src="" id="preview" alt="">
            <div id="loadImage"><img src="imagenes/ajax-loader.gif"></div>
            <p class="alert alert-danger" role='alert' id="notImage">No has seleccionado ninguna imagen</p>
        </div>
</div>
