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
                var elementos2 = document.getElementsByClassName("btn-cancelar");
                // Iterar sobre la colección y ocultar cada elemento
                for (var i = 0; i < elementos.length; i++) {
                    elementos[i].style.display = "none";
                    if(elementos2[i]){
                        elementos2[i].style.display = "none";
                    }
                   
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
        var traslado = datosP['Traslado'] ?? "";
        var fecha_ex = datosP['Fecha_expedicion'] ?? "";
        var fecha_vi = datosP['Fecha_vigencia'] ?? "";
        var cliente = datosC && datosC['CLIENTE'] ? datosC['CLIENTE'] : "";
        if (cliente.length > 40) {
            cliente = cliente.slice(0, 39);
        }
        var clocalidad = datosC && datosC['LOCALIDAD'] ? datosC['LOCALIDAD'] : "";
        var cmunicipio = datosC && datosC['MUNICIPIO'] ? datosC['MUNICIPIO'] : "";
        var cestado = datosC && datosC['ESTADO'] ? datosC['ESTADO'] : "";

        var marca = datosU && datosU['marca'] ? datosU['marca'] : "";
        var placas_tr = datosU && datosU['placas_tr'] ? datosU['placas_tr'] : "";
        var modelo = datosU && datosU['modelo'] ? datosU['modelo'] : "";
        var tipo_unidad = datosU && datosU['tipo_unidad'] ? datosU['tipo_unidad'] : "";


        var placas_plana = datosP && datosP['Placas_plana'] ? datosP['Placas_plana'] : "";
        var remolq = datosP && datosP['Remol'] ? datosP['Remol'] : "";

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
        $("#traslado").val(traslado);
        $("#fecha_exp").val(fecha_ex);
        $("#fecha_vig").val(fecha_vi);

        $("#marca").val(marca);
        $("#placas_tr").val(placas_tr);
        $("#modelo").val(modelo);
        $("#remolq").val(remolq);
        $("#placas_plana").val(placas_plana);
        $("#tipo_unidad").val(tipo_unidad);
        if (tipo_unidad === 'RABON' || tipo_unidad === 'RABÓN' || tipo_unidad === 'TORTON' ) {
            var campoR = document.getElementById("remolq");
            var campoP = document.getElementById("placas_plana");
            campoR.disabled = true;
            campoP.disabled = true;
            campoR.style.backgroundColor = '#F8F9F9';
            campoP.style.backgroundColor = '#F8F9F9';
        }
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
        autocompletarRemolq();
    });

}



function mostrarInfoGuia(datosP, datosU, datosG, datosC) {
    $('#card-guia').load('Forms/formDatosGuia.php', function () {
        var fecha_ex = datosP['Fecha_expedicion'] ?? "";
        var upp_psg = "AGROINDRUSTRIAS DE CORDOBA S.A DE C.V." ?? "";
        var nombre_o = datosG['granja'] ?? "";
        var estado_o = datosG['estado'] ?? "";
        var municipio_o = datosG['municipio'] ?? "";
        var localidad_o = datosG['localidad'] ?? "";
        var UPA = datosG['UPA'] ?? "";

        if (estado_o === "" && UPA == "") {
            var estado_granja = document.getElementById("estado-granja");
            estado_granja.innerHTML = "No se encontraron datos de la granja en la base de datos.";
        }

        var upp_psg_d = "XXXXXXX";
        var nombre_d = datosC['CLIENTE'] ?? "";
        if (nombre_d.length > 40) {
            nombre_d = nombre_d.slice(0, 39);
        }
        var estado_d = datosC['ESTADO'] ?? "";
        var municipio_d = datosC['MUNICIPIO'] ?? "";
        var localidad_d = datosC['LOCALIDAD'] ?? "";

        var marca = datosU['marca'] && datosU['marca'] ? datosU['marca'] : "";
        var modelo = datosU['modelo'] && datosU['modelo'] ? datosU['modelo'] : "";
        var año = datosU['modelo'] && datosU['modelo'] ? datosU['modelo'] : ""; //en el doc que trae los doc de la BD trae el valor de año con la llave de "modelo"
        var tipo_unidad = datosU['tipo_unidad'] && datosU['tipo_unidad'] ? datosU['tipo_unidad'] : "";
        var placas_tr = datosU['placas_tr'] && datosU['placas_tr'] ? datosU['placas_tr'] : "";
        var placas_plana = datosP && datosP['Placas_plana'] ? datosP['Placas_plana'] : "";
        var operador = datosP['Operador'] && datosP['Operador'] ? datosP['Operador'] : "";

        if (placas_tr === "" && marca == "" && modelo == "") {
            var estado_granja = document.getElementById("estado-unidad");
            estado_granja.innerHTML = "No se encontraron datos de la unidad en la base de datos.";
        }

        var especie = 'AVES';
        var cantidad = datosP['Pollos'] && datosP['Pollos'] ? datosP['Pollos'] : "";
        var mercancia = "AVES";
        var u_medida = "CABEZAS";
        var motivo = "ABASTO";
        var lote = datosP['Lote'] && datosP['Lote'] ? datosP['Lote'] : "";
        var antecedentes = "ANTECEDENTES PRESENTADOS";
        var factura = "XXXXXX";
        var const_enf = "XXXXXXXXXX";
        var mvz = "MVZ. RICARDO CRUZ CASTAÑEDA";

        //rellenar formulario
        $("#fecha_exp2").val(fecha_ex);
        $("#upp_o").val(upp_psg);
        $("#nombre_o").val(nombre_o);
        $("#UPA").val(UPA);
        $("#estado_o").val(estado_o);
        $("#municipio_o").val(municipio_o);

        $("#localidad_o").val(localidad_o);

        $("#nombre_d").val(nombre_d);
        $("#estado_d").val(estado_d);
        $("#municipio_d").val(municipio_d);
        $("#localidad_d").val(localidad_d);

        $("#upp_d").val(upp_psg_d);

        $("#marca2").val(marca);
        $("#año").val(año);

        $("#tipo_unidad2").val(tipo_unidad);

        $("#placas_1").val(placas_tr)
        $("#placas_2").val(placas_plana)

        var placas_1 = $("#placas_1").val();
        var placas_2 = $("#placas_2").val();

        $("#placas").val(placas_1 + "," + placas_2);
        $("#conductor").val(operador);

        $("#especie").val(especie);
        $("#cantidad").val(cantidad);
        $("#cantidad2").val(cantidad);
        $("#mercancia").val(mercancia);
        $("#unidad_medida").val(u_medida);
        $("#motivo").val(motivo);
        $("#lote").val(lote);
        $("#antec").val(antecedentes);
        $("#factura").val(factura);
        $("#const_enf").val(const_enf);
        $("#mvz2").val(mvz);

    });
    //PARA IDENTIFICAR LOS DATOS VER EL ARCHIVO generarDatosDocs.php

}

function campoVacios(formData) {
    // Verificar si algún campo está vacío
    var camposVacios = false;
    //verificar si es tracto/rabon/torton
    var remolque = $("#remolq").val();
    if(remolque == ''){
        var remolque = $("#tipo_unidad").val();
    }
   

    if (remolque === 'RABÓN' || remolque === 'RABON' || remolque === 'TORTON') {

        formData.forEach(function (value, key) {
            // Verificar si el valor es vacío o nulo exceptuando los campos no necesarios
            if (!value && key != 'placas_plana'
                && key != 'vehiculo'
                && key != 'modelo'
                && key != 'placas_2'
                && key != 'remolq'
                && key !='tipo_unidad'
                && key !='tipo_unidad2'
            ) {
                camposVacios = true;
                // Cambiar el color de fondo del campo vacío
                var campo = document.getElementById(key);
                if (campo) {
                    console.log(key);
                    campo.style.backgroundColor = '#EBEFF2'; // Colorea los campos que no se han llenado
                }
            }

        });
    } else {
        formData.forEach(function (value, key) {
            // Verificar si el valor es vacío o nulo exceptuando los campos no necesarios
            if (!value
                && key != 'vehiculo'
                && key != 'modelo'
                && key != 'tipo_unidad'
                && key !='tipo_unidad2'
            ) {
                camposVacios = true;
                // Cambiar el color de fondo del campo vacío
                var campo = document.getElementById(key);
                if (campo) {
                    console.log(key);
                    campo.style.backgroundColor = '#EBEFF2'; // Colorea los campos que no se han llenado
                }
            }

        });
    }

    return camposVacios;

}
function solicitudAjax_generarDoc(urlPHP, formData) {
    // Opciones para la solicitud AJAX
    var opciones = {
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            console.log(data);
            if (data.status === "OK") {

                // Abrir una nueva ventana o pestaña con el documento generado
                window.open('documentos/' + data.archivo, '_blank');
                console.log(data);
                setTimeout(function () {
                    eliminarArchivo(data.archivo);
                }, 10000);  // 10000 milisegundos = 10 segundos
                if (data.insert != 'OK') {
                    if (data.insert.slice(0, 15) == 'Duplicate entry') {
                        $mensaje = "El registro ya existe en la base de datos.";
                    } else {
                        $mensaje = "No se pudo guardar en la base de datos. " + data.insert;
                    }
                    alert($mensaje);
                }
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
function generarConstancia() {

    // Obtener referencia al formulario y recopilar datos
    var formulario = document.getElementById('formConstancia');
    var formData = new FormData(formulario);

    // Verificar si algún campo está vacío
    var camposVacios = campoVacios(formData);

    // Enviar datos solo si no hay campos vacíos
    if (!camposVacios) {
        var resultado = confirm("¿Estas seguro de que quieres generar y guardar la constancia de lavado?");

        if (resultado) {
            console.log("El usuario hizo clic en Aceptar");
            var urlPHP = 'php/crear_editar_constancia.php';
            solicitudAjax_generarDoc(urlPHP, formData);
        } else {
            console.log("El usuario hizo clic en Cancelar");
        }

    } else {
        alert("Completa los campos necesarios.");
    }


}
function generarGuia() {

    // Obtener referencia al formulario y recopilar datos
    var formulario = document.getElementById('formGuia');
    var formData = new FormData(formulario);

    // Verificar si algún campo está vacío
    var camposVacios = campoVacios(formData);

    // Enviar datos solo si no hay campos vacíos
    if (!camposVacios) {
        var resultado = confirm("¿Estas seguro de que quieres generar y guardar la constancia de lavado?");

        if (resultado) {
            var urlPHP = 'php/crear_editar_guia.php';
            solicitudAjax_generarDoc(urlPHP, formData);
        } else {
            console.log("El usuario hizo clic en Cancelar");
        }

    } else {
        alert("Completa los campos necesarios.");
    }


}
function eliminarArchivo(archivo) {
    // Realizar una solicitud AJAX para eliminar el archivo
    var urlEliminar = 'php/eliminar_archivo.php?archivo=' + archivo;

    $.ajax({
        url: urlEliminar,
        method: 'GET',
        success: function (data) {
            console.log('Archivo eliminado:', data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error al eliminar el archivo:', textStatus, errorThrown);
        }
    });
}

function autocompletarRemolq() {
    var remolq = $("#remolq").val();

    if (remolq !== '') {
        $.ajax({
            type: "GET",
            url: "php/funciones_autocompletard1.php",  // Archivo PHP que realiza la consulta
            data: { remolq: remolq },
            success: function (data) {
                // Parsear la respuesta JSON
                var respuesta = JSON.parse(data);
                // Completar los campos del formulario
                $("#placas_plana").val(respuesta.placas_plana);
            },
            error: function () {
                alert("Error en la solicitud AJAX");
            }
        });
    }
}

