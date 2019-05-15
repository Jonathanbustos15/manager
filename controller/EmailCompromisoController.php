<?php 

	


	include_once '../DAO/EmailDAO.php';
	
	class EmailCompromisoController {

		public $EmailDAO;
		public $usuario;

		//variables de correo
		public $destinatario; //un array para que pueda recibir mas de una persona
		public $asunto;
		//
		public $cuerpo;
		//------------------------------------------------------------------------
		public $compromisos;

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


		public function setHeaders(){
			//para el envío en formato HTML 
			$this->headers = "MIME-Version: 1.0\r\n"; 
			$this->headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

			//dirección del remitente luneliemanagermailpruebas@gmail.com pass:lunelmanageradmin
			$this->headers .= "From: Lunel IE Manager <luneliemanagermailpruebas@gmail.com>\r\n"; 
		}

		public function setCuerpo($tipo,$fkID_Usuario,$fkID_reunion,$pkID_compromiso){			

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

				case 'asignado':

					$this->compromisos = $this->EmailDAO->getCompromisosEmail($fkID_Usuario, $fkID_reunion);

					$this->cuerpo = ' 
								<html> 
								<head> 
								   <title>Compromisos de la Reunion del '.$this->compromisos[0]["fecha_reunion"].'</title> 
								</head> 
								<body> 
								<h2>Cordial saludo,</h2> 
								<p> 
								<b>La aplicacion Lunel IE Manager</b>, le informa que en la reunion del dia '.$this->compromisos[0]["fecha_reunion"].' se le han asignado los siguientes compromisos.
																		
									'.$this->renderCompromisos($this->compromisos).'
								<h4>Gracias.</h4> 
								</p> 
								</body> 
								</html>
								';

				break;

				case 'cumplido':

					$this->compromisos = $this->EmailDAO->getCompromisoEmail($pkID_compromiso);

					$this->cuerpo = ' 
								<html> 
								<head> 
								   <title>Compromiso de la Reunion del '.$this->compromisos[0]["fecha_reunion"].'</title> 
								</head> 
								<body> 
								<h2>Cordial saludo,</h2> 
								<p> 
								<b>La aplicacion Lunel IE Manager</b>, le informa que se ha cumplido el siguiente compromiso de la reunion del dia '.$this->compromisos[0]["fecha_reunion"].'.
																		
									'.$this->renderCompromisos($this->compromisos).'
								<h4>Gracias.</h4> 
								</p> 
								</body> 
								</html>
								';

				break;

			};
		}

		public function renderCompromisos($compromisos){
			
			$res = '<br><br>';

			foreach ($compromisos as $key => $value) {
				$res .= '<b>Descripcion:</b>'.$value["descripcion"].'<br>';
				$res .= '<b>Fecha de Cumplimiento:</b>'.$value["fecha_cumplimiento"].'<br><br>';

				if (array_key_exists('responsable', $value)) {
					$res .= '<b>Responsable:</b>'.$value["responsable"].'<br><br>';
				}
			}

			return $res;
		}

		public function setAsunto($tipo){

			switch ($tipo) {

				case 1:

					$this->asunto = 'Asignación de Compromisos';

				break;

				case 2:

					$this->asunto = 'Cumplimiento de Compromiso';

				break;			

			};
		}

		//---------------------------------------------------------------------------------------
		//Funcion para enviar correo de aprobacion de proyecto
		public function sendEmail($pkID_usuario,$tipo_asunto,$tipo_cuerpo,$fkID_reunion,$pkID_compromiso){

			if (($tipo_asunto==1) || ($tipo_asunto==2)) {
				# code...
				$this->usuario = $this->EmailDAO->getUsuarioEmail($pkID_usuario);

				$this->destinatario = $this->usuario[0]["email"];

			}		

			$this->setHeaders();

			$this->setCuerpo($tipo_cuerpo, $pkID_usuario, $fkID_reunion, $pkID_compromiso);

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