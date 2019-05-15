<?php
	/**/
	include_once 'GenericoDAO.php';
	include_once 'PermisosDAO.php';
		
	class actividadesDAO extends GenericoDAO {
		
		public $permisos;
		public $q_general;
		
		function __construct(){
			parent::__construct();
		}
		
		//Funciones------------------------------------------
		//Espacio para las funciones en general de esta clase.
   		public function permisos($fkID_modulo,$fkID_tipo_usuario){
		
			$this->permisos = new PermisosDAO();
			$arrayPermisos = $this->permisos->getPermisosModulo_Tipo($fkID_modulo,$fkID_tipo_usuario);
			return $arrayPermisos;
		}

		public function getActividades(){			

			$this->q_general = "select actividad.*, proyectos.nombre as nom_proyecto

								FROM `actividad`

								INNER JOIN proyectos ON proyectos.pkID = actividad.fkID_proyecto";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getActividadesProyecto($pkID_proyecto){			

			$this->q_general = "select actividad.*, proyectos.nombre as nom_proyecto

								FROM `actividad`

								INNER JOIN proyectos ON proyectos.pkID = actividad.fkID_proyecto

								WHERE actividad.fkID_proyecto = ".$pkID_proyecto;	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
		
	}
?>
