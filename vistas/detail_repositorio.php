<?php
	
	/**/
	include('../controller/muestra_pagina.php');
	
	$muestra_repositorio = new mostrar();
	
	//---------------------------------------------------------
	$pagina = 'cont_detail_repositorio.php';
	$scripts = array('cont_detail_repositorio.js');
	$id_modulo = 22;
	//---------------------------------------------------------
	
	$muestra_repositorio->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);
?>
