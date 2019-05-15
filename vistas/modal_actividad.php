
<!-- Modal -->
<div class="modal fade" id="form_modal_actividad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="lbl_form_actividad">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_actividad" method="POST">                
            <br>
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>
                                                       
                <div class="form-group">
                    <label for="nombre" class="control-label">Nombre</label>                        
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la actividad" required = "true">                        
                </div>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="subtotal" name="subtotal" required = "true">
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
                
                <div class="form-group">
                    <label for="iva_mask" class="control-label">IVA</label>            
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="iva_mask" type="text" class="form-control" required="true">                      
                    </div>

                </div>

                <div class="form-group" hidden="true">
                  <input type="text" class="form-control" id="total" name="total" required = "true">
                </div>

                <div class="form-group">
                    <label for="total_mask" class="control-label">Total</label>            
                    
                    <div class="input-group">
                      <span class="input-group-addon">$</span>
                      <input id="total_mask" type="text" class="form-control" readonly="true" required="true">                      
                    </div>

                </div>

                <div class="form-group" hidden="true">
                    <label for="fkID_proyecto" class="control-label">Proyecto</label>                        
                    <input type="text" class="form-control" id="fkID_proyecto" name="fkID_proyecto" required = "true" readonly="true" value=<?php echo $pkID ?> >                        
                </div>  
        </form>
                
      </div>

      <div class="modal-footer">    
        <button id="btn_actionactividad" type="button" class="btn btn-primary" data-action="-" disabled="disabled">
            <span id="lbl_btn_actionactividad">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>
  
<!-- /form modal 2-->

<!--<script src="../js/scripts_cont/cont_actividad.js"></script>-->
