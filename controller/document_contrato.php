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
    case 'consultararchivo':
    $db=$Conector->connect();
    $id=$_POST["pkID"];
    $sqli = mysqli_query($db,"select * FROM archivos_contrato where fkID_contrato=" .$id);
    $cliente = array();
      while ($row = mysqli_fetch_row($sqli)) {
          $idpk=$row[0];
          $codigo=$row[1];
          $nombre=$row[2];
          $codigoinput=$row[3];
          $cliente[] = array('id'=>$idpk,'codigo'=>$codigo,'nombre'=>$nombre,'id_input'=>$codigoinput);
      }
    $json_string =json_encode($cliente);
    echo $json_string;
      break;
  default:
    
    break;
}

?>