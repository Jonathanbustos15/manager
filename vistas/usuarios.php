<?php 

	include("../controller/muestra_pagina.php");

	$muestra_usuarios = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_usuarios.php";
	$scripts = array('helper_usuarios.js','cont_usuarios.js');
	//$perfiles_in = array('Administrador','jefe_personal');
	$id_modulo = 13;
	//---------------------------------------------------------

	$muestra_usuarios->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);

 ?>