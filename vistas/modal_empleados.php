<?php 
    //Incluyo el controller de hvida
    include("../controller/hvidaController.php");    

    $hvidainst = new HvidaController();
?>
<!-- Modal -->
<div class="modal fade" id="form_modal_empleados" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="overflow-y:scroll;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_empleados">-</h4>
      </div>
      <div class="modal-body">
        
        <form id="form_empleados">                
            <br>

                <div class="form-group" hidden>                     
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>                
                
                    <div class="form-group">
                        <label for="nidentificacion">Número de Identificación</label>                        
                        <input type="text" class="form-control" id="nidentificacion" name="nidentificacion" placeholder="Número de Cédula o identificación de la Persona" required="true">                        
                    </div>   
                    <div class="form-group">
                        <label for="" class="control-label">Ciudad documento</label>                        
                        <select name="ciudadCed" id="ciudadCed" class="form-control" required="true">
                            <option></option>
                            <?php 
                                $ciudadSelect = $hvidainst->getCiudad();
                                for ($i=0; $i < sizeof($ciudadSelect); $i++) {
                                    echo '<option value="'.$ciudadSelect[$i]["pkID"].'">'.$ciudadSelect[$i]["nombre"].'</option>';
                                };
                             ?>
                        </select>                                                
                    </div> 
                    <div class="form-group">
                        <label for="nombre" class="control-label">Nombre(s)</label>                        
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre(s) de la Persona" required="true">                        
                    </div>
                    <div class="form-group">
                        <label for="apellido" class="control-label">Apellido(s)</label>                    
                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido(s) de la Persona" required="true">                        
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="control-label">Teléfono</label>                    
                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Número de Teléfono de la Persona" required="true">                        
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>                        
                        <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico de la Persona">                        
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">Estado</label>                        
                        <select name="fkID_estado" id="fkID_estado" class="form-control" required="true">
                            <option></option>
                            <?php 
                                $estadoSelect = $hvidainst->getEstado();
                                for ($i=0; $i < sizeof($estadoSelect); $i++) {
                                    echo '<option value="'.$estadoSelect[$i]["pkID"].'">'.$estadoSelect[$i]["nombre"].'</option>';
                                };
                             ?>
                        </select>                                                
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">Observaciones</label>
                        <textarea rows="4" cols="50" id="obs_hvida" name="obs_hvida" class="form-control" placeholder="Observaciones"></textarea>                                                                        
                    </div>                        
        </form>
                
     </div>

      <div class="modal-footer">    
        
        <button id="btn_actionempleados" type="button" class="btn btn-primary" data-action="-" disabled="disabled">
            <span id="lbl_btn_actionempleados">-</span>
        </button>       

      </div>

    </div>
  </div>
</div>