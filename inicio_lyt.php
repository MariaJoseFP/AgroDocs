<?php

//ESTA ES LA INTERFAZ DONDE SE PUEDE REALIZAR :
/*
    1-CONSULTAR LA PROGRAMACION Y GENERAR LOS DOCUMENTOS
    2-REGISTRAR PROGRAMACIÓN 
    3-EDITAR LAS BASES DE DATOS 
*/

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="logo-audace.ico" type="image/x-icon">
  <title>Logística y transporte</title>
  <!-- Enlace al archivo CSS -->
  <link rel="stylesheet" href="css/css.css">
</head>

<body>

  <nav class="navbar navbar-expand-lg  fixed-top  navbar-dark">
    <div class="container mt-1 mb-1">
      <img src="images/logo audace.png" alt="Logo de Audace" class="navbar-logo" width="40" height="40" style="margin-right: 10px;">
      <a class="navbar-brand " href="inicio_lyt.php">
        Logística y transporte
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">

        <ul class="navbar-nav ms-auto"> <!-- Alinea 'Cerrar sesión' a la derecha -->
          <li class="nav-item">
            <a class="nav-link active " href="inicio_lyt.php" style="font-size: medium;">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="php/bd_lyt.php" style="font-size: medium;">Almacén de información</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="php/logout.php" style="font-size: medium;">Cerrar sesión</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <div class="row text-center" id="menu_cards">
      <div class="col-md-3 mb-4">
        <div class="card" onclick="verProgramacion()">
          <img src="images/calendario.png" class="card-img-top mt-3" alt="Imagen de la card" style="width: 40%" ;>
          <div class="card-body mb-3">
            <h5 class="card-title">Ver programación</h5>
            <p class="card-text">Programación de unidades.</p>

          </div>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="card" onclick="verBD()">
          <img src="images/bd2.png" class="card-img-top mt-3" alt="Imagen de la card" style="width: 40%" ;>
          <div class="card-body">
            <h5 class="card-title">Almacén de información</h5>
            <p class="card-text">Información guardada en la base de datos (clientes, granjas y unidades).</p>
          </div>
        </div>
      </div>
    </div>

    <div class="oculto col-md-12" id="div-programacion">
      <h2>Programación de unidades</h2>
      <h5 id="fecha"></h5>
      <script>
        const options = {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        };
        document.getElementById("fecha").innerHTML = new Date().toLocaleDateString('es-ES', options);
      </script>
      <table class="table table-hover" id="tabla-programacion">
      </table>
    </div>

    <div id="nueva-programacion">
      <!-- Modal -->
      <div class="modal" id="modal-nueva-programacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="exampleModalLabel">Crear programación de unidades</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="div" id="importarArchivo">
                <h5>Importar archivo</h5>
                <form id="formArchivo" class="row g-3 form-floating">
                  <div class="col-auto">
                    <input class="form-control" type="file" id="inputArchivo" accept=".xlsx, .xls" onchange="validarColumnasExcel()" />
                  </div>
                  <div class="col-auto">
                    <button class="btn btn-success mb-3" type="button" onclick="leerExcel()">Leer</button>
                  </div>
                  <div id="btnDescargar" class="col-auto col-6">
                    <button type="button" class="btn btn-outline-success">Descargar formato</button>
                    <div id="imagenFormato">
                      <img src="images/foto_formato.png" alt="Imagen de formato" class="img-fluid">
                    </div>
                  </div>


                </form>

                <div id="resultados"></div>
              </div>
              <div class="div" id="agregar-manualmente">
                <h5 id="label-manualmente">Agregar registros manualmente</h5>
                <div class="col-2">
                  <button class="btn btn-success mb-3" type="button" id="btnAgregar" onclick="agregarManualmente()">+</button>
                </div>
                <div id="result-form-traslado">

                </div>
              </div>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
              <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="btnModalguardar" onclick="guardarProgramacionExcel()">Guardar cambios</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="ModalEditar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Editar</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="row g-3" id="FormEditar">
            <label for="DestinoFecha">Fecha de expedición:</label>
            <input type="text" id="Fecha_expedicion" name="Fecha_expedicion">
            <label for="Traslado">Traslado:</label>
            <input type="text" id="Traslado" name="Traslado" required readonly>
            <label for="Cliente">Cliente:</label>
            <input type="text" id="Cliente" name="Cliente">
            <label for="Pollos">Pollos:</label>
            <input type="text" id="Pollos" name="Pollos">
            <label for="Granja">Granja:</label>
            <input type="text" id="Granja" name="Granja">
            <label for="Lote">Lote:</label>
            <input type="text" id="Lote" name="Lote">
            <label for="Destino">Destino:</label>
            <input type="text" id="Destino" name="Destino">

            <label for="campo2">Unidad:</label>
            <input type="text" id="Unidad" name="Unidad">
            <label for="campo2">Remolq.:</label>
            <input type="text" id="Remolq" name="Remol" onchange="autocompletarRemolq()">
            <label for="campo2">Placas plana:</label>
            <input type="text" class="placas_plana" id="Placas_plana" name="Placas_plana" readonly>

            <label for="campo2">Operador:</label>
            <input type="text" id="Operador" name="Operador">
            <label for="campo2">Rejas</label>
            <input type="text" id="Rejas" name="Rejas">
            <label for="campo2">Permisionario :</label>
            <input type="text" id="Permisionario" name="Permisionario">
            <label for="campo2">Folio :</label>
            <input type="text" id="Folio" name="Folio">
            <label for="campo2">Estatus :</label>
            <input type="text" id="Estatus" name="Estatus">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-success" onclick="guardarCambios()">Guardar cambios</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal con Parentesis -->
  <div class="modal fade" id="modalConParentesis" tabindex="-1" role="dialog" aria-labelledby="modalConParentesisLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalConParentesisLabel">Datos con Paréntesis</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Aquí se mostrará la tabla con datos que contienen paréntesis -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Incluye la biblioteca SheetJS (xlsx) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
  </head>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

  <script src="js/js_lyt.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>