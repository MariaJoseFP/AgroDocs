<?php
header('Content-Type: application/json');
include('conexion.php');
session_start();

//if (isset($_POST['login'])) {
$username = $_POST['username'];
$password = $_POST['password'];

// Verificar la conexión a la base de datos
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

try {
    // Consultar la base de datos para el usuario proporcionado
    $sql = "SELECT id, nombre, contraseña,area FROM usuarios WHERE nombre = '$username'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verificar la contraseña
        if ($password == $row["contraseña"]) {
            // Inicio de sesión exitoso, almacenar información del usuario en la sesión
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["user_name"] = $row["nombre"];
            $_SESSION["area"] = $row["area"];
            $_SESSION["autorizado"] = true;
            echo json_encode(array("status" => "success", "area" => $row["area"]));
            exit();
        } else {

            $message = "Contraseña incorrecta";
            echo json_encode(array("status" => "error", "message" => $message));
        }
    } else {
        $message = "Usuario no encontrado";
        echo json_encode(array("status" => "error", "message" => $message));
    }

    $conn->close();
} catch (PDOException $e) {
    $message = "Error durante la ejecución de la consulta: " . $e->getMessage();
    echo json_encode(array("status" => "error", "message" => $message));
}
//}
