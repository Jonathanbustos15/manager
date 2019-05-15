<?php
include "../controller/hvidaController.php";
include "../controller/formatosController.php";
include "../controller/proyectosController.php";
include "../controller/procesosController.php";

$hvidainst     = new HvidaController();
$formatoinst   = new FormatoController();
$proyectosinst = new proyectosController();
$procesosinst  = new procesosController();

$tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];
?>

<div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <!-- /Barrita amarilla -->
                    <div class="panel panel-default titulo-barra-amarilla">
                    <div class="icono_index"></div>
                      <div class="panel-body">
                        Menu RRHH
                      </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->


        <div class="row">

            <div class="menu-principal">

                <div class="col-md-6">

                <?php if ($tipoUsuario == 1 || $tipoUsuario == 2 || $tipoUsuario == 3 || $tipoUsuario == 4 || $tipoUsuario == 5 || $tipoUsuario == 8 || $tipoUsuario == 9 || $tipoUsuario == 10 || $tipoUsuario == 11 || $tipoUsuario == 13 || $tipoUsuario == 14) {?>
                    <div class="col-md-4 ajuste_index">
                        <a class="" href="hvida.php?s=*">
                            <img src="../img/b-hojasdevida.png" alt="Hojas de Vida">
                        </a>
                    </div>
                    <?php }?>

                <?php
if (($tipoUsuario == 1) || ($tipoUsuario == 4) || ($tipoUsuario == 8) || ($tipoUsuario == 9) || ($tipoUsuario == 10)) {
    ?>
                    <div class="col-md-4 ajuste_index">
                        <a class="" href="formatos.php">
                            <img src="../img/b-formatos.png" alt="Formatos" >
                        </a>
                    </div>
                    <?php }?>

                    <?php
if (($tipoUsuario == 1) || ($tipoUsuario == 4) || ($tipoUsuario == 8) || ($tipoUsuario == 11) || ($tipoUsuario == 13)) {
    ?>
                     <div class="col-md-4 ajuste_index">
                        <a class="" href="proyectos.php?filter=*">
                            <img src="../img/b-proyectos.png" alt="Proyectos" >
                        </a>
                    </div>
                    <?php }?>

                 <!-- ./.col-md-6 fichas-->
                </div>

                <div class="col-md-6">

                    <div class="panel panel-default">
                      <div class="panel-heading titulos-panel"><div class="icono_notificaciones"></div>Notificaciones de Procesos</div>
                      <div class="panel-body">
                        <!--Panel content-->
                        <?php $procesosinst->notIndexProcesos();?>
                      </div>
                    </div>

                    <div class="panel panel-default" hidden="true">
                      <div class="panel-heading titulos-panel"><div class="icono_profesionales"></div>Profesionales Disponibles</div>
                      <div class="panel-body">
                        <!--Panel content-->
                        <div id="morris-bar-chart"></div>
                      </div>
                    </div>

                <!-- ./.col-md-6 paneles-->
                </div>


                <!--Notificaciones Proceso Selección Abreviada de Menor Cuantía-->
                <div class="col-md-6">

                    <div class="panel panel-default">
                      <div class="panel-heading titulos-panel"><div class="icono_notificaciones"></div>Notificaciones Procesos : Selección Abreviada de Menor Cuantía</div>
                      <div class="panel-body">
                        <!--Panel content-->
                        <?php $procesosinst->notIndexProcesoSAdMC();?>
                      </div>
                    </div>

                    <div class="panel panel-default" hidden="true">
                      <div class="panel-heading titulos-panel"><div class="icono_profesionales"></div>Profesionales Disponibles</div>
                      <div class="panel-body">
                        <!--Panel content-->
                        <div id="morris-bar-chart"></div>
                      </div>
                    </div>
                    <?php
include "../controller/recursosController.php";

$recursosInst = new recursosController();

?>
<!-- Modal -->


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
/**/
$recursosInst->selectEmpleador();
?>
                    </select>
                </div>

                <div id="cargo" class="form-group">
                    <label for="fkID_cargo" class="control-label">Cargo</label>
                    <select name="fkID_cargo" id="fkID_cargo" class="form-control" required = "true">
                      <?php
$recursosInst->selectCargo();
?>
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
                      <?php
$recursosInst->selectCiudad();
?>
                    </select>
                </div>

                <div id="tipoContrato" class="form-group">
                    <label for="fkID_tipoContrato" class="control-label">Tipo Contrato</label>
                    <select name="fkID_tipoContrato" id="fkID_tipoContrato" class="form-control" required = "true">
                      <?php
$recursosInst->selectTipoContrato();
?>
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

                <?php
//Consulta los documentos
echo $recursosInst->getDocumentos();
?>

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
<?php
include "modal_empleados.php";
include "modal_cargos.php";
?>

<div id="page-wrapper">

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
  <div class="rowproc"></div>
  <!-- /.row -->

  <div class="row">

  <div class="panel panel-default">
  <div class="panel-body2">

    <div class="panel-heading">
      <div class="row">
        <div class="col-md-6">
            Recursos Humanos
        </div>
        <div class="col-md-6 text-right">
          <button id="btn_nuevoRecurso" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_recursos" <?php if ($crea != 1) {echo 'disabled="disabled"';}?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear Contrato</button>
        </div>
      </div>
    </div>
    <!-- /.panel-heading -->

    <div class="panel-body">

      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li id="li_p_oferta" role="presentation" class="active"><a href="#contratos" aria-controls="p_oferta" role="tab" data-toggle="tab">Contratos</a></li>
        <li id="li_certifiaciones" role="presentation"><a href="#certificaciones" aria-controls="certificaciones" role="tab" data-toggle="tab">Certificaciones</a></li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="contratos">
          <br>
          <?php
$recursosInst->createTableContratos();
?>
        </div>
        <div role="tabpanel" class="tab-pane" id="certificaciones">
          <br>
          <?php
$recursosInst->createTableCertificaciones();
?>
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

                <!-- ./.col-md-6 paneles-->
                </div>

             <!-- ./menu-principal -->
            </div>

        <!-- /.row -->
        </div>

</div>
<!-- /#page-wrapper -->
