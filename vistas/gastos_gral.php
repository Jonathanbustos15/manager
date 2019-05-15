<?php
	
	/**/
	include('../controller/muestra_pagina.php');
	
	$muestra_gastos_gral = new mostrar();
	
	//---------------------------------------------------------
	$pagina = 'cont_gastos_gral.php';
	$scripts = array('cont_gastos_gral.js','cont_gastos_gral_empresa.js','cont_gastos_gral_externo.js','cont_gastos_gral_selectsProyecto.js','cont_gastos_gral_filtro.js','helper_gasto_gral.js');
	$id_modulo = 16;
	//---------------------------------------------------------
	
	$muestra_gastos_gral->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);

//helper_gasto_gral.js	
?>
