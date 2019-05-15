<?php 

	include("../controller/muestra_pagina.php");

	$muestra_subcategoria = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_subcategoria.php";
	$scripts = array('cont_subcategoria.js');
	$perfiles_in = array('Administrador');
	//---------------------------------------------------------

	$muestra_subcategoria->mostrar_pagina_scripts($pagina,$scripts,$perfiles_in);

 ?>