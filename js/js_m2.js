//AQUÍ PUEDES ENCONTRAR LAS FUNCIONES QUE UTILIZA LA PÁGINA DE MOVILIZACION O INICIO_M.PHP
function verDocs(doc) {
  var elemento = document.getElementById("menu_cards");
  // Oculta el elemento cambiando su estilo
  elemento.style.display = "none";

  var elemento1 = document.getElementById("div-guias");
  elemento1.style.display = "none";

  var elemento2 = document.getElementById("div-constancias");
  elemento2.style.display = "none";

  var elemento3 = document.getElementById("div-" + doc);
  elemento3.style.display = "block";

  $.ajax({
    url: "php/consultar_" + doc + ".php", // Nombre del archivo PHP que manejará la consulta a la base de datos
    type: "GET",
    success: function (response) {
      if (response.trim() === "S/R") {
        $("#tabla-" + doc).html("No se encontraron resultados."); // Insertar la respuesta
      } else {
        // Mostrar la programación
        $("#tabla-" + doc).html(response); // Insertar la tabla generada en la respuesta en el contenedor
        // Verificar si los botones de descarga ya existen antes de agregarlos
        if ($("#div-btn-excel1 .btn-descargar").length === 0) {
          $("#div-btn-excel1").append(
            '<button class="btn btn-outline-primary btn-descargar mt-3" onclick="descargarExcel(\'constancias\')">Descargar Excel</button>'
          );
        }

        if ($("#div-btn-excel2 .btn-descargar").length === 0) {
          $("#div-btn-excel2").append(
            '<button class="btn btn-outline-primary btn-descargar mt-3" onclick="descargarExcel(\'guias\')">Descargar Excel</button>'
          );
        }
      }
    },
    error: function (error) {
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}

function solicitarCancelarDoc(btn, doc) {
  var resultado = confirm("¿Estas seguro de que deseas cancelar el documento?");
  if (resultado) {
    $("#modalMotivos").show();
    var id = btn.getAttribute("id");
    $("#id-doc").val(id);
    $("#doc-cancelar").val(doc);
  } else {
    console.log("El usuario hizo clic en Cancelar");
  }
}
function cancelarDoc() {
  //Obtener los valores del id y el documento que se va a cancelar
  var id = $("#id-doc").val();
  var doc = $("#doc-cancelar").val();
  var motivo = $("#motivos-cancelacion").val();
  console.log(motivo);

  // Realiza la solicitud AJAX
  $.ajax({
    url: "php/cancelarDoc.php",
    type: "GET",
    data: { id: id, doc: doc, motivo: motivo },
    success: function (response) {
      // Verifica si la respuesta es válida
      if (response.status === "OK") {
        location.reload(true);
      } else {
        console.error("Error al obtener datos del servidor");
      }
    },
    error: function (error) {
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}
function descargarExcel(doc) {
  var fechaActual = new Date();
  var año = fechaActual.getFullYear();
  var mes = fechaActual.getMonth() + 1; // Se suma 1 porque los meses en JavaScript van de 0 a 11
  var dia = fechaActual.getDate();

  // Formatear la fecha como 'YYYY-MM-DD'
  var fechaFormateada =
    año + "-" + (mes < 10 ? "0" : "") + mes + "-" + (dia < 10 ? "0" : "") + dia;

  descargarExcelAjax(doc, fechaFormateada, fechaFormateada);
}

function descargarExcelRango(doc, fechaIni, fechaFin) {
  var fechaIni = document.getElementById(fechaIni).value;
  var fechaFin = document.getElementById(fechaFin).value;
  descargarExcelAjax(doc, fechaIni, fechaFin);
}

//FUNCION AJAX PARA DESCARGAR CONSTANCIAS
function descargarExcelAjax(doc, fechaIni, fechaFin) {
  $.ajax({
    url: "php/exportarExcel.php",
    type: "GET",
    data: { doc: doc, fechaIni: fechaIni, fechaFin: fechaFin },
    success: function (response) {
      console.log(response);
      // Verifica si la respuesta es válida
      if (response.status === "OK") {
        window.open("documentos/" + response.archivo, "_blank");
      } else {
        alert("Error al obtener datos del servidor");
        console.error("Error al obtener datos del servidor");
      }
    },
    error: function (error) {
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}

function VerDocRango(doc, fecha1, fecha2) {
  var fechaIni = document.getElementById(fecha1).value;
  var fechaFin = document.getElementById(fecha2).value;

  $.ajax({
    url: "php/consultar_" + doc + ".php", // Nombre del archivo PHP que manejará la consulta a la base de datos
    type: "GET",
    data: { fechaIni: fechaIni, fechaFin: fechaFin },
    success: function (response) {
      if (response.trim() === "S/R") {
        $("#tabla-" + doc + "2").html("No se encontraron resultados."); // Insertar la respuesta
      } else {
        // Mostrar la programación
        $("#tabla-" + doc + "2").html(response); // Insertar la tabla generada en la respuesta en el contenedor
        $("#btn-3").css("display", "block"); // Para ocultar el elemento
        $("#btn-4").css("display", "block"); // Para ocultar el elemento
      }
    },
    error: function (error) {
      console.error("Error en la solicitud AJAX:", error);
    },
  });
}

function cerrarModal(modal) {
  $("#modalMotivos").hide();
}
