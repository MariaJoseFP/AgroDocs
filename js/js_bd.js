function verTabs(tabla) {
    var elemento = document.getElementById("menu_cards_bd");
    // Oculta el elemento cambiando su estilo
    elemento.style.display = "none";
    var elemento2 = document.getElementById("div-" + tabla);
    elemento2.style.display = "block";

    $("#flecha1").css("display","block");

    initializeDataTable(tabla);

}

function initializeDataTable(tableId) {
    $.extend($.fn.dataTable.defaults, {
        language: {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });

    $.ajax({
        url: 'get_data_bd.php',
        type: 'GET',
        dataType: 'json',
        data: {
            tabla: tableId
        },
        success: function (response) {
            data = response.data;
            if (data.length > 0) {
                var columns = Object.keys(data[0]);
                var dataTableColumns = columns.map(function (column) {
                    return {
                        data: column,
                        type: column === 'NUMERO_UNIDAD' ? 'num' : 'string'
                    };
                });

                // Destroy the existing DataTable if it exists
                if ($.fn.DataTable.isDataTable('#' + tableId)) {
                    $('#' + tableId).DataTable().destroy();
                }

                // Initialize DataTable with dynamic columns
                var table = $('#' + tableId).DataTable({
                    columns: dataTableColumns,
                    paging: true,
                    dom: 'lfrtBipr',
                    buttons: [{
                        extend: 'csv',
                        text: 'Exportar CSV',
                        className: 'btn-warning'
                    }]
                });

                // Fill the table with data
                table.rows.add(data).draw();

                // Agregar enlaces "Editar" a cada fila
                $('#' + tableId + ' tbody').on('click', 'tr', function () {
                    var rowData = table.row(this).data();
                    var clave = "";

                    switch (tableId) {
                        case 'unidades':
                            clave = rowData.NUMERO_UNIDAD;
                            break;
                        case 'clientes':
                            clave = rowData.CLIENTE;
                            break;
                        case 'granjas':
                            clave = rowData.UPA;
                            break;
                        default:
                            console.log("Opción no válida");
                    }


                    editarRegistro(clave, tableId);
                    // Redirigir a la página de edición con el número económico
                    //   window.location.href = 'editar.php?numero_economico=' + numeroEconomico;
                }).css({
                    'cursor': 'pointer'
                });
            } else {
                console.log('No data available.');
            }
        },
        error: function (error) {
            console.log('Error en la petición AJAX:', error);
        }
    });

    $('#searchInput-' + tableId).on('keyup', function () {
        $('#' + tableId).DataTable().search($(this).val()).draw();
    });

}

function editarRegistro(clave, tablaID) {

    // Realiza la solicitud AJAX
    $.ajax({
        url: 'get_data_bd.php',
        type: 'GET',
        data: { clave: clave, tablaID: tablaID },
        success: function (response) {
            // Verifica si la respuesta es válida
            if (response.status === 'success') {
                // Crea el formulario con los datos obtenidos
                //crearFormulario(response.data, tablaID, clave);
                crearOActualizarModal(response.data, tablaID, clave)
            } else {
                console.error('Error al obtener datos del servidor');
            }
        },
        error: function (error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
}

// Función para crear o actualizar el contenido del modal
function crearOActualizarModal(data, tabla, clave) {
    data = data[0];

    var modal = $('#formularioModalEditar');

    // Limpiar el contenido actual del modal
    modal.find('.modal-body').empty();

    // Crear un formulario dinámico dentro del modal
    var form = $('<form>');

    // Iterar sobre las propiedades del objeto
    Object.keys(data).forEach(function (key) {
        form.append($('<label>').text(key.replace(/_/g, ' ').toUpperCase()));
        form.append($('<input>').attr('type', 'text').attr('name', key).val(data[key]).addClass('form-control'));
    });

    // Agregar botón de enviar al pie del formulario
    form.append($('<div class="form-group text-right mt-2">').append($('<button>').attr('type', 'submit').text('Guardar').addClass('btn btn-success')));

    // Manejar el evento submit del formulario
    form.submit(function (event) {
        event.preventDefault();

        var updatedData = {};
        form.serializeArray().forEach(function (item) {
            updatedData[item.name] = item.value;
        });

        $.ajax({
            url: 'editarRegistro.php',
            type: 'POST',
            data: {
                datosTablas: updatedData,
                tabla: tabla,
                clave: clave
            },
            success: function (response) {
                if (response.status == "Éxito") {
                    $('#alert-success-edit').show();
                    $('#dismiss-modal-editado').show();
                    // location.reload(true);
                } else {
                    console.log(data);
                    alert(data.status);
                }
            },
            error: function (error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });

    // Agregar el formulario al cuerpo del modal
    modal.find('.modal-body').append(form);

    // Mostrar el modal
    modal.modal('show');
    
}

function AgregarRegistrosTab(tipoRegistro) {
    var modal = $('#formularioModalAgregar');

    // Limpiar el contenido actual del modal
    modal.find('.modal-body').empty();

    // Crear un formulario dinámico dentro del modal
    var form = $('<form>');

    // Iterar sobre las propiedades del objeto (fields of the form)
    switch (tipoRegistro) {
        case 'unidades':
            var fields = ['NUMERO_UNIDAD', 'RAZON_SOCIAL', 'TIPO_UNIDAD', 'MARCA', 'MODELO', 'AÑO', 'PLACAS_TR', 'PLACAS_PLANA', 'ÁREA', 'RESPONSABLE', 'NUM_REJAS', 'REJAS_PROPIAS/AGRO', 'FECHA_PRESTAMO', 'OBSERVACION'];
            break;
        case 'clientes':
            var fields = ['CLIENTE', 'LOCALIDAD', 'MUNICIPIO', 'ESTADO'];
            break;
        case 'granjas':
            var fields = ['GRANJA', 'UPA', 'LOCALIDAD', 'MUNICIPIO', 'ESTADO'];
            break;
        default:
            // code block
    }

    fields.forEach(function (key) {
        // Crear etiqueta
        var labelElement = $('<label>').text(key.replace(/_/g, ' ').toUpperCase());
    
        // Crear input
        var inputElement = $('<input>').attr('type', 'text').attr('name', key).addClass('form-control');
    
        // Agregar evento onkeyup al input
        inputElement.on('keyup', function () {
            // Aquí puedes agregar la lógica que deseas realizar cuando se suelta una tecla
            onkeyup=this.value = this.value.toUpperCase();
        });
    
        // Agregar etiqueta e input al formulario
        form.append(labelElement);
        form.append(inputElement);
    });
    // Agregar botón de enviar al pie del formulario
    form.append($('<div class="form-group text-right mt-2">').append($('<button>').attr('type', 'submit').text('Guardar').addClass('btn btn-success')));

    // Manejar el evento submit del formulario
    form.submit(function (event) {
        event.preventDefault();

        // Validar que los campos principales no estén vacíos
        var mainFields = ['NUMERO_UNIDAD', 'CLIENTE', 'UPA']; // Agrega los campos principales
        if (!mainFields.some(field => form.find(`[name="${field}"]`).val())) {
            alert('Al menos uno de los campos principales debe estar lleno.');
            return;
        }

        var newUnitData = {};
        form.serializeArray().forEach(function (item) {
            newUnitData[item.name] = item.value;
        });

        // Perform AJAX request to add new unit (you need to implement this)
        $.ajax({
            url: 'agregarRegistroTablas.php', // Replace with the actual endpoint for adding a unit
            type: 'POST',
            data: {
                datosTablas: newUnitData,
                tabla: tipoRegistro
            },
            success: function (response) {
                if (response.status == "OK") {
                    $('#alert-success-add').text('La unidad se ha agregado correctamente.').show();
                  
                } else {
                    console.log(response);
                    alert(response.status);
                }
            },
            error: function (error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });

    // Agregar el formulario al cuerpo del modal
    modal.find('.modal-body').append(form);

    // Mostrar el modal
    modal.modal('show');
}
