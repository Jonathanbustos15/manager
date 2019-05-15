<?php
	echo '<pre hidden="true">';

	// Muestra el resultado completo del comando "ls", y devuelve la
	// ultima linea de la salida en $ultima_linea. Almacena el valor de
	// retorno del comando en $retval.
	$ultima_linea = system('git tag', $retval);
	//echo $retval;

	// Imprimir informacion adicional
	echo '</pre><div class="contt_li"><hr />' . $ultima_linea.'</div>';
	//echo "Versión de repositorio de código: ".$ultima_linea 
?>