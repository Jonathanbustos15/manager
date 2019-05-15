<?php 
	
	header('content-type: aplication/json; charset=utf-8');//header para json	
	include('../DAO/GenericoDAO.php');
	include('materialesController.php');

	$materiales = new MaterialesController();
	$general = new GenericoDAO();

 	$accion= isset($_GET['tipo'])?$_GET['tipo']:"x";

 	$r = array();

 	switch ($accion) { 		
 		//----------------------------------------------------------------------------------------------------
	 	case 'inserta_material':	 		

	 		$q_inserta = "insert INTO `material` (`pkID`, `nombre`, `precio`, `marca`, `imagen`, `fkID_clase`, `fkID_tipo`) 

	 		VALUES (NULL, '".$_GET['nombre']."', '".$_GET['precio']."', '".$_GET['marca']."', '".$_GET['imagen']."', '".$_GET['fkID_clase']."', NULL);";

	 		//echo $q_inserta;

	 		$resultado = $materiales->insertaMateriales($q_inserta);
	 		/*----------------------------------------------------*/
	 		if($resultado){
	 			
	 			$r[] = $resultado;

	 		}else{

	 			$r["estado"] = "Error";
	 			$r["mensaje"] = "No se guardó.";
	 		}

	 	break;
		//----------------------------------------------------------------------------------------------------

		//----------------------------------------------------------------------------------------------------
	 	case 'actualiza_material':	 		

	 		$q_edita = "update `material` SET `nombre` = '".$_GET['nombre']."', `precio` = '".$_GET['precio']."', `marca` = '".$_GET['marca']."', `imagen` = '".$_GET['imagen']."', `fkID_clase` = '".$_GET['fkID_clase']."' WHERE `material`.`pkID` =".$_GET['pkID'];	 		

	 		$resultado = $general->EjecutaActualizar($q_edita);
	 		/*----------------------------------------------------*/
	 		if($resultado){
	 			 			
 				$r[] = $resultado;

	 		}else{

	 			$r["estado"] = "Error";
	 			$r["mensaje"] = "No se actualizó.";
	 		}

	 	break;
		//----------------------------------------------------------------------------------------------------

		//----------------------------------------------------------------------------------------------------
	 	case 'ver_material':	 		

	 		$q_ver = "select * from material where pkID =".$_GET['id_material'];	 		

	 		$resultado = $materiales->getMaterialId($q_ver);
	 		/*----------------------------------------------------*/
	 		if($resultado){
	 			
	 			$r["estado"] = "Ok";
 				$r["mensaje"] = $resultado;

	 		}else{

	 			$r["estado"] = "Error";
	 			$r["mensaje"] = "No hay resultados.";
	 		}

	 	break;
		//----------------------------------------------------------------------------------------------------

		//----------------------------------------------------------------------------------------------------
	 	case 'inserta_propiedad':	 		

	 		$q_inserta_p = "insert INTO `material_propiedad` (`fkID_material`, `fkID_propiedad`, `valor`, `fkID_uMedida`) 
	 		VALUES ('".$_GET['fkID_material']."', '".$_GET['fkID_propiedad']."', '".$_GET['valor']."', '".$_GET['fkID_uMedida']."');";

	 		//echo $q_inserta;

	 		$resultado = $general->EjecutaInsertar($q_inserta_p);
	 		/*----------------------------------------------------*/
	 		if($resultado){
	 			
	 			$r[] = $resultado;

	 		}else{

	 			$r["estado"] = "Error";
	 			$r["mensaje"] = "No se guardó.";
	 		}

	 	break;
		//----------------------------------------------------------------------------------------------------

		//----------------------------------------------------------------------------------------------------
	 	case 'ver_propiedades':	 			 		 	

	 		$resultado = $materiales->getMaterialPropiedades($_GET['id_material']);
	 		/*----------------------------------------------------*/
	 		if($resultado){
	 			
	 			$r["estado"] = "Ok";
 				$r["mensaje"] = $resultado;

	 		}else{

	 			$r["estado"] = "Error";
	 			$r["mensaje"] = "No hay resultados.";
	 		}

	 	break;
		//----------------------------------------------------------------------------------------------------

		//----------------------------------------------------------------------------------------------------
	 	case 'elimina_propiedad':	 		

	 		$q_elimina_p = "delete FROM `material_propiedad` WHERE `material_propiedad`.`pkID` = ".$_GET['id_propiedad'];	 		

	 		$resultado = $general->EjecutaEliminar($q_elimina_p);
	 		/*----------------------------------------------------*/
	 		if($resultado){
	 			
	 			$r[] = $resultado;

	 		}else{

	 			$r["estado"] = "Error";
	 			$r["mensaje"] = "No se eliminó.";
	 		}

	 	break;
		//----------------------------------------------------------------------------------------------------

	 	//----------------------------------------------------------------------------------------------------
	 	case 'elimina_material':	 		

	 		$q_elimina_m = "delete FROM `material` WHERE `material`.`pkID` = ".$_GET['id_material'];

	 		//"DELETE FROM `brick`.`material` WHERE `material`.`pkID` = 5" 		

	 		$resultado = $general->EjecutaEliminar($q_elimina_m);
	 		/*----------------------------------------------------*/
	 		if($resultado){
	 			
	 			$r[] = $resultado;

	 		}else{

	 			$r["estado"] = "Error";
	 			$r["mensaje"] = "No se eliminó.";
	 		}

	 	break;
		//----------------------------------------------------------------------------------------------------

 	}
 	//--------------------------------------------------------------------------------------------------------

	echo json_encode($r); //imprime el json

 ?>