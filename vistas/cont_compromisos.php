<?php
	
	/**/
	
	include('../controller/compromisosController.php');
	
	include('../conexion/datos.php');
	
	$compromisosInst = new compromisosController();
	
	$arrPermisos = $compromisosInst->getPermisosModulo_Tipo($id_modulo,$_COOKIE[$NomCookiesApp.'_IDtipo']);
	
	$crea = $arrPermisos[0]['crear'];
	
?>
