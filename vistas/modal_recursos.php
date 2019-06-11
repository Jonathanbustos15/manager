<!-- Modal -->
<div class="modal fade" id="form_modal_contrato" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="icono_modals"></div><h4 class="modal-title" id="lbl_form_contrato">-</h4>
      </div>
      <div class="modal-body">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs nav-modal reg-hv" role="tablist">
          <li role="presentation" class="active"><a href="#datosEmpleados" aria-controls="datosGenerales" role="tab" data-toggle="tab">Datos de Empleado</a></li>
          <li role="presentation"><a href="#Contrato" aria-controls="estudios" role="tab" data-toggle="tab">Contrato</a></li>
          <li role="presentation"><a href="#adjuntos" aria-controls="estudios" role="tab" data-toggle="tab">Archivos</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

          <div role="tabpanel" class="tab-pane active" id="datosEmpleados">
          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
            <form id="form_contratos" name="form_contratos">
                <br>
                    <div class="form-group" hidden>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="pkID" name="pkID">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Cedula</label>
                        <select name="fkID_cedula" id="fkID_cedula" class="form-control" required = "true">
                            <option value="" selected>Elije el empleado</option>
                            <?php
                                $estadoSelect = $recursosInst->getCedula();
                                for ($i = 0; $i < sizeof($estadoSelect); $i++) {
                                    echo '<option value="' . $estadoSelect[$i]["pkID"] . '">' . $estadoSelect[$i]["nidentificacion"] . '</option>';
                                };
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Nombre(s)</label>
                        <input type="text" readonly="readonly" class="form-control" id="nombrec" name="nombrec" placeholder="Nombre(s) de la Persona" maxlength="25"  title="El nombre no contiene letras" required="true">
                    </div>
                    <div class="form-group">
                        <label for="apellido" class="control-label">Apellido(s)</label>
                        <input type="text" readonly="readonly" class="form-control" id="apellidoc" name="apellidoc" placeholder="Apellido(s) de la Persona" maxlength="25" required="true">
                    </div>
                    <div class="form-group">
                        <label for="telefono" class="control-label">Teléfono</label>
                        <input type="tel" readonly="readonly" class="form-control" id="telefonoc" name="telefonoc" placeholder="Número de Teléfono de la Persona" required = "true">
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" readonly="readonly" class="form-control" id="emailc" name="emailc" placeholder="Correo electrónico de la Persona">
                    </div>
                   <!--<div class="form-group" hidden>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fkID_usuario" name="fkID_usuario" value=<?php //echo $_COOKIE["log_lunelAdmin_id"] ?> >
                        </div>
                    </div>-->
            </form>
          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
          </div>

          <div role="tabpanel" class="tab-pane" id="Contrato">
          <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
          <form id="form_contrato_datos" name="form_contrato_datos" >
                <div class="">
                <br>
                    <div class="form-group">
                        <label for="selectEstudioTecnico" class="control-label">Tipo de Contrato</label>
                            <?php
                                  $recursosInst->getSeleccion_Contrato();
                            ?>
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">Empresa</label>
                        <select name="fkID_estadoc" id="fkID_estadoc" class="form-control" required = "true">
                            <option value="" selected>Elije la Empresa</option>
                            <?php
                            $estadoSelect = $hvidainst->getEstado();
                            for ($i = 0; $i < sizeof($estadoSelect); $i++) {
                                echo '<option value="' . $estadoSelect[$i]["pkID"] . '">' . $estadoSelect[$i]["nombre"] . '</option>';
                            }
                            ;
                            ?>
                            <option value="" selected>Elije la Empresa</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fechain" class="control-label">Fecha de Ingreso</label>
                        <input type="date"class="form-control" id="fechain" name="fechain" required = "true">
                    </div>

                    <div class="form-group">
                        <label for="selectEstudio" class="control-label">Fecha Terminación de contrato</label>
                        <input type="date" class="form-control" name="fechater" id="fechater" required="true">
                    </div>

                    <div class="form-group">
                        <label for="apellido" class="control-label">Salario</label>
                        <input type="text" class="form-control" id="salarioc" name="salarioc" placeholder="Salario de la Persona" maxlength="25" required="true">
                    </div>

                    <div class="form-group">
                        <label for="selectEstudioTecnico" class="control-label">Cargo</label>
                            <?php
                                  $recursosInst->getSeleccion_Cargo();
                            ?>
                    </div>

                    <div class="form-group">
                        <label for="selectEstudioTecnico" class="control-label">ARL</label>
                            <?php
                                  $recursosInst->getSeleccion_arl();
                            ?>
                    </div>

                    <div class="form-group">
                        <label for="selectEstudioTecnico" class="control-label">EPS</label>
                            <?php
                                  $recursosInst->getSeleccion_eps();
                            ?>
                    </div>

                    <div class="form-group">
                        <label for="selectEstudioTecnico" class="control-label">Caja de Compensación</label>
                            <?php
                                  $recursosInst->getSeleccion_cajac();
                            ?>
                    </div>

                    <div class="form-group">
                        <label for="selectEstudioTecnico" class="control-label">Cesantias</label>
                            <?php
                                  $recursosInst->getSeleccion_cesantias();
                            ?>
                    </div>

                    <div class="form-group">
                        <label for="selectEstudioTecnico" class="control-label">Pensiones</label>
                            <?php
                                  $recursosInst->getSeleccion_pensiones();
                            ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="" class="control-label">Departamento</label>
                        <select name="fkID_departamento" id="fkID_departamento" class="form-control" required = "true">
                            <option value="">Elije el departamento</option>
                            <?php
                                $deparSelect = $recursosInst->getDepartamento();
                                for ($i = 0; $i < sizeof($deparSelect); $i++) {
                                    echo '<option value="' . $deparSelect[$i]["pkID"] . '">' . $deparSelect[$i]["nombre_departamento"] . '</option>';
                                };
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="" class="control-label">Ciudad</label>
                        <select name="ciudades" id="ciudades" class="form-control" required = "true">
                          <option value="" selected>Elije la ciudad</option>;
                        </select>  
                    </div>

             </form>
                    <hr>


                </div>

          </div>

          <div role="tabpanel" class="tab-pane" id="adjuntos">
            <div class="form-group">
            <br>
          <form id="formadjuntos" name="formadjuntos" method="POST" enctype="multipart/form-data">
              
                    <?php
                          $recursosInst->getArchivos_Contratos();
                    ?>
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
                        <div id="archivos_res_contra"></div> 
            
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
        <button id="btn_actioncontrato" type="button" class="btn btn-primary btn-limang" data-action="-" disabled="disabled">
            <span id="lbl_btn_actioncontrato" class="btn-limang">-</span>
        </button>
      </div>


    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>

</div>
