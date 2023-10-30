<!DOCTYPE html>
<html>
<head>
    <title>Administrador</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../Styles/estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel&family=Exo:wght@300&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2943493a50.js" crossorigin="anonymous"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
        }
        h1 {
            margin-top: 20px;
        }
        h2 {
            margin-top: 20px;
        }
       
    </style>
</head>
<body>
    <!-- <h1>Administrador</h1> -->
    <?php   
        include_once '../BaseDatos/DbConection.php';
        include_once '../Logo/Session.php';
        validateSession();
    ?>

    <div class='nameUserLoged'><?php echo "Administrador";?> <a onclick="window.location.href='../Logo/DestroydSession.php'"> <i title="Salir" class="fa-solid fa-power-off iconOutSesion"></i> </a> </div>  
    <h3>Información de la Tabla "usuario"</h3>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table>
            <tr>
                <th>ID Usuario</th>
                <th>Nombre de Usuario</th>
                <th>Estado</th>
                <th>Nueva Contraseña</th>
                <th>Acción</th>
            </tr>
            <?php
            include_once '../BaseDatos/DbConection.php';
            $conn = conexion();

            if (!$conn) {
                die("Error al conectar a la base de datos: " . mysqli_connect_error());
            }

            $consulta = "SELECT IdUsuario, Log, bloqueado FROM usuario";
            $resultado = mysqli_query($conn, $consulta);

            if ($resultado) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    $idUsuario = $fila['IdUsuario'];
                    $username = $fila['Log'];
                    $isBlocked = $fila['bloqueado'] == 1 ? true : false;

                    echo "<tr>";
                    echo "<td>{$idUsuario}</td>";
                    echo "<td>{$username}</td>";
                    echo "<td class='" . ($isBlocked ? "blocked" : "") . "'>" . ($isBlocked ? "Bloqueado" : "Desbloqueado") . "</td>";
                    echo "<td><input type='password' name='nueva_contrasena[{$idUsuario}]' value=''></td>";
                    echo "<td>";
                    if ($isBlocked) {
                        echo "<button type='submit' name='desbloquear' value='{$idUsuario}'>Desbloquear</button>";
                    } else {
                        echo "<button type='submit' name='modificar' value='{$idUsuario}'>Modificar</button>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "Error al ejecutar la consulta: " . mysqli_error($conn);
            }

            if (isset($_POST['modificar'])) {
                foreach ($_POST['nueva_contrasena'] as $idUsuario => $nueva_contrasena) {
                    $idUsuario = intval($idUsuario);
                    $nueva_contrasena = mysqli_real_escape_string($conn, $nueva_contrasena);

                    if (!empty($nueva_contrasena)) {
                        $actualizar_query = "UPDATE usuario SET Contraseña = '$nueva_contrasena' WHERE IdUsuario = $idUsuario";

                        if (mysqli_query($conn, $actualizar_query)) {
                            echo "<p>Contraseña actualizada con éxito para el usuario con ID $idUsuario.</p>";
                        } else {
                            echo "<p>Error al actualizar la contraseña para el usuario con ID $idUsuario: " . mysqli_error($conn) . "</p>";
                        }
                    }
                }
            }

            if (isset($_POST['desbloquear'])) {
                $idUsuario = $_POST['desbloquear'];
                $desbloquear_query = "UPDATE usuario SET bloqueado = 0 WHERE IdUsuario = $idUsuario";
                
                if (mysqli_query($conn, $desbloquear_query)) {
                    echo "<p>Usuario desbloqueado con éxito.</p>";
                } else {
                    echo "<p>Error al desbloquear al usuario: " . mysqli_error($conn) . "</p>";
                }
                
            }

            if (isset($_POST['desbloquear'])) {
                $idUsuario = $_POST['desbloquear'];
                $desbloquear_query = "UPDATE usuario SET bloqueado = 0, intentos_fallidos = 0 WHERE IdUsuario = $idUsuario";
                
                if (mysqli_query($conn, $desbloquear_query)) {
                    
                } else {
                    echo "<p>Error al desbloquear al usuario: " . mysqli_error($conn) . "</p>";
                }
            }
            

            mysqli_close($conn);
            ?>
        </table>
        <input type="submit" value="Guardar Cambios">
    </form>
</body>
</html>