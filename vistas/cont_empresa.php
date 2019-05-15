<?php 
  include("../controller/empresaController.php");    

  $empresasInst = new empresaController();

  $arrPermisos = $empresasInst->permisos($id_modulo,$_COOKIE["log_lunelAdmin_IDtipo"]);
  $crea = $arrPermisos[0]["crear"];

  //echo "El id del modulo es: ".$id_modulo;
 ?>
<!-- Modal -->
<div class="modal fade" id="form_modal_empresa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_empresa">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_empresa" method="POST">                
            <br>
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>
                                                       
                <div class="form-group">
                    <label for="nit" class="control-label">NIT</label>                        
                    <input type="text" class="form-control" id="nit" name="nit" placeholder="NIT de la empresa." required = "true">                        
                </div>

                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>                        
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la empresa." required = "true">                        
                </div>
                            
                <div class="form-group">
                    <label for="telefono" class="control-label">Teléfono</label>                        
                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono de la empresa." required = "true">                        
                </div>

                <div class="form-group">
                    <label for="direccion" class="control-label">Dirección</label>                        
                    <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección de la empresa." required = "true">                        
                </div>

                <div class="form-group">
                    <label for="representante_legal" class="control-label">Representante Legal</label>                        
                    <input type="text" class="form-control" id="representante_legal" name="representante_legal" placeholder="Representante legal de la empresa." required = "true">                  
                </div>

                
        </form>
                
      </div>


      <div class="modal-footer">    
        <button id="btn_actionempresa" type="button" class="btn btn-primary" data-action="-" disabled="disabled">
            <span id="lbl_btn_actionempresa">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div> 
<!-- ./form modal 2-->
<!--<?php  
  /*include("modal_entidades.php");
  include("modal_aprobar_asignar.php");
  include("modal_observaciones_proceso.php");*/
?>
-->
<div id="page-wrapper">

  <div class="row">

      <div class="col-lg-12">
      <div class="panel panel-default titulo-barra-amarilla">
            <!--<div class="icono_procesos"></div>-->
                      <div class="panel-body">
                        Empresas
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
            Registro de Empresas Lunel-IE
        </div>
        <div class="col-md-6 text-right">
          <button id="btn_nuevoEmpresa" type="button" class="btn btn-primary btn-limang" data-toggle="modal" data-target="#form_modal_empresa" <?php if ($crea != 1){echo 'disabled="disabled"';} ?> ><span class="glyphicon glyphicon-plus"></span>&nbspCrear Empresa</button>   
        </div>
      </div>
    </div>
    <!-- /.panel-heading -->
  
    <div class="panel-body">

      <div class="dataTable_wrapper table-responsive">
      
          <table class="table table-striped table-bordered table-hover" id="tbl_empresa">
              <thead>
                  <tr>
                      <!--<th>ID</th>
                      <th class="tabla-form-ancho">ID</th>-->
                      <th class="tabla-form-ancho">Nombre</th>
                      <th class="tabla-form-ancho">Teléfono</th>
                      <th class="tabla-form-ancho">Dirección</th>
                      <th class="tabla-form-ancho">Opciones</th>
                      
                  </tr>
              </thead>
              <tbody>
                   <?php 
                      $empresasInst->getTablaEmpresas();
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
  <!-- /.row -->
                
</div>
<!-- /#page-wrapper -->