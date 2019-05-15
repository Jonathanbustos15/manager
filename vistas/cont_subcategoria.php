<?php 

    include("../controller/categoriaController.php");    

    $categoriainst = new categoriaController();

?>
<!-- Modal -->
<div class="modal fade" id="form_modal_subcategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="lbl_form_subcategoria">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_subcategoria" method="POST">                
            <br>
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>

                <div class="form-group">
                        <label for="" class="control-label">Categoría</label>                        
                        <select name="fkID_padre" id="fkID_padre" class="form-control" required = "true">
                            <option></option>
                            <?php 
                                $categoriaSelect = $categoriainst->getCategorias();
                                for ($i=0; $i < sizeof($categoriaSelect); $i++) {
                                    echo '<option value="'.$categoriaSelect[$i]["pkID"].'">'.$categoriaSelect[$i]["nombre"].'</option>';
                                };
                             ?>
                        </select>                                                
                    </div>
                                                       
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>                        
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la Sub-categoría." required = "true">                        
                </div> 
        </form>
                
      </div>

      <div class="modal-footer">    
        <button id="btn_actionsubcategoria" type="button" class="btn btn-primary" data-action="-" disabled="disabled">
            <span id="lbl_btn_actionsubcategoria">-</span>
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
          <h1 class="page-header">Sub-categorías</h1> 
      </div>        
      <!-- /.col-lg-12 -->
      
  </div>
  <!-- /.row -->

  <div class="row">

    <div class="dataTable_wrapper">
        <table class="table table-striped table-bordered table-hover" id="tbl_subcategorias">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Padre</th> 
                    <th>Nombre</th>
                    <th data-orderable="false" >Opciones</th>
                </tr>
            </thead>
            <tbody>
                 <?php 
                    $categoriainst->getTablaSubcategorias();
                 ?>  
            </tbody>
        </table>
    </div>
    <!-- /.table-responsive -->

    <button id="btn_nuevosubcategoria" type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_modal_subcategoria"><span class="glyphicon glyphicon-plus"></span>&nbspCrear Sub-Categoría</button>            
     
  </div>
  <!-- /.row -->
                
</div>
        <!-- /#page-wrapper -->