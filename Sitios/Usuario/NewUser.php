<?php

	include_once '../../BaseDatos/DbConection.php';
	$nom = $_POST['Nombre'];
	$email =$_POST['Correo'];
	$clave =$_POST['Clave'];
	$confClave =$_POST['ConfirmarClave'];
	$conn = conexion();

	if ($clave!= $confClave){	
		$mensaje = "Las contraseñas ingresadas no coinciden";
		echo'<script type="text/javascript">alert("'.$mensaje.'");window.location.href="index.html";</script>';
		return;
	}

	$insert = "INSERT INTO usuarios (Nombre,Correo,Clave) 
	VALUES ('$nom','$email','$clave')";
	$query= mysqli_query($conn,$insert);
	// $data = mysqli_fetch_assoc($query);

	echo'<script type="text/javascript">alert("Guardado exitoso");window.location.href="../../index.php";</script>';
?>


