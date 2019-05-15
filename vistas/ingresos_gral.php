<?php
	
	/**/
	include('../controller/muestra_pagina.php');
	
	$muestra_ingresos_gral = new mostrar();
	
	//---------------------------------------------------------
	$pagina = 'cont_ingresos_gral.php';
	$scripts = array('helper_ingresos_gral.js','cont_ingresos_gral.js','cont_ingresos_gral_empresa.js','cont_ingresos_gral_externo.js');
	$id_modulo = 15;
	//---------------------------------------------------------
	
	$muestra_ingresos_gral->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);
?>