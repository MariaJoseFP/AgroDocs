<form class="row" id="formConstancia">
    <div class="col-md-6">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Traslado</label>
        <input type="text" class="form-control form-control-sm" id="traslado" name="traslado" onkeyup="this.value = this.value.toUpperCase();" >
    </div>
    <div class="col-md-6">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">No. Folio</label>
        <input type="text" class="form-control form-control-sm" id="folio" name="folio" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <h6>I. Constancia de lavado y desinfección para vehículos</h6>
    <div class="col-md-6">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Fecha de expedición</label>
       <!-- <input type="text" class="form-control form-control-sm" id="fecha_exp" name="fecha_exp" onkeyup="this.value = this.value.toUpperCase();">--->
        <input type="date" class="form-control form-control-sm" id="fecha_exp" name="fecha_exp" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-6">
        <label for="colFormLabelSm" class="col-sm-4 col-form-label col-form-label-sm">Fecha de vigencia</label>
        <input type="date" class="form-control form-control-sm"  id="Fecha_vigencia" name="Fecha_vigencia" onkeyup="this.value = this.value.toUpperCase();">
    </div>

    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-6 col-form-label col-form-label-sm">Marca del vehículo</label>
        <input type="text" class="form-control form-control-sm" id="marca" name="marca" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-3 col-form-label col-form-label-sm">Placa</label>
        <input type="text" class="form-control form-control-sm" id="placas_tr" name="placas_tr" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Modelo</label>
        <input type="text" class="form-control form-control-sm" id="modelo" name="modelo" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-12 col-form-label col-form-label-sm">Tipo de unidad</label>
        <input type="text" class="form-control form-control-sm" id="tipo_unidad" name="tipo_unidad" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-2">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Remolque</label>
        <input type="text" class="form-control form-control-sm" id="remolq" name="remolq" onkeyup="this.value = this.value.toUpperCase();" onchange="autocompletarRemolq()">
    </div>
    <div class="col-md-2">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Placas de la(s) jaula(s)</label>
        <input type="text" class="form-control form-control-sm" id="placas_plana" name="placas_plana" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <p id="estado-vehiculo" style="color:red"></p>
    <div class="col-md-12">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Procedentes de: </label>
        <input type="text" class="form-control form-control-sm" id="granja" name="granja" onkeyup="this.value = this.value.toUpperCase();" maxlength="50">
    </div>
    <div class="col-md-12">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Responsable: </label>
        <input type="text" class="form-control form-control-sm" id="cliente" name="cliente" onkeyup="this.value = this.value.toUpperCase();" maxlength="40">
    </div>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Domicilio: </label>
        <input type="text" class="form-control form-control-sm" id="localidad" name="localidad" laceholder="" onkeyup="this.value = this.value.toUpperCase();" maxlength="66">
    </div>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Municipio: </label>
        <input type="text" class="form-control form-control-sm" id="municipio" name="municipio" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Estado: </label>
        <input type="text" class="form-control form-control-sm" id="estado" name="estado" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Tipo de carga: </label>
        <input type="text" class="form-control form-control-sm" id="tipo_carga" name="tipo_carga" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <h6 class="mt-3">II. Información del procedimiento de lavado y desinfección</h6>
    <div class="col-md-12">
        <label for="colFormLabelSm" class="col-sm-12 col-form-label col-form-label-sm">Lavado y desinfectado mediante la aplicación de: </label>
        <input type="text" class="form-control form-control-sm" id="desinf" name="desinf" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-12">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Ingrediente activo: </label>
        <input type="text" class="form-control form-control-sm" id="activo" name="activo" onkeyup="this.value = this.value.toUpperCase();" maxlength="65">
    </div>
    <div class="col-md-4">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Concentración utilizada: </label>
        <input type="text" class="form-control form-control-sm" id="concent" name="concent" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-4">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Tiempo: </label>
        <input type="text" class="form-control form-control-sm" id="tiempo" name="tiempo" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-4">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">MVZ responsable: </label>
        <input type="text" class="form-control form-control-sm" id="mvz" name="mvz" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-4 mb-3">
        <label for="colFormLabelSm" class="col-sm-9 col-form-label col-form-label-sm">Clave de autorización: </label>
        <input type="text" class="form-control form-control-sm" id="clave_aut" name="clave_aut" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="auto d-flex justify-content-end">
        <button type="button" class="btn btn-outline-info" onclick="generarConstancia()">Guardar y descargar constancia</button>
    </div>

</form>