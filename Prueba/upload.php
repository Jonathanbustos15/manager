<?php 
   //Preguntamos si nuetro arreglo 'archivos' fue definido
         if (isset ($_FILES["archivos"])) {
         //de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo
         //obtenemos la cantidad de elementos que tiene el arreglo archivos
         $tot = count($_FILES["archivos"]["name"]);
         //este for recorre el arreglo
         for ($i = 0; $i < $tot; $i++){
         //con el indice $i, poemos obtener la propiedad que desemos de cada archivo
         //para trabajar con este
            $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
            $name = $_FILES["archivos"]["name"][$i];
            $name = str_replace(" ", "_", $name);
            $name = str_replace("%", "_", $name);
            $name = str_replace("-", "_", $name);
             //$name  = str_replace(".", "_", $name);
            $name  = str_replace(";", "_", $name);
            $name  = str_replace("#", "_", $name);
            $name  = str_replace("!", "_", $name);
            echo("<b>Archivo </b> $key ");
            echo("<br />");
            echo("<b>el nombre original:</b> ");
            echo($name);
            echo("<br />");
            echo("<b>el nombre temporal:</b> \n");
            echo($tmp_name);
            echo("<br />");            
            }
      }      
?>