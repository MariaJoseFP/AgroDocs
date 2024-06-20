<form class="col-12  row" id="form-translado" method="POST">

    <div class="col-md-6">
        <label for="exampleFormControlInput1"> Fecha </label>
        <input type="date" class="form-control" id="Fecha_expedicion" name="Fecha_expedicion">
    </div>
    <script>
        // LLENAR LOS CAMPOS DE FECHA
        var fechaCampo = document.getElementById('Fecha_expedicion');
        // Obtener la fecha actual en formato YYYY-MM-DD
        var fechaActual = new Date().toISOString().split('T')[0];
        // Asignar la fecha actual al campo de fecha
        fechaCampo.value = fechaActual;
    </script>

    <div class="col-md-6">
        <label for="exampleFormControlInput2">Traslado</label>
        <input name="Traslado" class="form-control" id="Traslado" name="Traslado" pattern="[0-9]+" required>
    </div>
    <div class="col-md-12">
        <label for="exampleFormControlInput2">Cliente</label>
        <!--- <input class="form-control" name="cliente" id="Cliente" onblur="autocompletarCliente()">--->
        <select class="form-control" id="Cliente" name="cliente" onchange="autocompletarCliente()" required>
            <option></option>
            <?php
            include("../php/conexion.php");
            $sql = "SELECT cliente FROM clientes";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conn));
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['cliente'] . "'>" . $row['cliente'] . "</option>";
                }
                echo "<option value='OTRO'>OTRO</option>";
            }
            $conn->close();
            ?>

        </select>
    </div>
    <div id="otroCliente" class="oculto col-md-12">
        <label for="campoAdicional">Nombre:</label>
        <input class="form-control" type="text" id="clienteAdicional" name="clienteAdicional" value="" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-3">
        <label for="exampleFormControlInput2">Pollos</label>
        <input class="form-control" id="Pollos" name="Pollos">
    </div>
    <div class="col-md-3">
        <label for="exampleFormControlSelect1">Granja</label>

        <select class="form-control" id="Granja" name="granja" required>
            <option> </option>
            <?php
            include("../php/conexion.php");
            $sql = "SELECT granja FROM granjas";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conn));
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['granja'] . "'>" . $row['granja'] . "</option>";
                }
            }
            ?>

        </select>
    </div>
    <div class="col-md-3">
        <label for="exampleFormControlInput2">Lote</label>
        <input type="email" class="form-control" id="Lote" name="lote">
    </div>
    <div class="col-md-3 mb-4">
        <label for="exampleFormControlInput2">Destino</label>
        <input class="form-control" id="Destino" name="Destino" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-6">
        <label for="exampleFormControlInput2">Operador</label>
        <input class="form-control" id="Operador" name="Operador" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-md-6">
        <label for="exampleFormControlSelect1">Unidad</label>
        <select class="form-control" id="Unidad" name="unidad" onchange="autocompletarUnidad()" required>
            <option></option>
            <?php

            $sql = "SELECT NUMERO_UNIDAD FROM unidades WHERE TIPO_UNIDAD != 'PLATAFORMA' ";
            $result = mysqli_query($conn, $sql);

            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conn));
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['NUMERO_UNIDAD'] . "'>" . $row['NUMERO_UNIDAD'] . "</option>";
                }
            }
            $conn->close();
            ?>

        </select>
    </div>
    <div class="col-6 col-md-4">
        <label for="exampleFormControlSelect1">Marca</label>
        <input class="form-control" id="marca" name="marca" readonly onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-6 col-md-4">
        <label for="exampleFormControlSelect1">Modelo</label>
        <input class="form-control" id="modelo" name="modelo" readonly onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-6 col-md-4">
        <label for="exampleFormControlSelect1">Placas</label>
        <input class="form-control" id="placa" name="placa" readonly>
    </div>
    <div class="col-6 col-md-4">
        <label for="exampleFormControlSelect1">Tipo de unidad</label>
        <input class="form-control" id="tipo_unidad" name="tipo_unidad" readonly>
    </div>
    <div class="col-md-4 mb-4 campos_remolq">
        <label for="exampleFormControlInput2">Remolque</label>
        <input class="form-control campos_remolq" id="Remol" name="Remol" onchange="autocompletarRemolq()" onkeyup="this.value = this.value.toUpperCase();">
    </div>
    <div class="col-6 col-md-4 campos_remolq">
        <label for="exampleFormControlSelect1">Placas plana</label>
        <input class="form-control" id="placas_plana" name="placas_plana" readonly>
    </div>

    <div class="col-md-12 mb-3">
        <label for="exampleFormControlInput2">Rejas</label>
        <input class="form-control" id="Rejas" name="Rejas">
    </div>
    <div class="col-md-12 mb-3">
        <label for="exampleFormControlInput2">Permisionario</label>
        <input class="form-control" id="Permisionario" name="permisionario" onkeyup="this.value = this.value.toUpperCase();">
    </div>

    <button class="btn btn-primary " id="btn-form-traslado" onclick="guardarTraslado() " type="button">Enviar</button>


</form>