
<?php
include "../controller/recursosController.php";
include "../controller/hvidaController.php";

$recursosInst = new recursosController();
$hvidainst    = new HvidaController();

$arrPermisos = $recursosInst->permisos($id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);
$crea        = $arrPermisos[0]["crear"];

if (isset($_GET["filter"])) {
    $filtro = $_GET["filter"];
} else {
    $filtro = '';
}

$tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];

?>

<?php
include 'modal_hvida.php';
?>

<!-- Modal -->
<div class="modal fade" id="form_modal_recursos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_proceso">-</h4>
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
        <button id="btn_busquedahvida" type="button" class="btn btn-primary btn-limang" data-action="-">
            <span id="lbl_btn_busquedaHvida" class="btn-limang">-</span>
        </button>
      </div>
      <div class="modal-body">

      <!-- Tab panes -->
      <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="general">

        <form id="form_contrato" method="POST" >
            <br>
                <div class="form-group" hidden>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>

                <div id="empleado" class="form-group">
                    <label for="fkID_empleado" class="control-label">Empleado</label>
                    <select name="fkID_empleado" id="fkID_empleado" class="form-control" required = "true">
                      <?php
$recursosInst->selectEmpleado();
?>
                    </select>
                </div>

                <div class="form-group text-right">
                  <button id="btn_nuevoempleado" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_estudios"><span class="glyphicon glyphicon-plus"></span> Agregar Empleado</button>
                </div>

                <div id="empleador" class="form-group">
                    <label for="fkID_empleador" class="control-label">Empleador</label>
                    <select name="fkID_empleador" id="fkID_empleador" class="form-control" required = "true">
                        <?php
$recursosInst->selectEmpleador();
?>
                    </select>
                </div>

                <div id="cargo" class="form-group">
                    <label for="fkID_cargo" class="control-label">Cargo</label>
                    <select name="fkID_cargo" id="fkID_cargo" class="form-control" required = "true">
                      <?php/*
$recursosInst->selectCargo();
 */?>
                    </select>
                </div>

                <div class="form-group text-right">
                  <button id="btn_nuevocargo" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_cargos"><span class="glyphicon glyphicon-plus"></span> Agregar Cargo</button>
                </div>

                <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="salario_mask" type="text" class="form-control" required = "true">
                    </div>
                </div>

                <div class="form-group" hidden="true">
                    <label for="salario" class="control-label">Salario</label>
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input name="salario" id="salario" type="text" class="form-control" required = "true">
                    </div>
                </div>

                <div class="form-group">
                    <label for="fechaIni" class="control-label">Fecha Ingreso</label>
                    <input type="text" class="form-control" id="fechaIni" name="fechaIni" placeholder="Fecha de ingreso" required = "true">
                </div>

                <div class="form-group">
                    <label for="fechaFin" class="control-label">Fecha Terminacion</label>
                    <input type="text" class="form-control" id="fechaFin" name="fechaFin" placeholder="Fecha de finalización.">
                </div>

                <div id="ciudad" class="form-group">
                    <label for="fkID_ciudad" class="control-label">Ciudad</label>
                    <select name="fkID_ciudad" id="fkID_ciudad" class="form-control" required = "true">
                      <?php /*
$recursosInst->selectCiudad();
 */?>
                    </select>
                </div>

                <div id="tipoContrato" class="form-group">
                    <label for="fkID_tipoContrato" class="control-label">Tipo Contrato</label>
                    <select name="fkID_tipoContrato" id="fkID_tipoContrato" class="form-control" required = "true">
                      <?php /*
$recursosInst->selectTipoContrato();
 */?>
                    </select>
                </div>

        </form>

        </div>
        <!--  cierra contendio de tabla-->

        <div role="tabpanel" class="tab-pane" id="documentos">

        <form id="form_documentos_empleado" method="POST" enctype="multipart/form-data">
            <br>
                <div class="form-group" hidden>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>

                <?php /*
//Consulta los documentos
echo $recursosInst->getDocumentos();
 */?>

        </form>

        </div>
        <!--  cierra contendio de tabla-->

      </div>

      </div>

      <div id="not_proceso_email" class="alert alert-danger">

      </div>

      <div class="modal-footer">
        <button id="btn_actionproceso" type="button" class="btn btn-primary" data-action="-" disabled="disabled">
            <span id="lbl_btn_actionproceso">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>

</div>
<!-- ./form modal 2-->
<?php /*
include "modal_empleados.php";
include "modal_cargos.php";
 */?>

<div id="page-wrapper">
<!-- /.panel de cabezera -->
    <div class="row">

        <div class="col-lg-12">
        <div class="panel panel-default titulo-barra-amarilla">
              <div class="icono_rrhh"></div>
                        <div class="panel-body">
                          Recursos Humanos
                        </div>
                      </div>
        </div>
      <!-- /.col-lg-12 -->
    </div>
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-body2">
        <div class="panel-body">
          <!-- Panel de navegación principal -->
          <ul class="nav nav-tabs" role="tablist">
            <li id="li_p_oferta" role="presentation" class="active"><a href="#h_vida" aria-controls="h_vida" role="tab" data-toggle="tab">Hojas de Vida</a></li>
            <li id="li_certifiaciones" role="presentation"><a href="#contratos" aria-controls="contratos" role="tab" data-toggle="tab">Contratos</a></li>
            <li id="li_certifiaciones" role="presentation"><a href="#informes" aria-controls="informes" role="tab" data-toggle="tab">Informes</a></li>
          </ul>
          <!-- Tab Contiene Submenus de Modulo Recursos -->
<div class="tab-content">
            <!-- Modulo HV -->
        <div role="tabpanel" class="tab-pane active" id="h_vida">
         <div class="modal fade" id="form_modal_busqueda_hvida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
        <!-- Nav tabs muestra los estudios para la busqueda avanzada -->
          <ul class="nav nav-tabs nav-modal reg-hv" role="tablist">
            <li role="presentation" class="active"><a href="#estudios_busqueda" aria-controls="estudios" role="tab" data-toggle="tab">Estudios</a></li>
          </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="estudios_busqueda">
                <div class="">
                  <br>
                  <!-- Formulario de busqueda de estudio -->
                  <form id="form_busqueda">
                      <div class="form-group">
                          <label for="selectEstudioTecnico" class="control-label">Tecnico</label>
                              <?php $hvidainst->getSelectTecnicoBusqueda();?>
                      </div>
                      <div class="form-group">
                          <label for="selectEstudioTecnologo" class="control-label">Tecnologo</label>
                              <?php $hvidainst->getSelectTecnologoBusqueda();?>
                      </div>
                      <div class="form-group">
                          <label for="selectEstudio" class="control-label">Pregrado</label>
                              <?php $hvidainst->getSelectPregradoBusqueda();?>
                      </div>
                      <div id="selectPosgrado" class="form-group">
                          <label for="selectEstudioPosBusqueda" class="control-label">Posgrado</label>
                              <?php $hvidainst->getSelectPosgradoBusqueda();?>
                      </div>
                      <div id="selectCertificacion" class="form-group">
                          <label for="selectEstudioCertificacion" class="control-label">Certificacion</label>
                              <?php $hvidainst->getSelectCertificacionBusqueda();?>
                      </div>
                  </form>
                </div>
          </div>
        </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
      </div>

    </div>
  </div>
</div>


<!-- /Modal -->
<?php include 'modal_estudios.php';?>
<!-- +++++++++++Submenu Hojas de vida+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
<div id="page-wrapper">
            <!-- /.row -->
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                    <div class="panel-body2">
                        <div class="panel-heading">

                            <div class="row">
                              <div class="col-md-6">

                              </div>

                              <div class="col-md-6 text-right">
                                  <!--Boton para crear una nueva hoja de vida-->
                                  <button id="btn_nuevoHvida" type="button" class="btn btn-primary  btn-limang" data-toggle="modal" data-target="#form_modal_hvida" <?php if ($crea != 1) {echo 'disabled="disabled"';}?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear Hoja de Vida</button>
                              </div>
                            </div>

                        </div>
                        <!-- /.panel Crear H_V -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="tbl_hvida">
                                    <thead>
                                        <tr>
                                            <th class="tabla-form-ancho">Nombres</th>
                                            <th class="tabla-form-ancho">Teléfono</th>
                                            <th class="tabla-form-ancho">Estado</th>
                                            <th class="tabla-form-ancho">Tecnico</th>
                                            <th class="tabla-form-ancho">Tecnologo</th>
                                            <th class="tabla-form-ancho">Pregrado</th>
                                            <th class="tabla-form-ancho">Posgrado</th>
                                            <th class="tabla-form-ancho">Certificacion</th>
                                            <th data-orderable="false">Opciones</th>
                                        </tr>
                                    </thead>
                                    <!-- /.table-hojas de vida -->
                                    <tbody>
                                        <?php $hvidainst->getTablahvida($filtro);?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->

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
</div>
        <!------fin modulo hv------>
      <div role="tabpanel" class="tab-pane" id="contratos">
                  <br>
                  <div class="modal fade" id="form_modal_busqueda_hvida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
        <!-- Nav tabs muestra los estudios para la busqueda avanzada -->
          <ul class="nav nav-tabs nav-modal reg-hv" role="tablist">
            <li role="presentation" class="active"><a href="#estudios_busqueda" aria-controls="estudios" role="tab" data-toggle="tab">Estudios</a></li>
          </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="estudios_busqueda">
                <div class="">
                  <br>
                  <!-- Formulario de busqueda de estudio -->
                  <form id="form_busqueda">
                      <div class="form-group">
                          <label for="selectEstudioTecnico" class="control-label">Tecnico</label>
                              <?php $hvidainst->getSelectTecnicoBusqueda();?>
                      </div>
                      <div class="form-group">
                          <label for="selectEstudioTecnologo" class="control-label">Tecnologo</label>
                              <?php $hvidainst->getSelectTecnologoBusqueda();?>
                      </div>
                      <div class="form-group">
                          <label for="selectEstudio" class="control-label">Pregrado</label>
                              <?php $hvidainst->getSelectPregradoBusqueda();?>
                      </div>
                      <div id="selectPosgrado" class="form-group">
                          <label for="selectEstudioPosBusqueda" class="control-label">Posgrado</label>
                              <?php $hvidainst->getSelectPosgradoBusqueda();?>
                      </div>
                      <div id="selectCertificacion" class="form-group">
                          <label for="selectEstudioCertificacion" class="control-label">Certificacion</label>
                              <?php $hvidainst->getSelectCertificacionBusqueda();?>
                      </div>
                  </form>
                </div>
          </div>
        </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
      </div>

    </div>
  </div>
</div>


<!-- /Modal -->
<?php include 'modal_estudios.php';?>
<!-- +++++++++++Submenu Hojas de vida+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
<div id="page-wrapper">
            <!-- /.row -->
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                    <div class="panel-body2">
                        <div class="panel-heading">

                            <div class="row">
                              <div class="col-md-6">

                              </div>

                              <div class="col-md-6 text-right">
                                  <!--Boton para crear una nueva hoja de vida-->
                                  <button id="btn_nuevoHvida" type="button" class="btn btn-primary  btn-limang" data-toggle="modal" data-target="#form_modal_hvida" <?php if ($crea != 1) {echo 'disabled="disabled"';}?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear Contrato</button>
                              </div>
                            </div>

                        </div>
                        <!-- /.panel Crear H_V -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="tbl_contrato">
                                    <thead>
                                        <tr>
                                            <th class="tabla-form-ancho">Nombres</th>
                                            <th class="tabla-form-ancho">Cedula</th>
                                            <th class="tabla-form-ancho">Empresa</th>
                                            <th class="tabla-form-ancho">Tipo de Contrato</th>
                                            <th class="tabla-form-ancho">Cargo</th>
                                            <th class="tabla-form-ancho">Ciudad</th>
                                            <th class="tabla-form-ancho">Inicio de Contrato</th>
                                            <th class="tabla-form-ancho">Fin de Contrato</th>
                                            <th data-orderable="false">Opciones</th>
                                        </tr>
                                    </thead>
                                    <!-- /.table-hojas de vida -->
                                    <tbody>
                                        <?php $hvidainst->getTablahvida($filtro);?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->

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


                </div>
        <div role="tabpanel" class="tab-pane" id="informes">
          <br>
          <?php /*
$recursosInst->createTableCertificaciones();
 */?>
        </div>

      </div>

    </div>
    <!-- /.panel-body -->

    </div>
    <!-- /.panel-body2 -->

  </div>
  <!-- /.panel -->


  </div>
  <!-- /.row -->

</div>
<!-- /#page-wrapper -->