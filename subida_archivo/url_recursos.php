<?php
if($_POST){
	$validator = array();
	for($i=1; $i<=7; $i++){
		$nombre = $_FILES['archivo'.$i]['name'];
		$tipo = $_FILES['archivo'.$i]['type'];
		$tamanio = $_FILES['archivo'.$i]['size'];
		$ruta = $_FILES['archivo'.$i]['tmp_name'];
		//Reemplaza los ' ','%','-' por guiones al piso
		$nombre = str_replace(" ", "_", $nombre);
		$nombre = str_replace("%", "_", $nombre);
		$nombre = str_replace("-", "_", $nombre);
		$nombre = $nombre;
		$destino = "../vistas/subidas/" . $nombre;

		//Copia el archivo al servidor
		move_uploaded_file($ruta, $destino);
		
		$validator[] = array('nombre' => $nombre, 'contador' => $i);
	}

	echo json_encode($validator);
}
?>