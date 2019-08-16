<?php

/**/

include '../controller/gastos_gralController.php';

$gastos_gralInst = new gastos_gralController();

$arrPermisos = $gastos_gralInst->permisos($id_modulo, $_COOKIE['log_lunelAdmin_IDtipo']);

//$prueba = $_COOKIE['log_lunelAdmin_IDtipo'];

//print_r($prueba);

$crea = $arrPermisos[0]['crear'];

$filtro = $_GET["filter"];

$tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];

//print_r($filtro);

?>

<!-- Modal -->
<div class="modal fade" id="form_modal_gasto_gral" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_gasto_gral">-</h4>
      </div>
      <div class="modal-body">

        <form id="form_gasto_gral" method="POST">
            <br>
                <div class="form-group" hidden>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>

                <?php if ($tipoUsuario != 13 ) {
    ?>
                <div class="form-group">
                    <label for="fkID_empresa" class="control-label">Empresa</label>
                    <?php
$gastos_gralInst->getSelectEmpresas();
    ?>
                    <button id="btn_nuevoempresa" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_empresa"><span class="glyphicon glyphicon-plus"></span></button>
                </div>
              <?php } else if ($tipoUsuario == 15 ) {?>
                        <div class="form-group" hidden="true">
                            <input type="text" class="form-control" id="fkID_empresa" name="fkID_empresa" value="3">
                        </div>

              <?php } else {?>
                        <div class="form-group" hidden="true">
                            <input type="text" class="form-control" id="fkID_empresa" name="fkID_empresa" value="2">
                        </div>

              <?php }?>


                <div class="form-group">
                    <label for="fkID_externo" class="control-label">Beneficiario</label>

                     <input type="text" class="form-control add-selectElement" id="beneficiario" required="true">

                     <button id="btn_nuevoexterno" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_externo"><span class="glyphicon glyphicon-plus"></span></button>
                </div>

                <div class="form-group" hidden="true">
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="fkID_externo" name="fkID_externo" required="true">
                    </div>
                </div>

                <div class="form-group">
                    <label for="fkID_proyecto" class="control-label">Proyecto</label>
                    <?php
$gastos_gralInst->getSelectProyectos();
?>
                </div>

                <div class="form-group">
                    <label for="fkID_actividad" class="control-label">Actividad</label>
                      <select name="fkID_actividad" id="fkID_actividad" class="form-control">
                        <option></option>
                      </select>
                </div>

        <div class="form-group">
                    <label for="descripcion" class="control-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del gasto." required = "true"></textarea>
                </div>

                <div class="form-group">
                    <label for="fecha_pago_limite" class="control-label">Fecha Límite de Pago</label>
                    <input type="text" class="form-control" id="fecha_pago_limite" name="fecha_pago_limite" required="true">
                </div>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="valor" name="valor" required = "true">
                </div>

                <div class="form-group">
                    <label class="control-label">Valor</label>
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="valor_mask" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="pago" name="pago">
                </div>

                <div class="form-group">
                    <label class="control-label">Pago</label>
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="pago_mask" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="diferencia" name="diferencia">
                </div>

                <div class="form-group">
                    <label class="control-label">Diferencia</label>
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="diferencia_mask" type="text" class="form-control">
                    </div>
                </div>


               <!-- <div class="form-group">
                    <label for="recursos" class="control-label">Observaciones</label>
                    <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
                </div>-->








                  <!-- div gastos_hide-->
                  <div id="gastos_hide">

                    <div class="form-group" id="div-observaciones">
                        <label for="observaciones" class="control-label">Observaciones</label>
                        <textarea class="form-control add-selectElement" id="observaciones" name="observaciones"></textarea>
                        <button id="btn_nuevoobservacion" type="button" class="btn btn-success" data-toggle="modal" data-target="#frm_observacion" style="margin-top: -9%;" title="Nueva Observación"><span class="glyphicon glyphicon-plus"></span></button>
                   </div>

                    <div class="form-group">
                      <label for="aprobado" class="control-label">Aprobado</label>
                      <select name="aprobado" id="aprobado" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="pagado" class="control-label">Pagado</label>
                      <select name="pagado" id="pagado" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                      </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha_pago" class="control-label">Fecha Pago</label>
                        <input type="text" class="form-control" id="fecha_pago" name="fecha_pago">
                        <br>
                        <label for="fecha_aprobacion" class="control-label">Fecha Aprobación</label>
                        <input type="text" class="form-control" id="fecha_aprobacion" name="fecha_aprobacion" readonly="true">
                    </div>
                  </div>
                <!-- ./div gastos_hide-->

                <div class="form-group" hidden>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="anio" name="anio">
                    </div>
                </div>

        </form>


      </div>

      <div class="modal-footer">
        <button id="btn_actiongasto_gral" type="button" class="btn btn-primary botonnewgasto" data-action="-">
            <span id="lbl_btn_actiongasto_gral">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>

</div>

<!-- /form modal 2-->
<?php
include "modal_empresas.php";
include "modal_externo.php";
include "form_novedades.php";
?>
<div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-default titulo-barra-amarilla">
                        <div class="icono_"></div>
                          <div class="panel-body">
                            Gastos
                          </div>
                    </div>


                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row rowform">

            </div>
            <!-- /.row -->

            <div class="row">
              <div id="ip" hidden="true">
                <input type="text" id="ip_server" value=<?php echo $_SERVER["REMOTE_ADDR"] ?>>
              </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                    <div class="panel-body2">

                        <div class="panel-heading">

                            <div class="row">
                              <div class="col-md-12">



                              </div>
                              <div class="col-md-12 text-right">

                                  <button id="btn_nuevogasto_gral" type="button" class="btn btn-primary btn-limang botonnewgasto" data-toggle="modal" data-target="#form_modal_gasto_gral" <?php if ($crea != 1) {echo 'disabled="disabled"';}?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear Gasto</button>

                              </div>
                              <div class="col-md-12 text-left form-inline">
                <br>
                                <h4 class="text-left"><span class="glyphicon glyphicon-filter"></span><strong>Filtro</strong></h4>

                                <?php
if ($tipoUsuario != 13 && $tipoUsuario != 15) {

    ?>
                                <label for="empresa_filtro" class="control-label">Empresas</label>
                                    <?php
$gastos_gralInst->getSelectEmpresasFiltro();   
}?>

                                <label for="aprobado_filtro" class="control-label">Aprobado</label>
                                <select name="aprobado_filtro" id="aprobado_filtro" class="form-control">
                                  <option></option>
                                  <option value="0">No</option>
                                  <option value="1">Sí</option>
                                </select>

                                <label for="pagado_filtro" class="control-label">Pagado</label>
                                <select name="pagado_filtro" id="pagado_filtro" class="form-control">
                                  <option></option>
                                  <option value="0">No</option>
                                  <option value="1">Sí</option>
                                </select>


                                <label for="fechas_filtro" class="control-label">Fecha de Aprobacion</label>
                                <?php
if ($tipoUsuario != 13) {
    $gastos_gralInst->getSelectFechasFiltro();
} else if ($tipoUsuario == 15 ){
      $gastos_gralInst->getSelectFechasFiltroProco();
} else {
    $gastos_gralInst->getSelectFechasFiltroFuntecso();
}
?>


                                <label for="fecha_anio_filtro" class="control-label" >Año</label>
                                <?php
$gastos_gralInst->getSelectAnioFiltro();

?>


                                <button class="btn btn-success" id="btn_filtrar"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>

                                <hr>

                              </div>

                            </div>

                        </div>
                        <!-- /.panel-heading -->

                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="tbl_gastos_gral">
                                    <thead>
                                        <tr>
                                            <!--<th>ID</th>-->
                                            <th>Empresa</th>
                                            <th>Beneficiario</th>
                                            <th class="tabla-max-ancho">Descripcion</th>
                                            <th class="tabla-form-ancho2" hidden="true">Ficti</th>
                                            <th class="tabla-form-ancho">Fecha Límite</th>
                                            <th>Valor</th>
                                            <th>Pago</th>
                                            <th>Diferencia</th>
                                            <th>Observaciones</th>
                                            <th>Aprobado</th>
                                            <th>Pagado</th>
                                            <th>Fecha de Pago</th>
                                            <th>Fecha de Aprobación</th>
                                            <th data-orderable="false" class="tabla-form-ancho">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//print_r($_COOKIE);
if ($tipoUsuario == 13) {
    $gastos_gralInst->getTablagastos_gralFuntecso($filtro);
} else if ($tipoUsuario == 15 ){
  $gastos_gralInst->getTablagastos_gralProco($filtro);
} else {
    $gastos_gralInst->getTablagastos_gral($filtro);
}
?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                            <hr>
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <label for="total_estudiantes" class="control-label">Total</label>
                                <div class="input-group">
                                  <span class="input-group-addon">$</span>
                                  <input type="text" class="form-control" id="total_gastos" name="total_gastos" readonly="true" value=<?php
if ($tipoUsuario == 13) {
    echo $gastos_gralInst->getSumagastosValFuntecso($filtro);
}  else if ($tipoUsuario == 15 ){
    echo $gastos_gralInst->getSumagastosValProco($filtro);
} else {
    echo $gastos_gralInst->getSumagastosVal($filtro);
}
?>>
                                </div>
                            </div>
                            <?php

// Muestra o no el div de total pago
$cadena_de_texto       = $filtro;
$cadena_buscada        = 'pagado=1';
$posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);

//se puede hacer la comparacion con 'false' o 'true' y los comparadores '===' o '!=='
if ($posicion_coincidencia === false) {
    $encontrado = false;
} else {
    $encontrado = true;
}
?>

                            <div id="pago_tot"
                              <?php
if ($encontrado == false) {
    echo "hidden = 'true'";
} else {
    echo "";
}
?>
                            >
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <label for="total_ingresos" class="control-label">Total Pago</label>
                                <div class="input-group">
                                  <span class="input-group-addon">$</span>
                                  <input type="text" class="form-control" id="total_pagos" name="total_pagos" readonly="true" value=<?php
if ($tipoUsuario == 13) {
    echo $gastos_gralInst->getSumaValPagosFuntecso($filtro);
} else if ($tipoUsuario == 15 ){
    echo $gastos_gralInst->getSumaValPagos($filtro);
} else {
    echo $gastos_gralInst->getSumaValPago($filtro);
}
?>>
                                </div>
                            </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                        </div>
                        <!-- /.panel-body2 -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->


        </div>

        <!-- /#page-wrapper -->