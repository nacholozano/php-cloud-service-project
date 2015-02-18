<div class="row">
   <div class="col-md-12 logSign">
    <div class="col-md-5 col-md-offset-1">
        <h3>Iniciar sesión</h3>
        <form action="index.php" method="post" class="form">
            <div class="form-group">
                <label for="usuario">Email</label>
                <input required type="email" maxlength="150" name="usuLogin" class="form-control" id="usuario">
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña</label>
                <input required type="password" maxlength="50" name="passLogin" class="form-control" id="contraseña">
            </div>
            <input type="hidden" name="url" value="login">
            <button type="submit" class="btn btn-default">Entrar</button>
        </form>
    </div>
