<?php 

	include("../controller/muestra_pagina.php");

	$muestra_empresa = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_empresa.php";
	$scripts = array('cont_empresa.js', 'cont_entidades_insert1.js');
	//---------------------------------------------------------
	//como saber que perfiles van?--BD
	//$perfiles_in = array('Administrador');
	$id_modulo = 23;
	//---------------------------------------------------------

	$muestra_empresa->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);

 ?>