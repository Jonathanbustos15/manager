<?php
	/**/
	include_once 'GenericoDAO.php';
	include_once 'PermisosDAO.php';
		
	class RolesDAO extends GenericoDAO {
		
		/*-----------------------------------------*/
		//variables
		public $q_general;
		public $permisos;		
		/*-----------------------------*/
		public function __construct(){
			//contruye la clase GenericoDAO
			parent::__construct();
		}
		/*-----------------------------------------*/

		/*-----------------------------------------*/

		public function permisos($fkID_modulo,$fkID_tipo_usuario){

			$this->permisos = new PermisosDAO();

			$arrayPermisos = $this->permisos->getPermisosModulo_Tipo($fkID_modulo,$fkID_tipo_usuario);

			return $arrayPermisos;

		}
		
		//Funciones------------------------------------------
		//Espacio para las funciones en general de esta clase.

		public function getRoles(){

			$this->q_general = "select permisos.*,tipo_usuario.nombre as nom_tUsuario, modulos.Nombre as nom_modulo 

								FROM `permisos`

								INNER JOIN tipo_usuario ON tipo_usuario.pkID = permisos.fkID_tipo_usuario

								INNER JOIN modulos ON modulos.pkID = permisos.fkID_modulo

								ORDER BY tipo_usuario.nombre";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getTipoUsuario(){

			$this->q_general = "select * FROM `tipo_usuario`";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getModulos(){

			$this->q_general = "select * FROM `modulos`";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
	}
?>
