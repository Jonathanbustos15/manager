<?php
if ($_POST) {
    $id      = $_POST['pkID'];
    $nombre  = $_FILES['archivo']['name'];
    $tipo    = $_FILES['archivo']['type'];
    $tamanio = $_FILES['archivo']['size'];
    $ruta    = $_FILES['archivo']['tmp_name'];
//Reemplaza los ' ','%','-' por guiones al piso
    $nombre = str_replace(" ", "_", $nombre);
    $nombre = str_replace("%", "_", $nombre);
    $nombre = str_replace("-", "_", $nombre);
    //$nombre  = str_replace(".", "_", $nombre);
    $nombre  = str_replace(";", "_", $nombre);
    $nombre  = str_replace("#", "_", $nombre);
    $nombre  = str_replace("!", "_", $nombre);
    $nombre  = $id . '_' . $nombre;
    $destino = "../vistas/subidas/" . $nombre;

    //Copia el archivo al servidor
    move_uploaded_file($ruta, $destino);
    $validator = array('Nombre' => $temporal, 'Tipo' => $destino);

    echo json_encode($validator);
}
