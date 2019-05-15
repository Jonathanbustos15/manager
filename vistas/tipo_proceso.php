<?php 

	include("../controller/muestra_pagina.php");

	$muestra_tipo_proceso = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_tipo_proceso.php";
	$scripts = array('cont_tipo_proceso.js');
	$perfiles_in = array('Administrador');
	//---------------------------------------------------------

	$muestra_tipo_proceso->mostrar_pagina_scripts($pagina,$scripts,$perfiles_in);

 ?>