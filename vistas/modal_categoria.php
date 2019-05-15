<?php 
    
    /**/
    //include("../controller/categoriaController.php");    

    //$categoriainst = new categoriaController();

?>
<!-- Modal -->
<div class="modal fade" id="form_modal_categoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="lbl_form_categoria">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_categoria" method="POST">                
            <br>
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>
                                                       
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>                        
                    <input type="text" class="form-control" id="nombre_cat" name="nombre_cat" placeholder="Nombre de la categoría." required = "true">                        
                </div> 
        </form>
                
      </div>

      <div class="modal-footer">    
        <button id="btn_actionCategoria" type="button" class="btn btn-primary" data-action="-" disabled="disabled">
            <span id="lbl_btn_actionCategoria">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>
  
<!-- /form modal 2-->

<!--<script src="../js/scripts_cont/cont_categoria.js"></script>-->
