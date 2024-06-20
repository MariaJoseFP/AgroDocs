<?php
session_start();
if (isset($_SESSION['autorizado']) && $_SESSION['autorizado'] === true) {
  // El usuario está logueado, puedes permitirle el acceso a esta página
} else {
  // El usuario no está logueado, redirige a la página de inicio de sesión u otra página
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Base de datos</title>
  <!-- Enlace a Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="icon" href="../logo-audace.ico" type="image/x-icon">
  <!-- Enlace al archivo CSS personalizado -->
  <link rel="stylesheet" href="../css/css.css">
  <!-- Enlace para DataTables y DataTables Buttons -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap4.min.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container mt-1 mb-1">
      <a href="bd_lyt.php">
        <img src="../images/logo audace.png" alt="Logo de Audace" class="navbar-logo" width="40" height="40" style="margin-right: 10px;">
      </a>
      <a class="navbar-brand" href="../inicio_lyt.php">
        Logística y transporte
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="../inicio_lyt.php" style="font-size: medium;">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="bd_lyt.php" style="font-size: medium;">Almacén de información</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php" style="font-size: medium;">Cerrar sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-5">

    <!-------CARDS------->
    <div class="row" id="menu_cards_bd">
      <div class="div">
        <h3 class="mb-5">Almacén de datos</h3>
      </div>

      <div class="col-md-2 mb-4">
        <div class="card" onclick="verTabs('unidades')">
          <img src="../images/camion.png" class="card-img-top imgBd mt-3" alt="Imagen de la card">
          <div class="card-body">
            <h5 class="card-title">Unidades</h5>
            <p class="card-text">Descripción de las unidades almacenadas en la Base de datos.</p>
          </div>
        </div>
      </div>

      <div class="col-md-2 mb-4">
        <div class="card" onclick="verTabs('clientes')">
          <img src="../images/clientes.png" class="card-img-top imgBd mt-3" alt="Imagen de la card">
          <div class="card-body">
            <h5 class="card-title">Clientes</h5>
            <p class="card-text">Descripción de los clientes almacenados en la Base de datos.</p>
          </div>
        </div>
      </div>

      <div class="col-md-2 mb-4">
        <div class="card" onclick="verTabs('granjas')">
          <img src="../images/campo.png" class="card-img-top imgBd mt-3" alt="Imagen de la card">
          <div class="card-body">
            <h5 class="card-title">Granjas</h5>
            <p class="card-text">Descripción de las granjas almacenadas en la Base de datos.</p>
          </div>
        </div>
      </div>
    </div>


    <div class="col-md-1 align-start text-left mb-2">
      <a href="bd_lyt.php">
        <img src="../images/flecha.png" alt="Descripción de la imagen" width="30" height="20" class="ms-0 oculto" id="flecha1">
      </a>

    </div>

    <div class="oculto col-md-12 mt-2" id="div-unidades">
      <div class="row ">
        <div class="col-md-2">
          <h4>Unidades</h4>
        </div>
        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="AgregarRegistrosTab('unidades')">Agregar unidad +</button>
        </div>
      </div>

      <!------TABLA DE UNIDADES------>
      <table id="unidades" class="table table-striped table-hover" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>NUMERO_UNIDAD</th>
            <th>RAZON_SOCIAL</th>
            <th>TIPO_UNIDAD</th>
            <th>MARCA</th>
            <th>MODELO</th>
            <th>AÑO</th>
            <th>PLACAS_TR</th>
            <th>PLACAS_PLANA</th>
            <th>ÁREA</th>
            <th>RESPONSABLE</th>
            <th>NUM_REJAS</th>
            <th>REJAS_PROPIAS/AGRO</th>
            <th>FECHA_PRESTAMO</th>
            <th>OBSERVACION</th>
            <!-- Agrega más encabezados según tus datos -->
          </tr>
        </thead>
        <tbody>
          <!-- Aquí se agregarán las filas de datos mediante JavaScript -->
        </tbody>
      </table>
    </div>
    <div class="oculto col-md-12" id="div-clientes">
      <div class="row ">
        <div class="col-md-2">
          <h4>Clientes</h4>
        </div>
        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="AgregarRegistrosTab('clientes')">Agregar cliente +</button>
        </div>
      </div>
      <!-----TABLA DE CLIENTES----->
      <table id="clientes" class="table table-striped table-hover" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>ID</th>
            <th>CLIENTE</th>
            <th>LOCALIDAD</th>
            <th>MUNICIPIO</th>
            <th>ESTADO</th>
            <!-- Agrega más encabezados según tus datos -->
          </tr>
        </thead>
        <tbody>
          <!-- Aquí se agregarán las filas de datos mediante JavaScript -->
        </tbody>
      </table>
    </div>
    <div class="oculto col-md-12" id="div-granjas">
      <div class="row ">
        <div class="col-md-2">
          <h4>Granjas</h4>
        </div>

        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-secondary btn-sm mb-2" onclick="AgregarRegistrosTab('granjas')">Agregar granja +</button>
        </div>

      </div>
      <!-------TABLA DE GRANJAS-------->
      <table id="granjas" class="table table-striped table-hover" style="width:100%">
        <thead class="table-secondary">
          <tr>
            <th>GRANJA</th>
            <th>UPA</th>
            <th>LOCALIDAD</th>
            <th>MUNICIPIO</th>
            <th>ESTADO</th>
            <!-- Agrega más encabezados según tus datos -->
          </tr>
        </thead>
        <tbody>
          <!-- Aquí se agregarán las filas de datos mediante JavaScript -->
        </tbody>
      </table>
    </div>
  </div>
  <!-- MODAL DE EDITAR REGISTRO-->
  <div class="modal fade" id="formularioModalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar registro</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Contenido del formulario se agregará dinámicamente aquí -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary oculto" data-bs-dismiss="modal" id="dismiss-modal-editado" onClick="window.location.reload();">Cerrar</button>
          <!-- El botón de guardar se agregará dinámicamente junto con el formulario -->
          <div class="alert alert-success oculto" role="alert" id="alert-success-edit">
            El registro se ha actualizado correctamente.
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- MODAL DE AGREGAR REGISTRO NUEVO -->
  <div class="modal fade" id="formularioModalAgregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar registro</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Contenido del formulario se agregará dinámicamente aquí -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="dismiss-modal-editado" onClick="window.location.reload();">Cerrar</button>
          <!-- El botón de guardar se agregará dinámicamente junto con el formulario -->
          <div class="alert alert-success oculto" role="alert" id="alert-success-add">
            La información se ha guardado correctamente.
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
  <script src="../js/js_bd.js"></script>

</body>

</html>