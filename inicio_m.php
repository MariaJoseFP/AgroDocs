<?php

//ESTA ES LA INTERFAZ DONDE SE PUEDE REALIZAR :
/*
    1-CONSULTAR LA PROGRAMACION Y GENERAR LOS DOCUMENTOS
    2-VER EL REGISTRO HISTORICO DE LAS CONSTANCIAS Y GUIAS GENERADAS
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
    <title>Movilización</title>
    <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="css/css.css">
    <link rel="icon" href="logo-audace.ico" type="image/x-icon">
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top navbar-dark">
        <div class="container mt-1 mb-1 ">
            <img src="images/logo audace.png" alt="Logo de Audace" class="navbar-logo" width="40" height="40" style="margin-right: 10px;">
            <a class="navbar-brand" href="inicio_m.php">
                Movilización
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav ms-auto"> <!-- Alinea 'Cerrar sesión' a la derecha -->

                    <li class="nav-item">
                        <a class="nav-link"  onclick="verDocs('constancias')" style="font-size: medium;">Constancias de lavado</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="verDocs('guias')" style="font-size: medium;">Guías de traslado</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto"> <!-- Alinea 'Cerrar sesión' a la derecha -->

                    <li class="nav-item">
                        <a class="nav-link active" href="inicio_m.php" style="font-size: medium;">Inicio</a>
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
                    <div class="card-body">
                        <h5 class="card-title">Ver programación</h5>
                        <p class="card-text">Programación de unidades y generación de formatos.</p>
                    </div>
                </div>
            </div>


            <div class="col-md-3 mb-4">
                <div class="card" onclick="verDocs('constancias')">
                    <img src="images/lavado.png" class="card-img-top mt-3 imgBd" alt="Imagen de la card" style="width: 40%" ;>
                    <div class="card-body">
                        <h5 class="card-title">Constancias</h5>
                        <p class="card-text">Registro de constancias de lavado y desinfección emitidas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card" onclick="verDocs('guias')">
                    <img src="images/entrega.png" class="card-img-top mt-3 imgBd" alt="Imagen de la card" style="width: 40%" ;>
                    <div class="card-body">
                        <h5 class="card-title">Guías de traslado</h5>
                        <p class="card-text"> Registro de guías de traslado emitidas. </p>
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
        <!----AQUÍ SE VE LA PROGRAMACIÓN--->
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
            <table class="table table-hover " id="tabla-programacion">
            </table>
        </div>
        <!----AQUÍ SE VEN LAS CONSTANCIAS--->
        <div class="oculto col-md-12" id="div-constancias">
            <h2>Constancias de lavado y desinfección</h2>


            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="cHoy-tab" data-bs-toggle="tab" data-bs-target="#cHoy-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Hoy</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cRango-tab" data-bs-toggle="tab" data-bs-target="#cRango-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Rango de fechas</button>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active mt-4" id="cHoy-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <h5 id="fecha2"></h5>
                    <script>
                        document.getElementById("fecha2").innerHTML = new Date().toLocaleDateString('es-ES', options);
                    </script>
                    <table class="table table-hover " id="tabla-constancias">
                    </table>
                    <div class="auto d-flex justify-content-end" id="div-btn-excel1">

                    </div>
                </div>
                <div class="tab-pane fade mt-4" id="cRango-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                    <label for="fechaInicio">Fecha de inicio:</label>
                    <input type="date" id="fechaInicio" name="fechaInicio">

                    <label for="fechaFin">Fecha de fin:</label>
                    <input type="date" id="fechaFin" name="fechaFin">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="VerDocRango('constancias', 'fechaInicio', 'fechaFin')">Buscar</button>
                    <table class="table table-hover mt-3" id="tabla-constancias2">
                    </table>
                    <div class="auto d-flex justify-content-end" id="div-btn-excel3">
                        <button class="btn btn-outline-success btn-descargar mt-3 oculto" id="btn-3" onclick="descargarExcelRango('constancias','fechaInicio', 'fechaFin')">Descargar Excel</button>
                    </div>
                </div>

            </div>
        </div>
        <!------AQUÍ SE VEN LAS GUÍAS--->
        <div class="oculto col-md-12" id="div-guias">
            <h2>Guías de traslado</h2>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-guiaHoy-tab" data-bs-toggle="tab" data-bs-target="#nav-guiaHoy" type="button" role="tab" aria-controls="nav-guiaHoy" aria-selected="true">Hoy</button>
                    <button class="nav-link" id="nav-guiaRango-tab" data-bs-toggle="tab" data-bs-target="#nav-guiaRango" type="button" role="tab" aria-controls="nav-guiaRango" aria-selected="false">Rango de fechas</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active mt-4" id="nav-guiaHoy" role="tabpanel" aria-labelledby="nav-guiaHoy-tab" tabindex="0">
                    <h5 id="fecha3"></h5>
                    <script>
                        document.getElementById("fecha3").innerHTML = new Date().toLocaleDateString('es-ES', options);
                    </script>
                    <table class="table table-hover " id="tabla-guias">
                    </table>
                    <div class="auto d-flex justify-content-start" id="div-btn-excel2">

                    </div>
                </div>
                <div class="tab-pane fade mt-4" id="nav-guiaRango" role="tabpanel" aria-labelledby="nav-guiaRango-tab" tabindex="0">
                    <label for="fechaInicio">Fecha de inicio:</label>
                    <input type="date" id="fechaInicio2" name="fechaInicio2">

                    <label for="fechaFin">Fecha de fin:</label>
                    <input type="date" id="fechaFin2" name="fechaFin2">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="VerDocRango('guias', 'fechaInicio2', 'fechaFin2')">Buscar</button>
                    <table class="table table-hover mt-3" id="tabla-guias2">
                    </table>
                    <div class="auto d-flex justify-content-end" id="div-btn-excel4">
                        <button class="btn btn-outline-success btn-descargar mt-3 oculto" id="btn-4" onclick="descargarExcelRango('guias', 'fechaInicio2', 'fechaFin2')">Descargar Excel</button>
                    </div>
                </div>
            </div>

        </div>
        <div class="container oculto" id="divDocs">
            <ul class="nav nav-tabs " id="tabDocs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="aviso-tab" data-bs-toggle="tab" data-bs-target="#aviso" type="button" role="tab" aria-selected="true">Aviso de Movilización</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="constancia-tab" data-bs-toggle="tab" data-bs-target="#constancia" type="button" role="tab" aria-selected="false">Constancia de lavado y desinfección</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="guia-tab" data-bs-toggle="tab" data-bs-target="#guia" type="button" role="tab" aria-selected="false">Guía de traslado</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="aviso" role="tabpanel" aria-labelledby="home-tab">
                    <!----CARD1--->
                    <div class="card no-escalar">
                        <div class="card-body" id="card-aviso">

                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="constancia" role="tabpanel" aria-labelledby="profile-tab">
                    <!----CARD2--->
                    <div class="card no-escalar">
                        <div class="card-body" id="card-constancia">

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade " id="guia" role="tabpanel" aria-labelledby="contact-tab">
                    <!----CARD3--->
                    <div class="card auto no-escalar">
                        <div class="card-body" id="card-guia">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalMotivos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="cerrarModal()"></button>
                </div>
                <div class="modal-body">
                    <div class="row d-flex align-items-end">
                        <div class="col-4">
                            <input type="text" class="form-control oculto" id="doc-cancelar" name="doc-cancelar" readonly>
                            <input type="text" class="form-control" id="id-doc" name="id-doc" readonly>
                        </div>

                        <div class="col-8">
                            <p>Motivo de la cancelación: (max 100 caracteres)</p>
                            <input type="text" class="form-control" id="motivos-cancelacion" name="motivos-cancelacion">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn-sig-motivos" onclick="cancelarDoc()">siguiente</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluye la biblioteca SheetJS (xlsx) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script src="js/js_m.js"></script>
    <script src="js/js_m2.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/xlsx@latest/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
    <script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
</body>

</html>