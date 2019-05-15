<?php
	//Incluye el controller
 	include("../controller/recursosController.php");    

 	//Instancia la clase
 	$recursosInst = new recursosController();

	//Recibe el ID
	if(isset($_REQUEST["pkID"])){
		$id = $_REQUEST["pkID"];
	}

 	//Tomo el nombre del empleado
 	$empleado = $recursosInst->getEmpleadoId($id);
 	//Limpia la URL
 	$nombre = str_replace(" ", "_", $empleado[0]['nombres']);
 	//Asigna el nombre del archivo
 	$nombre_archivo = "Certificacion_".$nombre.".doc";

 	//Pasa los encabezados
	header("Content-type: application/msword");
	header("Content-Disposition: attachment; filename=".$nombre_archivo);
	header("Pragma: no-cache");
	header("Expires: 0"); 
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
</head>
<body>
<?php
 	$resultado = $recursosInst->getCertificacion($id,'word');
 	echo $resultado;
?>
</body>
</html>