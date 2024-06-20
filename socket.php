<?php

// Crear un socket TCP/IP
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

// Vincular el socket a la dirección y puerto local
socket_bind($socket, '10.0.2.15', 80);

// Escuchar conexiones entrantes
socket_listen($socket);

// Aceptar la conexión entrante
$clientSocket = socket_accept($socket);

// Leer datos del cliente
$clientData = socket_read($clientSocket, 1024);

// Imprimir los datos recibidos del cliente
echo "Datos recibidos del Cliente: " . $clientData . PHP_EOL;

// Cerrar el socket del cliente
socket_close($clientSocket);

// Cerrar el socket del servidor
socket_close($socket);

?>
