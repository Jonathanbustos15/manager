<?php
	/**/
	include_once 'GenericoDAO.php';
	include_once 'PermisosDAO.php';
		
	class repositorioDAO extends GenericoDAO {
		
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

		public function getRepositorio(){

			$this->q_general = "select repositorio.*, tipo_repositorio_general.nombre as nom_tipo, empresa.nombre as empresa 

								FROM `repositorio`

								INNER JOIN tipo_repositorio_general ON tipo_repositorio_general.pkID = repositorio.fkID_tipo_repositorio_general

								INNER JOIN empresa ON empresa.pkID = repositorio.fkID_empresa";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getRepositorioId($pkID_repositorio){

			$this->q_general = "select * FROM `repositorio` WHERE pkID = ".$pkID_repositorio;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getArchivosRepositorio($pkID_repositorio){

			$this->q_general = "select archivos_repositorio.*, tipo_repositorio.nombre as nom_tipo 

								FROM `archivos_repositorio`

								INNER JOIN tipo_repositorio ON archivos_repositorio.fkID_tipo = tipo_repositorio.pkID

								WHERE archivos_repositorio.fkID_repositorio = ".$pkID_repositorio."

								ORDER BY archivos_repositorio.pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getTipoRepositorio(){

			$this->q_general = "select * FROM `tipo_repositorio`";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getTipoRepositorioGeneral(){

			$this->q_general = "select * FROM `tipo_repositorio_general`";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getEmpresa(){

			$this->q_general = "select * FROM `empresa`";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getRepositorioFuntecso(){

			$this->q_general = "select repositorio.*, tipo_repositorio_general.nombre as nom_tipo, empresa.nombre as empresa 

								FROM `repositorio`

								INNER JOIN tipo_repositorio_general ON tipo_repositorio_general.pkID = repositorio.fkID_tipo_repositorio_general

								INNER JOIN empresa ON empresa.pkID = repositorio.fkID_empresa

								WHERE repositorio.fkID_empresa = 2";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
		
	}
?>
