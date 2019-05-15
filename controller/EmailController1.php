<?php
	/**/
	include_once '../DAO/EmailDAO.php';
		
	class EmailController {
		
		public $EmailDAO;

		//variable de consulta de usuario
		public $usuario;
		public $usuariosLider;
		public $proceso;

		//variables de correo
		public $destinatario; //un array para que pueda recibir mas de una persona
		public $asunto;
		//
		public $cuerpo;
		//------------------------------------------------------------------------
		//variables correo html

		//------------------------------------------------------------------------
		public $headers;
		public $destinatarios; //para varios destinatarios

		//array de resultado
		public $r;
		
		function __construct(){
			$this->EmailDAO = new EmailDAO();
			$this->destinatario = array();
			$this->destinatarios = array();
			$this->r = array();
		}
		
		//Funciones-------------------------------------------
		//Espacio para las funciones en general de esta clase.		

		public function setHeaders(){
			//para el envío en formato HTML 
			$this->headers = "MIME-Version: 1.0\r\n"; 
			$this->headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

			//dirección del remitente luneliemanagermailpruebas@gmail.com pass:lunelmanageradmin
			$this->headers .= "From: Lunel IE Manager pruebas <luneliemanagermailpruebas@gmail.com>\r\n"; 
		}

		public function setCuerpo($tipo,$pkID_proceso){

			//consulta proceso

			$this->proceso = $this->EmailDAO->getProcesoEmail($pkID_proceso);

			switch ($tipo) {

				case 'prueba':

				$this->cuerpo = ' 
								<html> 
								<head> 
								   <title>Lunel IE Manager</title> 
								</head> 
									<body> 
										<h1>Un cordial saludo,</h1> 
										<p> 
										<b>Bienvenidos al correo electrónico de prueba de Lunel IE Manager</b>, este mensaje va a estar llegando a su correo mientras se hacen pruebas de desarrollo. <br> <h4>Gracias.</h4> 
										</p> 
									</body> 
								</html> 
								';

				break;

				//-----------------------------------------------------------------------------------------------------------------

				case 'aprobado':

				//variables
				//nom_proceso, fecha cierre

				$this->cuerpo = ' 
								<html> 
								<head> 
								   <title>Proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].' Aprobado</title> 
								</head> 
								<body> 
								<h2>Cordial saludo,</h2> 
								<p> 
								<b>La aplicación Lunel IE Manager</b>, le informa que el proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].' con fecha de cierre '.$this->proceso[0]["fecha_cierre"].'

								<br> ha sido <b>APROBADO</b>. 
								
								<h3>Detalles del proceso</h3> 
								
								<b>Número de proceso:</b>'.$this->proceso[0]["pkID"].'
								<br>
								<b>Fecha de Cierre:</b>'.$this->proceso[0]["fecha_cierre"].'
								<br>
								<b>Objeto:</b>'.$this->proceso[0]["objeto"].'
								<br>
								<b>Cuantía:</b>'.'$'.number_format($this->proceso[0]["cuantia"], 0, '', '.').'

								<h4>Gracias.</h4> 
								</p> 
								</body> 
								</html> 
								';

				break;

				//-----------------------------------------------------------------------------------------------------------------

				case 'solicitud_aprobacion':

				$this->cuerpo = ' 
								<html> 
								<head> 
								   <title>Solicitud de Aprobación Proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].'</title> 
								</head> 
								<body> 
								<h2>Cordial saludo,</h2> 
								<p> 
								<b>La aplicación Lunel IE Manager</b>, le informa que el proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].' con fecha de cierre '.$this->proceso[0]["fecha_cierre"].'

								<br> fue creado por '.$this->usuario[0]["nombre"].' '.$this->usuario[0]["apellido"].' y solicita la <b>APROBACIóN</b> por parte de los usuarios líder. 
								
								<h3>Detalles del proceso</h3> 
								
								<b>Número de proceso:</b>'.$this->proceso[0]["pkID"].'
								<br>
								<b>Fecha de Cierre:</b>'.$this->proceso[0]["fecha_cierre"].'
								<br>
								<b>Objeto:</b>'.$this->proceso[0]["objeto"].'
								<br>
								<b>Cuantía:</b>'.'$'.number_format($this->proceso[0]["cuantia"], 0, '', '.').'

								<h4>Gracias.</h4> 
								</p> 
								</body> 
								</html> 
								';

				break;

				//-----------------------------------------------------------------------------------------------------------------

				case 'asignado':

				$this->cuerpo = ' 
								<html> 
								<head> 
								   <title>Asignación a Proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].'</title> 
								</head> 
								<body> 
								<h2>Cordial saludo,</h2> 
								<p> 
								<b>La aplicación Lunel IE Manager</b>, le informa que el usuario '.$this->usuario[0]["nombre"].' '.$this->usuario[0]["apellido"].' ha sido <b>ASIGNADO</b> al proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].' con fecha de cierre '.$this->proceso[0]["fecha_cierre"].'

								<br> para mayor información consulte a los usuarios líder. 
								
								<h3>Detalles del proceso</h3> 
								
								<b>Número de proceso:</b>'.$this->proceso[0]["pkID"].'
								<br>
								<b>Fecha de Cierre:</b>'.$this->proceso[0]["fecha_cierre"].'
								<br>
								<b>Objeto:</b>'.$this->proceso[0]["objeto"].'
								<br>
								<b>Cuantía:</b>'.'$'.number_format($this->proceso[0]["cuantia"], 0, '', '.').'

								<h4>Gracias.</h4> 
								</p> 
								</body> 
								</html> 
								';

				break;

				//-----------------------------------------------------------------------------------------------------------------

				case 'reasignado':

				$this->cuerpo = ' 
								<html> 
								<head> 
								   <title>Retiro de Proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].'</title> 
								</head> 
								<body> 
								<h2>Cordial saludo,</h2> 
								<p> 
								<b>La aplicación Lunel IE Manager</b>, le informa que el usuario '.$this->usuario[0]["nombre"].' '.$this->usuario[0]["apellido"].' ha sido <b>RETIRADO</b> del proceso '.$this->proceso[0]["nom_entidad"].'/'.$this->proceso[0]["fecha_creacion"].' con fecha de cierre '.$this->proceso[0]["fecha_cierre"].'

								<br> lo cual significa que ya no es el responsable de dicho proceso; para mayor información consulte a los usuarios líder. 
								
								<h3>Detalles del proceso</h3> 
								
								<b>Número de proceso:</b>'.$this->proceso[0]["pkID"].'
								<br>
								<b>Fecha de Cierre:</b>'.$this->proceso[0]["fecha_cierre"].'
								<br>
								<b>Objeto:</b>'.$this->proceso[0]["objeto"].'
								<br>
								<b>Cuantía:</b>'.'$'.number_format($this->proceso[0]["cuantia"], 0, '', '.').'

								<h4>Gracias.</h4> 
								</p> 
								</body> 
								</html> 
								';

				break; 

			};
		}

		public function setAsunto($tipo){

			switch ($tipo) {

				case 1:

				$this->asunto = 'Aprobación de Proceso';

				break;

				case 2:

				$this->asunto = 'Solicitud de Aprobación de Proceso';

				break;

				case 3:

				$this->asunto = 'Asignación a Proceso';

				break;

				case 4:

				$this->asunto = 'Retiro de Proceso';

				break;   

			};
		}

		//---------------------------------------------------------------------------------------
		//Funcion para enviar correo de aprobacion de proyecto
		public function sendEmail($pkID_usuario,$tipo_asunto,$tipo_cuerpo,$pkID_proceso){

			if ($tipo_asunto==1) {
				# code...
				$this->usuario = $this->EmailDAO->getUsuarioEmail($pkID_usuario);

				$this->destinatario = $this->usuario[0]["email"];

			} else if ($tipo_asunto==2){
				# code...

				$this->usuario = $this->EmailDAO->getUsuarioEmail($pkID_usuario);

				array_push($this->destinatarios, $this->usuario[0]["email"]);

				//y agregarle los usuarios que son de tipo lider
				//y dejarlos en un string separados por ,

				$this->usuariosLider = $this->EmailDAO->getUsuariosLiderEmail();

				for ($i=0; $i<sizeof($this->usuariosLider); $i++) { 
					# code...
					array_push($this->destinatarios, $this->usuariosLider[$i]["email"]);
				}

				$this->destinatario =  implode(",", $this->destinatarios);

			} else if ($tipo_asunto==3){

				$this->usuario = $this->EmailDAO->getUsuarioEmail($pkID_usuario);

				$this->destinatario = $this->usuario[0]["email"];

			}else if ($tipo_asunto==4){

				$this->usuario = $this->EmailDAO->getUsuarioEmail($pkID_usuario);

				$this->destinatario = $this->usuario[0]["email"];
			}			

			$this->setHeaders();

			$this->setCuerpo($tipo_cuerpo,$pkID_proceso);

			$this->setAsunto($tipo_asunto);

			//-----------------------------------------------------------------------------------

			if (mail($this->destinatario,$this->asunto,$this->cuerpo,$this->headers)) {
				# code...
				$this->r["estado"] = "ok";
	 			$this->r["mensaje"] = "El correo se envio correctamente a ".$this->destinatario;

			}else{
				$this->r["estado"] = "error";
	 			$this->r["mensaje"] = "El correo no se pudo enviar a ".$this->destinatario;
			};

			//-----------------------------------------------------------------------------------

			return $this->r;
		}

		
	}
?>
