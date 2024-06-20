<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Movilización</title>
    <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="css/css.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Movilización</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto"> <!-- Alinea 'Inicio' a la izquierda -->
                    <li class="nav-item">
                        <a class="nav-link" href="inicio_m.php">Inicio</a>
                    </li>
                   
                </ul>
                <ul class="navbar-nav ms-auto"> <!-- Alinea 'Cerrar sesión' a la derecha -->
                    <li class="nav-item">
                        <a class="nav-link" href="php/logout.php">Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row text-center" id="menu_cards">
            <div class="col-md-3 mb-4">
                <div class="card" onclick="verProgramacion()">
                    <img src="images/calendario.png" class="card-img-top mt-2" alt="Imagen de la card" style="width: 40%" ;>
                    <div class="card-body">
                        <h5 class="card-title">Ver programación</h5>
                        <p class="card-text">Programación de unidades (aves)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card" onclick="verDocs('constancias')">
                    <img src="images/lavado1.png" class="card-img-top mt-2" alt="Imagen de la card" style="width: 40%" ;>
                    <div class="card-body">
                        <h5 class="card-title">Constancias</h5>
                        <p class="card-text">Constancias de lavado y desinfección emitidas</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card" onclick="verDocs('guias')">
                    <img src="images/ruta.png" class="card-img-top mt-2" alt="Imagen de la card" style="width: 40%" ;>
                    <div class="card-body">
                        <h5 class="card-title">Guías de transito</h5>
                        <p class="card-text">Guías de transito emitidas</p>
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
            <h5 id="fecha2"></h5>
            <script>
                document.getElementById("fecha2").innerHTML = new Date().toLocaleDateString('es-ES', options);
            </script>
            <table class="table table-hover " id="tabla-constancias">
            </table>
            <div class="auto d-flex justify-content-end" id="div-btn-excel1">
                
            </div>
            <div class="row text-center" id="menu_cards2">
                <div class="col-md-3 mb-4">
                    <div class="card" onclick="verContanciasHoy()">
                        <img src="images/calendario.png" class="card-img-top mt-2" alt="Imagen de la card" style="width: 40%" ;>
                        <div class="card-body">
                            <h5 class="card-title">Ver programación</h5>
                            <p class="card-text">Programación de unidades (aves)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card" onclick="verContanciasRango('constancias')">
                        <img src="images/lavado1.png" class="card-img-top mt-2" alt="Imagen de la card" style="width: 40%" ;>
                        <div class="card-body">
                            <h5 class="card-title">Constancias</h5>
                            <p class="card-text">Constancias de lavado y desinfección emitidas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="oculto col-md-12" id="div-guias">
            <h2>Guías de traslado</h2>
            <h5 id="fecha3"></h5>
            <script>
                document.getElementById("fecha3").innerHTML = new Date().toLocaleDateString('es-ES', options);
            </script>
            <table class="table table-hover " id="tabla-guias">
            </table>
            <div class="auto d-flex justify-content-start" id="div-btn-excel2">
                
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
                    <div class="card">
                        <div class="card-body" id="card-aviso">

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="constancia" role="tabpanel" aria-labelledby="profile-tab">
                    <!----CARD2--->
                    <div class="card">
                        <div class="card-body" id="card-constancia">

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade " id="guia" role="tabpanel" aria-labelledby="contact-tab">
                    <!----CARD3--->
                    <div class="card auto">
                        <div class="card-body" id="card-guia">

                        </div>
                    </div>
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