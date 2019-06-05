<?php
  $cod = $_POST["nombre"];

  		if (!empty($cod)) {
  			comprobar($cod);
  		}

  		function comprobar($cod) {
  			include_once '../Conexion/Conexion.php';
  			$Conector = new Conexion();
		    $db=$Conector->connect();
  			
  			$sql = mysqli_query($db,"select hoja_vida.pkID,hoja_vida.telefono,hoja_vida.email,hoja_vida.nombre,hoja_vida.apellido,estado.nombre as empresa FROM `hoja_vida`
			inner join estado on estado.pkID= estadov
			 where hoja_vida.pkID = '".$cod."'");   

  	$clientes = array();

while ($row = mysqli_fetch_row($sql)) {
	$codigo=$row[0];
		$nombre=$row[3];
		$apellido=$row[4];
		$telefono=$row[1];
		$email=$row[2];   
		$empresa=$row[5];
		$clientes[] = array('codigo'=> $codigo, 'nombre'=> $nombre, 'apellido'=> $apellido, 'telefono'=> $telefono, 'email'=> $email, 'empresa'=> $empresa);
}
		
	$json_string =json_encode($clientes);
	echo $json_string;
}

?>	
