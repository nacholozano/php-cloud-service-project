<?php

error_reporting(E_ALL);

session_start();
include_once '../conf-app.php';
include_once '../otros/PHPMailer-master/PHPMailerAutoload.php';
include_once '../mpdf60/mpdf.php';

$toSend = $_GET["nombrePDF"];
$imageName = $_GET['inputImage'];
$pdfToOpen = $rutaUsers."users/".$_SESSION["user"]."/pdf/".$toSend;

/* ---------- Añadir imagen al PDF ---------- */
$mpdf = new mPDF();
$mpdf->SetImportUse();
$pdfFile = $mpdf->SetSourceFile($pdfToOpen);
$template = $mpdf->ImportPage($pdfFile);
$mpdf->UseTemplate($template);
$mpdf->AddPage();
$mpdf->SetFooter("<img src='".$tmp.$imageName."'/>");
$mpdf->Output($tmp.$toSend ,"F");

/* ---------- Enviar PDF ---------- */
/*
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

$mail->SetFrom("mycloud.hosting.php@gmail.com","MyCloud");
/*
$mail->AddReplyTo("tu_correo_electronico_gmail@gmail.com","Nombre completo");
*/
/*
$mail->Subject = "PDF MyCloud";
$mail->MsgHTML("Aquí tienes tu PDF");
$mail->AddAttachment(/*$rutaUsers."users/".$_SESSION["user"]."/pdf/".$toSend*//*$tmp.$toSend);*/
/*
//indico destinatario
$address = $_SESSION["user"];
$mail->AddAddress($address, "Nombre completo");

if(!$mail->Send()) {
    echo "Error al enviar: " . $mail->ErrorInfo;
} else {
    echo "Mensaje enviado!";
}
*/
?>
