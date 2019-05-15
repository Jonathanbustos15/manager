<?php 

	include('../DAO/indexDAO.php');

	/**
	* 
	*/
	class indexController extends indexDAO{

		function bienvenida(){

			$datosGenerales = $this->getDatos();

			echo '<h2 class="brand-before">
                        <small>Bienvenido a</small>
                    </h2>
                    <h1 class="brand-name">'.$datosGenerales[0]["titulo"].'</h1>
                    <hr class="tagline-divider">
                    <h2>
                        <small>'.$datosGenerales[0]["slogan"].'</small>
                    </h2>';
		}

		function box_saludo1(){

			$datosGenerales = $this->getDatos();

			echo '<div class="col-lg-12">
                    <hr>
                    <h2 class="intro-text text-center"><strong>'.$datosGenerales[0]["titulo"].'</strong> te da la bienvenida a su sitio web.</h2>
                    <hr>
                    <img class="img-responsive img-border img-left" src="../img/barrow-420728_1280.jpg" width="300">
                    <hr class="visible-xs">
                    <p>La súper 7 es un depósito de materiales y ferretería ubicado en el barrio Cobec de Soacha, en nuestro local encontrarás todos los materiales que necesitas para realizar todos tus proyectos personales o profesionales. Nuestro negocio se enorgullece de presentarles nuestro sitio web que esta al servicio de nuestra distinguida clientela, facilitando el acceso a toda nuestra información a solo un par de clicks.</p>
                    <p>Esta página pretende dar a nuestros clientes la facilidad de hacer sus cotizaciones en línea, para que a la hora de acercarse a hacer su compra sea más rápido y efectivo su proceso de construcción o ejecución de su proyecto. Infórmese acerca de nuestros materiales en la sección de catálogo, para que tenga presente a la hora de hacer la cotización todas las características de los productos, tales como el precio entre otros.</p>
                    <p>Recuerde que en nuestra sección de contacto podrá recibir respuesta a todas sus inquietudes y sugerencias o si tiene algún tipo de petición especial.</p>
                </div>';
		}

		function titulo_encabezado(){

			$datosGenerales = $this->getDatos();

			echo '<div class="brand"> <img src="../img/logo_s7.svg" class="img-responsive logo_svg" />'.$datosGenerales[0]["titulo"].'</div>
    			  <div class="address-bar"> '.$datosGenerales[0]["slogan"].' | '.$datosGenerales[0]["direccion"].' '.$datosGenerales[0]["ubicacion"].' | '.$datosGenerales[0]["telefono"].' </div>';

		}
		
	}

 ?>