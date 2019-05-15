<?php
	
	/**/
	include('../controller/muestra_pagina.php');
	
	$muestra_contrasenas = new mostrar();
	
	//---------------------------------------------------------
	$pagina = 'cont_contrasenas.php';
	$scripts = array('cont_contrasenas.js');
	$id_modulo = 20;
	//---------------------------------------------------------
	
	$muestra_contrasenas->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);
?>
