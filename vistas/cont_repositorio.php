<?php
	
	/**/
	
	include('../controller/repositorioController.php');	
	
	$repositorioInst = new repositorioController();
	
	$arrPermisos = $repositorioInst->permisos($id_modulo,$_COOKIE['log_lunelAdmin_IDtipo']);
	
	$crea = $arrPermisos[0]['crear'];

  $tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];
	
	//echo "Hola por aca...";
?>

<!-- Modal -->
<div class="modal fade" id="form_modal_repositorio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_repositorio">-</h4>
      </div>
      <div class="modal-body">
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
        <!-- Nav tabs -->            

          <div role="tabpanel" class="tab-pane active" id="datosGenerales">
          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
            <form id="form_repositorio" method="POST">

                <br>
                    <div class="form-group" hidden>                     
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pkID" name="pkID">
                        </div>
                    </div>                                       
                    
                    <div class="form-group">
                        <label for="nombre" class="control-label">Nombre</label>                        
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del repositorio" required = "true">                        
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">Categoría</label>                    
                        <?php
                          $repositorioInst->getSelectTipoRepositorioGeneral();
                         ?>
                    </div>                    

                    <div class="form-group">
                        <label for="descripcion" class="control-label">Descripción</label>                    
                        <textarea  class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del repositorio" required = "true"> </textarea>                       
                    </div>  
                    <?php 
                      if($tipoUsuario != 13){
                    ?>
                    <div class="form-group">
                        <label for="" class="control-label">Empresa</label>                    
                        <?php
                          $repositorioInst->getSelectEmpresa();
                         ?>
                    </div> 
                    <?php
                      }else{
                    ?>
                      <div class="form-group" hidden="true">
                        <label for="" class="control-label">Empresa</label>                        
                        <input type="text" class="form-control" id="fkID_empresa" name="fkID_empresa" placeholder="Nombre del repositorio" required = "true" value=2>                        
                    </div>
                    <?php
                      }
                    ?>     

                  <!--Validación para mostrar el campo tipo_acceso al momento de actualizar....solo si el tipo de usuario es administrador
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
                 
            </form>		       		          
          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
          </div>               
               
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--> 
        <button id="btn_actionrepositorio" type="button" class="btn btn-primary" data-action="-">
            <span id="lbl_btn_actionrepositorio">-</span>
        </button>
      </div>
    </div>
  </div>
</div>
<!-- /form modal 2-->

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->

<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
        
            <div class="panel panel-default titulo-barra-amarilla">
                <div class="icono_"></div>
                  <div class="panel-body">
                    Repositorio
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

                          Repositorio 

                      </div>
                      <div class="col-md-6 text-right">
                          <button id="btn_nuevorepositorio" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_repositorio" <?php if ($crea != 1){echo 'disabled="disabled"';} ?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear repositorio</button> 
                      </div>
                    </div>

                </div>
                <!-- /.panel-heading -->

                <div class="panel-body">
                    <div class="dataTable_wrapper table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="tbl_repositorio">
                            <thead>
                                <tr>                                                                        
                                    <th>Nombre</th>                                    
                                    <th>Descripcion</th>
                                    <th>Tipo</th>
                                    <th>Empresa</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                      //print_r($_COOKIE); 
                                      if($tipoUsuario == 13){
                                          $repositorioInst->getTablaRepositorioFuntecso();
                                      }else{  
                                          $repositorioInst->getTablaRepositorio();
                                      }    
                                                   
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


