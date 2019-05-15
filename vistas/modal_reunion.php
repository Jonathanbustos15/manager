<?php 
                            $inst->getSelectModeradorReunion();
                        ?> 
                    </div>
                </div>
                                

                <div class="form-group">

                    <label for="" class="col-sm-1 control-label">Desarrollo</label>
                    <div class="col-sm-11">
                        <textarea id="desarrollo" name="desarrollo" class="form-control" rows="12" placeholder="Desarrollo de la reunión"></textarea>
                    </div>

                </div>

                <div id="select_usuario_reunion" class="form-group">

                    <label for="" class="text-left-important col-md-2 control-label">Participantes de la Reunión</label>
                    
                    <div class="col-sm-10 text-right">                                   
                        <?php
                            $inst->getSelectUsuariosReuniones();
                         ?>
                    </div>                       
                </div>
                               
        </form>

                <div id='select_participantes'>
                  <label class="control-label">Participantes Seleccionados</label> 
                  <form id="frm_usuarios_reuniones"></form>
                  <hr>
                </div>

                <div id="agenda_forms">
                    <hr>
                    <div class="form-group">
                        <label class="control-label">Agenda</label>                    
                    </div>

                    <div id="div_form_agenda" class="form-group">
                                                                
                    </div>

                    <div class="form-group">
                        <button id="btn_add_tema" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Añadir Tema</button>
                    </div>
                    <hr>
                </div>


                <div id="compromiso_forms">
                    <hr>
                    <div class="form-group">
                        <label class="control-label">Compromisos</label>                    
                    </div>

                    <div id="div_form_compromiso" class="form-group">
                                                                
                    </div>

                    <div class="form-group">
                        <br><br>
                        <button id="btn_add_compromiso" class="btn btn-primary btn-add-compromisos"><span class="glyphicon glyphicon-plus-sign"></span> Añadir Compromiso</button>
                    </div>
                    <hr>
                </div>
                

                <div id="res_form"></div>                
      </div>

      <div class="modal-footer">    
        <button id="btn_actionreunion" type="button" class="btn btn-primary" data-action="-">
            <span id="lbl_btn_actionreunion">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>
  
<!-- /form modal 2-->

<!--<script src="../js/scripts_cont/cont_reunion.js"></script>-->
