<?php

    //ini_set('error_reporting', E_ALL|E_STRICT);
    //ini_set('display_errors', 1); 

    include("../controller/proyectosController.php");    
    include("../controller/ingresos_gralController.php");    

    $inst = new proyectosController();

    $pkID = $_GET["id_proyecto"];

    $proyectoGen = $inst->getProyectoId($pkID);

    //print_r($proyectoGen);

    $filtro_gastos = $_GET["filter_gastos"];

    $filtro_documentos = $_GET["filter_documentos"];

    //---------------------------------------------------------------------------
    include('../controller/gastos_gralController.php'); 
  
    $gastos_gralInst = new gastos_gralController();
    $ingresos_gralInst = new ingresos_gralController();
    //---------------------------------------------------------------------------
?>

<!-- Modal presupuesto -->
<div class="modal fade" id="form_modal_presupuesto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_presupuesto">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_presupuesto" method="POST">                
            <br>
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>
                                                       
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>                        
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de Gasto." required = "true">                        
                </div>
                
                <div class="form-group">
                    <label for="fkID_actividad" class="control-label">Actividad</label>                        
                    <?php $inst->selectActividades($pkID); ?>
                    <!--<a href="entidades.php" target="_blank" title="Añadir Entidad" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a>-->
                    <button id="btn_nuevoactividad" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_actividad"><span class="glyphicon glyphicon-plus"></span></button>
                </div>

                <div class="form-group">
                    <label for="nom_archivo" class="control-label">Archivo</label>                        
                    <input type="file" class="form-control" id="file" name="file">
                    <div hidden="true">
                      <input type="text" name="nom_archivo" id="nom_archivo"> 
                    </div>                                          
                </div>
                                
                <hr>
                <label for="valor" class="control-label">Valor Contratado</label> 
                <hr>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="vc_subtotal" name="vc_subtotal" required = "true">
                </div>
                
            
                <div class="form-group">
                    <label for="valor" class="control-label">Subtotal</label>            
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="vc_subtotal_mask" type="text" class="form-control" required="true">                      
                    </div>

                </div>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="vc_iva" name="vc_iva" required = "true">
                </div>
                
                <div class="form-group">
                    <label for="vc_iva_mask" class="control-label">IVA</label>            
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="vc_iva_mask" type="text" class="form-control" required="true">                      
                    </div>

                </div>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="vc_total" name="vc_total" required = "true">
                </div>

                <div class="form-group">
                    <label for="vc_total_mask" class="control-label">Total</label>            
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="vc_total_mask" type="text" class="form-control" readonly="true" required="true">                      
                    </div>

                </div>
                <!-- -->

                <hr>
                <label for="">Valor Real</label>
                <hr>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="valor" name="valor" required = "true">
                </div>
                
            
                <div class="form-group">
                    <label for="valor" class="control-label">Valor</label>            
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="valor_mask" type="text" class="form-control" required="true">                      
                    </div>

                </div>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="iva" name="iva" required = "true">
                </div>
                
                <div class="form-group">
                    <label for="iva_mask" class="control-label">IVA</label>            
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="iva_mask" type="text" class="form-control" required="true">                      
                    </div>

                </div>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="total" name="total" required = "true">
                </div>

                <div class="form-group">
                    <label for="total_mask" class="control-label">Total</label>            
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="total_mask" type="text" class="form-control" readonly="true" required="true">                      
                    </div>

                </div>

                <!-- -->

                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="fkID_proyecto" name="fkID_proyecto" value= <?php echo $proyectoGen[0]["pkID"]; ?> >
                    </div>
                </div> 
        </form>
                
      </div>

      <div class="modal-footer">    
        <button id="btn_actionPresupuesto" type="button" class="btn btn-primary" data-action="-" disabled="disabled">
            <span id="lbl_btn_actionPresupuesto">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>
  
<!-- /form modal presupuesto-->



<!-- Modal documentos -->
<div class="modal fade" id="form_modal_documentos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_documentos">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_documentos" method="POST" enctype="multipart/form-data">                
            <br>
                <div class="form-group" hidden="true">                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>

                <div class="form-group">
                    <label for="fkID_tipo" class="control-label">Categoría</label>                        
                    <select name="fkID_tipo" id="fkID_tipo" class="form-control add-selectElement" required = "true">
                        <option></option>  
                        <?php 
                            //$inst->getSelectTipoDocumento();
                         ?>
                    </select>
                    <!--<a href="#" target="_blank" title="Añadir Tipo de Documento" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a>-->
                    <button id="btn_nuevotdocumento" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_tdocumento"><span class="glyphicon glyphicon-plus"></span></button>
                </div>

                <div class="form-group" id="sub_tipo" hidden="true">
                    <label for="fkID_subtipo" class="control-label">Sub Categoría</label>                        
                    <select name="fkID_subtipo" id="fkID_subtipo" class="form-control add-selectElement">
                        <option></option>                        
                    </select>
                    <!--<a href="#" target="_blank" title="Añadir Tipo de Documento" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a>-->
                    <button id="btn_nuevosubtdocumento" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_subtdocumento"><span class="glyphicon glyphicon-plus"></span></button>
                </div>
                <!--                                          
                <div class="form-group">
                    <label for="nom_doc" class="control-label">Nombre</label>                        
                    <input type="text" class="form-control" id="nom_doc" name="nom_doc" placeholder="Nombre de documento." required = "true">                        
                </div>
                -->
                <div class="form-group">
                    <label for="archivo" class="control-label">Archivo</label>
                    <!--                        
                    <input type="file" class="form-control" id="archivo" name="archivo" placeholder="Archivo"> 
                    <input type="hidden" name="ruta" id="ruta">-->
                    <input id="fileupload" type="file" name="files[]" data-url="../server/php/" multiple>
                </div>

                <br>
                <div id="res_form"></div>
              
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="fkID_proyecto" name="fkID_proyecto" value= <?php echo $proyectoGen[0]["pkID"]; ?> >
                    </div>
                </div> 
        </form>

        
                
      </div>

      <!--  /notificacion de subida de archivo.-->

      <div id="not_documentos_proyecto" class="alert alert-info">
        
      </div>

      <div class="modal-footer">    
        <button id="btn_actiondocumentos" type="button" class="btn btn-primary" data-action="-">
            <span id="lbl_btn_actiondocumentos">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>
  
<!-- ./form modal documentos-->

<?php 
  include("modal_tdocumento.php");
  include("modal_subtdocumento.php");
  include("modal_hv_personal.php");
  include("modal_actividad.php");
  include("modal_observaciones_proceso.php");
 ?>
<div id="page-wrapper">

  <div class="row">

      <div class="col-lg-12">          
           <div class="panel panel-default titulo-barra-amarilla">
              <div class="icono_proyectos"></div>
                <div class="panel-body">
                  Proyecto <?php echo $proyectoGen[0]["nombre"] ?>
                </div>
            </div>
      </div>        
      <!-- /.col-lg-12 -->

      <div class="col-lg-12 rowproy-det">
          <ol class="breadcrumb">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="proyectos.php?filter=*">Proyectos</a></li>
            <li class="active">Detalles proyecto <?php echo $proyectoGen[0]["nombre"] ?> </li>
          </ol>
      </div>
      
  </div>
  <!-- /.row -->

  <div class="row">


    <div class="col-lg-12">

    <!-- permisos para presupuesto -->
      <?php
      //id del modulo=9 
        $arrPermisosPresupuesto = $inst->permisos(9,$_COOKIE["log_lunelAdmin_IDtipo"]);
        $creaPresupuesto = $arrPermisosPresupuesto[0]["crear"];
        $consPresupuesto = $arrPermisosPresupuesto[0]["consultar"];          
       ?>
    
    <!-- permisos para documentos --> 
      <?php
      //id del modulo=10
        $arrPermisosDocumentos = $inst->permisos(10,$_COOKIE["log_lunelAdmin_IDtipo"]);
        $creaDocumentos = $arrPermisosDocumentos[0]["crear"];
        $consDocumentos = $arrPermisosDocumentos[0]["consultar"];          
       ?>

    <!-- permisos para personal --> 

      <?php
      //id del modulo=11
        $arrPermisosPersonal = $inst->permisos(11,$_COOKIE["log_lunelAdmin_IDtipo"]);
        $creaPersonal = $arrPermisosPersonal[0]["crear"];
        $consPersonal = $arrPermisosPersonal[0]["consultar"];          
       ?>

    <!-- permisos para gastos -->
      <?php
        //id del modulo=18
          $arrPermisosProy_gastos = $inst->permisos(18,$_COOKIE["log_lunelAdmin_IDtipo"]);
          $consProy_gastos = $arrPermisosProy_gastos[0]["consultar"];                
      ?>

      <!-- Nav tabs -->
      <ul class="nav nav-tabs proy-doc2" role="tablist">
        <li id="li_general" role="presentation"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>
        
        <li id="li_presupuesto" role="presentation" <?php if ($consPresupuesto != 1){echo 'style="display: none;"';} ?> ><a href="#presupuesto" aria-controls="presupuesto" role="tab" data-toggle="tab">Presupuesto</a></li>
        <li id="li_documentos" role="presentation" <?php if ($consDocumentos != 1){echo 'style="display: none;"';} ?> ><a href="#documentos" aria-controls="documentos" role="tab" data-toggle="tab">Documentos</a></li>
        <li id="li_personal" role="presentation" <?php if ($consPersonal != 1){echo 'style="display: none;"';} ?> ><a href="#personal" aria-controls="personal" role="tab" data-toggle="tab">Personal</a></li>
        <li id="li_seguimiento" role="presentation"><a href="#seguimiento" aria-controls="general" role="tab" data-toggle="tab">Seguimiento</a></li>
      
        <li id="li_gastos2" role="presentation" <?php if ($consProy_gastos != 1){echo 'style="display: none;"';} ?> ><a href="#gastos_2" aria-controls="gastos_2" role="tab" data-toggle="tab">Gastos</a></li>
        <li id="li_facturas" role="presentation" <?php if ($consProy_gastos != 1){echo 'style="display: none;"';} ?> ><a href="#facturas" aria-controls="facturas" role="tab" data-toggle="tab">Facturas</a></li>
        <!--  -->
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">

        <div role="tabpanel" class="tab-pane" id="general">
          <br>
          <!-- contenido general -->
          <div class="panel panel-default detl-proy-panel">
            <div class="panel-body">
              <!-- instancia php controller -->
              <?php $inst->getDataGenProyecto($pkID); ?>
            </div>
          </div>
          <!-- /.contenido general -->

        </div>
        
        <div role="tabpanel" class="tab-pane" id="presupuesto">
            <!-- ./*******++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
            <br>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li id="li_admin_presupuesto" class="active" role="tab"><a href="#admin_presupuesto" aria-controls="admin_presupuesto" role="tab" data-toggle="tab">Administrar</a></li>
              <li id="li_ver_presupuesto" role="tab"><a href="#ver_presupuesto" aria-controls="ver_presupuesto" role="tab" data-toggle="tab">Ver</a></li>              
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="admin_presupuesto">
              <!-- ./admin -->
                <br>
                <!-- ./filtro de gastos -->
                <div class="col-md-10 text-left form-inline">
                  
                  <br>

                  <h4 class="text-left"><span class="glyphicon glyphicon-filter"></span><strong>Filtro</strong></h4>
                  
                  <label for="actividad_filtro" class="control-label">Actividades</label>                                            
                  <?php
                      //$gastos_gralInst->getSelectEmpresasFiltro();
                      $inst->selectActividadesFiltro($pkID);
                   ?>                  
                  
                  &nbsp &nbsp &nbsp
                  <button class="btn btn-primary btn-limang" id="btn_filtrar"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
                  
                  <hr>

                </div>
                <!-- ./filtro de gastos -->
                <div class="panel panel-default proyec-marg5">

                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-md-6">
                          Registro de Presupuesto
                      </div>
                      <div class="col-md-6 text-right">
                        <a class="btn btn-success" href=<?php echo "actividades.php?id_proyecto=".$pkID; ?>><span class="glyphicon glyphicon-info-sign"></span>&nbspVer Actividades</a>
                        <button id="btn_nuevoPresupuesto" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_presupuesto" <?php if ($creaPresupuesto != 1){echo 'disabled="disabled"';} ?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear Gasto</button>                        
                      </div>
                    </div>
                  </div>
                  <!-- /.panel-heading -->

                  <div class="panel-body">

                  <div class="dataTable_wrapper table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="tbl_presupuesto">
                          <thead>
                              <tr>
                                  <!--<th>Id</th>
                                  <th class="tabla-form-ancho">ID</th>-->
                                  <th class="tabla-form-ancho">Nombre</th>                                  
                                  <th class="tabla-form-ancho">Actividad</th>
                                  <th class="tabla-form-ancho">Valor</th>
                                  <th class="tabla-form-ancho">IVA</th>
                                  <th class="tabla-form-ancho">Total</th>
                                  <th data-orderable="false" class="tabla-form-ancho">Opciones</th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php $inst->getTablaPresupuesto($pkID,$filtro_gastos); //$filtro_gastos?>
                          </tbody>
                      </table>
                  </div>

                  </div>
                  <!-- /.panel-body -->
                
                </div>
                <!-- /.panel -->

                <hr>
                <!-- footer de la tabla de presupuesto -->
                <div class="row">
            
                  <div class="col-md-12 text-right">
                    
                    <form class="form-inline">
                      <!--<hr>-->
                      <div class="form-group">
                          <label class="control-label"><u>Presupuesto</u>&nbsp&nbsp</label>                          
                      </div>

                      <div class="form-group">
                          <label for="total_f" class="control-label">Sub-Total $</label>                        
                          <input type="text" readonly="true" class="form-control" id="total_f" name="total_f" value=<?php $inst->getTotalGastosF($proyectoGen[0]["pkID"],$filtro_gastos); ?> >                        
                      </div>
                      
                      <div class="form-group">
                          <label for="total_iva" class="control-label">IVA $</label>                        
                          <input type="text" readonly="true" class="form-control" id="total_iva" name="total_iva" value=<?php $inst->getTotalIvaF($proyectoGen[0]["pkID"],$filtro_gastos); ?> >                        
                      </div>
                      
                      <div class="form-group">
                          <label for="total_final" class="control-label">Total $</label>                        
                          <input type="text" readonly="true" class="form-control" id="total_final" name="total_final" value=<?php $inst->getTotalFinalF($proyectoGen[0]["pkID"],$filtro_gastos); ?> style="border: 3px solid;">                        
                      </div>
                      <hr>
                      <!--<br><br>-->
                      <div <?php if ($filtro_gastos != '*') { echo 'hidden="true"'; } ?> >
                      <!--contenedor valores *-->
                        <div class="form-group">
                            <label class="control-label"><u>Valor del Proyecto</u>&nbsp&nbsp</label>                          
                        </div>

                        <div class="form-group">
                            <label for="pres_total" class="control-label">Sub-Total $</label>                        
                            <input readonly="true" type="text" class="form-control" id="pres_total" name="pres_total" value = <?php echo $proyectoGen[0]["subtotal"]; ?> >                        
                        </div>

                        <div class="form-group">
                            <label for="pres_total" class="control-label">IVA $</label>                        
                            <input readonly="true" type="text" class="form-control" id="iva_proyecto" name="iva_proyecto" value = <?php echo $proyectoGen[0]["iva"]; ?> >                        
                        </div>

                        <div class="form-group">
                            <label for="pres_total" class="control-label">Total $</label>                        
                            <input readonly="true" type="text" class="form-control" id="total_proyecto" name="total_proyecto" value = <?php echo $proyectoGen[0]["total"]; ?> style="border: 3px solid;" >                        
                        </div>

                        <hr>
                        
                        <div class="form-group">
                            <label for="utilidad" class="control-label"> IVA por pagar $</label>                        
                            <input readonly="true" type="text" class="form-control" id="iva_pagar" name="iva_pagar" placeholder = "Calculando..." title="IVA por pagar calculado entre los IVA del presupuesto y del costo del proyecto.">                        
                        </div>

                        <div class="form-group">
                            <label for="utilidad" class="control-label">Rentabilidad Apróximada $</label>                        
                            <input readonly="true" type="text" class="form-control" id="utilidad" name="utilidad" placeholder = "Calculando..." title="Rentabilidad apróximada calculada entre los subtotales del presupuesto y del valor del proyecto.">                        
                        </div>
                      <!--contenedor valores *-->
                      </div>

                      <hr>

                    </form>
                  
                  </div>
                  
                </div>
                <!-- ./footer de la tabla de presupuesto -->
              <!-- ./admin -->
              </div>
              <div role="tabpanel" class="tab-pane" id="ver_presupuesto">
                <br>
                <div id="tree_presupuesto"></div>
                <div id="tree_presupuestoNo"></div>
                <!-- /.prueba muestra treeview presupuesto -->
              </div>

            </div>                    
           <!-- ./*******++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
        </div> 

               

        <div role="tabpanel" class="tab-pane" id="documentos">

          <br>
            <div class="dataTable_wrapper">

             <!-- Nav tabs -->
            <ul class="nav nav-tabs admin-doc-proy" role="tablist">
              <li id="li_ver" class="active" ><a href="#ver" aria-controls="ver" role="tab" data-toggle="tab">Ver</a></li>
              <li id="li_admin"><a href="#admin" aria-controls="admin" role="tab" data-toggle="tab">Administrar</a></li>              
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane" id="admin">
                <br>
                <!-- ./filtro de documentos -->
                <div class="col-md-10 text-left form-inline">
                  
                  <br>

                  <h4 class="text-left"><span class="glyphicon glyphicon-filter"></span><strong>Filtro</strong></h4>
                  
                  <label for="actividad_filtro" class="control-label">Tipo de Documento</label>                                            
                  <?php
                      //$gastos_gralInst->getSelectEmpresasFiltro();
                      $inst->selectTipoDocumentosFiltro();
                   ?>                  
                  
                  &nbsp &nbsp &nbsp
                  <button class="btn btn-primary btn-limang" id="btn_filtrarDocumentos"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
                  
                  <hr>

                </div>
                <!-- ./filtro de documentos -->
                <div class="panel panel-default proyec-marg5">

                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-md-6">
                          Administracion de Documentos para Proyectos
                      </div>
                      <div class="col-md-6 text-right">
                        <button id="btn_nuevoDocumento" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_documentos" <?php if ($creaDocumentos != 1){echo 'disabled="disabled"';} ?>><span class="glyphicon glyphicon-plus"></span>&nbspAñadir Documento</button>  
                      </div>
                    </div>
                  </div>
                  <!-- /.panel-heading -->
                  
                  <div class="panel-body">

                  <div class="dataTable_wrapper table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="tbl_documentos">
                        <thead>
                            <tr>
                                <!--<th>Id</th>
                                <th class="tabla-form-ancho">ID</th>-->
                                <th class="tabla-form-ancho">Categoría</th>
                                <th class="tabla-form-ancho">Sub Categoría</th>
                                <th class="tabla-form-ancho">Nombre</th>                                                            
                                <th data-orderable="false"  class="tabla-form-ancho">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $inst->getTablaDocumentos($pkID,$filtro_documentos); ?>
                        </tbody>
                    </table>
                  </div>
                  <!-- /.prueba muestra documentos treeview -->
                  <div  hidden="true">
                    <input type="text" id="id_proyecto" value=<?php echo $pkID; ?> >
                  </div>

                  </div>
                  <!-- /.panel-body -->
                
                </div>
                <!-- /.panel -->                

              </div>
              <div role="tabpanel" class="tab-pane active" id="ver">
                <br>
                <div id="tree"></div>
                <div id="tree_objt"></div>
                <!-- /.prueba muestra documentos treeview -->
              </div>

            </div>        
                
                
            </div>                  

        </div>
        
        

        <div role="tabpanel" class="tab-pane" id="personal">
          <h2 class="personas-asignadas">Personas asignadas a este proyecto</h2>
          <br>
            
            <div class="panel panel-default proyec-marg5">

              <div class="panel-heading">
                <div class="row">
                  <div class="col-md-6">
                      Registro de Personas asignadas al proyecto Lunel-IE
                  </div>
                  <div class="col-md-6 text-right">
                    <button id="btn_nuevopersonal" type="button" class="btn btn-success btn-limang" data-toggle="modal" data-target="#form_modal_personal" <?php if ($creaPersonal != 1){echo 'disabled="disabled"';} ?>><span class="glyphicon glyphicon-plus"></span> Añadir Personal</button> 
                  </div>
                </div>
              </div>
              <!-- /.panel-heading -->
              
              <div class="panel-body">

              <div class="dataTable_wrapper table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="tbl_personal">
                      <thead>
                          <tr>
                              <!--<th class="tabla-form-ancho">ID</th>-->
                              <th class="tabla-form-ancho">C.C.</th>
                              <th class="tabla-form-ancho">Nombre</th>
                              <th class="tabla-form-ancho">Apellido</th>
                              <th class="tabla-form-ancho">Teléfono</th>
                              <th class="tabla-form-ancho">Email</th>
                              <th class="tabla-form-ancho">Rol</th>
                              <th class="tabla-form-ancho">Observaciones</th>                            
                              <th data-orderable="false"  class="tabla-form-ancho">Opciones</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php $personalinst->getTablaPersonalProyecto($pkID); ?>
                      </tbody>
                  </table>
              </div>

              </div>
              <!-- /.panel-body -->
            
            </div>
            <!-- /.panel -->

            <hr>
          
        </div>

        <div role="tabpanel" class="tab-pane" id="seguimiento">
          <br>
          <!-- contenido general -->
          <div class="panel panel-default detl-proc4 def-proc5">
            <div class="panel-body">

            <div class="row">
              
              <div class="col-md-8">
                <!-- instancia php controller -->
                <?php $inst->getObservacionesProyecto(); ?> 
              </div>

              <div class="col-md-4 text-right">
                <button id="btn_nuevoobservacion" class="btn btn-success" data-toggle="modal" data-target="#form_modal_observacion"><span class="glyphicon glyphicon-plus"></span> Nueva Observación</button>
              </div>

            </div>
              
                                           
            </div>
          </div>
          <!-- /.contenido general -->

        </div>


        <div role="tabpanel" class="tab-pane" id="gastos">
        
          <br>
            
            <div class="panel panel-default proyec-marg5">

              <div class="panel-heading">
                <div class="row">
                  <div class="col-md-6">
                      Registro de Gastos al proyecto
                  </div>
                  <div class="col-md-6 text-right">
                    
                  </div>
                </div>
              </div>
              <!-- /.panel-heading -->
              
              <div class="panel-body">

              <div class="dataTable_wrapper table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="tbl_gastosProyecto">
                      <thead>
                          <tr>                              
                              <th class="tabla-form-ancho">Beneficiario</th>                                            
                              <th class="tabla-form-ancho">Descripcion</th>
                              <th class="tabla-form-ancho">Fecha Límite</th>
                              <th class="tabla-form-ancho">Valor</th>
                              <th class="tabla-form-ancho">Observaciones</th>
                              <th class="tabla-form-ancho">Actividad</th>                              
                          </tr>
                      </thead>
                      <tbody>
                          <?php $gastos_gralInst->getTablagastos_gralProyecto($pkID); ?>
                      </tbody>
                  </table>
                  <hr>
                  <div class="col-md-6"></div>
                  <div class="col-md-6">                            
                      <label for="total_gastosProyecto" class="control-label">Total Gastos</label>                                
                      <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" class="form-control" id="total_gastosProyecto" name="total_gastosProyecto" readonly="true" value=<?php $gastos_gralInst->getSumagastosValProyecto($pkID); ?>>
                      </div>
                  </div>
              </div>

              </div>
              <!-- /.panel-body -->
            
            </div>
            <!-- /.panel -->

            <hr>
        </div>



<div role="tabpanel" class="tab-pane" id="gastos_2">
            <!-- ./*******++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
            <br>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li id="li_admin_gastos" class="active" role="tab"><a href="#admin_gastos" aria-controls="admin_gastos" role="tab" data-toggle="tab">Administrar</a></li>
              <li id="li_ver_gastos" role="tab"><a href="#ver_gastos" aria-controls="ver_gastos" role="tab" data-toggle="tab">Ver</a></li>              
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="admin_gastos">
              <!-- ./admin -->
               <br>
            
            <div class="panel panel-default proyec-marg5">

              <div class="panel-heading">
                <div class="row">
                  <div class="col-md-6">
                      Registro de Gastos al proyecto
                  </div>
                  <div class="col-md-6 text-right">
                    
                  </div>
                </div>
              </div>
              <!-- /.panel-heading -->
              
              <div class="panel-body">

              <div class="dataTable_wrapper table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="tbl_gastosProyecto">
                      <thead>
                          <tr>                              
                              <th class="tabla-form-ancho">Beneficiario</th>                                            
                              <th class="tabla-form-ancho">Descripcion</th>
                              <th class="tabla-form-ancho">Fecha Límite</th>
                              <th class="tabla-form-ancho">Valor</th>
                              <th class="tabla-form-ancho">Observaciones</th>
                              <th class="tabla-form-ancho">Actividad</th>                              
                          </tr>
                      </thead>
                      <tbody>
                          <?php $gastos_gralInst->getTablagastos_gralProyecto($pkID); ?>
                      </tbody>
                  </table>
                  <hr>
                  <div class="col-md-6"></div>
                  <div class="col-md-6">                            
                      <label for="total_gastosProyecto" class="control-label">Total Gastos</label>                                
                      <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" class="form-control" id="total_gastosProyecto" name="total_gastosProyecto" readonly="true" value=<?php $gastos_gralInst->getSumagastosValProyecto($pkID); ?>>
                      </div>
                  </div>
              </div>

              </div>
              <!-- /.panel-body -->
            
            </div>
            <!-- /.panel -->

            <hr>
              <!-- ./admin -->
              </div>
              <div role="tabpanel" class="tab-pane" id="ver_gastos">
                <br>
                <div id="tree_ingresos"></div>
                <div id="tree_ingresosNo"></div>
                <!-- /.prueba muestra treeview presupuesto -->
              </div>

            </div>                    
           <!-- ./*******++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
        </div> 



<div role="tabpanel" class="tab-pane" id="facturas">
            <!-- ./*******++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
            <br>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li id="li_admin_facturas" class="active" role="tab"><a href="#admin_facturas" aria-controls="admin_facturas" role="tab" data-toggle="tab">Administrar</a></li>
              <li id="li_ver_facturas" role="tab"><a href="#ver_facturas" aria-controls="ver_facturas" role="tab" data-toggle="tab">Ver</a></li>              
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="admin_facturas">
              <!-- ./admin -->
               <br>
            
            <div class="panel panel-default proyec-marg5">

              <div class="panel-heading">
                <div class="row">
                  <div class="col-md-6">
                      Registro de Facturas del proyecto
                  </div>
                  <div class="col-md-6 text-right">
                    
                  </div>
                </div>
              </div>
              <!-- /.panel-heading -->
              
              <div class="panel-body">

              <div class="dataTable_wrapper table-responsive">
                  <table class="table table-striped table-bordered table-hover" id="tbl_gastosProyecto">
                      <thead>
                          <tr>                              
                              <th class="tabla-form-ancho">Empresa</th>
                                            <th class="tabla-form-ancho">Fuente</th>                                            
                                            <th class="tabla-form-ancho">Descripcion</th>
                                            <th class="tabla-form-ancho2">Pagado</th>
                                            <th class="tabla-form-ancho">Fecha Radicacion</th>
                                            <th class="tabla-form-ancho">Fecha Pago</th>
                                            <th class="tabla-form-ancho">Valor Pagado</th>
                                            <th data-orderable="false">Opciones</th>                       
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                            //print_r($_COOKIE); 
                            $ingresos_gralInst->getTablaingresos_gral("ingreso_gral.fkID_proyecto=".$pkID." AND pagado=1");                           
                         ?>
                                    </tbody>
                  </table>
                  <hr>
                  <div class="col-md-6"></div>
                  <div class="col-md-6">                            
                      <label for="total_gastosProyecto" class="control-label">Total Facturas</label>                                
                      <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" class="form-control" id="total_gastosProyecto" name="total_gastosProyecto" readonly="true" value=
                        <?php //$gastos_gralInst->getSumagastosValProyecto($pkID); ?>
                        >
                      </div>
                  </div>
              </div>

              </div>
              <!-- /.panel-body -->
            
            </div>
            <!-- /.panel -->

            <hr>
              <!-- ./admin -->
              </div>
              <div role="tabpanel" class="tab-pane" id="ver_facturas">
                <br>
                <div id="tree_ingresos"></div>
                <div id="tree_ingresosNo"></div>
                <!-- /.prueba muestra treeview presupuesto -->
              </div>

            </div>                    
           <!-- ./*******++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
        </div> 




      </div>

    </div>            
     
  </div>
  <!-- /.row -->
                
</div>
<!-- /#page-wrapper -->