<?php
	
	/**/
	include('../controller/muestra_pagina.php');
	
	$muestra_compromisos = new mostrar();
	
	//---------------------------------------------------------
	$pagina = 'cont_compromisos.php';
	$scripts = array('cont_compromisos.js');
	$id_modulo = 37;
	//---------------------------------------------------------
	
	$muestra_compromisos->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);
?>
