<?php

include "../controller/hvidaController.php";

$hvidainst = new HvidaController();

//$busqueda = $_GET["s"];

//echo $busqueda;
//consulta los permisos con la cookie de id_tipo y el id_modulo

$arrPermisos = $hvidainst->permisos($id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);

$crea = $arrPermisos[0]["crear"];

if (isset($_GET["filter"])) {
    $filtro = $_GET["filter"];
} else {
    $filtro = '';
}

$tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];

//print_r($arrPermisos);
?>

<!-- Modal -->
<?php
include 'modal_hvida.php';
?>
<!-- /form modal 2-->

<!-- Modal de busqueda-->
<div class="modal fade" id="form_modal_busqueda_hvida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_busquedaHvida">-</h4>
      </div>
      <div class="modal-body">
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-modal reg-hv" role="tablist">
          <li role="presentation" class="active"><a href="#estudios_busqueda" aria-controls="estudios" role="tab" data-toggle="tab">Estudios</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

          <div role="tabpanel" class="tab-pane active" id="estudios_busqueda">
          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->


                <div class="">
                <br>

                <form id="form_busqueda">

                    <div class="form-group">
                        <label for="selectEstudioTecnico" class="control-label">Tecnico</label>
                            <?php
$hvidainst->getSelectTecnicoBusqueda();
?>
                    </div>

                    <div class="form-group">
                        <label for="selectEstudioTecnologo" class="control-label">Tecnologo</label>
                            <?php
$hvidainst->getSelectTecnologoBusqueda();
?>
                    </div>

                    <div class="form-group">
                        <label for="selectEstudio" class="control-label">Pregrado</label>
                            <?php
$hvidainst->getSelectPregradoBusqueda();
?>
                    </div>
                    <div id="selectPosgrado" class="form-group">
                        <label for="selectEstudioPosBusqueda" class="control-label">Posgrado</label>
                            <?php
$hvidainst->getSelectPosgradoBusqueda();
?>
                    </div>

                    <div id="selectCertificacion" class="form-group">
                        <label for="selectEstudioCertificacion" class="control-label">Certificacion</label>
                            <?php
$hvidainst->getSelectCertificacionBusqueda();
?>
                    </div>

                </form>

                    <hr>

                    <div class="form-group">
                        <form id="frm_estudios_busquedaHvida">

                        </form>
                    </div>


                </div>

          </div>

        </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
        <button id="btn_busquedahvida" type="button" class="btn btn-primary btn-limang" data-action="-">
            <span id="lbl_btn_busquedaHvida" class="btn-limang">-</span>
        </button>
      </div>
    </div>
  </div>
</div>


<!-- /Modal -->
<?php
include 'modal_estudios.php';
?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default titulo-barra-amarilla">
                    <div class="icono_hvs"></div>
                      <div class="panel-body">
                        Hojas de vida
                      </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row rowhv">

            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                    <div class="panel-body2">
                        <div class="panel-heading">

                            <div class="row">
                              <div class="col-md-6">

                                  Registro de Hojas de Vida

                              </div>

                              <div class="col-md-6 text-right">
                                  <!--<button id="btn_buscaHvida" type="button" class="btn btn-default" data-toggle="modal" data-target="#form_modal_Shvida"><span class="glyphicon glyphicon-search"></span>&nbspBúsqueda avanzada</button>-->
                                  <button id="btn_nuevoHvida" type="button" class="btn btn-primary  btn-limang" data-toggle="modal" data-target="#form_modal_hvida" <?php if ($crea != 1) {echo 'disabled="disabled"';}?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear Hoja de Vida</button>
                              </div>


                              <div class="col-md-10 text-left form-inline">

                                <br>

                                <label for="busqueda_estudios" class="control-label">Buscar por estudios</label>


                                <button class="btn btn-success" id="btn_buscar"><span class="glyphicon glyphicon-filter"></span>Buscar</button>

                                <button class="btn btn-success" id="btn_inicial">Inicial</button>
                                <hr>

                              </div>



                            </div>

                        </div>
                        <!-- /.panel-heading -->
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
                                    <tbody>
                                        <?php
//print_r($_COOKIE);
$hvidainst->
    getTablahvida($filtro);
?>
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
        <!-- /#page-wrapper -->
