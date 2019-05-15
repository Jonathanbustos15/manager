<?php
	
	/**/
	
	include('../controller/contactosController.php');
	
	//include('../conexion/datos.php');
	
	$contactosInst = new contactosController();
	
	$arrPermisos = $contactosInst->permisos($id_modulo,$_COOKIE['log_lunelAdmin_IDtipo']);
	
	$crea = $arrPermisos[0]['crear'];
?>

<!-- Modal -->
<div class="modal fade" id="form_modal_contactos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_contactos">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_contactos" method="POST">                
            <br>
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>
								
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>                        
                    <input type="text" class="form-control" id="nombre" name="nombre" required="true">                        
                </div>

                <div class="form-group">
                    <label for="apellido" class="control-label">Apellido</label>                        
                    <input type="text" class="form-control" id="apellido" name="apellido" required="true">                        
                </div>

                <div class="form-group">
                    <label for="num_tel" class="control-label">Número Telefónico</label>                        
                    <input type="text" class="form-control" id="num_tel" name="num_tel" required="true">                        
                </div> 

                <div class="form-group">
                    <label for="direccion" class="control-label">Dirección</label>                        
                    <input type="text" class="form-control" id="direccion" name="direccion" required="true">                        
                </div>  

                <div class="form-group">
                    <label for="email" class="control-label">Correo</label>                        
                    <input type="text" class="form-control" id="email" name="email" required="true">                        
                </div>                                               

                <div class="form-group">
                    <label for="descripcion" class="control-label">Descripción</label>                        
                    <textarea cols="40" rows="5" class="form-control"  id="descripcion" name="descripcion"></textarea>
                </div>

                 <!--Validación para mostrar el campo tipo_acceso al momento de actualizar el contacto....solo si el tipo de usuario es administrador
                   puede modificar el campo tipo_acceso, de lo contrario no lo puede modificar por que esta oculto-->
                <div class="form-group" <?php if($_COOKIE['log_lunelAdmin_IDtipo']!=1){echo "hidden='true'";} ?>>
                    <fieldset data-role="controlgroup" >
                        <label>Tipo de Acceso: </label><br>
                        <label>
                            <input id="chk_tipoacceso1" type="radio" name="tipo_acceso" value="1" >  Privado
                        </label>   
                        <label>
                            <input id="chk_tipoacceso2" type="radio" name="tipo_acceso" value="0">  Público
                        </label>
                    </fieldset>
                </div>                      

                <!--<div class="form-group">
                    <label for="archivo" class="control-label">Archivo</label>                        
                    <input class="form-control" type="file" id="archivo" name="archivo">
                </div>-->

                <div class="form-group" hidden="true">                                        
                    <input class="form-control" type="text" id="url" name="url">
                </div>                
				
				<div class="form-group">
                    <label for="fkID_tipo_contacto" class="control-label">Tipo de Contacto</label>                                            
                    <?php
                      	$contactosInst->selectTipoContacto();
                     ?>                    
                    <button id="btn_nuevotipoContacto" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_tipoContacto"><span class="glyphicon glyphicon-plus"></span></button>
                </div>

                <div class="form-group">
                    <label for="fkID_entidad" class="control-label">Entidad</label>                
                    <?php
                      	$contactosInst->selectEntidad();
                     ?>
                     <button id="btn_nuevoentidad" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_entidad"><span class="glyphicon glyphicon-plus"></span></button>                                                     
                </div>
                                                                               
        </form>

        <div class="form-group">
            <label for="archivo" class="control-label">Archivos</label>                        
            <input id="fileupload" type="file" name="files[]" data-url="../server/php/" multiple>
        </div>

        <div id="res_form"></div>

        <div id="not_archivos" class="alert alert-info"></div>

      </div>
      
      <div class="modal-footer">    
        <button id="btn_actioncontactos" type="button" class="btn btn-primary" data-action="-">
            <span id="lbl_btn_actioncontactos">-</span>
        </button>        
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>
<?php 
    include('modal_tipoContacto.php');
    include('modal_entidades.php');
 ?>  
<!-- /form modal 2-->

<div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                
                    <div class="panel panel-default titulo-barra-amarilla">
                        <div class="icono_"></div>
                          <div class="panel-body">
                            Contactos
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
                                  Registro de Contactos                                 
                              </div>
                              <div class="col-md-6 text-right">
                              	<button id="btn_nuevocontactos" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_contactos" <?php if ($crea != 1){echo 'disabled="disabled"';} ?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear Contacto</button> 
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
                                            <th class="tabla-form-ancho">Apellido</th>                                            
                                            <th class="tabla-form-ancho">Num. Telefónico</th>                                            
                                            <th>Correo</th>
                                            <th>Descripción</th>                                            
                                            <th class="tabla-form-ancho">Tipo</th>
                                            <th class="tabla-form-ancho">Entidad</th>
                                            <th data-orderable="false" class="tabla-form-ancho">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                              //print_r($_COOKIE); 
                                              $contactosInst->getTablacontactos();                           
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