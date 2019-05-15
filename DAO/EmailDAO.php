<?php
	/**/
	include_once 'GenericoDAO.php';
		
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

		public function getUsuariosLiderEmail($pkID_usuario){

			$this->q_general = "select * FROM `usuarios` where fkID_tipo = 3";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getProcesoEmail($pkID_proceso){

			$this->q_general = "select procesos.*, pasos_proceso.nombre as nom_paso, entidades.nombre_entidad as nom_entidad, estado_proceso.nombre as nom_estado, tipo_proceso.nombre as nom_tipo

								FROM procesos 

								INNER JOIN pasos_proceso ON pasos_proceso.pkID = procesos.fkID_paso_actual

								INNER JOIN entidades on entidades.pkID = procesos.fkID_entidad

								INNER JOIN estado_proceso on estado_proceso.pkID = procesos.fkID_estado

								INNER JOIN tipo_proceso on tipo_proceso.pkID = procesos.fkID_tipo

								where procesos.pkID = ".$pkID_proceso;	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
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
?>
