<?php
session_start();
if (isset($_SESSION['autorizado']) && $_SESSION['autorizado'] === true) {
  // El usuario está logueado, puedes permitirle el acceso a esta página
  if($_SESSION["area"] == 'lyt'){
    header("Location: inicio_lyt.php");
  }else if($_SESSION["area"] == 'movilizacion'){
    header("Location: inicio_m.php");
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/css.css">
    <link rel="icon" href="logo-audace.ico" type="image/x-icon">

</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header" style="background-color: #324759; color:white;">
                        <h3 class="text-center">Iniciar sesión</h3>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="usuario">Usuario:</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese su usuario">
                            </div>
                            <div class="form-group">
                                <label for="clave">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña">
                            </div>
                            <div class="alert alert-danger oculto" role="alert" id="alert-error" >
                                Usuario y/o Contraseña incorrecto.
                            </div>
                            <button type="button" class="btn btn-light btn-block" id="btnLogin" >Iniciar sesión</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="js/login.js"></script>
</body>

</html>