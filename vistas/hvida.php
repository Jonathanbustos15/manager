<?php

include "../controller/muestra_pagina.php";

$muestra_hvida = new mostrar();

//---------------------------------------------------------
$pagina  = "cont_hvida.php";
$scripts = array('cont_hvida.js', 'cont_hvida_functions.js', 'cont_hvida_estudiosPos.js', 'cont_hvida_filtro.js');
//---------------------------------------------------------
//como saber que perfiles van?--BD
//$perfiles_in = array('Administrador');
$id_modulo = 1;
//---------------------------------------------------------

$muestra_hvida->mostrar_pagina_scripts($pagina, $scripts, $id_modulo);
