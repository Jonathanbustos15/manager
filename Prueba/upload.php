<?php
if ($_POST) {
    $nombre  = $_FILES['archivos']['name'];
    $tipo    = $_FILES['archivos']['type'];
    $tamanio = $_FILES['archivos']['size'];
    $ruta    = $_FILES['archivos']['tmp_name'];
//Reemplaza los ' ','%','-' por guiones al piso
    $nombre = str_replace(" ", "_", $nombre);
    $nombre = str_replace("%", "_", $nombre);
    $nombre = str_replace("-", "_", $nombre);
    //$nombre  = str_replace(".", "_", $nombre);
    $nombre  = str_replace(";", "_", $nombre);
    $nombre  = str_replace("#", "_", $nombre);
    $nombre  = str_replace("!", "_", $nombre);
    $destino = "../vistas/subidas/" . $nombre;

    //Copia el archivos al servidor
    move_uploaded_file($ruta, $destino);
    $validator = array('Nombre' => $temporal, 'Tipo' => $destino);

    echo "holaaaa";
}
?>
