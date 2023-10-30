<?php
include_once '../BaseDatos/DbConection.php';

session_start();

$user = $_POST['user'];
$pass = $_POST['pass'];
$conn = conexion();


$sql_usuario = "SELECT * FROM usuario WHERE Log = '$user'";
$resultado_usuario = mysqli_query($conn, $sql_usuario);


$sql_admin = "SELECT * FROM usuarioadmin WHERE Logadmin = '$user'";
$resultado_admin = mysqli_query($conn, $sql_admin);

if ($resultado_usuario && mysqli_num_rows($resultado_usuario) > 0) {
    $data_usuario = mysqli_fetch_assoc($resultado_usuario);

    if ($data_usuario['bloqueado'] == 1) {
        echo '<script type="text/javascript">alert("Tu cuenta está bloqueada. Contacta al administrador.");window.location.href="../index.html";</script>';
    } else {
        if ($data_usuario['Contraseña'] == $pass) {
            mysqli_query($conn, "UPDATE usuario SET intentos_fallidos = 0 WHERE Log = '$user'");
            $_SESSION["user"] = $data_usuario;
            header('Location:../Chats/index.php');
        } else {
            $intentos_fallidos = $data_usuario['intentos_fallidos'] + 1;
            mysqli_query($conn, "UPDATE usuario SET intentos_fallidos = $intentos_fallidos WHERE Log = '$user'");
            if ($intentos_fallidos >= 3) {
                mysqli_query($conn, "UPDATE usuario SET bloqueado = 1, bloqueo_fecha = NOW() WHERE Log = '$user'");
            }
            echo '<script type="text/javascript">alert("El usuario o contraseña ingresados no son válidos.");window.location.href="../index.html";</script>';
        }
    }
} elseif ($resultado_admin && mysqli_num_rows($resultado_admin) > 0) {
    $data_admin = mysqli_fetch_assoc($resultado_admin);

    if ($data_admin['contraseñadmin'] == $pass) {
        $_SESSION["admin"] = $data_admin;
        header('Location:../Admin/index.php');
    } else {
        echo '<script type="text/javascript">alert("La contraseña del administrador es incorrecta.");window.location.href="../index.html";</script>';
    }
} else {
    echo '<script type="text/javascript">alert("El usuario no existe.");window.location.href="../index.html";</script>';
}

mysqli_free_result($resultado_usuario);
mysqli_free_result($resultado_admin);
mysqli_close($conn);
?>