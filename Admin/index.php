<!DOCTYPE html>
<html>
<head>
    <title>Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        h1 {
            text-align: center;
        }
        h2 {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #333;
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
                <th>Nueva Contraseña</th>
                <th>Acción</th>
            </tr>
            <?php
             
             include_once '../BaseDatos/DbConection.php';
             $conn = conexion();
 
             if (!$conn) {
                 die("Error al conectar a la base de datos: " . mysqli_connect_error());
             }
 
             $consulta = "SELECT IdUsuario, Log FROM usuario";
             $resultado = mysqli_query($conn, $consulta);
 
             if ($resultado) {
                 while ($fila = mysqli_fetch_assoc($resultado)) {
                     echo "<tr>";
                     echo "<td>{$fila['IdUsuario']}</td>";
                     echo "<td>{$fila['Log']}</td>";
                     echo "<td><input type='password' name='nueva_contrasena[{$fila['IdUsuario']}]' value=''></td>";
                     echo "<td><button type='submit' name='modificar' value='{$fila['IdUsuario']}'>Modificar</button></td>";
                     echo "</tr>";
                 }
             } else {
                 echo "Error al ejecutar la consulta: " . mysqli_error($conn);             }
 
             if (isset($_POST['modificar'])) {
                 foreach ($_POST['nueva_contrasena'] as $id_usuario => $nueva_contrasena) {
                     $id_usuario = intval($id_usuario);
                     $nueva_contrasena = mysqli_real_escape_string($conn, $nueva_contrasena);
                     
                     if (!empty($nueva_contrasena)) {
                         $actualizar_query = "UPDATE usuario SET Contraseña = '$nueva_contrasena' WHERE IdUsuario = $id_usuario";
 
                         if (mysqli_query($conn, $actualizar_query)) {
                             echo "<p>Contraseña actualizada con éxito para el usuario con ID $id_usuario.</p>";
                             
                         } else {
                             echo "<p>Error al actualizar la contraseña para el usuario con ID $id_usuario: " . mysqli_error($conn) . "</p>";
                         }
                     }
                 }
             }
 
             mysqli_close($conn);
             ?>
           
        </table>
        <input type="submit" value="Guardar Cambios">
    </form>
</body>
</html>
