<?php 

	include("../controller/muestra_pagina.php");

	$muestra_entidades = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_entidades.php";
	$scripts = array('cont_entidades.js');
	$perfiles_in = array('Administrador');
	//---------------------------------------------------------

	$muestra_entidades->mostrar_pagina_scripts($pagina,$scripts,$perfiles_in);

 ?>