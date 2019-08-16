<?php
	/**/
	include_once 'genericoDAO.php';
	include_once 'PermisosDAO.php';
		
	class ingresos_gralDAO extends GenericoDAO {
		
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

		public function getIngresos(){
			
			$this->q_general = "select ingreso_gral.*, empresa.nombre as nom_empresa, proyectos.nombre nom_proyecto

								FROM `ingreso_gral`

								INNER JOIN empresa ON empresa.pkID = ingreso_gral.fkID_empresa

								INNER JOIN proyectos ON proyectos.pkID = ingreso_gral.fkID_proyecto

								WHERE proyectos.fkID_estado <> 1 

								UNION

								SELECT ingreso_gral.*,empresa.nombre as nom_empresa, proyectos.nombre nom_proyecto

								FROM `ingreso_gral` 

								INNER JOIN empresa ON empresa.pkID = ingreso_gral.fkID_empresa

								LEFT JOIN proyectos ON proyectos.pkID = ingreso_gral.fkID_proyecto
 
								WHERE ingreso_gral.fkID_proyecto < 1 ORDER BY nom_empresa, anio desc ";


			/*$this->q_general = "select ingreso_gral.*, empresa.nombre as nom_empresa, proyectos.nombre nom_proyecto 

								FROM `ingreso_gral`

								INNER JOIN empresa ON empresa.pkID = ingreso_gral.fkID_empresa

								INNER JOIN proyectos ON proyectos.pkID = ingreso_gral.fkID_proyecto

								WHERE proyectos.fkID_estado <> 1 

								order by ingreso_gral.pkID desc";
			*/
			/*		
			*/
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getIngresosFiltro($filtro){
			
			$this->q_general = "select ingreso_gral.*,  empresa.nombre as nom_empresa, proyectos.nombre nom_proyecto 

								FROM `ingreso_gral`

								INNER JOIN empresa ON empresa.pkID = ingreso_gral.fkID_empresa

								LEFT OUTER JOIN proyectos ON proyectos.pkID = ingreso_gral.fkID_proyecto

								WHERE proyectos.fkID_estado != 1 AND ".$filtro." 


								UNION

								SELECT ingreso_gral.*,  empresa.nombre as nom_empresa, proyectos.nombre nom_proyecto

								FROM `ingreso_gral` 

								INNER JOIN empresa ON empresa.pkID = ingreso_gral.fkID_empresa

								LEFT JOIN proyectos ON proyectos.pkID = ingreso_gral.fkID_proyecto
 
								WHERE ingreso_gral.fkID_proyecto < 1 AND ".$filtro."";	

								//print_r($this->q_general);	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getEmpresas(){
			
			$this->q_general = "select * FROM `empresa` WHERE empresa.pkID != 10 ORDER by nombre";		
			//print_r($this->q_general);
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getEmpresasId($pkID){
			
			$this->q_general = "select * FROM `empresa` WHERE pkID=".$pkID;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getProyectosId($pkID){
			
			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado 

								FROM `proyectos`

								INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

								INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

								WHERE proyectos.pkID=".$pkID." ORDER BY entidades.nombre_entidad";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getExternos(){
			
			$this->q_general = "select * FROM `externo`";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getPeriodo(){
			
			$this->q_general = "select * FROM `periodo`";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSumaIngresos(){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(total_recibido) as total_ingresos FROM `ingreso_gral`";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSumaIngresosFiltro($filtro){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(total_recibido) as total_ingresos FROM `ingreso_gral` WHERE ".$filtro;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSumaIva(){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(iva) as total_iva FROM `ingreso_gral`";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSumaIvaFiltro($filtro){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(iva) as total_iva FROM `ingreso_gral` WHERE ".$filtro;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSumaTotal(){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(total) as total_total FROM `ingreso_gral`";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSumaTotalFiltro($filtro){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(total) as total_total FROM `ingreso_gral` WHERE ".$filtro;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		} 
		

		/*20180104: Agregado Funtectso*/
		public function getIngresosFuntecso(){
			
			$this->q_general = "select ingreso_gral.*, empresa.nombre as nom_empresa, proyectos.nombre nom_proyecto

								FROM `ingreso_gral`

								INNER JOIN empresa ON empresa.pkID = ingreso_gral.fkID_empresa

								INNER JOIN proyectos ON proyectos.pkID = ingreso_gral.fkID_proyecto

								WHERE proyectos.fkID_estado <> 1  AND ingreso_gral.fkID_empresa = 2 

								UNION

								SELECT ingreso_gral.*,empresa.nombre as nom_empresa, proyectos.nombre nom_proyecto

								FROM `ingreso_gral` 

								INNER JOIN empresa ON empresa.pkID = ingreso_gral.fkID_empresa

								LEFT JOIN proyectos ON proyectos.pkID = ingreso_gral.fkID_proyecto
 
								WHERE ingreso_gral.fkID_proyecto < 1 AND ingreso_gral.fkID_empresa = 2 ";

			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getIngresosProco(){
			
			$this->q_general = "select ingreso_gral.*, empresa.nombre as nom_empresa, proyectos.nombre nom_proyecto

								FROM `ingreso_gral`

								INNER JOIN empresa ON empresa.pkID = ingreso_gral.fkID_empresa

								INNER JOIN proyectos ON proyectos.pkID = ingreso_gral.fkID_proyecto

								WHERE proyectos.fkID_estado <> 1  AND ingreso_gral.fkID_empresa = 3 

								UNION

								SELECT ingreso_gral.*,empresa.nombre as nom_empresa, proyectos.nombre nom_proyecto

								FROM `ingreso_gral` 

								INNER JOIN empresa ON empresa.pkID = ingreso_gral.fkID_empresa

								LEFT JOIN proyectos ON proyectos.pkID = ingreso_gral.fkID_proyecto
 
								WHERE ingreso_gral.fkID_proyecto < 1 AND ingreso_gral.fkID_empresa = 3 ";

			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getIngresosFiltroFuntecso($filtro){
			
			$this->q_general = "select ingreso_gral.*, empresa.nombre as nom_empresa, proyectos.nombre nom_proyecto 

								FROM `ingreso_gral`

								INNER JOIN empresa ON empresa.pkID = ingreso_gral.fkID_empresa

								LEFT OUTER JOIN proyectos ON proyectos.pkID = ingreso_gral.fkID_proyecto

								WHERE proyectos.fkID_estado != 1 AND ".$filtro." AND ingreso_gral.fkID_empresa = 2 


								UNION

								SELECT ingreso_gral.*,empresa.nombre as nom_empresa, proyectos.nombre nom_proyecto

								FROM `ingreso_gral` 

								INNER JOIN empresa ON empresa.pkID = ingreso_gral.fkID_empresa

								LEFT JOIN proyectos ON proyectos.pkID = ingreso_gral.fkID_proyecto
 
								WHERE ingreso_gral.fkID_proyecto < 1  AND ingreso_gral.fkID_empresa = 2 AND ".$filtro."";	

			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getIngresosFiltroProco($filtro){
			
			$this->q_general = "select ingreso_gral.*, empresa.nombre as nom_empresa, proyectos.nombre nom_proyecto 

								FROM `ingreso_gral`

								INNER JOIN empresa ON empresa.pkID = ingreso_gral.fkID_empresa

								LEFT OUTER JOIN proyectos ON proyectos.pkID = ingreso_gral.fkID_proyecto

								WHERE proyectos.fkID_estado != 1 AND ".$filtro." AND ingreso_gral.fkID_empresa = 3 


								UNION

								SELECT ingreso_gral.*,empresa.nombre as nom_empresa, proyectos.nombre nom_proyecto

								FROM `ingreso_gral` 

								INNER JOIN empresa ON empresa.pkID = ingreso_gral.fkID_empresa

								LEFT JOIN proyectos ON proyectos.pkID = ingreso_gral.fkID_proyecto
 
								WHERE ingreso_gral.fkID_proyecto < 1  AND ingreso_gral.fkID_empresa = 3 AND ".$filtro."";	

			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getProyectosFuntecso(){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado 

				FROM `proyectos` INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				WHERE fkID_estado<>1 AND proyectos.fkID_empresa = 2 

				ORDER BY entidades.nombre_entidad";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
		/*20180104: Fin Agregado Funtectso*/
		public function getProyectosProco(){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado 

				FROM `proyectos` INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				WHERE fkID_estado<>1 AND proyectos.fkID_empresa = 3 

				ORDER BY entidades.nombre_entidad";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getAnio(){
			
			$this->q_general = "select DISTINCT anio FROM ingreso_gral WHERE anio IS NOT NULL AND anio <> '0000' ORDER BY anio desc";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getPeriodoId($pkID){
			
			$this->q_general = "select * FROM `periodo` WHERE pkID=".$pkID;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
	}
?>
