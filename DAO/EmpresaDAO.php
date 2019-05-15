<?php
	include_once 'GenericoDAO.php';
	include_once 'PermisosDAO.php';

	class empresa extends GenericoDAO{

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
		
		//funciones generales
		public function getEmpresas(){

			$this->q_general = "select empresa.*  FROM empresa WHERE empresa.pkID != 10 ORDER BY pkID DESC";
			/*$this->q_general = "select YEAR(proyectos.fechaFin) as anio, empresa.nombre as entidad, empresa.pkID as idEmpresa, 						empresa.* , proyectos.* FROM empresa, proyectos WHERE empresa.pkID != 10 and empresa.pkID = 						proyectos.fkID_empresa ORDER BY anio DESC, empresa.nombre , proyectos.objeto";	*/	
			//print_r($this->q_general);
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
		
		

		public function getNumEmpresas(){

			$this->q_general = "select count(*) as numEmpresas from empresa";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getEntidadEmpresaSelect(){			

			$this->q_general = "select * FROM `entidades` ";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		//---------------------------------------------------------------------------------------------------------
		//Funciones específicas

		public function getEmpresaId($pkID){

			$this->q_general = "select empresa.*
								FROM `empresa` 
								WHERE empresa.pkID = ".$pkID;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getCertificadosEmpresa($pkID){

			$this->q_general = 	"select certificacion_experiencia.*,year(certificacion_experiencia.fechaFin) as anio, empresa.nombre as nom_empresa , entidades.nombre_entidad
			
								 FROM `certificacion_experiencia`

                                 INNER JOIN empresa ON empresa.pkID = certificacion_experiencia.fkID_empresa

                                 INNER JOIN entidades ON entidades.pkID = certificacion_experiencia.fkID_entidad
                                 
                                 where fkID_empresa = ".$pkID." order by certificacion_experiencia.pkID desc";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getInfoFinanciera($pkID_empresa){


			$this->q_general = 	"select * FROM info_financiera WHERE fkID_empresa = ".$pkID_empresa." order by pkID desc";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getDocLegalEmpresa($pkID){

			$this->q_general = 	"select documentos_legales.*, empresa.nombre as nom_empresa
								 FROM `documentos_legales`
                                 INNER JOIN empresa ON empresa.pkID = documentos_legales.fkID_empresa
                                 
                                 where fkID_empresa = ".$pkID." order by documentos_legales.anio_expedicion desc";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getFechas(){
			
			$this->q_general = "select DISTINCT fechaFin FROM proyectos WHERE fechaFin IS NOT NULL AND fechaFin <> '0000-00-00' 					ORDER BY fechaFin desc ";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getEmpresasFiltro($filtro){

			$this->q_general = "select YEAR(proyectos.fechaFin) as anio, empresa.nombre as entidad, empresa.pkID as idEmpresa, 						empresa.* , proyectos.* FROM empresa, proyectos WHERE ".$filtro." and empresa.pkID != 10 and 						empresa.pkID = proyectos.fkID_empresa ORDER BY anio DESC, empresa.nombre , proyectos.objeto";		
			//print_r($this->q_general);
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getAnio(){
			
			$this->q_general = "select DISTINCT documentos_legales.anio_expedicion FROM documentos_legales WHERE documentos_legales.anio_expedicion IS NOT NULL AND documentos_legales.anio_expedicion <> '0000' ORDER BY documentos_legales.anio_expedicion desc";		
			//print_r($this->q_general);
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getEntidadId($pkID){

			$this->q_general = "select entidad.*
								FROM `entidad` 
								WHERE entidad.pkID = ".$pkID;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		/*public function getTablaDocLegalEmpresaFiltro($filtro){

			$this->q_general = 	"select documentos_legales.*, empresa.nombre as nom_empresa
								 FROM `documentos_legales`
                                 INNER JOIN empresa ON empresa.pkID = documentos_legales.fkID_empresa
                                 
                                 where ".$filtro." order by documentos_legales.pkID desc";				
			//print_r($this->q_general);
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}*/
		
	
	}

?>