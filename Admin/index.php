<!DOCTYPE html>
<html>
<head>
    <title>Administrador</title>
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
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
        }
        th {
            background-color: #0074b1;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        input[type="password"] {
            width: 100%;
            padding: 8px;
        }
        button {
            background-color: #0074b1;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        button:hover {
            background-color: #00548c;
        }
        input[type="submit"] {
            background-color: #0074b1;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            background-color: #00548c;
        }
        .blocked {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Administrador</h1>

    <h2>Información de la Tabla "usuario"</h2>
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
        <input type="button" value="Salir" onclick="window.location.href='../index.html'">
    </form>
</body>
</html>