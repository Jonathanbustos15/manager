<?php 

	include("../controller/muestra_pagina.php");

	$muestra_categoria = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_categoria.php";
	$scripts = array('cont_categoria.js');
	$perfiles_in = array('Administrador');
	//---------------------------------------------------------

	$muestra_categoria->mostrar_pagina_scripts($pagina,$scripts,$perfiles_in);

 ?>