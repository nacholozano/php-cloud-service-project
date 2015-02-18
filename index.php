<?php session_start();?>
<!doctype html>
<html>
<head>
    <?php include_once ("./vista/head.php") ?>
</head>
<body>

    <div class="appWrapper container-fluid">

<?php

$check;

include_once "conf-app.php";
include_once "modelo/function-db.php";
include_once "modelo/functions.php";
include_once "vista/function/function.php";

switch ( $_POST["url"] ) {

    case "logout":

        destroySession();
        include_once "./vista/header.php";
        include_once "./vista/login.php";
        include_once "./vista/signup.php";
        include_once "vista/footer.php";

    break;

    case "login":

        $check = checkUser( $_POST["usuLogin"] , $_POST["passLogin"] ) ;

        if( $check == 0 ){

            include_once "./vista/header.php";
            include_once "vista/login.php";
            include_once "vista/signup.php";
            include_once "vista/errors/userNotExists.php";
            include_once "vista/footer.php";

        }else if( $check == 1 ){

            include_once "./vista/header.php";
            include_once "vista/login.php";
            include_once "vista/signup.php";
            include_once "vista/errors/passError.php";
            include_once "vista/footer.php";

        }else{
            $_SESSION["user"] = $_POST["usuLogin"] ;
            include_once "./vista/header2.php";
            include_once './vista/mycloud.php';
        }

    break;

    case "signup":

        $check = checkUser( $_POST["usuSign"] , $_POST["passSign"] ) ;

        if( $check == 0 ){

            signup( $_POST["usuSign"] , $_POST["passSign"] , $rutaUsers ) ;
            include_once "./vista/header.php";
            include_once "vista/login.php";
            include_once "vista/signup.php";
            include_once "vista/success/userCreated.php";
            include_once "vista/footer.php";

        }else{

            include_once "./vista/header.php";
            include_once "vista/login.php";
            include_once "vista/signup.php";
            include_once "vista/errors/userTaken.php";
            include_once "vista/footer.php";

        }

    break;

    case "mycloud":
        include_once "./vista/header2.php";
        include_once "./vista/mycloud.php";
    break;

    default:
        include_once "./vista/header.php";
        include_once "./vista/login.php";
        include_once "./vista/signup.php";
        include_once "vista/footer.php";

}

?>

    </div>

<?php include_once "vista/sendPDF.php"; ?>

</body>
</html>
