<?php

include "../controller/hvidaController.php";

$hvidainst = new HvidaController();

$id_hoja = $_GET["id_hoja"];

$arrPermisos      = $hvidainst->permisos(11, $_COOKIE["log_lunelAdmin_IDtipo"]);
$editaPersonal    = $arrPermisos[0]["editar"];
$eliminaPersonal  = $arrPermisos[0]["eliminar"];
$consultaPersonal = $arrPermisos[0]["consultar"];
?>

<div id="page-wrapper">

    <div class="row">

        <div class="col-lg-12">
            <h1 class="page-header">Detalles Hoja de Vida</h1>
        </div>
        <!-- /.col-lg-12 -->
        <div class="col-lg-12 rowhv3">
            <ol class="breadcrumb">
              <li><a href="index.php">Inicio</a></li>
              <li><a href="recursos.php?s=*">Hojas de Vida</a></li>
              <li class="active">Detalles Hoja de vida</li>
              <li>
                <?php
echo '<a id="btn_editar" title="Editar" name="edita_hvida" data-toggle="modal" data-target="#form_modal_hvida" data-id-hvida = "' . $id_hoja . '" ';if ($editaPersonal != 1) {echo 'disabled="disabled"';}
echo '>Editar</a>'
?>
              </li>
            </ol>
        </div>

    </div>
    <!-- /.row -->

<!-- /Modal -->
<?php
include 'modal_hvida.php';
include 'modal_estudios.php';
?>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  -->

    <div class="row">

        <?php
$hvidainst->getHvidaTitulo($id_hoja);
?>

        <div class="panel panel-default">

            <?php
$hvidainst->getHvidaDatosGen($id_hoja);

$hvidainst->getEstudiosHvidaId($id_hoja);

$hvidainst->getArchivosHvidaId($id_hoja);
?>

        </div>

    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->