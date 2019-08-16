<?php 
  
  include("../controller/proyectosController.php");
  include("../DAO/UsuariosDAO.php");
  include("../DAO/gastos_gralDAO.php");

  
  $proyectoinst = new proyectosController();
  $usuariosInst = new UsuariosDAO();
  $gastos_gralInst = new gastos_gralDAO();


  $arrPermisos = $proyectoinst->permisos(4,$_COOKIE["log_lunelAdmin_IDtipo"]);

  $crea = $arrPermisos[0]["crear"];

  $filtro = $_GET["filter"];

  //print_r($filtro);

  $tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];

 ?>
<!-- Modal -->
<div class="modal fade" id="frm_modal_proyecto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_proyecto">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_proyecto" method="POST">                
            <br>
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>

                <div class="form-group">
                    <label for="fkID_empresa" class="control-label">Empresa</label>                        
                    <select name="fkID_empresa" id="fkID_empresa" class="form-control" required = "true">
                        <option></option>
                        <?php
                          /**/ 
                            $empresaSelect = $gastos_gralInst->getEmpresas();
                            for ($i=0; $i < sizeof($empresaSelect); $i++) {
                                echo '<option value="'.$empresaSelect[$i]["pkID"].'">'.$empresaSelect[$i]["nombre"].'</option>';
                            };
                         ?>
                    </select>                                                
                </div>

                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>                        
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del proyecto" required = "true">                        
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
                    <label for="objeto" class="control-label">Objeto</label>                        
                    <textarea class="form-control" id="objeto" name="objeto" placeholder="Objeto del proyecto" required = "true"></textarea>                        
                </div>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="subtotal" name="subtotal" required="true">
                </div>

                <div class="form-group">
                    
                    <label for="subtotal" class="control-label">Sub-Total</label>                
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="subtotal_mask" type="text" class="form-control" required="true">                      
                    </div>

                </div>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="iva" name="iva" required = "true">
                </div>
                
                <div class="form-group form-inline">
                    <label for="iva_mask" class="control-label tax_label">IVA</label>            
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="iva_mask" type="text" class="form-control tax_mask" required="true">                      
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">%</span>
                      <input id="iva_percent" type="number" class="form-control tax_percent">                      
                    </div>

                </div>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="total" name="total" required = "true">
                </div>

                <div class="form-group">
                    <label for="total" class="control-label">Total</label>            
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="total_mask" type="text" class="form-control" readonly="true" required="true">                      
                    </div>

                </div>

                <div class="form-group">
                    <label for="fkID_entidad" class="control-label">Entidad</label>                        
                    <select name="fkID_entidad" id="fkID_entidad" class="form-control" required = "true">
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
                    <button id="btn_nuevoentidad" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_entidad"><span class="glyphicon glyphicon-plus"></span></button>
                </div>

                <div class="form-group">
                    <label for="fkID_estado" class="control-label">Estado</label>                        
                    <select name="fkID_estado" id="fkID_estado" class="form-control" required = "true">
                        <option></option>
                        <?php
                          /**/ 
                            $estadoSelect = $proyectoinst->getSelectEstadoProyecto();
                            for ($i=0; $i < sizeof($estadoSelect); $i++) {
                                echo '<option value="'.$estadoSelect[$i]["pkID"].'">'.$estadoSelect[$i]["nombre"].'</option>';
                            };
                         ?>
                    </select>                                                
                </div>

                <div class="form-group" id="div-observaciones">
                    <label for="observaciones" class="control-label">Observaciones</label>                    
                    <textarea name="observaciones" id="observaciones" class="form-control add-selectElement" disabled="true"></textarea>
                    <button id="btn_nuevoobservacion" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_observacion" style="margin-top: -9%;" title="Nueva Observación"><span class="glyphicon glyphicon-plus"></span></button>
                </div>

                <div id="select_users_proyecto" class="form-group">
                    <label for="fkID_usuario" class="control-label" >Usuarios</label>                        
                    <select id="fkID_usuario" class="form-control" data-accion="select" >
                        <option></option>
                        <?php
                          /**/ 
                            $usuarioSelect = $usuariosInst->getUsuariosNoAdmin();
                            for ($i=0; $i < sizeof($usuarioSelect); $i++) {
                                echo '<option id="fkID_usuario_'.$usuarioSelect[$i]["pkID"].'" value="'.$usuarioSelect[$i]["pkID"].'" data-nombre = "'.$usuarioSelect[$i]["nombre"].' '.$usuarioSelect[$i]["apellido"].'" >'.$usuarioSelect[$i]["nombre"].' '.$usuarioSelect[$i]["apellido"].' -- '.$usuarioSelect[$i]["nom_tipo"].'</option>';
                            };
                         ?>
                    </select>                                                
                </div>
                                                                                   
        </form>  
        
        <div id='select_usuarios'>
          <label class="control-label">Usuarios Asignados</label> 
          <form id="frm_usuarios_proyecto"></form>
        </div>   
                
      </div>
      
      <div class="modal-footer">    
        <button id="btn_actionproyecto" type="button" class="btn btn-primary" data-action="-" disabled="disabled">
            <span id="lbl_btn_actionproyecto">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>
  
<!-- /form modal 2-->

<?php 
  
  include("modal_entidades.php");
  include("modal_observaciones_proceso.php");
 ?>

<div id="page-wrapper">

  <div class="row">

      <div class="col-lg-12">
      <div class="panel panel-default titulo-barra-amarilla">
            <div class="icono_proyectos"></div>
                      <div class="panel-body">
                        Proyectos
                      </div>
                     </div> 
      </div>
      <!-- /.col-lg-12 -->
      
  </div>
  <!-- /.row -->

  <div class="row rowproy">
  
    <div class="col-lg-12">
      
      <div class="panel panel-default pandelproy3">
      <div class="panel-body2">


        <!-- ./filtro de estados -->
        <div class="col-md-10 text-left form-inline">
          
        </div>
        <!-- ./filtro de estados -->

        <div class="panel-heading">
          <div class="row">
            <div class="col-md-6">

                Registro de Proyectos
                <?php 
              if($tipoUsuario == 1){
            ?>
             <div class="col-md-12 text-left form-inline">
                <br>
                    <h4 class="text-left"><span class="glyphicon glyphicon-filter"></span><strong>Filtro</strong></h4>
                                
                                
                    <label for="empresa_filtrop" class="control-label">Empresas</label>

                          <?php
                             $proyectoinst->getSelectEmpresasFiltro();
                          ?>                                            
                      
                                
                     <button class="btn btn-success" id="btn_filtrar"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
                
                     <hr>

            </div>
            <?php } ?>
            <br>

            </div>
            <div class="col-md-6 text-right">
                <button id="btn_nuevoproyecto" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#frm_modal_proyecto" <?php if ($crea != 1){echo 'disabled="disabled"';} ?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear Proyecto</button>
            </div>


          </div>
        </div>
        <!-- /.panel-heading -->
        
        <div class="panel-body">
        
        <!-- /.tabs por estado -->
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li id="li_ejecucion" role="presentation"><a href="#ejecucion" aria-controls="ejecucion" role="tab" data-toggle="tab">Ejecución</a></li>
          <li id="li_terminado" role="presentation"><a href="#terminado" aria-controls="terminado" role="tab" data-toggle="tab">Terminado</a></li>
          <li id="li_liquidado" role="presentation"><a href="#liquidado" aria-controls="liquidado" role="tab" data-toggle="tab">Liquidado</a></li>
          <li id="li_todos" role="presentation"><a href="#todos" aria-controls="todos" role="tab" data-toggle="tab">Todos</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane" id="ejecucion">
            <!--estado_proyecto.pkID=2-->
            <br>
            <?php 
                $proyectoinst->creaTablaProyectosE($filtro,"1");
             ?>
          </div>
          <div role="tabpanel" class="tab-pane" id="terminado">
            <!-- estado_proyecto.pkID = 3 -->
            <br>
            <?php 
                $proyectoinst->creaTablaProyectosT($filtro,"2");
             ?>
          </div>
          <div role="tabpanel" class="tab-pane" id="liquidado">
            <!-- estado_proyecto.pkID = 1 -->
            <br>
            <?php 
                $proyectoinst->creaTablaProyectosL($filtro,"3");
             ?>
          </div>
          <div role="tabpanel" class="tab-pane" id="todos">
            <br><br>
            <?php 

                  $proyectoinst->creaTablaProyectosTodos($filtro,"4");

             ?>  
                    
            <!-- /.contenido todos -->
          </div>

        </div>        
        <!-- /.table-responsive -->

        <!-- /.tabs por estado -->

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