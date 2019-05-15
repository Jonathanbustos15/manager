<?php
	
	/**/
	include('../controller/muestra_pagina.php');
	
	$muestra_contactos = new mostrar();
	
	//---------------------------------------------------------
	$pagina = 'cont_contactos.php';
	$scripts = array('cont_contactos.js','cont_contactos_tipoContacto.js','cont_contactos_entidad.js');
	$id_modulo = 17;
	//---------------------------------------------------------
	
	$muestra_contactos->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);
?>
