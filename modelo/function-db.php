<?php

/* Conexión a la base de datos */
function conection(){
    include "conf-db.php";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

/* Comprobar que el uusario existe */
function checkUser($user,$pass){
    /*
    Valores de la variable 'checker'
    0 --> el usuario no existe
    1 --> el usuario existe
    2 --> el usuario existe y tiene asignada esa contraseña
    */
    $checker = 0 ;

    $conn = conection() ;

    $sql = "SELECT user FROM Users WHERE user='" . $user . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $checker = 1 ;

        $sql = "SELECT user FROM Users WHERE user='" . $user . "' AND password='" . $pass . "'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $checker = 2 ;
        }
    }

    return $checker ;

}

?>
