<?php
include_once '../BaseDatos/DbConection.php';
$pass = $_POST['pass'];
$user = $_POST['user'];

 
$conn = conexion();
$sql = "SELECT * FROM usuario  WHERE `log` = '$user' AND `contraseña` = '$pass'";
$resultado = mysqli_query($conn, $sql);
$data=mysqli_fetch_assoc($resultado);
if ($data == null) {
  echo'<script type="text/javascript">alert("El usuario o contraseña ingresados no son validos");window.location.href="../index.html";</script>';
} else {
  session_start();
  $_SESSION["user"]=$data;
  header('Location:../Chats/index.php');
}
mysqli_free_result($resultado);
mysqli_close($conn);

?>