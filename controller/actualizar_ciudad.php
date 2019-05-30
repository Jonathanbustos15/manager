    <?php
  $cod = $_POST["ciudad"];

  		if (!empty($cod)) {
  			comprobar($cod);
  		}

  		function comprobar($cod) {
  			require("../Conexion/Conexion2.php");
  			
  			$sql = mysqli_query($con,"select * FROM `ciudad` WHERE fkID_departamento = '".$cod."'ORDER BY nombre_ciudad");

  	$clientes = array();

while ($row = mysqli_fetch_row($sql)) {
	$codigo=$row[0];
		$codigodep=$row[1];
		$nombre=$row[2];
		$clientes[] = array('codigo'=> $codigo, 'nombre'=> $nombre, 'codigodepartamento'=> $codigodep);
}
		
	$json_string =json_encode($clientes);
	echo $json_string;
}

?>