<?php

session_start();
include_once '../conf-app.php';
require_once ('../otros/PHPMailer-master/PHPMailerAutoload.php');

$toSend = $_GET["nombrePDF"];

$mail = new PHPMailer();
//indico a la clase que use SMTP
$mail->IsSMTP();
//permite modo debug para ver mensajes de las cosas que van ocurriendo
$mail->SMTPDebug = 2;

//Debo de hacer autenticación SMTP
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";

//indico el servidor de Gmail para SMTP
$mail->Host = "smtp.gmail.com";
//indico el puerto que usa Gmail
$mail->Port = 465;

//indico un usuario / clave de un usuario de gmail
$mail->Username = "mycloud.hosting.php@gmail.com";
$mail->Password = "mycloudhostingphp";

/*
$mail->SetFrom('tu_correo_electronico_gmail@gmail.com', 'Nombre completo');
$mail->AddReplyTo("tu_correo_electronico_gmail@gmail.com","Nombre completo");
*/
$mail->SetFrom("mycloud.hosting.php@gmail.com","MyCloud");
$mail->Subject = "PDF MyCloud";
$mail->MsgHTML("Aquí tienes tu PDF");
$mail->AddAttachment($rutaUsers."users/".$_SESSION["user"]."/pdf/".$toSend);

//indico destinatario
$address = $_SESSION["user"];
$mail->AddAddress($address, "Nombre completo");


if(!$mail->Send()) {
    echo "Error al enviar: " . $mail->ErrorInfo;
} else {
    echo "Mensaje enviado!";
}

?>
