<?php 

  include("../controller/RolesController.php");
  $rolesInst = new RolesController();

  /**/
  $arrPermisos = $rolesInst->permisos(14,$_COOKIE["log_lunelAdmin_IDtipo"]);

  $crea = $arrPermisos[0]["crear"];

 ?>

<!-- Form roles -->
<div class="modal fade" id="form_modal_rol" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_rol">-</h4>
      </div>
      <div class="modal-body">
        <!-- form modal contenido -->

                <form id="form_rol" method="POST">
                <br>
                    <div class="form-group" hidden>                     
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pkID" name="pkID">
                        </div>
                    </div>
                                      
                    <div class="form-group">
                        <label for="fkID_tipo_usuario" class="control-label">Tipo Usuario</label>
                        
                        <?php $rolesInst->getSelectTipoUsuario(); ?>
                        <button id="btn_nuevotUsuario" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_tUsuario"><span class="glyphicon glyphicon-plus"></span></button>
                    
                    </div>

                    <div class="form-group">
                        <label for="fkID_modulo" class="control-label">Modulo</label>
                        
                        <?php $rolesInst->getSelectModulos(); ?>
                        <button id="btn_nuevomodulo" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_modulo"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>
                    
                    <hr>
                    <h4>Permisos</h4>
                    <div class="checkbox">
                      <label>Crear</label>
                      <select name="crear" id="crear">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                      </select>
                      &nbsp
                      <label>Editar</label>
                      <select name="editar" id="editar">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                      </select>
                      &nbsp
                      <label>Eliminar</label>
                      <select name="eliminar" id="eliminar">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                      </select>
                      &nbsp
                      <label>Consultar</label>
                      <select name="consultar" id="consultar">
                        <option value="0">No</option>
                        <option value="1">Sí</option>
                      </select>
                    </div>


                </form>

        <!-- /form modal contenido-->
      </div>
      <div class="modal-footer">        
        <button id="btn_actionrol" type="button" class="btn btn-primary" data-action="-">
            <span id="lbl_btn_actionrol"></span>
        </button>
      </div>
    </div>
  </div>
</div>
<!-- /form modal -->
<?php 
  include('modal_tUsuario.php');
  include('modal_modulo.php');
 ?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->


<div id="page-wrapper">

  <div class="row">

      <div class="col-lg-12">
          <div class="panel panel-default titulo-barra-amarilla">
            <div class="icono_index"></div>
              <div class="panel-body">
                Roles
              </div>
          </div>
      </div>        
      <!-- /.col-lg-12 -->
      
  </div>
  <!-- /.row -->

  <div class="row">    
      
      <div class="col-lg-12">
        
        <div class="panel panel-default">

          <div class="panel-heading">

            <div class="row">
              <div class="col-md-6">
                  Registro de Roles 
              </div>
              <div class="col-md-6 text-right">
                 <button id="btn_nuevoRol" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_rol" <?php if ($crea != 1){echo 'disabled="disabled"';} ?> ><span class="glyphicon glyphicon-plus"></span> Nuevo Rol</button>
              </div>
            </div>

          </div>
          <!-- /.panel-heading --> <!---->
        
        <div class="panel-body">

          <div class="dataTable_wrapper">
              <table class="table table-striped table-bordered table-hover" id="tbl_rol">
                  <thead>
                      <tr>
                          <!--<th>ID</th>-->
                          <th>Rol</th>
                          <th>Modulo</th>
                          <th>Crear</th>                                                            
                          <th>Editar</th>
                          <th>Eliminar</th>
                          <th>Consultar</th>
                          <th>Opciones</th>                                               
                      </tr>
                  </thead>

                  <tbody>
                      <?php
                          //print_r($_COOKIE); 
                          $rolesInst->getTablaRoles();                           
                       ?>
                  </tbody>
              </table>
          </div>
          <!-- /.table-responsive -->
        
        </div>
        <!-- /.panel-body -->

        </div>
        <!-- /.panel -->
      
      </div>
      <!-- /.col-lg-12 -->
    
    </div>
    <!-- /.row -->
                
</div>
<!-- /#page-wrapper -->


