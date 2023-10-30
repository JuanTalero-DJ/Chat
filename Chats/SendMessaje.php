<?php

	include_once '../BaseDatos/DbConection.php';
	include_once '../Logo/Session.php';
	$mensaje = $_POST['mensaje'];
	$conn = conexion();
	validateSession();
	$fecha= date("Y-m-d H:i:s");	
	$iduser = $_SESSION['user']['IdUsuario'];

	$insert = "INSERT INTO chat (idUsuario,Mensaje,Hora, estado) 
	VALUES ('$iduser','$mensaje','$fecha',0)";
	$query= mysqli_query($conn,$insert);
	header('Location:../Chats/index.php');

?>


