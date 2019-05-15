<?php

/**/
//include("../controller/empresaController.php");

//$observacioninst = new observacionController();

?>
<!-- Modal -->
<div class="modal fade" id="form_modal_docslegales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="lbl_form_docslegales">-</h4>
      </div>
      <div class="modal-body">

        <form id="form_docslegales" method="POST" enctype="multipart/form-data">
            <br>
                <div class="form-group" hidden="true">
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="pkID" id="pkID">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nom_docl" class="control-label">Nombre</label>
                    <input type="text" class="form-control" id="nom_docl" name="nom_docl" placeholder="Nombre del documento legal." required = "true">
                </div>

                <div class="form-group">
                    <label for="nom_docl2" class="control-label">Nombre2</label>
                    <input type="text" class="form-control" id="nom_docl2" name="nom_docl2" placeholder="Nombre del documento legal." required = "true">
                </div>

                <div class="form-group">
                    <label for="anio_docl" class="control-label">Año de Expedición</label>

                   <select id="anio_expedicion" name="anio_expedicion" class="form-control">
                      <?php for ($i = 1990; $i <= 2020; $i++) {echo "<option value='" . $i . "'>" . $i . "</option>";}?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="archivo" class="control-label">Archivo</label>
                    <input type="file" class="form-control" id="archivo" name="archivo" placeholder="Archivo">
                    <input type="hidden" name="ruta" id="ruta">
                </div>


                <div class="form-group" hidden>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="fkID_empresa" name="fkID_empresa" value= <?php echo $empresaGen[0]["pkID"]; ?> >
                    </div>
                </div>
        </form>
        <div id="not_docs_legales" class="alert alert-info">

        </div>

      </div>

      <div class="modal-footer">
        <button id="btn_actiondocslegales" type="button" class="btn btn-primary" data-action="-" disabled="disabled">
            <span id="lbl_btn_actiondocslegales">-</span>
        </button>
      </div>

    </div>
        <!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->
  </div>

</div>

<!-- /form modal 2-->

<!--<script src="../js/scripts_cont/cont_observacion.js"></script>-->
