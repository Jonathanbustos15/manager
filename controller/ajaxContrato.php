<?php 

  $idhv = $_POST['idhv'];
  $idticontra = $_POST['idticontra'];
  $fechain = $_POST['fechain'];
  $fechater = $_POST['fechater'];
  $salario = $_POST['salario'];
  $idcargo = $_POST['idcargo'];  
  $idarl = $_POST['idarl'];
  $ideps = $_POST['ideps'];
  $idcaja = $_POST['idcaja'];
  $idcesan = $_POST['idcesan'];
  $idpensio = $_POST['idpensio'];
  $idciudad = $_POST['idciudad'];
  $accion = $_POST['tipoaccion'];

  
            include_once '../Conexion/Conexion.php';
            $Conector = new Conexion();
            $db=$Conector->connect();

            $sql = "INSERT into contrato (fkID_hvida, fkID_tipo_contrato, fecha_inicio, fecha_terminacion, salario_base, fkID_cargo, fkID_arl, fkID_eps, fkID_caja_compensacion, fkID_cesantias, fkID_pensiones, fkID_ciudad) VALUES ('$idhv', '$idticontra', '$fechain', '$fechater', '$salario', '$idcargo', '$idarl', '$ideps', '$idcaja', '$idcesan', '$idpensio', '$idciudad')";
            $result = mysqli_query($db,$sql);
            $clientes = array();
           $resulta = mysqli_query($db,"select pkID FROM `contrato` ORDER by pkID DESC LIMIT 1");
           while ($row = mysqli_fetch_row($resulta)) {
            $codigo=$row[0];
            $clientes[] = array('codigo'=> $codigo, 'nombre'=> "pkID", 'id'=> "texto");
            }
           echo json_encode($clientes);
 
?>
         