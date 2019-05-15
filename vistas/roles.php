<?php 

	include("../controller/muestra_pagina.php");

	$muestra_roles = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_roles.php";
	$scripts = array('cont_roles.js');
	//$perfiles_in = array('Administrador','jefe_personal');
	$id_modulo = 14;
	//---------------------------------------------------------

	$muestra_roles->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);

 ?>