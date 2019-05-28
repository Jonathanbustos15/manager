<?php
  $cod = $_GET['_num1'];

  		if (!empty($cod)) {
  			comprobar($cod);
  		}

  		function comprobar($cod) {
  			$con = mysql_connect('localhost','root','');
  			mysql_select_db('managerbd', $con);

  			$sql = mysql_query("select hoja_vida.pkID,hoja_vida.telefono,hoja_vida.email,hoja_vida.nombre,hoja_vida.apellido,estado.nombre as empresa FROM `hoja_vida`
inner join estado on estado.pkID= estadov
 where hoja_vida.pkID = '".$cod."'",$con);

  	$clientes = array();

while ($row = mysql_fetch_row($sql)) {
	$codigo=$row[0];
		$nombre=$row[3];
		$apellido=$row[4];
		$telefono=$row[1];
		$email=$row[2];
		$empresa=$row[5];
		$clientes[] = array('codigo'=> $codigo, 'nombre'=> $nombre, 'apellido'=> $apellido, 'telefono'=> $telefono, 'email'=> $email, 'empresa'=> $empresa,).
}
		
	$json_string =json_encode($clientes);
	echo $json_string;
}

?>	
