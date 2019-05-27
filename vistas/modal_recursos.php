<!-- Modal -->
<div class="modal fade" id="form_modal_contrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_Hvida">-</h4>
      </div>
      <div class="modal-body">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-modal reg-hv" role="tablist">
          <li role="presentation" class="active"><a href="#datosGenerales" aria-controls="datosGenerales" role="tab" data-toggle="tab">Datos de Empleado</a></li>
          <li role="presentation"><a href="#estudios" aria-controls="estudios" role="tab" data-toggle="tab">Contrato</a></li>
          <li role="presentation"><a href="#archivos" aria-controls="estudios" role="tab" data-toggle="tab">Archivos</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

          <div role="tabpanel" class="tab-pane active" id="datosGenerales">
          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
            <form id="form_hvida" method="POST">
                <br>
                    <div class="form-group" hidden>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pkID" name="pkID">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="selectEstudioTecnico" class="control-label">Cedula</label>
                            <?php
                                  $recursosInst->getDocumentos();
                            ?>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Nombre(s)</label>
                        <input type="text" readonly="readonly" class="form-control" id="nombre" name="nombre" placeholder="Nombre(s) de la Persona" maxlength="25"  title="El nombre no contiene letras" required="true">
                    </div>
                    <div class="form-group">
                        <label for="apellido" class="control-label">Apellido(s)</label>
                        <input type="text" readonly="readonly" class="form-control" id="apellido" name="apellido" placeholder="Apellido(s) de la Persona" maxlength="25" required="true">
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="control-label">Teléfono</label>
                        <input type="tel" readonly="readonly" class="form-control" id="telefono" name="telefono" placeholder="Número de Teléfono de la Persona" required = "true">
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" readonly="readonly" class="form-control" id="email" name="email" placeholder="Correo electrónico de la Persona">
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">Estado**</label>
                        <select name="fkID_estado" id="fkID_estado" class="form-control" required = "true">
                            <option></option>
                            <?php
$estadoSelect = $hvidainst->getEstado();
for ($i = 0; $i < sizeof($estadoSelect); $i++) {
    echo '<option value="' . $estadoSelect[$i]["pkID"] . '">' . $estadoSelect[$i]["nombre"] . '</option>';
}
;
?>
                        </select>
                    </div>
                   <!--<div class="form-group" hidden>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fkID_usuario" name="fkID_usuario" value=<?php //echo $_COOKIE["log_lunelAdmin_id"] ?> >
                        </div>
                    </div>-->
            </form>
          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
          </div>

          <div role="tabpanel" class="tab-pane" id="estudios">
          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
          <form id="form_hvida_estudios">
                <div class="">
                <br>
                    <div class="form-group">
                        <label for="selectEstudioTecnico" class="control-label">Tecnico</label>
                            <?php
$hvidainst->getSelectTecnico();
?>
                    </div>

                    <div class="form-group">
                        <label for="selectEstudioTecnologo" class="control-label">Tecnologo</label>
                            <?php
$hvidainst->getSelectTecnologo();
?>
                    </div>

                    <div class="form-group">
                        <label for="selectEstudio" class="control-label">Pregrado</label>
                            <?php
$hvidainst->getSelectPregrado();
?>
                    </div>
                    <div id="selectPosgrado" class="form-group">
                        <label for="selectEstudioPos" class="control-label">Posgrado</label>
                            <?php
$hvidainst->getSelectPosgrado();
?>
                    </div>

                    <div id="selectCertificacion" class="form-group">
                        <label for="selectEstudioCertificacion" class="control-label">Certificacion</label>
                            <?php
$hvidainst->getSelectCertificacion();
?>
                    </div>

                    <div class="form-group text-right">
                            <button id="btn_nuevoestudio" type="button" class="btn btn-success" data-toggle="modal" data-target="#form_modal_estudios"><span class="glyphicon glyphicon-plus"></span> Agregar Estudio</button>
                    </div>
             </form>
                    <hr>

                    <div class="form-group">
                        <form id="frm_estudios_hvida">

                        </form>
                    </div>


                </div>

          </div>

          <div role="tabpanel" class="tab-pane" id="archivos">
            <div class="form-group">
            <br>
          <form id="form1" method="post" enctype="multipart/form-data">
              <div class="form-group ">
              <div class="col-sm-8 custom-file">
                <input type="file" class="form-control custom-file-input" id="archivo" name="archivo[]" multiple="">
                <br>
              </div>
              </div>
              <div class="form-group" hidden="true">
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pkID" name="pkID">
                    </div>
                </div>
              <!--<button type="submit" class="btn btn-primary">Cargar</button>
            </div>
            <div id="not_img" hidden>hola</div>                       
                      --->
                        <br>
                        <div id="archivos_res"></div> 
            
          </form>
                      
                <!--<button id="btn_sube_archivos" class="btn btn-primary">Subir</button>
                <br><br>
                <button id="btn_subir" data-nombre-archivo="-">buscar nombre</button>-->
                <br>
                <div id="res_form"></div>

            </div>
          </div>

        </div>

      </div>

      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--> 
        <button id="btn_actionHvida" type="button" class="btn btn-primary btn-limang" data-action="-" disabled="disabled">
            <span id="lbl_btn_actionHvida" class="btn-limang">-</span>
        </button>
      </div>


    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>

</div>
