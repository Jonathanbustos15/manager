<?php
$guia= 1;
$falta="No";
$listo="Si";
$servername = "localhost";
$database = "managerbd";
$username = "root";
$password = "";
$conn = mysqli_connect($servername, $username, $password, $database);
        $contratos = mysqli_query($conn,"select concat_ws(' ',hoja_vida.nombre,hoja_vida.apellido) as nombre, archivos_contrato.fkID_contrato as N_contrato ,COUNT(archivos_contrato.fkID_tipo_archivo_contrato) as Cantidad_archivo from archivos_contrato inner join tipo_archivo_contrato on tipo_archivo_contrato.pkID= archivos_contrato.fkID_tipo_archivo_contrato inner join contrato on contrato.pkID = archivos_contrato.fkID_contrato inner join hoja_vida on hoja_vida.pkID = contrato.fkID_hvida GROUP BY archivos_contrato.fkID_contrato");
 while($contra=$contratos->fetch_array()){
        $empleados[] = array('nombre'=> $contra[0], 'N_contrato'=> $contra[1], 'Cantidad_archivo'=> $contra[2]);
    }
$contratos = mysqli_query($conn,"select contrato.pkID,concat_ws(' ',hoja_vida.nombre,hoja_vida.apellido)as nombres from contrato INNER JOIN hoja_vida on hoja_vida.pkID = contrato.fkID_hvida");
 while($contra=$contratos->fetch_array()){
        $idcontratos[] = array('pkID'=> $contra[0], 'nombres'=> $contra[1]);
    }
$archivos = mysqli_query($conn,"select * from tipo_archivo_contrato");
 while($tipo=$archivos->fetch_array()){
    $archivo[] = array('pkID'=> $tipo[0], 'nombre_archivo_contrato'=> $tipo[1]);
    }
    echo '<table width="70%" HEIGHT="40" border="1px" align="center">
        <tr>
            <th>Nombres</th>';
            for ($j=0; $j < sizeof($archivo) ; $j++) { 
            echo'<th>'.$archivo[$j]['nombre_archivo_contrato'].'</th>';
        }    
        echo '</tr>
        <tr>';
  for ($i=0; $i < sizeof($idcontratos) ; $i++) { 
    for ($x=0; $x < sizeof($empleados) ; $x++) { 
        if ($idcontratos[$i]['pkID'] == $empleados[$x]['N_contrato']) {
            $guia=2;
        }
    }
    if ($guia != 2) {
        echo '
        <td width="33%">'.$idcontratos[$i]['nombres'].'</td>';
        for ($j=0; $j < sizeof($archivo) ; $j++) { 
            echo'
            <td align="center">'.$falta.'</td>';
        ;
        }
         echo '</tr>';
    }
    $guia=1;
  }
  for ($i=0; $i < sizeof($empleados) ; $i++) { 
    if ($empleados[$i]['Cantidad_archivo'] == 7) {
    } else {
        echo'<p><tr>
            <td >'.$empleados[$i]['nombre'].'</td>';
        $archivitos =mysqli_query($conn,"select * from archivos_contrato WHERE archivos_contrato.fkID_contrato=".$empleados[$i]['N_contrato']);
         while($contra=$archivitos->fetch_array()){
            $archivo_contrato[] = array('pkID_archivo'=> $contra[3]);
            }
            $g=2;
            for ($k=0; $k < sizeof($archivo) ; $k++) {
                for ($j=0; $j < sizeof($archivo_contrato) ; $j++) {
                    if ($archivo[$k]['pkID'] === $archivo_contrato[$j]['pkID_archivo']) {
                        $g="si";
                    } 
                }; 
                if ($g == "si") {
                      echo'
                        <td align="center">si</td>';
                  } else {
                      echo'
                        <td align="center">'.$falta.'</td>';

                  }
                  $g=2;
            };
            
    }
    echo'</tr></p>';
  }
  echo '
    </table>';

?>
