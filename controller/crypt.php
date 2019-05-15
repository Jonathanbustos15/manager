<?php
	
	header('content-type: aplication/json; charset=utf-8');

	/**
	 * Esta clase encripta y desencripta valores
	 */
	include("class_crypt.php"); 
	
	$accion= isset($_GET['tipo'])?$_GET['tipo']:"x";

 	$r = array();

	switch ($accion) { 		
 		
		//----------------------------------------------------------------------------------------------------
	 	case 'encriptar':

	 		$Crypt_inst = new crypt();

	 		$encriptado = $Crypt_inst->encriptar($_GET['valor']);
	 		
	 		/**/
	 		if($encriptado){
	 			
	 			$r["encriptado"] = $encriptado;
	 			$r["get"] = $_GET['valor']; 			

	 		}else{

	 			$r["estado"] = "Error";
	 			$r["mensaje"] = "No se encriptó.";
	 		}

	 	break;
		//----------------------------------------------------------------------------------------------------

		//----------------------------------------------------------------------------------------------------
	 	case 'desencriptar':

	 		$Crypt_inst = new crypt();

	 		$r["get"] = $_GET['valor'];

	 		$desencriptado = $Crypt_inst->desencriptar(str_replace(" ", "+", $_GET['valor']));
	 		
	 		/**/
	 		if($desencriptado){
	 			
	 			$r["desencriptado"] = $desencriptado;
	 			$r["get"] = $_GET['valor']; 			

	 		}else{

	 			$r["estado"] = "Error";
	 			$r["mensaje"] = "No se desencriptó.";
	 		}

	 	break;
		//----------------------------------------------------------------------------------------------------

		//----------------------------------------------------------------------------------------------------
	 	case 'sha1':

	 		$Crypt_inst = new crypt();

	 		$r["get"] = $_GET['valor'];

	 		$encriptado = $Crypt_inst->encriptasha1($_GET['valor']);
	 		
	 		/**/
	 		if($encriptado){
	 			
	 			$r["encriptado"] = $encriptado;
	 			$r["get"] = $_GET['valor']; 			

	 		}else{

	 			$r["estado"] = "Error";
	 			$r["mensaje"] = "No se encriptó.";
	 		}

	 	break;
		//----------------------------------------------------------------------------------------------------
	}

	echo json_encode($r); //imprime el json

 ?>