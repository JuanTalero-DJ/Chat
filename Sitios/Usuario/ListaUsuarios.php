<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel&family=Exo:wght@300&display=swap" rel="stylesheet">
    <title>Lista Usuarios</title>
</head>


<?php

include_once '../../BaseDatos/DbConection.php';
$sql = "SELECT * FROM usuarios Order by Id";
$conn = conexion();
$resultado = mysqli_query($conn, $sql);

if ($resultado == null) {
    echo '<script type="text/javascript">alert(No se encontraron registros);window.location.href="../Menú/index.php";</script>';
    return;
}
?>

<body style="text-align: center;">
    <br> <br>
    <br><br>
    <h4>CHAT</h4>
    <br>
    <div class="container">
        
    </div>
<br>
    <div class="row">
                <div class="col-md">
                    <button type="button" onclick="window.location.href = '../../index.php'">Enviar</button>
                </div>
            </div>
</body>
<?php

mysqli_free_result($resultado);
mysqli_close($conn);

?>

  