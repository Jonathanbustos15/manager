<?php
	
	/**/
	include('../controller/muestra_pagina.php');
	
	$muestra_reuniones = new mostrar();
	
	//---------------------------------------------------------
	$pagina = 'cont_reuniones.php';
	$scripts = array('cont_reuniones.js', 'cont_reuniones_filtro.js', 'helper_reuniones.js', 'helper_detail_reunion.js');
	$id_modulo = 36;
	//---------------------------------------------------------
	
	$muestra_reuniones->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);
?>
