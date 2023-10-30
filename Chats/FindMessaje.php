<?php
include_once '../BaseDatos/DbConection.php';
include_once '../Logo/Session.php';
$conn = conexion();
session_start();
$sql = "SELECT `IdUsuario`, `Hora`, `Mensaje` FROM `chat` ORDER BY  Hora asc" ;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0 ) {

   $totalRegistros = $result->num_rows;


		$register = $totalRegistros;
		while ($row = $result->fetch_assoc()) {
			$usuario = $row['IdUsuario'];	
			$hora = $row['Hora'];
			$mensaje = $row['Mensaje'];
			$mensaje_decodificado = base64_decode($mensaje);
			
				$messageClass = ($usuario == $_SESSION['user']["IdUsuario"]) ? 'user-message' : 'other-user-message';
		   
				echo '<div class="message ' . $messageClass . '">'.'<p>' . $mensaje_decodificado . '</p>'.'<p style="font-size: 13px; text-align: right;">' . $hora . '</p>'.'</div>';
			}
	
} else {
	echo '<p>No se encontraron mensajes en el chat.</p>';
}

?>


