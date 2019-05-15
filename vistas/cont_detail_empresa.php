<?php

include "../controller/empresaController.php";

$inst = new empresaController();

$pkID = $_GET["id_empresa"];

//hacer el metodo que llame todos los datos del
//proceso para mostrarlos en la vista individual
$empresaGen = $inst->getEmpresaId($pkID);

if (isset($_GET["filter"])) {
    $filtro = $_GET["filter"];
} else {
    $filtro = '';
}

//print_r($prueba);
?>

<!-- Modal documentos -->
<div class="modal fade" id="form_modal_certificaciones" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_certificacion">-</h4>
      </div>
      <div class="modal-body">

        <form id="form_certificados" method="POST" enctype="multipart/form-data">
            <br>
                <div class="form-group" hidden="true">
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>

                <div class="form-group">
                    <label for="fkID_entidad" class="control-label">Entidad</label>
                    <select name="fkID_entidad" id="fkID_entidad" class="form-control add-selectElement" required = "true">
                        <option></option>
                        <?php
/**/
$entidadSelect = $inst->getEntidadEmpresaSelect();
for ($i = 0; $i < sizeof($entidadSelect); $i++) {
    echo '<option value="' . $entidadSelect[$i]["pkID"] . '">' . $entidadSelect[$i]["nombre_entidad"] . '</option>';
}
;
?>
                    </select>
                    <!--<a href="entidades.php" target="_blank" title="Añadir Entidad" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a>-->
                    <button id="btn_nuevoentidad" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_entidad"><span class="glyphicon glyphicon-plus"></span></button>
                </div>

                <div class="form-group">
                    <label for="objeto" class="control-label">Objeto</label>
                    <textarea class="form-control" id="objeto" name="objeto" placeholder="Objeto del proyecto" required = "true"></textarea>
                </div>

                <div class="form-group">
                    <label for="rup_id" class="control-label">Rup</label>
                    <input type="number" class="form-control" id="rup" name="rup" placeholder="Consecutivo RUP" required = "true">
                </div>
                <div class="form-group" hidden="true">
                    <input class="form-control" id="valor" name="valor" "Valor." required = "true"></input>
                </div>

                <div class="form-group">
                    <label for="valor" class="control-label">Valor</label>
                      <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input class="form-control" id="valor_mask" type="text"  required = "true">
                      </div>
                </div>

                <div class="form-group">
                    <label for="fechaIni" class="control-label">Fecha Inicial</label>
                    <input type="text" class="form-control" id="fechaIni" name="fechaIni" placeholder="Fecha de inicio" required = "true">
                </div>

                <div class="form-group">
                    <label for="fechaFin" class="control-label">Fecha Final</label>
                    <input type="text" class="form-control" id="fechaFin" name="fechaFin" placeholder="Fecha de finalizacion" required = "true">
                </div>

                <div class="form-group">
                    <label for="nom_certi" class="control-label">Nombre</label>
                    <input type="text" class="form-control" id="nom_certi" name="nom_certi" placeholder="Nombre del certificado." required = "true">
                </div>

                <div class="form-group">
                    <label for="archivo" class="control-label">Archivo 1</label>
                    <input type="file" class="form-control" id="archivo" name="archivo" placeholder="Archivo" multiple="">
                    <input type="hidden" name="ruta" id="ruta">
                </div>

                <div class="form-group" hidden>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="fkID_empresa" name="fkID_empresa" value= <?php echo $empresaGen[0]["pkID"]; ?> >
                    </div>
                </div>
        </form>

        <div id="not_docs_empresa" class="alert alert-info">

        </div>

      </div>

      <div class="modal-footer">
        <button id="btn_actioncertificacion" type="button" class="btn btn-primary" data-action="-">
            <span id="lbl_btn_actioncertificacion">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>

</div>

<!-- ./form modal documentos-->

<?php
include "modal_indicadores_financieros.php";
include "modal_docslegales_empresa.php";
include "modal_entidades.php";
?>


<div id="page-wrapper">

  <div class="row">

      <div class="col-lg-12">
          <div class="panel panel-default titulo-barra-amarilla">
          <div class=""></div>
            <div class="panel-body">
              Empresa <?php echo $empresaGen[0]["nombre"] ?>
            </div>
          </div>
      </div>
      <!-- /.col-lg-12 -->

      <div class="col-lg-12">
          <ol class="breadcrumb">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="empresa.php">Empresas</a></li>
            <li class="active">Detalles empresa <?php echo $empresaGen[0]["nombre"] ?> </li>
          </ol>
      </div>

  <div class="row">

      <div class="col-lg-12">

      <!-- Nav tabs -->
        <ul class="nav nav-tabs tabs-proc3" role="tablist">
          <li id="li_general" role="presentation"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>
          <li id="li_certificados" role="presentation"><a href="#certificados" aria-controls="general" role="tab" data-toggle="tab">Certificación de Experiencia</a></li>
          <li id="li_infoFinanciera" role="presentation"><a href="#infoFinanciera" aria-controls="general" role="tab" data-toggle="tab">Información Financiera</a></li>
          <li id="li_docsLegales" role="presentation"><a href="#docsLegales" aria-controls="general" role="tab" data-toggle="tab">Documentos Legales</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

            <div role="tabpanel" class="tab-pane" id="general">
              <br>
              <!-- contenido general -->
              <div class="panel panel-default proc-pan-def3">
                <div class="panel-body">

                  <!-- instancia php controller -->
                  <?php $inst->getDataEmpresaGen($pkID);?>


                </div>
              </div>
              <!-- /.contenido general -->

            </div>


            <?php
//id del modulo=26 info_financiera
$arrPermisosInfoFinanciera = $inst->permisos(26, $_COOKIE["log_lunelAdmin_IDtipo"]);
$creaInfoFinanciera        = $arrPermisosInfoFinanciera[0]["crear"];
//echo "crea documentos=".$creaDocumentos;
?>

            <div role="tabpanel" class="tab-pane" id="infoFinanciera">
              <br>
              <!-- contenido general -->
              <div class="panel panel-default">

                <div class="panel-body">
                  <!-- instancia php controller -->
                  <br>
                  <div class="panel panel-default proc-detl6">

                    <div class="panel-heading">
                      <div class="row">
                        <div class="col-md-6">
                            Registro de Información Financiera
                        </div>
                        <div class="col-md-6 text-right">
                          <button id="btn_nuevoinfo_financiera" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#frm_modal_info_financiera" <?php if ($creaInfoFinanciera != 1) {echo 'disabled="disabled"';}?> ><span class="glyphicon glyphicon-plus"></span>&nbspAñadir Información Financiera</button>
                        </div>
                      </div>
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">

                    <div class="dataTable_wrapper table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="tbl_info_financiera">
                          <thead>
                              <tr>
                                  <th>Año</th>
                                  <th>Liquidez</th>
                                  <th>Capital de Trabajo</th>
                                  <th>Rentabilidad Patrimonio</th>
                                  <th>Endeudamiento</th>
                                  <th>Razón de cobertura de Intereses</th>
                                  <th>Rentabilidad del Activo</th>
                                  <th>Patrimonio</th>
                                  <th data-orderable="false" class="tabla-form-ancho">Opciones</th>
                              </tr>
                          </thead>
                          <tbody>
                             <?php $inst->getTablaInfoFinanciera($pkID);?>
                          </tbody>
                      </table>
                    </div>

                    </div>
                    <!-- /.panel-body -->

                  </div>
                  <!-- /.panel -->

                </div>

              </div>
              <!-- /.contenido general -->

            </div>


        <div role="tabpanel" class="tab-pane" id="certificados">

          <div>

          <?php
//id del modulo=25
$arrPermisosCertificados = $inst->permisos(25, $_COOKIE["log_lunelAdmin_IDtipo"]);
$creaCertificacion       = $arrPermisosCertificados[0]["crear"];
//echo "crea documentos=".$creaDocumentos;
?>

          <!-- Tab panes -->
          <div class="tab-content">

            <div role="tabpanel" class="tab-pane active" id="admin">
                <br>
                <!-- contenido general -->
                  <div class="panel panel-default">

                    <div class="panel-body">
                      <!-- instancia php controller -->
                      <br>
                      <div class="panel panel-default proc-detl6">

                        <div class="panel-heading">
                          <div class="row">
                            <div class="col-md-6">
                                Registro de Certificación de Experiencia
                            </div>
                            <div class="col-md-6 text-right">
                              <button id="btn_nuevoCertificacion" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_certificaciones" <?php if ($creaCertificacion != 1) {echo 'disabled="disabled"';}?> ><span class="glyphicon glyphicon-plus"></span>&nbspAñadir Certificado</button>
                            </div>
                          </div>
                        </div>
                        <!-- /.panel-heading -->

                        <div class="panel-body">

                        <div class="dataTable_wrapper table-responsive">
                          <table class="table table-striped table-bordered table-hover" id="tbl_certificados">
                              <thead>
                                  <tr>
                                      <!--<th>Id</th>-->
                                      <!--<th>Tipo</th>
                                      <th class="tabla-form-ancho">ID</th>-->
                                      <th class="tabla-form-ancho" width="100px">Año Finalización</th>
                                      <th class="tabla-form-ancho">Rup</th>
                                      <th class="tabla-form-ancho" width="250px">Entidad</th>
                                      <th class="tabla-form-ancho">Objeto</th>
                                      <th class="tabla-form-ancho">Valor</th>
                                     <!-- <th class="tabla-form-ancho">Nombre</th>  -->
                                      <th data-orderable="false"  class="tabla-form-ancho" width="100px">Opciones</th>
                                  </tr>
                              </thead>
                              <tbody>
                                 <?php $inst->getTablaCertificacionEmpresa($pkID);?>
                              </tbody>
                          </table>
                        </div>

                          <div  hidden="true">
                            <input type="text" id="id_empresa" value=<?php echo $pkID; ?> >
                          </div>

                        </div>
                        <!-- /.panel-body -->

                      </div>
                      <!-- /.panel -->

                    </div>

                  </div>
                  <!-- /.contenido general -->
            </div>
            <div role="tabpanel" class="tab-pane" id="ver">

              <br>
              <div id="tree"></div>

            </div>
          </div>

        </div>


        </div>


        <div role="tabpanel" class="tab-pane" id="docsLegales">

          <div>

          <?php
//id del modulo=26
$arrPermisosDocslegales = $inst->permisos(27, $_COOKIE["log_lunelAdmin_IDtipo"]);
$creadocslegal          = $arrPermisosDocslegales[0]["crear"];
//echo "crea documentos=".$creaDocumentos;
?>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="admin">
                <br>
                <!-- contenido general -->
                  <div class="panel panel-default">

                    <div class="panel-body">
                      <!-- instancia php controller -->
                      <br>
                      <div class="panel panel-default proc-detl6">

                        <div class="panel-heading">
                          <div class="row">
                            <div class="col-md-6">
                                Registro de Documentos Legales
                            </div>
                            <div class="col-md-6 text-right">
                              <button id="btn_nuevoDoclegal" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_docslegales" <?php if ($creadocslegal != 1) {echo 'disabled="disabled"';}?> ><span class="glyphicon glyphicon-plus"></span>&nbspAñadir Documento Legal</button>
                            </div>


                          </div>
                        </div>
                        <!-- /.panel-heading -->


                        <div class="panel-body">

                        <div class="dataTable_wrapper table-responsive">
                          <table class="table table-striped table-bordered table-hover" id="tbl_doclegal">
                              <thead>
                                  <tr>
                                      <!--<th>Id</th>-->
                                      <!--<th>Tipo</th>
                                      <th class="tabla-form-ancho">ID</th>-->
                                      <th class="tabla-form-ancho" width="100px">Año Expedición</th>
                                      <th class="tabla-form-ancho">Nombre</th>
                                      <th data-orderable="false"  class="tabla-form-ancho" width="150px">Opciones</th>
                                  </tr>
                              </thead>
                              <tbody>
                                 <?php $inst->getTablaDocsLegalesEmpresa($pkID);?>
                              </tbody>
                          </table>
                        </div>

                          <div  hidden="true">
                            <input type="text" id="id_empresa" value=<?php echo $pkID; ?> >
                          </div>

                        </div>
                        <!-- /.panel-body -->

                      </div>
                      <!-- /.panel -->

                    </div>

                  </div>
                  <!-- /.contenido general -->
            </div>
            <div role="tabpanel" class="tab-pane" id="ver">

              <br>
              <div id="tree"></div>

            </div>
          </div>

        </div>


        </div>

      </div>

    </div>


  </div>
  <!-- /.row -->

</div>