<!-- Modal -->
<div class="modal fade" id="form_modal_entidad" tabindex="-1" role="dialog" data-backdrop="static">
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
                    <input type="text" class="form-control" id="nombre_entidad" name="nombre_entidad" placeholder="Nombre de la entidad." required = "true" >                        
                </div>

                <div id="not_entidades_modal" class="alert alert-info">
                    
                </div>

                <div class="form-group">
                    <label for="nom_contacto" class="control-label">Nombre de Contacto</label>                        
                    <input type="text" class="form-control" id="nom_contacto" name="nom_contacto" placeholder="Nombre de Contacto en la entidad.">                        
                </div>
                <div class="form-group">
                    <label for="tel_contacto" class="control-label">Teléfono de Contacto</label>                        
                    <input type="number" class="form-control" id="tel_contacto" name="tel_contacto" placeholder="Teléfono de Contacto en la entidad.">                        
                </div>
                <div class="form-group">
                    <label for="observacion_entidad" class="control-label">Observación</label>                        
                    <!--<input type="number" class="form-control" id="tel_contacto" name="tel_contacto" placeholder="Teléfono de Contacto en la entidad." required = "true">-->
                    <textarea name="observacion_entidad" id="observacion_entidad" class="form-control" cols="10" rows="2"></textarea>
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
