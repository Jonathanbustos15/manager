<?php

	/**/

	ini_set('error_reporting', E_ALL|E_STRICT);
	ini_set('display_errors', 1); 

	//------------------------------------------
	//------------------------------------------

	class Conexion{
    		     
	    private $dbconection;	    
	    private $userconection;	    
	    private $passconection;	    
	    private $stringconection;	    
	    private $hostconection;
	    	    	   
	    public function __construct() {

	        $dbconection="lunelAdmin";
		    $userconection="root";
		    $passconection="s0p0rt3";
		    $hostconection="localhost";
	    
	        $this->dbconection=$dbconection;
	        $this->userconection=$userconection;
	        $this->passconection=$passconection;
	        $this->hostconection=$hostconection;
	        
	    }
			   
	    public function connect(){
	              
			$this->stringconection= new mysqli($this->hostconection, $this->userconection,  $this->passconection,$this->dbconection);
			
	        $conn = $this->stringconection;

	        $conn->set_charset("utf8");

			return $conn;
	              
	    }
	    	    
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


	class GenericoDAO {
       	   
	   protected $Conector;
	   private $r;
	   
	     
	   public function __construct() {
	        $this->Conector = new Conexion();
	        $this->r = array();
	    }
	     
	    
	    public static function EjecutarConsulta($query){
	      				
			$Conector = new Conexion();
			$db=$Conector->connect();
	        
	        if(!$result = $db->query($query)){
				die('There was an error running the query [' . $db->error . ']');
			}
			//-----------------------------------------
			if ($result->num_rows >0){
				while ($fila = $result->fetch_assoc()){
					$retorno[] = $fila;
				}
				return $retorno;
			} else {
				return $result->num_rows;
			}
			
			$result->free();
			//------------------------------------------
		}


		//------------------------------------------------------------------------	
		public function EjecutaActualizar($query){

			 // $db=$Conector->connect();
			$Conector = new Conexion();
			$db=$Conector->connect();

		       if(!$result = $db->query($query)){
					die('There was an error running the query [' . $db->error . ']');
				}

				else{
					$this->r["estado"] = "ok";
					$this->r["mensaje"] = "Actualizado correctamente.";

					return $this->r;
				}
		}
	//------------------------------------------------------------------------
		
	}



	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	class EmailDAO extends GenericoDAO {
		
		public $generico;
		public $q_general;
		
		function __construct(){
			$this->generico = new GenericoDAO();
		}
		
		//Funciones------------------------------------------
		//Espacio para las funciones en general de esta clase.

		public function getUsuarioEmail($pkID_usuario){

			$this->q_general = "select * FROM `usuarios` where pkID = ".$pkID_usuario;	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getCompromisos(){

			$this->q_general = "select compromisos.*, estado_compromiso.nombre as nom_estado

								FROM compromisos

								INNER JOIN estado_compromiso ON compromisos.fkID_estado = estado_compromiso.pkID";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function actualizarEstado($id_compromiso){
	
			$this->q_general = "update compromisos SET fkID_estado = 3 WHERE pkID = ".$id_compromiso;

			return $this->generico->EjecutaActualizar($this->q_general);

		}


		public function getCompromisosEmail($fkID_Usuario, $fkID_reunion){			

			$this->q_general = "select compromisos.*, reuniones.fecha_realizacion as fecha_reunion

								FROM `compromisos`

								INNER JOIN reuniones ON reuniones.pkID = compromisos.fkID_reunion 

								WHERE fkID_reunion = ".$fkID_reunion." AND fkID_usuario = ".$fkID_Usuario;

			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
		
        public function getCompromisoEmail($pkID_compromiso){			

			$this->q_general = "select compromisos.*, reuniones.fecha_realizacion as fecha_reunion, concat(usuarios.nombre,' ',usuarios.apellido) as responsable

								FROM `compromisos`

								INNER JOIN reuniones ON reuniones.pkID = compromisos.fkID_reunion
                                
                                INNER JOIN usuarios ON compromisos.fkID_usuario = usuarios.pkID

								WHERE compromisos.pkID = ".$pkID_compromiso;

			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
	}

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

		public function setCuerpo($tipo,$pkID_compromiso,$num_dias){			

			switch ($tipo) {				

				case 'vencido':

					$this->compromisos = $this->EmailDAO->getCompromisoEmail($pkID_compromiso);

					$this->cuerpo = ' 
								<html> 
								<head> 
								   <title>Compromiso de la Reunion del '.$this->compromisos[0]["fecha_reunion"].'</title> 
								</head> 
								<body> 
								<h2>Cordial saludo,</h2> 
								<p> 
								<b>La aplicación Lunel IE Manager</b>, le informa que se ha pasado la fecha de cumplimiento por ('.$num_dias.') día(s) en el compromiso de la reunión del día '.$this->compromisos[0]["fecha_reunion"].'.
																		
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

				case 3:

					$this->asunto = 'Vencimiento de Fecha Compromiso';

				break;			

			};
		}

		//---------------------------------------------------------------------------------------
		//Funcion para enviar correo de aprobacion de proyecto
		public function sendEmail($pkID_usuario,$tipo_asunto,$tipo_cuerpo,$pkID_compromiso,$num_dias){

			
			# code...
			$this->usuario = $this->EmailDAO->getUsuarioEmail($pkID_usuario);

			$this->destinatario = $this->usuario[0]["email"];
					
			$this->setHeaders();

			$this->setCuerpo($tipo_cuerpo,$pkID_compromiso,$num_dias);

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

	//-------------------------------------------------------------------------------------------
	//obtener todos los compromisos para evaluar cada una de las fechas de cumplimiento
	//validar cada una de las fechas, si esta pasada la fecha enviar el correo de vencido
	//al responsable del compromiso.
	//
	$email_dao = new EmailDAO();
	$email_controller = new EmailCompromisoController();

	$compromisos = $email_dao->getCompromisos();
	//print_r($compromisos);


	//------------------------------------
	//fecha actual
	$fecha_actual = date_create(date("Y-m-d"));

	//print_r($fecha_actual);

	//------------------------------------
	/**/
	foreach ($compromisos as $llave => $valor) {
		//------------------------------------
		echo $llave." - ";
		//print_r($valor["fecha_cumplimiento"]);
		echo $valor["fecha_cumplimiento"]."<br>";
		echo $valor["fkID_estado"]."<br>";
		echo $valor["nom_estado"]."<br>";
		//echo $valor["fkID_usuario"]."<br>";

		$fecha_cumplimiento = date_create($valor["fecha_cumplimiento"]);
		//------------------------------------

		//intervalo de días
		$interval = date_diff($fecha_actual, $fecha_cumplimiento);
		//formatea el resultado
		$intervalo_final = $interval->format('%R%a');
		//pasa el formateo a un valor cuantificable
		$interval_num = intval($intervalo_final);

		echo $interval_num."<br>";
		
		if ( ($interval_num > 0) ) {
			echo "Esta fecha se vence en ".$interval_num." día(s)!"."<br>";
			
		}else{

			if ( ($valor["fkID_estado"] == 1) ) {

				echo "Esta fecha está vencida por ".$interval_num." día(s) y está pendiente!"."<br>";
				//envia correo al responsabe del compromiso que tiene pendiente este compromiso
				//y que tiene tantos días de pasada la fecha de cumplimiento
				//$email_controller
				$email_dao->actualizarEstado($valor["pkID"]);
				$send_correo = $email_controller->sendEmail($valor["fkID_usuario"],3,'vencido',$valor["pkID"],$interval_num);
				
				print_r($send_correo);

			}else{
				echo "Esta fecha está vencida por ".$interval_num." día(s), pero ya esta cumplida o vencida."."<br>";
			}
			
		}
		
	}
	//-------------------------------------------------------------------------------------------

 ?>
