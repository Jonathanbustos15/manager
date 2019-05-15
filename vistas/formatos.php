<?php 

	include("../controller/muestra_pagina.php");

	$muestra_formatos = new mostrar();

	//---------------------------------------------------------
	$pagina = "cont_formatos.php";
	$scripts = array('helper_formatos.js','cont_formatos.js','cont_formatos_cat.js','cont_formatos_selects.js','cont_formatos_tree1.js');
	//$perfiles_in = array('Administrador');
	$id_modulo = 2;
	//---------------------------------------------------------

	$muestra_formatos->mostrar_pagina_scripts($pagina,$scripts,$id_modulo);

 ?>