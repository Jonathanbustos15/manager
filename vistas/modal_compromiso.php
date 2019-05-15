<?php 
                        $inst->getSelectEstadoCompromiso();
                     ?>
                </div>
                <div class="form-group">                     
                    <label for="contador_reprogramacion" class="control-label">Veces Reprogramado</label>
                    <input type="text" class="form-control" id="contador_reprogramacion" name="contador_reprogramacion" readonly="true">
                </div>
                <div id="descripcion_repro" class="form-group">
                    <label for="descripcion_reprogramacion" class="control-label">Descripción de la Reprogramación del Compromiso </label>
                    <textarea id="descripcion_reprogramacion" name="descripcion_reprogramacion" class="form-control" disabled="true"></textarea>
                </div>
                 <div class="form-group" id="div-novedades">
                        <label for="novedades" class="control-label">Novedades</label>     
                        <textarea class="form-control add-selectElement" id="novedades" name="novedades" readonly="true"></textarea>
                        <button id="btn_nuevonovedad" type="button" class="btn btn-success" data-toggle="modal" data-target="#frm_novedad" style="margin-top: -9%;" title="Nueva Novedad"><span class="glyphicon glyphicon-plus"></span></button>                  
                </div>

                
        </form>

        
        </div>

      <div class="modal-footer">
        <button id="btn_reprocompromiso" type="button" class="btn btn-warning">
           Reprogramar Compromiso
        </button>

        <button id="btn_actioncompromiso" type="button" class="btn btn-primary" data-action="-">
            <span id="lbl_btn_actioncompromiso">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>