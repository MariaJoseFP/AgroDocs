<?php
session_start(); // Inicia la sesión si no está iniciada

// Cierra la sesión
session_destroy();
session_unset();

// Redirige a la página de inicio de sesión u otra página después de cerrar sesión
header("Location: ../index.php");
exit();
?>
