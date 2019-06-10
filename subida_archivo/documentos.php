<?php
    $id      = $_POST['pkID'];
    $nombre  = $_POST['nombre'];
    $ruta  = $_POST['ruta'];
    $nombre =$_FILES['file']["name"];
    //Reemplaza los caracteres especiales por guiones al piso
    $nombre = str_replace(" ", "_", $nombre);
    $nombre = str_replace("%", "_", $nombre);
    $nombre = str_replace("-", "_", $nombre);
    $nombre = str_replace(";", "_", $nombre);
    $nombre = str_replace("#", "_", $nombre);
    $nombre = str_replace("!", "_", $nombre);
    $nombre = $id . '_' . $nombre;
    //carga el archivo en el servidor
    $destino = "../vistas/subidas/" . $nombre;  
    if(move_uploaded_file($_FILES['file']["tmp_name"], $destino)) {        
                $mensaje = "El archivo $nombre ha almacenado en forma exitosa";

                } else {    
                $mensaje = "El archivo $nombre no se ha almacenado en forma exitosa";
            }
    echo json_encode($nombre);
?>

