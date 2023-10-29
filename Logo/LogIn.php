<?php
include_once '../BaseDatos/DbConection.php';
$user = $_POST['user'];
$pass = $_POST['pass'];
$conn = conexion();

$sql = "SELECT * FROM usuario WHERE Log = '$user' AND Contraseña = '$pass'";
$resultado_usuario = mysqli_query($conn, $sql);

$sql_admin = "SELECT * FROM usuarioadmin WHERE Logadmin = '$user' AND contraseñadmin = '$pass'";
$resultado_admin = mysqli_query($conn, $sql_admin);

$data_usuario = mysqli_fetch_assoc($resultado_usuario);
$data_admin = mysqli_fetch_assoc($resultado_admin);

if ($data_usuario == null && $data_admin == null) {
  echo '<script type="text/javascript">alert("El usuario o contraseña ingresados no son válidos");window.location.href="../index.html";</script>';
} else {
  session_start();
  
  if ($data_usuario !== null) {
    $_SESSION["user"] = $data_usuario;
    header('Location:../Chats/index.php');
  } elseif ($data_admin !== null) {
    $_SESSION["user"] = $data_admin;
    header('Location:../Admin/index.php'); 
  }
}

mysqli_free_result($resultado_usuario);
mysqli_free_result($resultado_admin);
mysqli_close($conn);
?>
