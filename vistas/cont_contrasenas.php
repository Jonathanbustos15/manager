<?php
	
	/**/
	
	include('../controller/contrasenasController.php');
	
	$contrasenasInst = new contrasenasController();
	
	$arrPermisos = $contrasenasInst->permisos($id_modulo,$_COOKIE['log_lunelAdmin_IDtipo']);
	
	$crea = $arrPermisos[0]['crear'];
	
	//echo "Hola contrasenas";
?>

<!-- Modal -->
<div class="modal fade" id="form_modal_contrasena" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_contrasena">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_contrasena" method="POST">                
            <br>
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>
								
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>                        
                    <input type="text" class="form-control" id="nombre" required="true">                        
                </div>

                <div class="form-group" hidden="true">                                        
                    <input class="form-control" type="text" id="nombre_crypt" name="nombre">
                </div>

                <div class="form-group">
                    <label for="usuario" class="control-label">Usuario</label>                        
                    <input type="text" class="form-control" id="usuario" required="true">                        
                </div>

                <div class="form-group" hidden="true">                                        
                    <input class="form-control" type="text" id="usuario_crypt" name="usuario">
                </div>

                <div class="form-group">
                    <label for="contrasena" class="control-label">Contraseña</label>                        
                    <input type="text" class="form-control" id="contrasena" required="true">                        
                </div>

                <div class="form-group" hidden="true">                                        
                    <input class="form-control" type="text" id="contrasena_crypt" name="contrasena">

                </div>                                                          

                <div class="form-group">
                    <label for="notas" class="control-label">Notas</label>                        
                    <textarea class="form-control" id="notas"></textarea>
                </div>

                <div class="form-group" hidden="true">                                        
                    <textarea class="form-control" id="notas_crypt" name="notas"></textarea>
                </div>               		
                                                                               
        </form>

                
      </div>
      
      <div class="modal-footer">    
        <button id="btn_actioncontrasena" type="button" class="btn btn-primary" data-action="-">
            <span id="lbl_btn_actioncontrasena">-</span>
        </button>        
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
<?php 
    include('modal_contrasena_confirma.php');
 ?>
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
        
            <div class="panel panel-default titulo-barra-amarilla">
                <div class="icono_"></div>
                  <div class="panel-body">
                    Contraseñas
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
    	
        <div class="col-lg-12">
            <div class="panel panel-default">
            <div class="panel-body2">
                
                <div class="panel-heading">

                    <div class="row">
                      <div class="col-md-6">
                          Registro de Contraseñas
                      </div>
                      <div class="col-md-6 text-right">
                      	<button id="btn_nuevocontrasena" type="button" class="btn btn-primary btn-limang" <?php if ($crea != 1){echo 'disabled="disabled"';} ?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear</button> 
                      </div>                            
                    </div>

                </div>
                <!-- /.panel-heading -->

                <div class="panel-body">
                    <div class="dataTable_wrapper table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tbl_ingresos_gral">
                            <thead>
                                <tr>
                                    <!--<th class="tabla-form-ancho">ID</th>-->
                                    <th class="tabla-form-ancho">Nombre</th>
                                   <!-- <th class="tabla-form-ancho">Contraseña</th>-->                                    
                                    <th data-orderable="false" class="tabla-form-ancho">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                      //print_r($_COOKIE); 
                                      $contrasenasInst->getTablaContrasenas();                           
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