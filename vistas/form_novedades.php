<div class="modal fade" id="frm_observacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header fondomodalheader">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="imgedicion"></div><h3 class="modal-title titulomodal" id="lbl_form_observacion">-</h3>
      </div>
      <div class="modal-body">
        
        <form id="form_observacion" method="POST">                
            <br>
                <div class="form-group" hidden="true">                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkIDObservacionOwner" >
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha_observacion" class="control-label">Fecha de Creación - Novedad</label>                 
                    <input type="text" class="form-control" id="fecha_observacion" required = "true" readonly>           
                </div>
                                                       
                <div class="form-group">
                    <label for="novedadNuevo" class="control-label">novedades (caracteres no permitidos: #%&!()/)</label>                    
                    <textarea id="novedadNuevo" class="form-control" required = "true"></textarea>                    
                </div> 
        </form>
                
      </div>

      <div class="modal-footer">    
        <button id="btn_actionobservacion" type="button" class="btn btn-primary botonnewgasto" data-action="-">
            <span id="lbl_btn_actionobservacion">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>
  
<!-- /form modal 2-->

<!--<script src="../js/scripts_cont/cont_novedad.js"></script>-->