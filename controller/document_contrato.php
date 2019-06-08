<?php
include_once"../DAO/RecursosDAO.php";
include_once '../Conexion/Conexion.php';
$fun = $_POST["tipo"];
$tabla = $_POST["nom_tabla"];
$Conector = new Conexion();
$seleccion = new recursos();
$db=$Conector->connect();

switch ($fun) {
  case 'consultarA':
  $archSelect = $seleccion->getArchivo();
  $db=$Conector->connect();
  $sql = mysqli_query($db,"select * FROM tipo_archivo_contrato");
  $clientes = array();
    while ($row = mysqli_fetch_row($sql)) {
      $codigo=$row[0];
        $nombre=$row[1];
        $codigoinput=$row[2];
        $clientes[] = array('codigo'=> $codigo, 'nombre'=> $nombre, 'id_input'=> $codigoinput);
    }
  $json_string =json_encode($clientes);
  echo $json_string;
  
    break;
    case 'variable':
      
      break;
  default:
    
    break;
}

?>