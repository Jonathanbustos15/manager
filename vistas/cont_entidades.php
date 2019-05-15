<?php 

    include("../controller/entidadController.php");    

    $entidadinst = new entidadController();

?>
<!-- Modal -->
<div class="modal fade" id="form_modal_entidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="lbl_form_entidad">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_entidad" method="POST">                
            <br>
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>
                                                       
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>                        
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la entidad." required = "true">                        
                </div> 
        </form>
                
      </div>

      <div class="modal-footer">    
        <button id="btn_actionentidad" type="button" class="btn btn-primary" data-action="-" disabled="disabled">
            <span id="lbl_btn_actionentidad">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>
  
<!-- /form modal 2-->


<div id="page-wrapper">

  <div class="row">

      <div class="col-lg-12">
          <h1 class="page-header">Entidades</h1> 
      </div>        
      <!-- /.col-lg-12 -->
      
  </div>
  <!-- /.row -->

  <div class="row">

    <div class="dataTable_wrapper">
        <table class="table table-striped table-bordered table-hover" id="tbl_entidades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>                                  
                    <th data-orderable="false" >Opciones</th>
                </tr>
            </thead>
            <tbody>
                 <?php 
                    $entidadinst->getTablaEntidades();
                 ?>  
            </tbody>
        </table>
    </div>
    <!-- /.table-responsive -->

    <button id="btn_nuevoentidad" type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_modal_entidad"><span class="glyphicon glyphicon-plus"></span>&nbspCrear Entidad</button>            
     
  </div>
  <!-- /.row -->
                
</div>
<!-- /#page-wrapper -->