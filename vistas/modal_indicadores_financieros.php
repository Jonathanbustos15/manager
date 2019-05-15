
<!-- Modal -->
<div class="modal fade form-horizontal" id="frm_modal_info_financiera" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="lbl_form_info_financiera">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_info_financiera" method="POST" enctype="multipart/form-data">                
            <br>
                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="anio" class="col-sm-4 control-label">Año </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="anio" name="anio" required = "true" readonly="true">  
                    </div>                    
                </div>

                <div class="form-group">
                    <label for="liquidez" class="col-sm-4 control-label">Liquidez </label>
                    <div class="col-sm-8">
                      <input type="number" class="form-control" id="liquidez" name="liquidez" required = "true">  
                    </div>                    
                </div>

                <div class="form-group" hidden="true">
                    <label for="capital_trabajo" class="col-sm-4 control-label">Capital de Trabajo </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="capital_trabajo" name="capital_trabajo" required = "true">  
                    </div>                    
                </div>

                <div class="form-group">
                    <label for="capital_trabajo_mask" class="col-sm-4 control-label">Capital de Trabajo </label>
                    <div class="col-sm-8">
                      <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input id="capital_trabajo_mask" type="text" class="form-control" required = "true">
                      </div>
                    </div>                  
                </div>

                <div class="form-group">
                    <label for="rentabilidad_patrimonio" class="col-sm-4 control-label">Rentabilidad del Patrimonio </label>
                    <div class="col-sm-8">
                      <div class="input-group">
                        <input type="number" class="form-control" id="rentabilidad_patrimonio" name="rentabilidad_patrimonio" required = "true">
                        <div class="input-group-addon">%</div>
                      </div>                      
                    </div>                    
                </div>

                <div class="form-group">
                    <label for="endeudamiento" class="col-sm-4 control-label">Endeudamiento </label>
                    <div class="col-sm-8">
                      <div class="input-group">                        
                        <input type="number" class="form-control" id="endeudamiento" name="endeudamiento" required = "true">
                        <div class="input-group-addon">%</div>
                      </div>                        
                    </div>                    
                </div>

                <div class="form-group">
                    <label for="razon_cobert_int" class="col-sm-4 control-label">Razón de Cobertura de Intereses </label>
                    <div class="col-sm-8">                                             
                      <input type="number" class="form-control" id="razon_cobert_int" name="razon_cobert_int" required = "true">                                              
                    </div>                    
                </div>

                <div class="form-group">
                    <label for="rentabilidad_activo" class="col-sm-4 control-label">Rentabilidad del Activo </label>
                    <div class="col-sm-8">
                      <div class="input-group">                        
                        <input type="number" class="form-control" id="rentabilidad_activo" name="rentabilidad_activo" required = "true">
                        <div class="input-group-addon">%</div>
                      </div>                        
                    </div>                    
                </div>

                <div class="form-group" hidden="true">
                    <label for="patrimonio" class="col-sm-4 control-label">Patrimonio </label>
                    <div class="col-sm-8">                                             
                      <input type="text" class="form-control" id="patrimonio" name="patrimonio" required="true">                                              
                    </div>                    
                </div>

                <div class="form-group">
                    <label for="patrimonio_mask" class="col-sm-4 control-label">Patrimonio </label>
                    <div class="col-sm-8">
                      <div class="input-group">
                        <span class="input-group-addon">$</span>
                        <input id="patrimonio_mask" type="text" class="form-control" required = "true">
                      </div>
                    </div>                  
                </div>

                <div class="form-group">
                    <label for="archivo" class="col-sm-4 control-label">Archivo</label>
                    <div class="col-sm-8">                        
                      <input id="archivo" type="file" name="archivo">
                      <input type="hidden" name="ruta" id="ruta">
                    </div>                       
                </div>

                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="fkID_empresa" name="fkID_empresa" value=<?php echo $empresaGen[0]["pkID"];  ?>>
                    </div>
                </div> 
        </form>
                
      </div>

      <div id="not_info_financiera" class="alert alert-info">
                
      </div>

      <div class="modal-footer">    
        <button id="btn_actioninfo_financiera" type="button" class="btn btn-primary" data-action="-" disabled="disabled">
            <span id="lbl_btn_actioninfo_financiera">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>
  
</div>
  
<!-- /form modal 2-->

<!--<script src="../js/scripts_cont/cont_info_financiera.js"></script>-->
