<?php
/*SELECT concat_ws(' ',hoja_vida.nombre,hoja_vida.apellido) as nombre, archivos_contrato.fkID_contrato as N_contrato ,COUNT(archivos_contrato.fkID_tipo_archivo_contrato) as Cantidad_archivo from 
archivos_contrato
inner join tipo_archivo_contrato on tipo_archivo_contrato.pkID= archivos_contrato.fkID_tipo_archivo_contrato
inner join contrato on contrato.pkID = archivos_contrato.fkID_contrato
inner join hoja_vida on hoja_vida.pkID = contrato.fkID_hvida
GROUP BY archivos_contrato.fkID_contrato*/
$servername = "localhost";
$database = "managerbd";
$username = "root";
$password = "";
$conn = mysqli_connect($servername, $username, $password, $database);
        $contratos = mysqli_query($conn,"select concat_ws(' ',hoja_vida.nombre,hoja_vida.apellido) as nombre, archivos_contrato.fkID_contrato as N_contrato ,COUNT(archivos_contrato.fkID_tipo_archivo_contrato) as Cantidad_archivo from archivos_contrato inner join tipo_archivo_contrato on tipo_archivo_contrato.pkID= archivos_contrato.fkID_tipo_archivo_contrato inner join contrato on contrato.pkID = archivos_contrato.fkID_contrato inner join hoja_vida on hoja_vida.pkID = contrato.fkID_hvida GROUP BY archivos_contrato.fkID_contrato");
 while($contra=$contratos->fetch_array()){
    echo'
    <table width="70%" border="1px" align="center">
        <tr>
            <td>'.$contra["nombre"].'</td>
            <td>'.$contra["N_contrato"].'</td>
            <td>'.$contra["Cantidad_archivo"].'</td>
        </tr>
    </table>
    ';
    }
    echo '<br> <br>';
        $resultado = mysqli_query($conn,"select pkID from contrato");
 while($datos=$resultado->fetch_array()){
    echo'
    <table width="70%" border="1px" align="center">
        <tr>
            <td>'.$datos["pkID"].'</td>
        </tr>
    </table>';
    }
    echo '<br> <br>';
        $archivos = mysqli_query($conn,"select * from tipo_archivo_contrato");
 while($tipo=$archivos->fetch_array()){
    echo'
    <table width="70%" border="1px" align="center">
        <tr>
            <td>'.$tipo["pkID"].'</td>
            <td>'.$tipo["nombre_archivo_contrato"].'</td>
        </tr>
    </table>';
    }


?>
