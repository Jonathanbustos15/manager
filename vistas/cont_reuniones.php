<?php
	
	/*ini_set('error_reporting', E_ALL|E_STRICT);
	ini_set('display_errors', 1);
	*/
	include('../controller/reunionesController.php');
	
	include('../Conexion/datos.php');
	
	$inst = new reunionesController();
	
	$arrPermisos = $inst->getPermisosModulo_Tipo($id_modulo,$_COOKIE[$NomCookiesApp.'_IDtipo']);
	
	$crea = $arrPermisos[0]['crear'];

    $tipo_usuario = $_COOKIE["log_lunelAdmin_IDtipo"];

    $id_user = $_COOKIE["log_lunelAdmin_id"];

    $filtro = $_GET["filter"];

    //echo "filtro: ".$filtro;
    //print_r($id_user);
	
    include('modal_reunion.php');
    include("modal_compromiso.php");
    include("form_novedades.php");
    
?>


<div id="page-wrapper">

  <div class="row">

      <div class="col-lg-12">
          <div class="panel panel-default titulo-barra-amarilla">
            <div class="icono_reuniones"></div>
              <div class="panel-body">
                Reuniones
              </div>
          </div>
      </div>        
      <!-- /.col-lg-12 -->
      
  
  <!-- /.row -->

  <div class="row">    
      
      <div class="col-lg-12">
        
        <div class="panel panel-default">

          <div class="panel-heading">

            <div class="row">
              <div class="col-md-6">
                  Registro de Reuniones
              </div>
              <div class="col-md-6 text-right">
                 <button id="btn_nuevoreunion" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#frm_modal_reunion"><span class="glyphicon glyphicon-plus"></span> Crear Reunión</button>
              </div>

              <div class="col-md-12 text-left form-inline">
                <br>
                  <h4 class="text-left"><span class="glyphicon glyphicon-filter"></span><strong>Filtro</strong></h4>
                                
                      <!--<label for="usuario_filtro" class="control-label">Participantes</label>                                            
                        <?php
                            $inst//->getSelectParticipantesF();
                        ?>
                      -->
                      <label for="tema_filtro" class="control-label">Temas</label>                                            
                        <?php
                            $inst->getSelectTemasF();
                        ?>

                      <label for="fecha1" class="control-label">Desde</label>                        
                      <input type="text" class="form-control sel-filter" id="fecha1" name="fecha1" placeholder="Desde" required = "true">                        
                      
                      
                      <label for="fecha2" class="control-label">Hasta</label>                        
                      <input type="text" class="form-control sel-filter" id="fecha2" name="fecha2" placeholder="Hasta" required = "true">                        
                    
                      &nbsp &nbsp &nbsp
                                
                      <button class="btn btn-success" id="btn_filtrar"><span class="glyphicon glyphicon-filter"></span>Filtrar</button>
                
                      <hr>

               </div>

              
            </div>

          </div>
          <!-- /.panel-heading --> <!---->
         <div class="rowproc"></div>  

          <div class="row">

                  <div class="col-lg-12">

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs tabs-proc3" role="tablist">
                      <li id="li_general" role="presentation"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>          
                      <li id="li_compromisos" role="presentation"  <?php if ($tipo_usuario!=1){ ?> style="display:none" <?php } ?>><a href="#compromisos" aria-controls="general" role="tab" data-toggle="tab">Compromisos</a></li>          
                  </ul>
                      <!-- Tab panes -->
                    <div class="tab-content">


                        <div role="tabpanel" class="tab-pane" id="general">
                          <br>
                          <!-- contenido general -->
                          <div class="panel panel-default proc-pan-def3">
                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                                  <table class="table table-striped table-bordered table-hover" id="tbl_reunion">
                                      <thead>
                                          <tr>
                        
                                              <th>Fecha Realización</th>
                                              <th>Moderador</th>
                                              <th>Desarrollo</th>                          
                                              <th data-orderable="false">Opciones</th>                                               
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php
                                           
                                              $inst->getTablaReuniones($filtro, $tipo_usuario, $id_user);  
                                           
                                           ?>
                                      </tbody>
                                  </table>
                              </div>
                             

                            </div>
                          </div>
                          <!-- /.contenido general -->
                        </div>
                        
                    
                        <div role="tabpanel" class="tab-pane" id="compromisos" >
                          <br>
                          <!-- contenido general -->
                          <div class="panel panel-default detl-proc4 def-proc5">
                            <div class="panel-body">
                              <!-- instancia php controller -->               
                              <br>
                              <div class="panel panel-default proc-detl6">

                                <!-- /.panel-heading -->
                                
                                <div class="panel-body">

                                  <div class="dataTable_wrapper table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="tbl_compromisos">
                                        <thead>
                                            <tr>
                                                <th>Participante</th>                                  
                                                <th>Fecha de Cumplimiento</th>
                                                <th>Descripción</th>
                                                <th>Estado</th>
                                                                                                     
                                                <th data-orderable="false" class="tabla-form-ancho">Opciones</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php   
                                                  $inst->getTablaCompromisosReuniones();     
                                            ?>
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

                   </div>

                  </div>

              </div>

        </div>
        <!-- /.panel -->
      
      </div>
      <!-- /.col-lg-12 -->
    
    </div>
    <!-- /.row -->
                
</div>
<!-- /#page-wrapper -->