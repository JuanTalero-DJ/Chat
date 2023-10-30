<?php

	include_once '../BaseDatos/DbConection.php';
	include_once '../Logo/Session.php';
	$mensaje = $_POST['mensaje'];
	$conn = conexion();
	validateSession();
	$fecha= date("Y-m-d H:i:s");	
	$iduser = $_SESSION['user']['IdUsuario'];
	$mensaje_codificado = base64_encode($mensaje);

	$insert = "INSERT INTO chat (idUsuario,Mensaje,Hora, estado) 
	VALUES ('$iduser','$mensaje_codificado','$fecha',0)";
	$query= mysqli_query($conn,$insert);
	header('Location:../Chats/index.php');


?>


