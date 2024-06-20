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
        // Crear el botón
        // Crear el botón
        var button = $('<button>', {
          text: "Crear programación",
          class: "btn btn-primary",
          id: "btn-crear-programacion",
          "data-bs-toggle": "modal",
          "data-bs-target": "#modal-nueva-programacion"
        });

        // Agregar el botón al contenedor
        $('#div-programacion').append(button);

      } else {
        // Mostrar la programación 
        $('#tabla-programacion').html(response); // Insertar la tabla generada en la respuesta en el contenedor
        var button = $('<button>', {
          text: "+",
          class: "btn btn-primary",
          id: "btn-crear-programacion",
          "data-bs-toggle": "modal",
          "data-bs-target": "#modal-nueva-programacion"
        });

        // Agregar el botón al contenedor
        $('#div-programacion').append(button);

        // Obtener todos los elementos con la clase "btn-generar"
        var btnGenerar = document.getElementsByClassName("btn-generar");

        // Recorrer los elementos y ocultarlos
        for (var i = 0; i < btnGenerar.length; i++) {
          btnGenerar[i].style.display = "none";
        }


      }
    },
    error: function (error) {
      console.error('Error en la solicitud AJAX:', error);
    }
  });

}

function leerExcel() {
  var inputFile = document.getElementById('inputArchivo');
  var resultadosContainer = document.getElementById('resultados');
  var btnModalguardar = document.getElementById('btnModalguardar');

  btnModalguardar.style.display = "block";
  var archivo = inputFile.files[0];

  if (archivo) {
    var lector = new FileReader();

    lector.onload = function (e) {
      var data = new Uint8Array(e.target.result);
      var workbook = XLSX.read(data, { type: 'array', cellDates: true });

      // Supongamos que solo hay una hoja en el archivo Excel
      var primeraHoja = workbook.SheetNames[0];

      // Obtener datos como arreglo de objetos
      var datos = XLSX.utils.sheet_to_json(workbook.Sheets[primeraHoja], { header: 1 });

      // Crear una tabla HTML
      var tablaHTML = '<table class="table table-hover">';

      // Agregar encabezados de columna
      tablaHTML += '<thead><tr>';
      for (var i = 0; i < datos[0].length; i++) {
        tablaHTML += '<th>' + datos[0][i] + '</th>';
      }
      tablaHTML += '</tr></thead>';

      // Agregar filas de datos
      tablaHTML += '<tbody>';
      for (var j = 1; j < datos.length; j++) {
        tablaHTML += '<tr>';
        for (var k = 0; k < datos[j].length; k++) {
          // Verificar si el valor es una fecha y formatearla
          var valorFormateado = (k === 0) ? moment(datos[j][k]).format('DD/MM/YYYY') : datos[j][k];
          
          tablaHTML += '<td>' + valorFormateado + '</td>';
        }
        tablaHTML += '</tr>';
      }
      tablaHTML += '</tbody>';

      // Cerrar la tabla
      tablaHTML += '</table>';

      // Mostrar la tabla en el contenedor
      resultadosContainer.innerHTML = tablaHTML;
    };

    lector.readAsArrayBuffer(archivo);
  } else {
    alert('Por favor, selecciona un archivo Excel.');
  }
}
function guardarProgramacionExcel() {
  var inputFile = document.getElementById('inputArchivo');
  
  var archivo = inputFile.files[0];
  
  if (archivo) {
    var lector = new FileReader();
  
    lector.onload = function (e) {
      var data = new Uint8Array(e.target.result);
      var workbook = XLSX.read(data, { type: 'array', cellDates: true });
  
      // Supongamos que solo hay una hoja en el archivo Excel
      var primeraHoja = workbook.SheetNames[0];
      var dateNF = 'yyyy/m/d/;@';
  
      var datos = XLSX.utils.sheet_to_json(workbook.Sheets[primeraHoja], { Fecha_expedicion: dateNF });
  
      if (!contieneParentesis(datos)) {
        // Si no hay paréntesis, guardar en la base de datos
        guardarTablaEnBD(datos);
      } else {
        // Si hay paréntesis, eliminar lo que hay dentro o mostrar alerta
        eliminarContenidoParentesis(datos);
        mostrarModalConParentesis(datos)
      }
    };
  
    lector.readAsArrayBuffer(archivo);
  } else {
    alert('Por favor, selecciona un archivo Excel.');
  }
}
function contieneParentesis(datos) {
  // Función para verificar si algún campo contiene paréntesis
  for (var j = 0; j < datos.length; j++) {
    for (var k in datos[j]) {
      if (typeof datos[j][k] === 'string' && /\(|\)/.test(datos[j][k])) {
        return true; // Al menos un campo contiene paréntesis
      }
    }
  }
  return false; // Ningún campo contiene paréntesis
}

function eliminarContenidoParentesis(datos) {
  // Función para eliminar el contenido dentro de paréntesis
  for (var j = 0; j < datos.length; j++) {
    for (var k in datos[j]) {
      if (typeof datos[j][k] === 'string' && /\(|\)/.test(datos[j][k])) {
        // Eliminar contenido dentro de paréntesis
        datos[j][k] = datos[j][k].replace(/\([^)]*\)/g, '');
      }
    }
  }

  // Mostrar alerta o realizar la acción necesaria
  alert('Se encontraron campos con paréntesis. El contenido dentro de los paréntesis ha sido eliminado.');
  // Puedes realizar otras acciones aquí, como mostrar la tabla modificada, etc.
}


function mostrarModalConParentesis(datos) {
  // Función para mostrar el modal con la información que contiene paréntesis
  var tablaHTML = '<table class="table table-hover">';
  tablaHTML += '<thead><tr>';
  for (var i = 0; i < datos[0].length; i++) {
    tablaHTML += '<th>' + datos[0][i] + '</th>';
  }
  tablaHTML += '</tr></thead>';
  tablaHTML += '<tbody>';
  for (var j = 1; j < datos.length; j++) {
    tablaHTML += '<tr>';
    for (var k = 0; k < datos[j].length; k++) {
      var valorFormateado = (k === 0) ? moment(datos[j][k]).format('DD/MM/YYYY') : datos[j][k];
      tablaHTML += '<td>' + valorFormateado + '</td>';
    }
    tablaHTML += '</tr>';
  }
  tablaHTML += '</tbody>';
  tablaHTML += '</table>';

  // Mostrar la tabla en el modal
  modalConParentesis.querySelector('.modal-body').innerHTML = tablaHTML;

  // Mostrar el modal
  $('#modalConParentesis').modal('show');
}


function guardarTablaEnBD(datos) {
  console.log(datos);
  // Ejemplo usando jQuery.ajax
  $.ajax({
    url: 'php/guardarPrograBD.php',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({ datosTabla: datos }),
    success: function (data) {
      if (data.status == "Éxito") {
        alert("Los datos se han guardado correctamente.");
        location.reload(true);
      }
      else if (data.status != "Éxito") {
        console.log(data);
        alert(data.status);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
    }
  });
}
function guardarTrasladoEnBD(datos) {

  $.ajax({
    url: 'php/guardarPrograBD.php',
    method: 'POST',
    contentType: 'application/json',
    data: JSON.stringify({ datosForm: datos }),
    success: function (data) {
      if (data.status == "Éxito") {
        alert("Los datos se han guardado correctamente.");
        location.reload(true);
      }
      else if (data.status != "Éxito") {
        console.log(data);
        alert(data.status);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
    }
  });
}
function agregarManualmente() {
  var resultadosContainer = document.getElementById('importarArchivo');
  var form3 = document.getElementById('result-form-traslado');
  var btnAgregar = document.getElementById('btnAgregar');
  var btnModalguardar = document.getElementById('btnModalguardar');

  btnAgregar.style.display = "none";
  resultadosContainer.style.display = "none";
  form3.style.display = "block";
  btnModalguardar.style.display = "none";

  fetch('Forms/formNuevoTraslado.php')
    .then(response => response.text())
    .then(data => {
      // Inserta el contenido PHP en el contenedor
      document.getElementById('result-form-traslado').innerHTML = data;
      // LLENAR LOS CAMPOS DE FECHA
      var fechaCampo = document.getElementById('Fecha_expedicion');
      // Obtener la fecha actual en formato YYYY-MM-DD
      var fechaActual = new Date().toISOString().split('T')[0];
      // Asignar la fecha actual al campo de fecha
      fechaCampo.value = fechaActual;
    })
    .catch(error => console.error('Error al cargar el script PHP:', error));


}
function autocompletarCliente() {
  var cliente = $("#Cliente").val();

  if (cliente !== '') {
    $.ajax({
      type: "GET",
      url: "php/funciones_autocompletard1.php",  // Archivo PHP que realiza la consulta
      data: { cliente: cliente },
      success: function (data) {
        // Parsear la respuesta JSON
        var respuesta = JSON.parse(data);

        // Completar los campos del formulario
        $("#Destino").val(respuesta.municipio);
      },
      error: function () {
        alert("Error en la solicitud AJAX");
      }
    });
  }
}
function autocompletarUnidad() {
  var unidad = $("#Unidad").val();
  if (unidad !== '') {
    $.ajax({
      type: "GET",
      url: "php/funciones_autocompletard1.php",  // Archivo PHP que realiza la consulta
      data: { unidad: unidad },
      success: function (data) {
        var respuesta = JSON.parse(data);

        // Completar los campos del formulario
        
        $("#tipo_unidad").val(respuesta.tipo_unidad);
        $("#Permisionario").val(respuesta.permisionario);
        $("#placa").val(respuesta.placas_tr);
        $("#marca").val(respuesta.marca);
        $("#modelo").val(respuesta.año);
        $("#placas_plana").val(respuesta.placas_plana);

        //SI NO ES PLATAFORMA DESAPARECE EL CAMPO DE REMOLQUE 
        if (respuesta.tipo_unidad == "PLATAFORMA" || respuesta.tipo_unidad == "DOLLY" || respuesta.tipo_unidad == "TRACTOCAMION") {
          $("#Remol").val(respuesta.tipo_unidad);
          $(".campos_remolq").css({
            "display": "block",
          });
        } else {
          $(".campos_remolq").css({
            "display": "none",
          });
        }
      },
      error: function () {
        alert("Error en la solicitud AJAX");
      }
    });
  }
}
function closeModal() {
  var form3 = document.getElementById('result-form-traslado');
  var btnAgregar = document.getElementById('btnAgregar'); // Agrega esta línea
  var importarArchivo = document.getElementById('importarArchivo'); // Agrega esta línea

  btnAgregar.style.display = "block";
  importarArchivo.style.display = "block";
  form3.style.display = "none";
}

function guardarTraslado() {
  // Recopilar los valores de los campos del formulario
  var fecha = document.getElementById('Fecha_expedicion').value;
  var traslado = document.getElementById('Traslado').value;
  var cliente = document.getElementById('Cliente').value;
  var pollos = document.getElementById('Pollos').value;
  var granja = document.getElementById('Granja').value;
  var lote = document.getElementById('Lote').value;
  var destino = document.getElementById('Destino').value;
  var operador = document.getElementById('Operador').value;
  var unidad = document.getElementById('Unidad').value;
  var marca = document.getElementById('marca').value;
  var modelo = document.getElementById('modelo').value;
  var placa = document.getElementById('placa').value;
  var remol = document.getElementById('Remol').value;
  var rejas = document.getElementById('Rejas').value;
  var permisionario = document.getElementById('Permisionario').value;

  if (
    traslado === "" ||
    cliente === "" ||
    pollos === "" ||
    granja === "" ||
    operador === "" ||
    unidad === ""
  ) {
    // Mostrar mensaje de error
    alert("Por favor, complete todos los campos antes de enviar el formulario.");
    return false; // Evitar que el formulario se envíe
  }

  // Verificar si los campos numéricos solo contienen números
  if (!/^\d+$/.test(traslado) || !/^\d+$/.test(pollos)) {
    alert("Por favor, ingrese solo números en los campos de Traslado y Pollos.");
    return false; // Evitar que el formulario se envíe
  }
  // Crear un objeto JSON con los datos recopilados
  var datos = {
    Fecha_expedicion: fecha,
    Traslado: traslado,
    Cliente: cliente,
    Pollos: pollos,
    Granja: granja,
    Lote: lote,
    Destino: destino,
    Operador: operador,
    Unidad: unidad,
    marca: marca,
    modelo: modelo,
    placa: placa,
    Remol: remol,
    Rejas: rejas,
    Permisionario: permisionario
  };
  guardarTrasladoEnBD(datos);
}
function abrirFormulario(btn) {
  // Obtiene el ID desde el atributo personalizado
  var id = btn.getAttribute('id');

  // Realiza la solicitud AJAX
  $.ajax({
    url: 'php/obtener_datos.php',
    type: 'GET',
    data: { traslado: id },
    success: function (response) {
      // Verifica si la respuesta es válida
      if (response.status === 'success') {
        // Crea el formulario con los datos obtenidos
        crearFormulario(response.datos);
      } else {
        console.error('Error al obtener datos del servidor');
      }
    },
    error: function (error) {
      console.error('Error en la solicitud AJAX:', error);
    }
  });
}

function crearFormulario(datos) {
  var formulario = document.getElementById('FormEditar');
  jsonData = datos;
  for (var key in jsonData) {
    if (jsonData.hasOwnProperty(key)) {
      // Encuentra el elemento del formulario por su nombre
      var campo = formulario.elements[key];

      // Verifica si el campo existe en el formulario y es un campo de texto
      if (campo && campo.type === 'text') {
        // Establece el valor del campo con el valor correspondiente del JSON
        campo.value = jsonData[key];
      }
    }
  }

  // Abre el modal
  $('#ModalEditar').modal('show');
}

function guardarCambios() {
  var Traslado = document.getElementById('Traslado').value;
  if (Traslado === '') {
    alert("Por favor ingrese el numero de Traslado");

  } else {
    const formulario = $('#FormEditar')[0]; // Utiliza jQuery para obtener el formulario
    const formData = new FormData(formulario);
    const jsonData = {};

    formData.forEach((value, key) => {
      jsonData[key] = value;
    });

    // Resto de tu lógica AJAX...
    $.ajax({
      url: 'php/editarRegistro.php',
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({ datos: jsonData }),
      success: function (data) {
        if (data.status == "Éxito") {
          alert("Los datos se han guardado correctamente.");
          location.reload(true);
        }
        else if (data.status != "Éxito") {
          console.log(data);
          alert(data.status);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error('Error en la solicitud AJAX:', textStatus, errorThrown);
      }
    });
  }

}

function validarColumnasExcel() {
  var input = document.getElementById('inputArchivo');
  var archivo = input.files[0];

  if (archivo) {
    var lector = new FileReader();

    lector.onload = function (e) {
      try {
        var contenido = e.target.result;
        var libro = XLSX.read(contenido, { type: 'binary' });
        var hoja = libro.Sheets[libro.SheetNames[0]];

        // Array con nombres de columnas que se deben validar
        var columnasEsperadas = ['Fecha_expedicion', 'Traslado', 'Cliente', 'Pollos', 'Granja', 'Lote', 'Destino', 'Unidad', 'Remol', 'Operador', 'Rejas', 'Permisionario', 'Folio', 'Estatus'];

        // Verificar si todas las columnas esperadas están presentes
        for (var i = 0; i < columnasEsperadas.length; i++) {
          var celda = hoja[XLSX.utils.encode_cell({ r: 0, c: i })];
          
          if (!celda || !celda.w || celda.w !== columnasEsperadas[i]) {
            alert('La columna ' + columnasEsperadas[i] + ' no está presente en el archivo Excel.');
            input.value = "";
            return;
            
          }
        }

        // Si todas las columnas esperadas están presentes, puedes continuar con tu lógica
        console.log('Todas las columnas están presentes. Puedes continuar con la lógica.');
      } catch (error) {
        alert('Error al leer el archivo Excel: ' + error.message);
          input.innerHTML = "";

      }
    };

    lector.readAsBinaryString(archivo);
  } else {
    alert('Por favor, selecciona un archivo Excel.');
  }
}
