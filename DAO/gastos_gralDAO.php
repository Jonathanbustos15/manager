<?php
	/**/
	include_once 'genericoDAO.php';
	include_once 'PermisosDAO.php';
		
	class gastos_gralDAO extends GenericoDAO {
		
		public $permisos;
		public $q_general;
		public $fecha_4m;
		public $fecha_hoy;
		
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

		public function getGastos(){

			//$this->fecha_4m = date( "Y-m-d",mktime(0, 0, 0, date("m")-4,date("d"), date("Y")));
			//$this->fecha_hoy = date( "Y-m-d",mktime(0, 0, 0, date("m"),date("d"), date("Y")));

			//echo "Mostrando gastos por <strong>Fecha Límite</strong> desde: ".$this->fecha_4m." hasta: ".$this->fecha_hoy." <br><br>";
			
			$this->q_general = "select gasto_gral.*, empresa.nombre as nom_empresa, externo.nombre nom_externo 

								FROM `gasto_gral`

								INNER JOIN empresa ON empresa.pkID = gasto_gral.fkID_empresa

								INNER JOIN externo ON externo.pkID = gasto_gral.fkID_externo	

								WHERE gasto_gral.fecha_aprobacion IS NOT NULL						

								ORDER BY anio DESC, empresa.nombre  , gasto_gral.fecha_pago_limite DESC";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getGastosProyecto($pkID_proyecto){
			
			$this->q_general = "select gasto_gral.*, empresa.nombre as nom_empresa, externo.nombre nom_externo, proyectos.nombre as nom_proyecto, actividad.nombre as nom_actividad 

								FROM `gasto_gral`

								INNER JOIN empresa ON empresa.pkID = gasto_gral.fkID_empresa

								INNER JOIN externo ON externo.pkID = gasto_gral.fkID_externo
                                
                                INNER JOIN proyectos on proyectos.pkID = gasto_gral.fkID_proyecto
                                
                                INNER JOIN actividad on actividad.pkID = gasto_gral.fkID_actividad

								WHERE gasto_gral.fkID_proyecto = ".$pkID_proyecto;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getGastosProyectoNoAct($pkID_proyecto){
			
			$this->q_general = "select gasto_gral.*, empresa.nombre as nom_empresa, externo.nombre nom_externo, proyectos.nombre as nom_proyecto 

								FROM `gasto_gral`

								INNER JOIN empresa ON empresa.pkID = gasto_gral.fkID_empresa

								INNER JOIN externo ON externo.pkID = gasto_gral.fkID_externo
                                
                                INNER JOIN proyectos on proyectos.pkID = gasto_gral.fkID_proyecto                                                                

								WHERE gasto_gral.fkID_proyecto = ".$pkID_proyecto." AND (gasto_gral.fkID_actividad = 0 OR gasto_gral.fkID_actividad IS NULL)";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getGastosFiltro($filtro){

			//$this->fecha_4m = date( "Y-m-d",mktime(0, 0, 0, date("m")-4,date("d"), date("Y")));
			//$this->fecha_hoy = date( "Y-m-d",mktime(0, 0, 0, date("m"),date("d"), date("Y")));

			//echo "Mostrando gastos por <strong>Fecha Límite</strong> desde: ".$this->fecha_4m." hasta: ".$this->fecha_hoy." <br><br>";
			
			$this->q_general = "select gasto_gral.* ,  empresa.nombre as nom_empresa, externo.nombre nom_externo 

								FROM `gasto_gral` 

								INNER JOIN empresa ON empresa.pkID = gasto_gral.fkID_empresa 

								INNER JOIN externo ON externo.pkID = gasto_gral.fkID_externo

								WHERE ".$filtro." AND gasto_gral.fecha_aprobacion IS NOT NULL 

								ORDER BY gasto_gral.fecha_pago_limite DESC";

			//print_r($this->q_general);
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getEmpresas(){
			
			$this->q_general = "select * FROM `empresa` WHERE empresa.pkID != 10";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getFechas(){
			
			$this->q_general = "select DISTINCT fecha_aprobacion FROM gasto_gral WHERE fecha_aprobacion IS NOT NULL AND fecha_aprobacion <> 0000-00-00 ORDER BY fecha_aprobacion DESC";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getFechasAp($fecha){
			
			$this->q_general = "select gasto_gral.* FROM gasto_gral WHERE gasto_gral.fecha_aprobacion =".$fecha;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getEmpresasId($pkID){
			
			$this->q_general = "select * FROM `empresa` WHERE pkID=".$pkID;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getExternos(){
			
			$this->q_general = "select * FROM `externo`";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getProyectos(){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado 

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				WHERE fkID_estado = 2 

				ORDER BY entidades.nombre_entidad";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSumaGastos(){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(valor) as total_gastos FROM `gasto_gral` WHERE gasto_gral.fecha_aprobacion IS NOT NULL";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSumaPagos(){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(pago) as total_pagos FROM `gasto_gral` WHERE gasto_gral.fecha_aprobacion IS NOT NULL";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
		public function getSumaGastosProyecto($pkID_proyecto){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(valor) as total_gastos FROM `gasto_gral` WHERE fkID_proyecto = ".$pkID_proyecto;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSumaGastosFiltro($filtro){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(valor) as total_gastos FROM `gasto_gral` WHERE ".$filtro." AND gasto_gral.fecha_aprobacion IS NOT NULL";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSumaPagosFiltro($filtro){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(pago) as total_pagos FROM `gasto_gral` WHERE ".$filtro." AND gasto_gral.fecha_aprobacion IS NOT NULL";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getGastosFuntecso(){
            
            $this->q_general = "select gasto_gral.*, empresa.nombre as nom_empresa, externo.nombre nom_externo 

                                FROM `gasto_gral`

                                INNER JOIN empresa ON empresa.pkID = gasto_gral.fkID_empresa

                                INNER JOIN externo ON externo.pkID = gasto_gral.fkID_externo    

                                WHERE gasto_gral.fecha_aprobacion IS NOT NULL AND gasto_gral.fkID_empresa = 2                        

                                ORDER BY gasto_gral.pkID DESC";        
            
            return GenericoDAO::EjecutarConsulta($this->q_general);
        }

        public function getGastosFiltroFuntecso($filtro){

            $this->q_general = "select gasto_gral.*, empresa.nombre as nom_empresa, externo.nombre nom_externo 

                                FROM `gasto_gral` 

                                INNER JOIN empresa ON empresa.pkID = gasto_gral.fkID_empresa 

                                INNER JOIN externo ON externo.pkID = gasto_gral.fkID_externo

                                WHERE ".$filtro." AND gasto_gral.fecha_aprobacion IS NOT NULL AND gasto_gral.fkID_empresa = 2

                                ORDER BY gasto_gral.pkID DESC";
            
            return GenericoDAO::EjecutarConsulta($this->q_general);
        }

        public function getFechasFuntecso(){
            
            $this->q_general = "select DISTINCT fecha_aprobacion FROM gasto_gral WHERE fecha_aprobacion IS NOT NULL AND fecha_aprobacion <> '0000-00-00' AND gasto_gral.fkID_empresa = 2 ";        
            
            return GenericoDAO::EjecutarConsulta($this->q_general);
        }


        public function getProyectosFuntecso(){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado 

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				WHERE fkID_estado<>1 AND proyectos.fkID_empresa = 2

				ORDER BY entidades.nombre_entidad";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getSumaGastosFuntecso(){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(valor) as total_gastos FROM `gasto_gral` WHERE gasto_gral.fecha_aprobacion IS NOT NULL
								AND fkID_empresa = 2 ";		
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSumaPagosFuntecso(){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(pago) as total_pagos FROM `gasto_gral` WHERE gasto_gral.fecha_aprobacion IS NOT NULL
								AND fkID_empresa = 2 ";		
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getFechasAnio(){
			
			$this->q_general = "select DISTINCT anio FROM gasto_gral WHERE anio <> 0";		

			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}



		public function getSumaGastosFiltroFuntecso($filtro){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(valor) as total_gastos FROM `gasto_gral` WHERE ".$filtro." AND gasto_gral.fecha_aprobacion IS NOT NULL AND fkID_empresa = 2 ";
				return GenericoDAO::EjecutarConsulta($this->q_general);
		}	

		public function getSumaPagosFiltroFuntecso($filtro){

			//SELECT SUM(valor) as total_ingresos FROM `ingreso_gral`

			$this->q_general = "select SUM(pago) as total_pagos FROM `gasto_gral` WHERE ".$filtro." AND gasto_gral.fecha_aprobacion IS NOT NULL AND fkID_empresa = 2 ";
				return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getFechasAnioFuntecso(){
			
			$this->q_general = "select DISTINCT anio FROM gasto_gral WHERE fkID_empresa = 2 AND anio <> 0";		

			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}



	}
?>
