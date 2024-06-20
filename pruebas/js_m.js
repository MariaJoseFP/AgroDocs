function verProgramacion() {
    var elemento = document.getElementById("menu_cards");
    // Oculta el elemento cambiando su estilo
    elemento.style.display = "none";
    var elemento2 = document.getElementById("div-programacion");
    elemento2.style.display = "block";

    $.ajax({
        url: 'php/consultar_programacion.php', // Nombre del archivo PHP que manejará la consulta a la base de datos
        type: 'GET',
        success: function (response) {

            if (response.trim() === "S/R") {
                $('#tabla-programacion').html("No se encontraron resultados."); // Insertar la respuesta

            } else {
                // Mostrar la programación 
                $('#tabla-programacion').html(response); // Insertar la tabla generada en la respuesta en el contenedor
                // Obtener todos los elementos con la clase "tuClase"
                var elementos = document.getElementsByClassName("btn-editar");

                // Iterar sobre la colección y ocultar cada elemento
                for (var i = 0; i < elementos.length; i++) {
                    elementos[i].style.display = "none";
                }




            }
        },
        error: function (error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });

}
function generarAviso(btn) {
    // Obtiene el ID desde el atributo personalizado
    var id = btn.getAttribute('id');

    // Realiza la solicitud AJAX
    $.ajax({
        url: 'php/generarDatosDocs.php',
        type: 'GET',
        data: { traslado: id },
        success: function (response) {
            // Verifica si la respuesta es válida
            if (response.status === 'success') {
                var div_programacion = document.getElementById("div-programacion");
                div_programacion.style.display = "none";
                var TabDocs = document.getElementById("divDocs");
                TabDocs.style.display = "block";

                mostrarInfoAviso(response);
                mostrarInfoConstancia(response.data, response.datos_unidad, response.datos_granja, response.datos_cliente)
                mostrarInfoGuia(response.data, response.datos_unidad, response.datos_granja, response.datos_cliente);
            } else {
                console.error('Error al obtener datos del servidor');
            }
        },
        error: function (error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
}

function mostrarInfoAviso(response) {

    // Obtén el elemento card-body
    var CardBody = document.getElementById('card-aviso');
    // Lista de textos CON LA INFORMACIÓN TRAIDA DE LA BASE DE DATOS
    var textosMercancia = ['ESPECIE: AVICOLA', 'NOMBRE: ANIMALES VIVOS', 'CANTIDAD: ' + response.data['Pollos'] + ' CABEZAS'];
    // Recorre la lista de textos DE LA MERCANCIA y crea elementos <p> para cada uno
    textosMercancia.forEach(function (texto) {
        // Crea un nuevo elemento <p>
        var nuevoParrafo = document.createElement('p');

        // Agrega el texto al elemento <p>
        nuevoParrafo.textContent = texto;

        // Agrega el nuevo elemento <p> al card-body
        CardBody.appendChild(nuevoParrafo);
    });


    //DATOS DE ORIGEN
    var T1 = document.createElement('h6');
    T1.textContent = 'ORIGEN DE LA MERCANCÍA';
    CardBody.appendChild(T1);


    if (response.datos_granja != null) {
        var textosOrigen = ['ESTABLECIMIENTO: ' + response.datos_granja['granja'],
        'ESTADO: ' + response.datos_granja['estado'],
        'MUNICIPIO: ' + response.datos_granja['municipio']];

        textosOrigen.forEach(function (texto) {
            // Crea un nuevo elemento <p>
            var nuevoParrafo = document.createElement('p');

            // Agrega el texto al elemento <p>
            nuevoParrafo.textContent = texto;

            // Agrega el nuevo elemento <p> al card-body
            CardBody.appendChild(nuevoParrafo);
        });
    }

    //DATOS DE DESTINO

    var T2 = document.createElement('h6');
    T2.textContent = 'DESTINO DE LA MERCANCÍA';
    CardBody.appendChild(T2);

    var cliente = response.datos_cliente && response.datos_cliente['CLIENTE'] ? response.datos_cliente['CLIENTE'] : " ";
    var estado = response.datos_cliente && response.datos_cliente['ESTADO'] ? response.datos_cliente['ESTADO'] : " ";
    var municipio = response.datos_cliente && response.datos_cliente['MUNICIPIO'] ? response.datos_cliente['MUNICIPIO'] : " ";

    var textosDestino = ['NOMBRE O RAZÓN SOCIAL: ' + cliente,
    'ESTADO: ' + estado,
    'MUNICIPIO: ' + municipio];




    textosDestino.forEach(function (texto) {
        // Crea un nuevo elemento <p>
        var nuevoParrafo = document.createElement('p');

        // Agrega el texto al elemento <p>
        nuevoParrafo.textContent = texto;

        // Agrega el nuevo elemento <p> al card-body
        CardBody.appendChild(nuevoParrafo);
    });

    var Enlace = document.createElement('a');

    // Asigna la URL deseada al atributo href
    Enlace.href = 'https://sistemasssl.senasica.gob.mx/snam/login.xhtml';
    Enlace.target = '_blank'
    // Asigna el texto del enlace
    Enlace.textContent = 'Sistema Nacional de Avisos de Movilización';
    CardBody.appendChild(Enlace);

}


function mostrarInfoConstancia(datosP, datosU, datosG, datosC) {

    // Carga el formulario desde otro documento
    $('#card-constancia').load('Forms/formDatosConstancia.php', function () {
        // Callback que se ejecuta después de cargar el formulario

        //VARIABLES
        var fecha_ex = datosP['Fecha_expedicion'] ?? "";
        var fecha_vi = datosP['Fecha_vigencia'] ?? "";
        var cliente = datosC && datosC['CLIENTE'] ? datosC['CLIENTE'] : "";
        var clocalidad = datosC && datosC['LOCALIDAD'] ? datosC['LOCALIDAD'] : "";
        var cmunicipio = datosC && datosC['MUNICIPIO'] ? datosC['MUNICIPIO'] : "";
        var cestado = datosC && datosC['ESTADO'] ? datosC['ESTADO'] : "";

        var marca = datosU && datosU['marca'] ? datosU['marca'] : "";
        var placas_tr = datosU && datosU['placas_tr'] ? datosU['placas_tr'] : "";
        var modelo = datosU && datosU['modelo'] ? datosU['modelo'] : "";
        var placas_plana = datosU && datosU['placas_plana'] ? datosU['placas_plana'] : "";

        if (marca === "" && placas_tr === "" && modelo === "" && placas_plana === "") {
            var estado_vehiculo = document.getElementById("estado-vehiculo");
            estado_vehiculo.innerHTML = "No se encontraron datos de la unidad en la base de datos.";
        }


        var granja = datosG && datosG['granja'] ? datosG['granja'] : "";

        var tipo_carga = "ANIMALES EN PIE";
        var desinf = "URCARSAN PLUS";
        var activo = "GLUTARALDEHIDO BASE 50, CUATERNARIO DE AMONIO DE 4ta. GENERACION";
        var concent = "500gr. EN  Ltr. DE AGUA";
        var tiempo = "24 HORAS";
        var mvz = "MVZ. RICARDO CRUZ CASTAÑEDA";
        var clave_aut = "MR-0922-30-026-03";

        //rellenar formulario
        $("#fecha_exp").val(fecha_ex);
        $("#fecha_vig").val(fecha_vi);
        $("#marca").val(marca);
        $("#placas_tr").val(placas_tr);
        $("#modelo").val(modelo);
        $("#placas_plana").val(placas_plana);
        $("#granja").val(granja);
        $("#cliente").val(cliente);
        $("#localidad").val(clocalidad);
        $("#municipio").val(cmunicipio);
        $("#estado").val(cestado);
        $("#tipo_carga").val(tipo_carga);
        $("#desinf").val(desinf);
        $("#activo").val(activo);
        $("#concent").val(concent);
        $("#tiempo").val(tiempo);
        $("#mvz").val(mvz);
        $("#clave_aut").val(clave_aut);
    });

}



function mostrarInfoGuia(datosP, datosU, datosG, datosC) {

    //PARA IDENTIFICAR LOS DATOS VER EL ARCHIVO generarDatosDocs.php

    // Obtén el elemento card-body
    var CardBody3 = document.getElementById('card-guia');

    // Lista de textos CON LA INFORMACIÓN TRAIDA DE LA BASE DE DATOS
    var T1 = document.getElementById('cardTitulo1');
    T1.textContent = 'REGISTRO EN EL ESTADO DE VERACRUZ';
    var T2 = document.getElementById('cardTitulo2');
    T2.textContent = 'DATOS DEL TRANSPORTE';
    var T3 = document.getElementById('cardTitulo3');
    T3.textContent = 'DATOS DE LA MOVILIZACIÓN';
    var T4 = document.getElementById('cardTitulo4');
    T4.textContent = 'IDENTIFICACIÓN INDIVIDUAL DE LOS ANIMALES MOVILIZADOS';


    var contenedor1 = document.getElementById('list1');
    var contenedor2 = document.getElementById('list2');
    var contenedor3 = document.getElementById('list3');
    var contenedor4 = document.getElementById('list4');

    if (datosG != null) {
        var textoRemitente =
            [
                'UPP/PSG: ' + 'AGROINDRUSTRIAS DE CORDOBA S.A DE C.V',
                'NOMBRE : ' + datosG['granja'] + ' (' + datosG['UPA'] + ') ',
                'ESTADO: ' + datosG['estado'],
                'MUNICIPIO: ' + datosG['municipio']

            ];
    } else {
        var UPA = " ";
    }

    if (datosC != null) {
        var textoDestino =
            [
                'NOMBRE : ' + datosC['CLIENTE'],
                'ESTADO: ' + datosC['ESTADO'],
                'MUNICIPIO: ' + datosC['MUNICIPIO']

            ];
    }



    if (datosU != null) {
        var marca = datosU['marca'] && datosU['marca'] ? datosU['marca'] : " ";
        var modelo = datosU['modelo'] && datosU['modelo'] ? datosU['modelo'] : " ";
        var placas_tr = datosU['placas_tr'] && datosU['placas_tr'] ? datosU['placas_tr'] : " ";
        var placas_plana = datosU['placas_plana'] && datosU['placas_plana'] ? datosU['placas_plana'] : " ";
        var operador = datosU['placas_plana'] && datosU['placas_plana'] ? datosU['placas_plana'] : " ";

        var textoTransporte =
            [
                'MARCA : ' + marca,
                'AÑO: ' + modelo,
                'COLOR: ' + " ",
                'PLACAS: ' + placas_tr + "," + placas_plana,
                'NOMBRE DEL CONDUCTOR: ' + operador


            ];
    }
    var textoMovilizacion =
        [
            'ESPECIE : ' + 'AVES',
            'CANTIDAD: ' + datosP['Pollos'],
            'MERCANCÍA: ' + "AVES",
            'UNIDAD DE MEDIDA : ' + "CABEZAS",
            'MOTIVO DE TRANSPORTE: ' + 'ABASTO'


        ];

    var textoIdentificacion =
        [
            'ESTE VEHICULO FUE LAVADO Y DESINFECTADO ',
            'EL VEHICULO VIAJA DE DIA Y DE NOCHE',
            'No. DE CONSTANCIA DE LAVADO Y DESINFECCION DEL VEHICULO: ',
            'No. DE REGISTRO DE LA PLANTA DE ORIGEN' + UPA,
            'LOTE: ' + datosP['Lote'],
            'UNIDAD DE MEDIDA : ' + "CABEZAS",
            'MOTIVO DE TRANSPORTE: ' + 'ABASTO'

        ];

    escribirListas(textoRemitente, contenedor1, "REMITENTE");
    escribirListas(textoDestino, contenedor1, "DESTINATARIO");
    escribirListas(textoTransporte, contenedor2, "");
    escribirListas(textoMovilizacion, contenedor3, "");
    escribirListas(textoIdentificacion, contenedor4, "");

}

function escribirListas(texto, contenedor, nombre) {
    if (texto === null || texto === undefined) {
        // Manejar la excepción o simplemente retornar sin hacer nada
        console.error('El arreglo es nulo o indefinido.');
        return;
    } else {
        var Titulo = document.createElement('P');
        Titulo.textContent = nombre;
        Titulo.style.color = 'blue';
        contenedor.appendChild(Titulo);
        texto.forEach(function (texto) {
            // Crea un nuevo elemento <p>
            var nuevoParrafo = document.createElement('li');
            // Agrega el texto al elemento <p>
            nuevoParrafo.textContent = texto;
            nuevoParrafo.className = 'list-group-item';
            // Agrega el nuevo elemento <p> al card-body
            contenedor.appendChild(nuevoParrafo);
        });
    }

}

function generarConstancia() {
    console.log("Generando constancia...");

    // Obtener referencia al formulario y recopilar datos
    var formulario = document.getElementById('formConstancia');
    var formData = new FormData(formulario);

    // Imprimir datos en la consola
    formData.forEach(function (value, key) {
        console.log(key + ': ' + value);
    });

    var urlPHP = 'php/crear_editar_constancia.php';

    // Opciones para la solicitud AJAX
    var opciones = {
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            console.log(data.status);
            if (data.status === "OK") {
                alert("Los datos se han guardado correctamente.");
                // Abrir una nueva ventana o pestaña con el documento generado
                window.open('documentos/contanciaLavado_documento_editado.docx', '_blank');
            } else {
                console.error('Error en la solicitud AJAX:', data.status);
                alert("Error al procesar la solicitud. Consulta la consola para más detalles.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
            alert("Error en la solicitud AJAX. Consulta la consola para más detalles.");
        }
    };

    // Realizar la solicitud AJAX
    $.ajax(urlPHP, opciones);
}
