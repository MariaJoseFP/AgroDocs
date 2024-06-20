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
                mostrarInfoConstancia( response.data,response.datos_unidad, response.datos_granja, response.datos_cliente)
                //ENVIA LOS DATOS QUE YA SE OBTUVIERON EN LA FUNCION ANTERIOR
                //generarConstancia(response);
            } else {
                console.error('Error al obtener datos del servidor');
            }
        },
        error: function (error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
}
function generarConstancia(datos) {

    var data = JSON.stringify(datos.data);
    var granja = JSON.stringify(datos.datos_granja);
    var cliente = JSON.stringify(datos.datos_cliente);

    // Realiza la solicitud AJAX
    $.ajax({
        url: 'php/generarDatosConstancia.php',
        type: 'GET',
        data: { data: data, granja: granja, cliente: cliente },
        success: function (response) {
            // Verifica si la respuesta es válida
            if (response.status === 'success') {
             mostrarInfoConstancia(data, response.datosUnidad, granja, cliente);
            } else {
                console.error('Error al obtener datos del servidor');
            }
        },
        error: function (error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
}
function generarGuia(datos) {


}

function mostrarInfoAviso(response) {

    // Obtén el elemento card-body
    var CardBody = document.getElementById('card-aviso');


    // Lista de textos CON LA INFORMACIÓN TRAIDA DE LA BASE DE DATOS
    var textosMercancia = ['ESPECIE: AVICOLA', 'NOMBRE: ANIMALES VIVOS', 'CANTIDAD: ' + response.data['Pollos'] + ' CABEZAS'];
    var textosOrigen = ['ESTABLECIMIENTO: ' + response.datos_granja['granja'], 'ESTADO: ' + response.datos_granja['estado'], 'MUNICIPIO: ' + response.datos_granja['municipio']];
    var textosDestino = ['NOMBRE O RAZÓN SOCIAL: ' + response.datos_cliente['CLIENTE'], 'ESTADO: ' + response.datos_cliente['ESTADO'], 'MUNICIPIO: ' + response.datos_cliente['MUNICIPIO']];



    // Recorre la lista de textos y crea elementos <p> para cada uno
    textosMercancia.forEach(function (texto) {
        // Crea un nuevo elemento <p>
        var nuevoParrafo = document.createElement('p');

        // Agrega el texto al elemento <p>
        nuevoParrafo.textContent = texto;

        // Agrega el nuevo elemento <p> al card-body
        CardBody.appendChild(nuevoParrafo);
    });

    // textos para los elementos <h6>
    var T1 = document.createElement('h6');
    T1.textContent = 'ORIGEN DE LA MERCANCÍA';
    var T2 = document.createElement('h6');
    T2.textContent = 'DESTINO DE LA MERCANCÍA';


    CardBody.appendChild(T1);

    textosOrigen.forEach(function (texto) {
        // Crea un nuevo elemento <p>
        var nuevoParrafo = document.createElement('p');

        // Agrega el texto al elemento <p>
        nuevoParrafo.textContent = texto;

        // Agrega el nuevo elemento <p> al card-body
        CardBody.appendChild(nuevoParrafo);
    });

    CardBody.appendChild(T2);

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

    // Obtén el elemento card-body
    var CardBody2 = document.getElementById('card-constancia');


 // Lista de textos CON LA INFORMACIÓN TRAIDA DE LA BASE DE DATOS

    var T1 = document.createElement('h6');
    T1.textContent = 'CONTANCIA DE LAVADO Y DESINFECCIÓN PARA VEHÍCULOS';
    CardBody2.appendChild(T1);

    var textosFechas= ['FECHA DE EXPEDICIÓN: '+ datosP['Fecha_expedicion'],'FECHA DE VIGENCIA: '+ datosP['Fecha_vigencia']];
    textosFechas.forEach(function (texto) {
        // Crea un nuevo elemento <p>
        var nuevoParrafo = document.createElement('p');

        // Agrega el texto al elemento <p>
        nuevoParrafo.textContent = texto;

        // Agrega el nuevo elemento <p> al card-body
        CardBody2.appendChild(nuevoParrafo);
    });
   
    var T2 = document.createElement('strong');
    T2.textContent = 'Datos de la unidad';
    CardBody2.appendChild(T2);

    for (var clave in datosU) {
        if (datosU.hasOwnProperty(clave)) {
            var parrafo = document.createElement("p");
            parrafo.innerHTML = "<strong>" + clave + ":</strong> " + datosU[clave];
            CardBody2.appendChild(parrafo);
        }
    }

    var textoDestino= ['PROPIETARIO O RESPONSABLE DEL VEHÍCULO : '+ datosC['CLIENTE'],
                        'DOMICILIO: '+ datosC['LOCALIDAD'],
                        'MUNICIPIO: '+ datosC['MUNICIPIO'],
                        'ESTADO: '+ datosC['ESTADO']
                    
                        ];

    textoDestino.forEach(function (texto) {
        // Crea un nuevo elemento <p>
        var nuevoParrafo = document.createElement('p');

        // Agrega el texto al elemento <p>
        nuevoParrafo.textContent = texto;

        // Agrega el nuevo elemento <p> al card-body
        CardBody2.appendChild(nuevoParrafo);
    });

}
