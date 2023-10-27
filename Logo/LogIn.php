<?php
include_once '../BaseDatos/DbConection.php';
$user = $_POST['user'];
$pass = $_POST['pass'];
$conn = conexion();

$sql = "SELECT * FROM Usuario  WHERE Log= '$user' AND Contraseña = '$pass'";
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