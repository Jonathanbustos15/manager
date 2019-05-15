<!-- Modal -->
<div class="modal fade" id="form_modal_estudios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_estudios">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_estudios">    
            <br>

                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>                
                
                <div class="form-group">                                      
                    <label for="nombre" class="control-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre_estudio" name="nombre" required = "true">                    
                </div>     

                <div class="form-group">
                    <label for="" class="control-label">Tipo de Estudio</label>                        
                    <select name="fkID_tipoEstudio" id="fkID_tipoEstudio" class="form-control" required = "true">
                        <option></option>
                        <?php
                            /**/
                            $tipoEstudiosSelect = $hvidainst->getTipoEstudio();
                            
                            for ($i=0; $i < sizeof($tipoEstudiosSelect); $i++) {
                                echo '<option value="'.$tipoEstudiosSelect[$i]["pkID"].'">'.$tipoEstudiosSelect[$i]["nombre"].'</option>';
                            };
                         ?>
                    </select>                                                
                </div>                          
        </form>
                
      </div>

      <div class="modal-footer">    
        
        <button id="btn_actionestudios" type="button" class="btn btn-primary" data-action="-" disabled="disabled">
            <span id="lbl_btn_actionestudios">-</span>
        </button>       

      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>
  
<!-- /form modal 2-->

<!--<script src="../js/scripts_cont/cont_estudios.js"></script>-->
