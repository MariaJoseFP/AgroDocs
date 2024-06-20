<form class="row my-0 mx-0" id="formGuia">
    <h6>Registro en el estado de Veracruz</h6>
    <p style="color:blue">Remitente</p>
    <div class="col-md-6">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Folio No. :</label>
        <input type="text" class="form-control form-control-sm" id="folio_guia" name="folio_guia" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-6">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Fecha de expedición</label>
        <!-- <input type="text" class="form-control form-control-sm" id="fecha_exp" name="fecha_exp" onkeyup="this.value = this.value.toUpperCase();">--->
        <input type="date" class="form-control form-control-sm" id="fecha_exp2" name="fecha_exp" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-6">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">UPP/PSG:</label>
        <input type="text" class="form-control form-control-sm" id="upp_o" name="upp_o" onkeyup="this.value = this.value.toUpperCase();" maxlength="50">
    </div>
    <div class="col-md-6">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Nombre:</label>
        <input type="text" class="form-control form-control-sm" id="nombre_o" name="nombre_o" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-4">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Localidad:</label>
        <input type="text" class="form-control form-control-sm" id="localidad_o" name="localidad_o" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-4">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Estado:</label>
        <input type="text" class="form-control form-control-sm" id="estado_o" name="estado_o" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-4">
        <label for="colFormLabelSm" class="col-sm-6 col-form-label col-form-label-sm">Municipio:</label>
        <input type="text" class="form-control form-control-sm" id="municipio_o" name="municipio_o" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <p id="estado-granja" style="color:red"></p>
    <p style="color:blue">Destinatario</p>
    <div class="col-md-6">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">UPP/PSG:</label>
        <input type="text" class="form-control form-control-sm" id="upp_d" name="upp_d" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-6">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Nombre:</label>
        <input type="text" class="form-control form-control-sm" id="nombre_d" name="nombre_d" onkeyup="this.value = this.value.toUpperCase();"  maxlength="40">
    </div>
    <div class="col-md-4">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Localidad:</label>
        <input type="text" class="form-control form-control-sm" id="localidad_d" name="localidad_d" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-4">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Estado:</label>
        <input type="text" class="form-control form-control-sm" id="estado_d" name="estado_d" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-4">
        <label for="colFormLabelSm" class="col-sm-6 col-form-label col-form-label-sm">Municipio:</label>
        <input type="text" class="form-control form-control-sm" id="municipio_d" name="municipio_d" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <h6 class="mt-3">Datos del transporte</h6>
    <div class="col-md-2 col-3">
        <label for="colFormLabelSm" class="col-sm-6 col-form-label col-form-label-sm">Vehiculo:</label>
        <input type="text" class="form-control form-control-sm" id="vehiculo" name="vehiculo" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-2 col-3">
        <label for="colFormLabelSm" class="col-sm-6 col-form-label col-form-label-sm">Modelo:</label>
        <input type="text" class="form-control form-control-sm" id="modelo" name="modelo" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-2 col-3">
        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Marca:</label>
        <input type="text" class="form-control form-control-sm" id="marca2" name="marca2" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-2 col-3">
        <label for="colFormLabelSm" class="col-sm-12 col-form-label col-form-label-sm">Tipo de unidad:</label>
        <input type="text" class="form-control form-control-sm" id="tipo_unidad2" name="tipo_unidad2" readonly>
    </div>
    <div class="col-md-2 col-3">
        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Año:</label>
        <input type="text" class="form-control form-control-sm" id="año" name="año" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-2 col-3">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Color:</label>
        <input type="text" class="form-control form-control-sm" id="color" name="color" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <p id="estado-vehiculo" style="color:red"></p>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Placas: </label>
        <input type="text" class="form-control form-control-sm" id="placas_1" name="placas_1" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Placas plana: </label>
        <input type="text" class="form-control form-control-sm" id="placas_2" name="placas_2" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm oculto">Placas: </label>
        <input type="text" class="form-control form-control-sm oculto" id="placas" name="placas" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <p id="estado-unidad" style="color:red"></p>
    <div class="col-md-6">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Nombre del conductor: </label>
        <input type="text" class="form-control form-control-sm" id="conductor" name="conductor" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-12">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Ruta: </label>
        <input type="text" class="form-control form-control-sm" id="ruta" name="ruta" laceholder="" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <h6 class="mt-3">Datos de la movilización</h6>
    <div class="col-md-2">
        <label for="colFormLabelSm" class="col-sm-6 col-form-label col-form-label-sm">Especie: </label>
        <input type="text" class="form-control form-control-sm" id="especie" name="especie" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-2">
        <label for="colFormLabelSm" class="col-sm-6 col-form-label col-form-label-sm">Cantidad: </label>
        <input type="text" class="form-control form-control-sm" id="cantidad" name="cantidad" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-2">
        <label for="colFormLabelSm" class="col-sm-6 col-form-label col-form-label-sm">Mercancía: </label>
        <input type="text" class="form-control form-control-sm" id="mercancia" name="mercancia" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-2">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Unidad de medida: </label>
        <input type="text" class="form-control form-control-sm" id="unidad_medida" name="unidad_medida" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-4">
        <label for="colFormLabelSm" class="col-sm-12 col-form-label col-form-label-sm">Motivo del transporte: </label>
        <input type="text" class="form-control form-control-sm" id="motivo" name="motivo" onkeyup="this.value = this.value.toUpperCase();" readonly>
    </div>
    <h6 class="mt-3">Identificación individual de los animales movilizados</h6>
    <div class="col-md-4">
        <label for="colFormLabelSm" class="col-sm-12 col-form-label col-form-label-sm">No. de constancia de lavado y desinfección del vehículo: </label>
        <input type="text" class="form-control form-control-sm" id="n_constancia" name="n_constancia" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-4">
        <label for="colFormLabelSm" class="col-sm-12 col-form-label col-form-label-sm">No. de registro de la planta de origen : </label>
        <input type="text" class="form-control form-control-sm" id="UPA" name="UPA" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-4">
        <label for="colFormLabelSm" class="col-sm-12 col-form-label col-form-label-sm">Lote : </label>
        <input type="text" class="form-control form-control-sm" id="lote" name="lote" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-4">
        <label for="colFormLabelSm" class="col-sm-12 col-form-label col-form-label-sm"></label>
        <input type="text" class="form-control form-control-sm" id="" name="" onkeyup="this.value = this.value.toUpperCase();" value="LIC. SERVANDO MORA CARVAJAL">
    </div>
    <h6 class="mt-3">Documentos presentados</h6>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Antecedentes: </label>
        <input type="text" class="form-control form-control-sm" id="antec" name="antec" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Esta guía ampara: </label>
        <input type="text" class="form-control form-control-sm" id="cantidad2" name="cantidad2" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Factura exp. NO.: </label>
        <input type="text" class="form-control form-control-sm" id="factura" name="factura" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Certificado zoosanitario: </label>
        <input type="text" class="form-control form-control-sm" id="cert_zoo" name="cert_zoo" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-12 col-form-label col-form-label-sm">Constancia de enfermedad bajo campaña: </label>
        <input type="text" class="form-control form-control-sm" id="const_enf" name="const_enf" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3 mb-4">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">MVZ: </label>
        <input type="text" class="form-control form-control-sm" id="mvz2" name="mvz" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <hr>
    <div class="card  destacar-form">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <label class="form-label" col-form-label-sm>NO. de expediente:</label>
                    <input type="text" class="form-control form-control-sm" id="no_expediente" name="no_expediente">
                    <?php
                    include("../php/conexion.php");
                    $query = "SELECT No_expediente from guias_pollo ORDER by No_expediente DESC LIMIT 1";
                    $result = $conn->query($query);

                    if (!$result) {
                        die("Error en la consulta: " . $conn->error);
                    }
                    // Procesar los resultados
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Procesar cada fila de resultados aquí
                            echo "<p style='color:blue'>Último folio registrado: " . $row["No_expediente"]."</p>";
                        }
                    }
                    ?>
                </div>

                <div class="col">
                    <label class="form-label" col-form-label-sm>Responsable de la documentación: </label>
                    <input type="text" class="form-control form-control-sm" id="responsable_doc" name="responsable_doc" onkeyup="this.value = this.value.toUpperCase();">
                </div>
            </div>
        </div>
    </div>

    <div class="auto d-flex justify-content-end">
        <button type="button" class="btn btn-outline-info" onclick="generarGuia()">Guardar y descargar guía</button>
    </div>

</form>