<?php
	/**/
	include_once 'GenericoDAO.php';
	include_once 'PermisosDAO.php';
		
	class contrasenasDAO extends GenericoDAO {
		
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

		public function getContrasenas(){			

			$this->q_general = "select * FROM `contrasenas` order by pkID desc";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
		
	}
?>
