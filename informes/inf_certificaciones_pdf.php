<?php
require_once '../bower_components/PDF/dompdf/dompdf_config.inc.php';

//Incluye el controller
include "../controller/recursosController.php";

//Instancia la clase
$recursosInst = new recursosController();

//Recibe el ID
if (isset($_REQUEST["pkID"])) {
    $id = $_REQUEST["pkID"];
}

//Tomo el nombre del empleado
$empleado = $recursosInst->getEmpleadoId($id);
//Limpia la URL
$nombre = str_replace(" ", "_", $empleado[0]['nombres']);
//Asigna el nombre del archivo
$nombre_archivo = "Certificacion_" . $nombre . ".pdf";

//$resultado = $recursosInst->getContrato($id);
$resultado = $recursosInst->getCertificacion($id, 'pdf');

$dompdf = new DOMPDF();
$dompdf->load_html($resultado);
$dompdf->render();
$dompdf->stream($nombre_archivo);
