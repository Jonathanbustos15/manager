<?php
    //http://usefulangle.com/post/14/jquery-2-ways-of-ajax-file-upload-formdata-and-filereader
    //$id      = $_POST['pkID'];
    //$nombre  = $_POST['nombre'];
    $clave  = $_POST['valor'];
    //$ruta  = $_POST['ruta'];
    $nombre =$_FILES[$clave]["name"];
    //$nombre  = $_FILES[$clave]["name"];
//Reemplaza los ' ','%','-' por guiones al piso
   /* $nombre = str_replace(" ", "_", $nombre);
    $nombre = str_replace("%", "_", $nombre);
    $nombre = str_replace("-", "_", $nombre);
    //$nombre  = str_replace(".", "_", $nombre);
    $nombre  = str_replace(";", "_", $nombre);
    $nombre  = str_replace("#", "_", $nombre);
    $nombre  = str_replace("!", "_", $nombre);
    $nombre  = $id . '_' . $nombre;*/
    //$ruta    = $_FILES['archivo_1']['tmp_name'];
    $destino = "../vistas/subidas/" . $nombre;  
    if(move_uploaded_file($_FILES[$clave]["tmp_name"], $destino)) { 
                //echo "El archivo $filename se ha almacenado en forma exitosa.<br>";       
                $mensaje = "El archivo $nombre ha almacenado en forma exitosa";

                } else {    
                $mensaje = "El archivo $nombre no se ha almacenado en forma exitosa";
            }
    //Copia el archivo al servidor
    //move_uploaded_file($_FILES['archivo']['tmp_name'], $destino);
    //move_uploaded_file();
    //$validator = array('Nombre' => $temporal, 'Tipo' => $destino);

    echo json_encode($mensaje);

?>

