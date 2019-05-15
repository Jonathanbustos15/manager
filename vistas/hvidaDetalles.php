<?php 

	include("../controller/muestra_pagina.php");

	$muestra_hvidaDetalles = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_hvidaDetalles.php";
	$scripts = array('cont_hvidaDetalles.js','cont_hvida.js','cont_hvida_estudios.js');
	//$perfiles_in = array('Administrador');
	$id_modulo = 6;
	//---------------------------------------------------------

	$muestra_hvidaDetalles->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);

 ?>