<?php
/**/
	include_once 'GenericoDAO.php';
		
	class reunionesDAO extends GenericoDAO {
		
		//use GenericoDAO;
		
		public $q_general;
		
		
		//Funciones------------------------------------------
		//Espacio para las funciones en general de esta clase.

		public function getModerador(){

			$this->q_general = 	"select * FROM usuarios WHERE usuarios.fkID_tipo = 1 OR usuarios.fkID_tipo =3 OR usuarios.fkID_tipo =8 ";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getParticipantes(){

			$this->q_general = 	"select * FROM usuarios ";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getParticipanteId($pkID){

			$this->q_general = 	"select DISTINCT CONCAT(usuarios.nombre,' ',usuarios.apellido) AS participante 

								FROM usuarios 

								INNER JOIN participantes ON participantes.fkID_usuario = usuarios.pkID

								WHERE participantes.fkID_usuario = ".$pkID;				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getTemasIdReunion($reunion){

			$this->q_general = "select temas.* 

								FROM temas 

								INNER JOIN reuniones ON reuniones.pkID = temas.fkID_reunion

								WHERE temas.fkID_reunion = ".$reunion;

			return GenericoDAO::EjecutarConsulta($this->q_general);					
		}	


		public function getParticipantesIdReunion($reunion){

			$this->q_general = 	"select DISTINCT participantes.fkID_usuario,CONCAT(usuarios.nombre,' ',usuarios.apellido) AS participante, usuarios.email as email

								FROM participantes 

								INNER JOIN usuarios ON usuarios.pkID = participantes.fkID_usuario

								WHERE participantes.fkID_reunion = ".$reunion;				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
	

		
		public function getParticipantesF(){

			$this->q_general = 	"select DISTINCT participantes.fkID_usuario,CONCAT(usuarios.nombre,' ',usuarios.apellido) AS participante 

								FROM participantes 

								INNER JOIN usuarios ON usuarios.pkID = participantes.fkID_usuario";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getTemasF(){

			$this->q_general = "select temas.* 

								FROM temas 

								INNER JOIN reuniones ON reuniones.pkID = temas.fkID_reunion";

			return GenericoDAO::EjecutarConsulta($this->q_general);					
		}						


		public function getInvitados(){

			$this->q_general = 	"select * FROM invitados";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getReuniones(){

			$this->q_general = 	"select reuniones.*, CONCAT(usuarios.nombre,' ',usuarios.apellido) as moderador

									FROM reuniones

									INNER JOIN usuarios ON usuarios.pkID = reuniones.fkID_moderador";	
			//print_r($this->q_general);									
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getCompromisos(){

			$this->q_general = "select compromisos.*, CONCAT(usuarios.nombre,' ',usuarios.apellido)  as participante, estado_compromiso.nombre as estado 

								FROM `compromisos`

								INNER JOIN usuarios ON usuarios.pkID = compromisos.fkID_usuario

								INNER JOIN estado_compromiso ON estado_compromiso.pkID = compromisos.fkID_estado

								WHERE fkID_estado IN(1,2)";

			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getReunionesUsuario($usuario){

			$this->q_general = 	"select reuniones.*,CONCAT(usuarios.nombre,' ',usuarios.apellido)  as moderador
								 
								 FROM reuniones

								 INNER JOIN usuarios ON usuarios.pkID = reuniones.fkID_moderador

								 INNER JOIN participantes ON participantes.fkID_reunion = reuniones.pkID

								 WHERE  participantes.fkID_usuario = ".$usuario."

								 UNION

								 select reuniones.*,CONCAT(usuarios.nombre,' ',usuarios.apellido)  as moderador

								 FROM reuniones

								 INNER JOIN usuarios ON usuarios.pkID = reuniones.fkID_moderador

								 WHERE reuniones.fkID_moderador = ".$usuario;

								 //print_r($this->q_general);				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getReunionesUsuarioParticipante($usuario){

			$this->q_general = 	"select reuniones.*,CONCAT(usuarios.nombre,' ',usuarios.apellido)  as moderador
								 
								 FROM reuniones

								 INNER JOIN usuarios ON usuarios.pkID = reuniones.fkID_moderador

								 INNER JOIN participantes ON participantes.fkID_reunion = reuniones.pkID

								 WHERE  participantes.fkID_usuario = ".$usuario;

								 //print_r($this->q_general);				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getReunionesFiltro($filtro){

			$this->q_general = 	"select DISTINCT reuniones.*,CONCAT(usuarios.nombre,' ',usuarios.apellido) as moderador
								FROM `participantes` 

								INNER JOIN reuniones ON reuniones.pkID= participantes.fkID_reunion 

								INNER JOIN usuarios ON usuarios.pkID = reuniones.fkID_moderador 

								LEFT JOIN temas ON temas.fkID_reunion = reuniones.pkID 

								WHERE ".$filtro." 

								order by reuniones.pkID desc";				
			
			//echo $this->q_general;

			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getReunionesFiltroP($filtro){

			$this->q_general = 	"select reuniones.*,CONCAT(usuarios.nombre,' ',usuarios.apellido) as moderador
								FROM `reuniones` 

								INNER JOIN usuarios ON usuarios.pkID = reuniones.fkID_moderador 

								LEFT JOIN temas ON temas.fkID_reunion = reuniones.pkID 

								WHERE ".$filtro." 

								order by reuniones.pkID desc";				
			
			echo $this->q_general;

			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
		

		public function getReunion($pkID){

			$this->q_general = 	"select reuniones.*, CONCAT(usuarios.nombre,' ',usuarios.apellido) as moderador

									FROM `reuniones`

									INNER JOIN usuarios ON usuarios.pkID = reuniones.fkID_moderador 

									WHERE reuniones.pkID = ".$pkID;				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getCompromisosReuniones($fkID_reunion){

			$this->q_general = 	"select compromisos.*, CONCAT(usuarios.nombre,' ',usuarios.apellido) as participante, estado_compromiso.nombre as estado

									FROM `compromisos`

									INNER JOIN usuarios ON usuarios.pkID = compromisos.fkID_usuario

									INNER JOIN reuniones ON reuniones.pkID = compromisos.fkID_reunion

									INNER JOIN estado_compromiso ON estado_compromiso.pkID = compromisos.fkID_estado
                                    
                                    WHERE reuniones.pkID = ".$fkID_reunion;				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getCompromisosReunionesParticipante($fkID_reunion, $usuario){

			$this->q_general = 	"select compromisos.*, CONCAT(usuarios.nombre,' ',usuarios.apellido) as participante, estado_compromiso.nombre as estado

								FROM `compromisos`

								INNER JOIN usuarios ON usuarios.pkID = compromisos.fkID_usuario

								INNER JOIN reuniones ON reuniones.pkID = compromisos.fkID_reunion

								INNER JOIN estado_compromiso ON estado_compromiso.pkID = compromisos.fkID_estado
                                    
                                WHERE reuniones.pkID = ".$fkID_reunion." AND compromisos.fkID_usuario = ".$usuario;				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getCompromisosReunionesUsuario($moderador, $fkID_reunion, $usuario){

			$this->q_general = 	"select compromisos.*, CONCAT(usuarios.nombre,' ',usuarios.apellido) as participante, estado_compromiso.nombre as estado

								FROM `compromisos`

								INNER JOIN usuarios ON usuarios.pkID = compromisos.fkID_usuario

								INNER JOIN reuniones ON reuniones.pkID = compromisos.fkID_reunion

								INNER JOIN estado_compromiso ON estado_compromiso.pkID = compromisos.fkID_estado
                                    
                                WHERE reuniones.pkID = ".$fkID_reunion." AND reuniones.fkID_moderador = ".$moderador." 
                                AND compromisos.fkID_usuario = ".$usuario;	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getEstadosCompromiso(){

			$this->q_general = "select pkID, nombre FROM `estado_compromiso`";

			return GenericoDAO::EjecutarConsulta($this->q_general);

		}	

	}
?>


