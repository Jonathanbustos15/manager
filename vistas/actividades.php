<?php
	
	/**/
	include('../controller/muestra_pagina.php');
	
	$muestra_actividades = new mostrar();
	
	//---------------------------------------------------------
	$pagina = 'cont_actividades.php';
	$scripts = array('cont_actividades.js');
	$id_modulo = 19;
	//---------------------------------------------------------
	
	$muestra_actividades->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);
?>
