<?php

function validateSession()
{

    session_start();
    if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])) {
        echo'<script type="text/javascript">alert("No se encontro ninguna sesión activa, por favor ingrese nuevamente");window.location.href="../index.html";</script>';
        return false;
    }
    return true;
}

?>