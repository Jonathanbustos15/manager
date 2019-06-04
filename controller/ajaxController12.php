<?php

    ini_set('error_reporting', E_ALL|E_STRICT);
    ini_set('display_errors', 1); 
    
    header('content-type: aplication/json; charset=utf-8');//header para json   
    
    include('../DAO/GenericoDAO.php');

    include('crea_sql.php');

    //----------------------------------------------
    //include para enviar mails
    include('EmailController.php');
    include('EmailCompromisoController.php');

    $accion= isset($_GET['tipo'])?$_GET['tipo']:"x";

    $r = array();

    switch ($accion) {      
        
        //----------------------------------------------------------------------------------------------------
        case 'inserta':

            $generico = new GenericoDAO();
            $crea_sql = new crea_sql();

            $q_inserta = $crea_sql->crea_insert($_GET);
            $r["query"] = $q_inserta;           

            $resultado = $generico->EjecutaInsertar($q_inserta);
            /**/
            if($resultado){
                
                $r[] = $resultado;          

            }else{

                $r["estado"] = "Error";
                $r["mensaje"] = "No se inserto.";
            }

        break;
        //----------------------------------------------------------------------------------------------------

        //----------------------------------------------------------------------------------------------------
        case 'inserta_registro':

            $generico = new GenericoDAO();
            $crea_sql = new crea_sql();

            //pass_conf
            $_GET["pass"] = sha1($_GET["pass"]);
            $_GET["pass_conf"] = sha1($_GET["pass_conf"]);

            $q_inserta = $crea_sql->crea_insert($_GET);

            $r["query"] = $q_inserta;           

            /**/
            $resultado = $generico->EjecutaInsertar($q_inserta);
            
            if($resultado){
                
                $r[] = $resultado;          

            }else{

                $r["estado"] = "Error";
                $r["mensaje"] = "No se inserto.";
            }

        break;
        //----------------------------------------------------------------------------------------------------

        //----------------------------------------------------------------------------------------------------
        case 'actualiza_usuario':

            $generico = new GenericoDAO();
            $crea_sql = new crea_sql();


            $_GET["pass"] = sha1($_GET["pass"]);

            $q_actualiza = $crea_sql->crea_update($_GET);

            $r["query"] = $q_actualiza;         

            /**/
            $resultado = $generico->EjecutaActualizar($q_actualiza);
            
            if($resultado){
                
                $r["estado"] = "ok";
                $r["mensaje"] = "Contraseña Actualizada!";          

            }else{

                $r["estado"] = "Error";
                $r["mensaje"] = "No se actualizo.";
            }

        break;
        
        //----------------------------------------------------------------------------------------------------


        //----------------------------------------------------------------------------------------------------
        case 'consultar':

            $generico = new GenericoDAO();
            $crea_sql = new crea_sql();

            $q_carga = $crea_sql->crea_select($_GET);           

            $resultado = $generico->EjecutarConsulta($q_carga);
            /**/
            if($resultado){

                $r["estado"] = "ok";
                $r["mensaje"] = $resultado;

            }else{

                $r["estado"] = "Error";
                $r["mensaje"] = "No hay registros.";
            }

        break;
        //----------------------------------------------------------------------------------------------------

        //----------------------------------------------------------------------------------------------------
        case 'consultarcon':

            $generico = new GenericoDAO();
                  
            $q_carga = "select pkID, fkID_estado as fkID_estadoc, concat_ws(' ', nidentificacion,nombre,apellido) as fkID_cedula,nombre as nombrec,apellido as apellidoc,telefono as telefonoc,email as emailc FROM `hoja_vida` WHERE pkID =" . $_GET["pkID"]; 

            $resultado = $generico->EjecutarConsulta($q_carga);
            /**/
            if($resultado){

                $r["estado"] = "ok";
                $r["mensaje"] = $resultado;

            }else{

                $r["estado"] = "Error";
                $r["mensaje"] = "No hay registros.";
            }

        break;
        //----------------------------------------------------------------------------------------------------

        //----------------------------------------------------------------------------------------------------
        case 'consultarcontrato':

            $generico = new GenericoDAO();
                  
            $q_carga = "select contrato.pkID, fkID_tipo_contrato as selectC, fkID_cargo as selectCar, fkID_arl as selectarl, fkID_eps as selecteps,fkID_caja_compensacion as selectcaja, fkID_cesantias as selectcesan, fkID_pensiones as selectpensi, departamento.pkID as fkID_departamento, fkID_ciudad as pkciudad, ciudad.nombre_ciudad as ciudades, fecha_inicio as fechain, fecha_terminacion as fechater, salario_base as salarioc  FROM contrato
                INNER JOIN ciudad ON ciudad.pkID = contrato.fkID_ciudad
                INNER JOIN departamento ON departamento.pkID = ciudad.fkID_departamento
                WHERE contrato.pkID =" . $_GET["pkID"]; 

            $resultado = $generico->EjecutarConsulta($q_carga);
            /**/
            if($resultado){

                $r["estado"] = "ok";
                $r["mensaje"] = $resultado;

            }else{

                $r["estado"] = "Error";
                $r["mensaje"] = "No hay registros.";
            }

        break;
        //----------------------------------------------------------------------------------------------------

        //----------------------------------------------------------------------------------------------------
        case 'consulta_gen':

            $generico = new GenericoDAO();
            //$crea_sql = new crea_sql();

            $q_consulta = $_GET["query"];           

            $resultado = $generico->EjecutarConsulta($q_consulta);
            /**/
            if($resultado){

                $r["estado"] = "ok";
                $r["mensaje"] = $resultado;
                $r["consulta"] = $q_consulta;

            }else{

                $r["estado"] = "Error";
                $r["mensaje"] = "No hay registros.";
                $r["consulta"] = $q_consulta;
            }

        break;
        //----------------------------------------------------------------------------------------------------

        //----------------------------------------------------------------------------------------------------
        case 'actualizar':

            $generico = new GenericoDAO();
            $crea_sql = new crea_sql();

            $q_actualiza = $crea_sql->crea_update($_GET);           

            $resultado = $generico->EjecutaActualizar($q_actualiza);
            /**/
            if($resultado){
                
                $r["estado"] = "ok";
                $r["mensaje"] = $resultado;
                $r["query"] = $q_actualiza;

            }else{

                $r["estado"] = "Error";
                $r["mensaje"] = "No se actualizó.";
                $r["query"] = $q_actualiza;
            }

        break;
        //----------------------------------------------------------------------------------------------------

        //----------------------------------------------------------------------------------------------------
        case 'eliminar':

            $generico = new GenericoDAO();
            $crea_sql = new crea_sql();

            $q_elimina = $crea_sql->crea_delete($_GET);

            $r["query"] = $q_elimina;           

            $resultado = $generico->EjecutaEliminar($q_elimina);
            /**/
            if($resultado){
                
                $r["estado"] = "ok";
                $r["mensaje"] = $resultado;

            }else{

                $r["estado"] = "Error";
                $r["mensaje"] = "No se eliminó.";
            }

        break;

        case 'eliminarlogico':
        $generico = new GenericoDAO();
        $crea_sql = new crea_sql();
        $q_elimina = $crea_sql->crea_deletelog($_GET);
        $r["query"] = $q_elimina;
        $resultado = $generico->EjecutaEliminar($q_elimina);
        /**/
        if ($resultado) {
            $r["estado"]  = "ok";
            $r["mensaje"] = $resultado;
        } else {
            $r["estado"]  = "Error";
            $r["mensaje"] = "No se eliminó.";
        }
        break;
        //----------------------------------------------------------------------------------------------------

        //----------------------------------------------------------------------------------------------------
        case 'email':

            $email = new EmailController();                 

            $resultado = $email->sendEmail($_GET['pkID_usuario'],$_GET['tipo_asunto'],$_GET['tipo_cuerpo'],$_GET["pkID_proceso"]);
            /**/
            if($resultado){
                
                $r["estado"] = "ok";
                $r["mensaje"] = $resultado;

            }else{

                $r["estado"] = "Error";
                $r["mensaje"] = $resultado;
            }

        break;
        //----------------------------------------------------------------------------------------------------

        //----------------------------------------------------------------------------------------------------
        case 'email_compromisos':

            $email = new EmailCompromisoController();                   

            $resultado = $email->sendEmail($_GET['pkID_usuario'],$_GET['tipo_asunto'],$_GET['tipo_cuerpo'],$_GET['fkID_reunion'],$_GET['pkID_compromiso']);
            /**/
            if($resultado){
                
                $r["estado"] = "ok";
                $r["mensaje"] = $resultado;

            }else{

                $r["estado"] = "Error";
                $r["mensaje"] = $resultado;
            }

        break;
        //----------------------------------------------------------------------------------------------------

        //----------------------------------------------------------------------------------------------------
        case 'actualiza_gen':

            $generico = new GenericoDAO();
            //$crea_sql = new crea_sql();

            $q_consulta = $_GET["query"];           

            $resultado = $generico->EjecutaActualizar($q_consulta);
            /**/
            if($resultado){

                $r["estado"] = "ok";
                $r["mensaje"] = $resultado;
                $r["consulta"] = $q_consulta;

            }else{

                $r["estado"] = "Error";
                $r["mensaje"] = "No hay registros.";
                $r["consulta"] = $q_consulta;
            }

        break;
        //----------------------------------------------------------------------------------------------------
        
    }
    //--------------------------------------------------------------------------------------------------------

    echo json_encode($r); //imprime el json

 ?>