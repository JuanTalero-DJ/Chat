<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../Styles/estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel&family=Exo:wght@300&display=swap" rel="stylesheet">
    <title>Conversación de Chat</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <div class="chat-container">
            <h1>Matha</h1>

            <?php
     
        include_once '../BaseDatos/DbConection.php';
        include_once '../Logo/Session.php';
        $conn = conexion();
        validateSession();


        $sql = "SELECT `IdUsuario`, `Hora`, `Mensaje`  FROM `chat` ORDER BY  Hora DESC" ;
        $nameOtherUser = "SELECT `IdUsuario`, `Hora`, `Mensaje`  FROM `chat` ORDER BY  Hora DESC";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $usuario = $row['IdUsuario'];
                $hora = $row['Hora'];
                $mensaje = $row['Mensaje'];

                // Estilo de mensaje según el usuario
                $messageClass = ($usuario == $_SESSION['user']["IdUsuario"]) ? 'user-message' : 'other-user-message';

                echo '<div class="message ' . $messageClass . '">';                
                echo '<p>' . $mensaje . '</p>';
                echo '<p style="font-size: 13px; text-align: right;">' . $hora . '</p>';

                echo '</div>';
            }
        } else {
            echo '<p>No se encontraron mensajes en el chat.</p>';
        }

        // Cerrar la conexión a la base de datos
        mysqli_close($conn);
        ?>

            <!-- Formulario para enviar mensajes -->
            <form>
                <input type="text" placeholder="Escribe tu mensaje...">
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>

</html>