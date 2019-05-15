<?php 

	include("../controller/muestra_pagina.php");

	$muestra_contactoDetalles = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_contactoDetalles.php";
	$scripts = array('cont_contactoDetalles.js');
	//$perfiles_in = array('Administrador');
	$id_modulo = 6;
	//---------------------------------------------------------

	$muestra_contactoDetalles->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);

 ?>