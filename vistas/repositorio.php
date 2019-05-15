<?php
	
	/**/
	include('../controller/muestra_pagina.php');
	
	$muestra_repositorio = new mostrar();
	
	//---------------------------------------------------------
	$pagina = 'cont_repositorio.php';
	$scripts = array('cont_repositorio.js');
	$id_modulo = 21;
	//---------------------------------------------------------
	
	$muestra_repositorio->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);
?>
