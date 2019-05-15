<?php 

    include('../controller/valida.php');

    $login = new valida();

    function valida_login(){

        global $login;

       $valida_login = $login->valida_vals();

        if ($valida_login) {
            # code...
            //echo "Login: ".$valida_login;
            header('Location: index.php');
        } else {
            # code...
            //echo "No esta logueado.";
            header('Location: cont_login.php');
        } 
    }
    
    valida_login();

 ?>