<?php 
  include("../controller/proyectosController.php");
  include("../controller/procesosController.php");    

  $proyectoinst = new proyectosController();
  $procesosInst = new procesosController();

  $arrPermisos = $procesosInst->permisos($id_modulo,$_COOKIE["log_lunelAdmin_IDtipo"]);
  $crea = $arrPermisos[0]["crear"];

  //echo "El id del modulo es: ".$id_modulo;
 ?>
<!-- Modal -->
<div class="modal fade" id="form_modal_proceso" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_proceso">-</h4>
      </div>
      <div class="modal-body">

      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>
        <li role="presentation"><a href="#indicadores" aria-controls="indicadores" role="tab" data-toggle="tab">Indicadores</a></li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="general">
        
        <form id="form_proceso" method="POST">                
            <br>
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>
                                                       
                <div class="form-group">
                    <label for="fecha_cierre" class="control-label">Fecha cierre</label>                        
                    <input type="text" class="form-control" id="fecha_cierre" name="fecha_cierre" placeholder="Fecha cierre del proceso." required = "true" readonly>                        
                </div>

                <div class="form-group" hidden="true">
                    <label for="fecha_creacion" class="control-label">Fecha de Creación</label>                        
                    <input type="text" class="form-control" id="fecha_creacion" name="fecha_creacion" placeholder="Fecha de creación del proceso." required = "true" readonly>                        
                </div>

                <div class="form-group">
                    <label for="codigo">Código</label>                    
                    <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Código de referencia del proceso" required = "true">
                </div>

                <div class="form-group">
                    <label for="objeto" class="control-label">Objeto</label>
                    <textarea class="form-control" id="objeto" name="objeto" placeholder="Objeto del proceso." required = "true"></textarea>                    
                </div>

                <div class="form-group">
                    <label for="experiencia" class="control-label">Experiencia</label>
                    <textarea class="form-control" id="experiencia" name="experiencia" placeholder="Experiencia para el proceso." required = "true"></textarea>                    
                </div>
                
                <div class="form-group" hidden="true">
                    <input class="form-control" id="cuantia" name="cuantia" placeholder="Cuantía del proceso." required = "true"></input>  
                </div>

                <!-- select paso_actual -->
                <div id="div_tipo_cuantia" class="form-group">
                    <label for="fkID_tipo_cuantia" class="control-label">Tipo Cuantía</label>                       
                    <select name="fkID_tipo_cuantia" id="fkID_tipo_cuantia" class="form-control" required = "true">                        
                        <?php
                          /**/
                            $procesosInst->selectTipoCuantia();                            
                         ?>
                    </select>
                    <!--<a href="#" target="_blank" title="Añadir Estado" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a>-->
                </div>

                <div class="form-group">
                    <label for="cuantia" class="control-label">Cuantía</label>
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="cuantia_mask" type="text" class="form-control" required = "true">                      
                    </div>                  
                </div>

                <div class="form-group">
                    <label for="personal" class="control-label">Personal</label>
                    <textarea class="form-control" id="personal" name="personal" placeholder="Personal para el proceso." required = "true"></textarea>                    
                </div>                

                <div class="form-group">
                    <label for="url_propuesta" class="control-label">url propuesta</label>                        
                    <!--<input type="file" class="form-control" id="archivo" name="archivo" required = "true">-->
                    <input type="text" name="url_propuesta" id="url_propuesta" class="form-control" required = "true">
                    <code id="url_codigo" class="col-md-12">&lt;url propuesta debe llevar el protocolo http o https &gt;</code>                       
                </div>

                <div class="form-group">
                    <label for="fkID_entidad" class="control-label">Entidad</label>                        
                    <select name="fkID_entidad" id="fkID_entidad" class="form-control add-selectElement" required = "true">
                        <option></option>
                        <?php
                          /**/ 
                            $entidadSelect = $proyectoinst->getSelectEntidad();
                            for ($i=0; $i < sizeof($entidadSelect); $i++) {
                                echo '<option value="'.$entidadSelect[$i]["pkID"].'">'.$entidadSelect[$i]["nombre_entidad"].'</option>';
                            };
                         ?>
                    </select>
                    <!--<a href="entidades.php" target="_blank" title="Añadir Entidad" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a>-->
                    <button id="btn_nuevoentidad" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_entidad" ><span class="glyphicon glyphicon-plus"></span></button>
                </div>
                <!-- select estado_proceso, no es seguro que se puedan añadir estados -->
                <div class="form-group">
                    <label for="fkID_estado" class="control-label">Estado&nbsp</label>                        
                    <select name="fkID_estado" id="fkID_estado" class="form-control add-selectElement" required = "true">
                        <option></option>
                        <?php
                          /**/
                            //$procesosInst->selectEstadoProceso();                            
                         ?>
                    </select>
                    <!--<a href="#" target="_blank" title="Añadir Estado" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a>-->
                </div>
                <!-- select paso_actual -->
                <div id="div_paso_actual" class="form-group" hidden="true">
                    <label for="fkID_paso_actual" class="control-label">Paso Actual</label>                       
                    <select name="fkID_paso_actual" id="fkID_paso_actual" class="form-control add-selectElement" required = "true">                        
                        <?php
                          /**/
                            $procesosInst->selectPasosProceso();                            
                         ?>
                    </select>
                    <!--<a href="#" target="_blank" title="Añadir Estado" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a>-->
                </div>

                <!-- select tipo_proceso, no es seguro que se puedan añadir mas tipos -->
                <div id="div_tipo_proceso" class="form-group" hidden="true">
                    <label for="fkID_tipo" class="control-label">Tipo de Proceso</label>                        
                    <select name="fkID_tipo" id="fkID_tipo" class="form-control add-selectElement" required = "true">
                        <!--<option></option>-->
                        <?php
                          /**/
                            $procesosInst->selectTipoProceso();                            
                         ?>
                    </select>
                    <!--<a href="#" target="_blank" title="Añadir Tipo de Proceso" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></a>-->
                </div>

                <div id="div_fecha_apertura" class="form-group" hidden="true">
                    <label for="fecha_apertura" class="control-label">Fecha de Apertura</label>
                    <input type="text" class="form-control add-selectElement" id="fecha_apertura" name="fecha_apertura" placeholder="Fecha de Apertura." readonly>
                </div>
                
                <div id="form-group">
                  <div class="checkbox">
                        <label>
                          <input type="checkbox" id="chk_recurrente" name="recurrente" >

                          <input type='hidden' id="chk_recurrente_hidden" value='0' name='recurrente'>

                          <!--<input type='checkbox' value='1' name='selfdestruct'>-->

                          <!--<input type="checkbox" id="chk_recurrente" name="recurrente" value="1">
                          <input type="checkbox" onclick="this.previousSibling.value=1-this.previousSibling.value">-->
                          Recurrente
                        </label>
                  </div>    
                </div>

                <div id="div_fecha_revision" class="form-group" hidden="true">                  
                    <label for="fecha_revision" class="control-label">Fecha de Revisión</label>
                    <input type="text" class="form-control add-selectElement" id="fecha_revision" name="fecha_revision" placeholder="Fecha de Revisión." readonly>
                </div>

                <div class="form-group" id="div-observaciones">
                    <label for="observaciones" class="control-label">Observaciones</label>                    
                    <textarea name="observaciones" id="observaciones" class="form-control add-selectElement" required = "true"></textarea>
                    <button id="btn_nuevoobservacion" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_observacion" style="margin-top: -9%;" title="Nueva Observación"><span class="glyphicon glyphicon-plus"></span></button>
                </div>
                
        </form>

        </div>
        <!--  cierra contendio de tabla-->

        <div role="tabpanel" class="tab-pane" id="indicadores">
          <form id="form_indicadores_proceso" method="POST" class="form-horizontal">
            <br>
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>

                <div class="form-group">
                    <label for="liquidez" class="col-sm-4 control-label">Liquidez >= </label>
                    <div class="col-sm-8">
                      <input type="number" class="form-control" id="liquidez" name="liquidez" required = "true">  
                    </div>                    
                </div>

                <div class="form-group" hidden="true">
                    <label for="capital_trabajo" class="col-sm-4 control-label">Capital de Trabajo >= </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="capital_trabajo" name="capital_trabajo" required = "true">  
                    </div>                    
                </div>

                <div class="form-group">
                    <label for="capital_trabajo_mask" class="col-sm-4 control-label">Capital de Trabajo >= </label>
                    <div class="col-sm-8">
                      <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input id="capital_trabajo_mask" type="text" class="form-control" required = "true">
                      </div>
                    </div>                  
                </div>

                <div class="form-group">
                    <label for="rentabilidad_patrimonio" class="col-sm-4 control-label">Rentabilidad del Patrimonio >= </label>
                    <div class="col-sm-8">
                      <div class="input-group">
                        <input type="number" class="form-control" id="rentabilidad_patrimonio" name="rentabilidad_patrimonio" required = "true">
                        <div class="input-group-addon">%</div>
                      </div>                      
                    </div>                    
                </div>

                <div class="form-group">
                    <label for="endeudamiento" class="col-sm-4 control-label">Endeudamiento <= </label>
                    <div class="col-sm-8">
                      <div class="input-group">                        
                        <input type="number" class="form-control" id="endeudamiento" name="endeudamiento" required = "true">
                        <div class="input-group-addon">%</div>
                      </div>                        
                    </div>                    
                </div>

                <div class="form-group">
                    <label for="razon_cobert_int" class="col-sm-4 control-label">Razón de Cobertura de Intereses >= </label>
                    <div class="col-sm-8">                                             
                      <input type="number" class="form-control" id="razon_cobert_int" name="razon_cobert_int" required = "true">                                              
                    </div>                    
                </div>

                <div class="form-group">
                    <label for="rentabilidad_activo" class="col-sm-4 control-label">Rentabilidad del Activo >= </label>
                    <div class="col-sm-8">
                      <div class="input-group">                        
                        <input type="number" class="form-control" id="rentabilidad_activo" name="rentabilidad_activo" required = "true">
                        <div class="input-group-addon">%</div>
                      </div>                        
                    </div>                    
                </div>

                <div class="form-group" hidden="true">
                    <label for="patrimonio" class="col-sm-4 control-label">Patrimonio >= </label>
                    <div class="col-sm-8">                                             
                      <input type="text" class="form-control" id="patrimonio" name="patrimonio" required="true">                                              
                    </div>                    
                </div>

                <div class="form-group">
                    <label for="patrimonio_mask" class="col-sm-4 control-label">Patrimonio >= </label>
                    <div class="col-sm-8">
                      <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input id="patrimonio_mask" type="text" class="form-control" required = "true">
                      </div>
                    </div>                  
                </div>

          </form>
        </div>

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
  include("modal_entidades.php");
  include("modal_aprobar_asignar.php");
  include("modal_observaciones_proceso.php");
?>

<div id="page-wrapper">

  <div class="row">

      <div class="col-lg-12">
      <div class="panel panel-default titulo-barra-amarilla">
            <div class="icono_procesos"></div>
                      <div class="panel-body">
                        Procesos
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
            Registro de Procesos
        </div>
        <div class="col-md-6 text-right">
          <button id="btn_nuevoProceso" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_proceso" <?php if ($crea != 1){echo 'disabled="disabled"';} ?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear Proceso</button>   
        </div>
      </div>
    </div>
    <!-- /.panel-heading -->
  
    <div class="panel-body">

      <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li id="li_p_oferta" role="presentation"><a href="#p_oferta" aria-controls="p_oferta" role="tab" data-toggle="tab">Presentar Oferta</a></li>
        <li id="li_borrador" role="presentation"><a href="#borrador" aria-controls="borrador" role="tab" data-toggle="tab">Borrador</a></li>
        <li id="li_creado" role="presentation"><a href="#creado" aria-controls="creado" role="tab" data-toggle="tab">Creado/Abierto</a></li>
        <li id="li_revision" role="presentation"><a href="#revision" aria-controls="revision" role="tab" data-toggle="tab">Revisión/Abierto</a></li>
        <li id="li_entregados" role="presentation"><a href="#entregados" aria-controls="entregados" role="tab" data-toggle="tab">Entregados</a></li>
        <li id="li_no_entregados" role="presentation"><a href="#no_entregados" aria-controls="no_entregados" role="tab" data-toggle="tab">No Entregados</a></li>
        <li id="li_perdidos" role="presentation"><a href="#perdidos" aria-controls="perdidos" role="tab" data-toggle="tab">Perdidos</a></li>
        <li id="li_ganados" role="presentation"><a href="#ganados" aria-controls="ganados" role="tab" data-toggle="tab">Ganados</a></li>
        <li id="li_descartados" role="presentation"><a href="#descartados" aria-controls="descartados" role="tab" data-toggle="tab">Descartados</a></li>
        <li id="li_reporte" role="presentation" <?php if ($_COOKIE["log_lunelAdmin_IDtipo"] != "1"){echo "style='display: none;'"; } ?> ><a href="#reporte" aria-controls="reporte" role="tab" data-toggle="tab">Estadísticas</a></li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane" id="p_oferta">
          <br>
          <?php 
            $procesosInst->createTableProcesos("procesos.fkID_estado = 2 AND procesos.fkID_paso_actual = 6","1");
           ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="borrador">
          <br>
          <?php 
            $procesosInst->createTableProcesos("procesos.fkID_estado = 1","2");
           ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="creado">
          <br>
          <?php 
            $procesosInst->createTableProcesos("procesos.fkID_estado = 2 AND procesos.fkID_paso_actual = 1","9");
           ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="revision">
          <br>
          <?php 
            $procesosInst->createTableProcesos("procesos.fkID_estado = 2 AND procesos.fkID_paso_actual = 5","8");
           ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="entregados">
          <br>
          <?php 
            $procesosInst->createTableProcesos("procesos.fkID_paso_actual = 9","3");
           ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="no_entregados">
          <br>
          <?php 
            $procesosInst->createTableProcesos("procesos.fkID_paso_actual = 10","4");
           ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="perdidos">
          <br>
          <?php 
            $procesosInst->createTableProcesos("procesos.fkID_paso_actual = 11","5");
           ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="ganados">
          <br>
          <?php 
            $procesosInst->createTableProcesos("procesos.fkID_paso_actual = 12","6");
           ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="descartados">
          <br>
          <?php 
            $procesosInst->createTableProcesos("procesos.fkID_paso_actual = 7","7");
           ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="reporte">
          <br>

          <form class="form-inline">
            <div class="form-group">
              <label class="control-label">Fecha Inicial</label>
              <input type="text" class="form-control" id="fecha_ini_est" readonly="true" placeholder="Fecha de Inicio">
            </div>
            <div class="form-group">
              <label class="control-label">Fecha Final</label>
              <input type="text" class="form-control" id="fecha_fin_est" readonly="true" placeholder="Fecha de Fin">
            </div>
            <button id="btn_cons_est" class="btn btn-default">Consultar</button>
          </form>

          <br>

          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Estadísticas</h3>
            </div>
            <div id="div-estadistica-procesos" class="panel-body">          
                            
            </div>
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
  <!-- /.row -->
                
</div>
<!-- /#page-wrapper -->