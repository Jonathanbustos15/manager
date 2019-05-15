<?php 

	include("../controller/muestra_pagina.php");

	$muestra_detail_reunion = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_detail_reunion.php";

	$scripts = array('helper_detail_reunion.js', 'cont_detail_reunion.js');
	//$perfiles_in = array('Administrador');
	$id_modulo = 38;
	//---------------------------------------------------------

	$muestra_detail_reunion->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);

 ?>