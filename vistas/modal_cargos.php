<!-- Modal -->
<div class="modal fade" id="form_modal_cargos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_cargos">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_cargos">                
            <br>

                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>                
                
                    <div class="form-group">
                        <label for="nombre_cargo">Nombre</label>                        
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del cargo" required="true">                        
                    </div>                  
        </form>
                
     </div>

      <div class="modal-footer">    
        
        <button id="btn_actioncargos" type="button" class="btn btn-primary" data-action="-" disabled="disabled">
            <span id="lbl_btn_actioncargos">-</span>
        </button>       

      </div>

    </div>
  </div>
</div>