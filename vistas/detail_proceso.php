<?php 
	
	include("../controller/muestra_pagina.php");

	$muestra_detail_proceso = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_detail_proceso.php";
	$scripts = array('helper_procesos.js','cont_detail_proceso.js','cont_documentos_proceso.js','cont_detail_proceso_tdocumento.js','cont_detail_proceso_tdocumento_select.js','cont_detail_proceso_observaciones.js');
	//$perfiles_in = array('Administrador');
	$id_modulo = 8; 
	//---------------------------------------------------------

	$muestra_detail_proceso->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);

 ?>