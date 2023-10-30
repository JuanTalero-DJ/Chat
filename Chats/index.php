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
    <script src="https://kit.fontawesome.com/2943493a50.js" crossorigin="anonymous"></script>
    <title>Conversación de Chat</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        function realizarConsulta() {
            $.ajax({
                url: 'FindMessaje.php',
                type: 'POST',
                success: function(data) {
                    $('#chat').html(data);
                },
                error: function() {}
            });
        }

        setInterval(realizarConsulta, 1000); // Ejecutar cada 10 segundos (10000 milisegundos)
    });
    </script>
</head>

<body>
    
    <?php   
        include_once '../BaseDatos/DbConection.php';
        include_once '../Logo/Session.php';
        $conn = conexion();
        validateSession();
    ?>

    <div class='nameUserLoged'><?php echo $_SESSION['user']['Nombre'];?> <a onclick="window.location.href='../Logo/DestroydSession.php'"> <i title="Salir" class="fa-solid fa-power-off iconOutSesion"></i> </a> </div>
    <div class="container">

        <div class="chat-container">
        <?php
        $iduser = $_SESSION['user']['IdUsuario'];
        $sql = "SELECT Nombre FROM `usuario` where IdUsuario != '$iduser' LIMIT 1" ;
        $result = mysqli_query($conn, $sql);
        $nameUserChat=mysqli_fetch_assoc($result);

        echo '<div class="row userDest"> <i class="fa-solid fa-circle-user userDest"></i> <h3>' . $nameUserChat['Nombre'] . '</div></h3>';   
        ?>
            <div id="chat"></div>
        <?php
        mysqli_close($conn);
        ?>
            <form name="sendmessaje" method="post" action="SendMessaje.php">
                <input type="text" name="mensaje" placeholder="Escribe tu mensaje..." required>
                <button type="submit" onkeypress="wipeValue()">Enviar</button>
            </form>
        </div>
    </div>

    
</body>
<script>

    function wipeValue() {
        document.getElementById("sendmessaje").value = "";
    }

</script>
</html>