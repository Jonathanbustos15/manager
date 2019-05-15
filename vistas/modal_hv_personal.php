<?php

/**/
include "../controller/hvidaController.php";

$personalinst = new HvidaController();

?>
<!-- Modal -->
<div class="modal fade" id="form_modal_personal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_personal">-</h4>
      </div>
      <div class="modal-body">

        <form id="form_personal" method="POST">
            <br>

                <div class="form-group" hidden>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>

                <div class="form-group" hidden>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="fkID_proyecto" name="fkID_proyecto" value=<?php echo $pkID; ?>>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="control-label">Persona (Empleado o Externo)</label>
                    <!--<select name="fkID_hv" id="fkID_hv" class="form-control" required = "true">
                        <option></option>
                        <?php
/*
$personalSelect = $personalinst->getHvidaPersonal();

for ($i=0; $i < sizeof($personalSelect); $i++) {
echo '<option value="'.$personalSelect[$i]["pkID"].'">C.C.:'.$personalSelect[$i]["nidentificacion"].' -- '.$personalSelect[$i]["nombre"].' '.$personalSelect[$i]["apellido"].'</option>';
};*/
?>
                    </select>-->
                    <input type="text" id="personal_autocompleta" class="form-control" placeholder="Autocompletado por Número de identificación, Nombre o Apellido" required="true">
                    <input type="hidden" id="fkID_hv" name="fkID_hv" class="form-control">
                </div>

                <div class="form-group">
                    <label for="" class="control-label">Rol</label>
                    <input type="text" class="form-control" id="rol" name="rol">
                </div>

                <div class="form-group">
                    <label for="" class="control-label">Observaciones</label>
                    <textarea class="form-control" name="observaciones" id="observaciones" cols="5" rows="2"></textarea>
                </div>

        </form>

      </div>

      <div class="modal-footer">
        <button id="btn_actionpersonal" type="button" class="btn btn-primary" data-action="-" disabled="disabled">
            <span id="lbl_btn_actionpersonal">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>

</div>

<!-- /form modal 2-->

<!--<script src="../js/scripts_cont/cont_personal.js"></script>-->
