<?php 

	include_once 'GenericoDAO.php';
	include_once 'PermisosDAO.php';

	class proyectos extends GenericoDAO{

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

		public function getProyectos(){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado,empresa.nombre as empresa 

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getProyectosUser($pkID_usuario, $pkID_empresa){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado, usuarios.nombre as nom_user, usuarios.apellido as apellido_user 

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado
                
                INNER JOIN proyectos_usuarios ON proyectos_usuarios.fkID_proyecto = proyectos.pkID
                
                INNER JOIN usuarios ON usuarios.pkID = proyectos_usuarios.fkID_usuario
                
                WHERE (proyectos_usuarios.fkID_usuario = ".$pkID_usuario." and proyectos.fkID_empresa = ".$pkID_empresa.")

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getProyectoId($pkID){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, entidades.nom_contacto, entidades.tel_contacto, entidades.observacion_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado, e.nombre as nom_empresa 

								FROM `proyectos` 

								INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad 

								INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

								INNER JOIN empresa e ON e.pkID = CASE 
                                
                                	WHEN proyectos.fkID_empresa = 0 THEN 10
                                    
                                    WHEN proyectos.fkID_empresa != 0 THEN proyectos.fkID_empresa
                                    
                                END 

								WHERE proyectos.pkID = ".$pkID;	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		/*
		select usuarios.*, tipo_usuario.nombre as nom_tipo, empresa.nombre as nom_empresa

                FROM `usuarios` 

                INNER JOIN tipo_usuario ON tipo_usuario.pkID = usuarios.fkID_tipo
                
                INNER JOIN empresa e ON e.pkID = CASE
                
                	WHEN proyectos.fkID_empresa = 0 THEN 10

                	WHEN proyectos.fkID_empresa != 0 THEN usuarios.fkID_empresa

                END 
		*/

		//-----------------------------------------------------------
		//FUNCIONES PARA SELECTS

		public function getSelectEntidad(){			

			$this->q_general = "select * FROM `entidades` order by nombre_entidad";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getSelectEstadoProyecto(){

			$this->q_general = "select * FROM `estado_proyecto`";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getActividades($pkID){

			$this->q_general = "select * FROM `actividad` WHERE fkID_proyecto = ".$pkID;			
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getActividadId($pkID){

			$this->q_general = "select * FROM `actividad` WHERE pkID = ".$pkID;			
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getTipoDocumentoId($pkID){

			$this->q_general = "select * FROM `tipo_documento` WHERE pkID = ".$pkID;			
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		//-----------------------------------------------------------
		//FUNCION CONTADOR DE PROYECTOS EN LA PAGINA DE INICIO
		public function getNumProyectos(){

			$this->q_general = "select count(*) as numProyectos from proyectos";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}		
		//-----------------------------------------------------------


		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//presupuesto

		public function getPresupuesto($pkID){
			//SELECT * FROM `gastos` WHERE fkID_actividad IS NULL
			$this->q_general = "select * from gastos where (fkID_proyecto = ".$pkID.") and (fkID_actividad IS NULL or fkID_actividad = 0) order by gastos.pkID desc";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
		//--------------------------------------------------------------------------------------------------------
		public function getTotalGastosNoAct($pkID){

			$this->q_general = "select SUM(gastos.valor) as total_gastos from gastos where fkID_proyecto =".$pkID." and (fkID_actividad IS NULL or fkID_actividad = 0)";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getTotalFinalNoAct($pkID){

			$this->q_general = "select SUM(gastos.total) as total_final from gastos where fkID_proyecto =".$pkID." and (fkID_actividad IS NULL or fkID_actividad = 0)";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getTotalIvaNoAct($pkID){

			$this->q_general = "select SUM(gastos.iva) as total_iva from gastos where fkID_proyecto =".$pkID." and (fkID_actividad IS NULL or fkID_actividad = 0)";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}		
		//--------------------------------------------------------------------------------------------------------
		public function getPresupuestoAct($pkID){

			$this->q_general = "select gastos.*, actividad.nombre as nom_actividad 

								from gastos 

								INNER JOIN actividad ON actividad.pkID = gastos.fkID_actividad

								where gastos.fkID_proyecto = ".$pkID." order by gastos.pkID desc";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		//presupuesto con filtro				

		public function getPresupuestoActFiltro($pkID,$filtro){

			$this->q_general = "select gastos.*, actividad.nombre as nom_actividad 

								from gastos 

								INNER JOIN actividad ON actividad.pkID = gastos.fkID_actividad

								where gastos.fkID_proyecto = ".$pkID." AND ".$filtro." order by gastos.pkID desc";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		//----------------------------------------------------------------------------------------------------------------------

		public function getTotalGastos($pkID){

			$this->q_general = "select SUM(gastos.valor) as total_gastos from gastos where fkID_proyecto =".$pkID;				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getTotalGastosFiltro($pkID,$filtro){
						

			$this->q_general = "select SUM(gastos.valor) as total_gastos 

								from gastos 

								INNER JOIN actividad ON actividad.pkID = gastos.fkID_actividad

								where gastos.fkID_proyecto =".$pkID." AND ".$filtro;			
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getTotalIva($pkID){

			$this->q_general = "select SUM(gastos.iva) as total_iva from gastos where fkID_proyecto =".$pkID;				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getTotalIvaFiltro($pkID,$filtro){

			$this->q_general = "select SUM(gastos.iva) as total_iva 

								from gastos

								INNER JOIN actividad ON actividad.pkID = gastos.fkID_actividad 

								where gastos.fkID_proyecto =".$pkID." AND ".$filtro;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getTotalFinal($pkID){

			$this->q_general = "select SUM(gastos.total) as total_final from gastos where fkID_proyecto =".$pkID;				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getTotalFinalFiltro($pkID,$filtro){

			$this->q_general = "select SUM(gastos.total) as total_final 

								from gastos 
								
								INNER JOIN actividad ON actividad.pkID = gastos.fkID_actividad
			
								where gastos.fkID_proyecto =".$pkID." AND ".$filtro;			
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		//--------------------------------------------------------------------------------------------------------

		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//Documentos
		public function getTipoDocumento(){

			$this->q_general = "select * FROM `tipo_documento` WHERE fkID_padre IS NULL AND nombre_tdoc != 'No Aplica'";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getDocumentos($pkID){
			/*!!!!!ATENCION!!!!! en la linea 
			WHEN documentos.fkID_subtipo = 0 THEN 15
			indica el pkID de la categoría No aplica en la BD*/
			$this->q_general = "select documentos.*, a.nombre_tdoc as nom_tipoDocumento, b.nombre_tdoc as nombre_tsubtipo 

								FROM `documentos` 

								INNER JOIN tipo_documento a ON a.pkID = documentos.fkID_tipo
                                
                                INNER JOIN tipo_documento b ON b.pkID = CASE
                                	
                                        WHEN documentos.fkID_subtipo = 0 THEN 15

                                        WHEN documentos.fkID_subtipo != 0 THEN documentos.fkID_subtipo 
                                    
                                    END

								where fkID_proyecto = ".$pkID."

								order by documentos.pkID desc";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		//---------------------------------------------------------
		public function getDocumentosFiltro($pkID,$filtro){

			$this->q_general = "select documentos.*, a.nombre_tdoc as nom_tipoDocumento, b.nombre_tdoc as nombre_tsubtipo 

								FROM `documentos` 

								INNER JOIN tipo_documento a ON a.pkID = documentos.fkID_tipo
                                
                                INNER JOIN tipo_documento b ON b.pkID = CASE
                                	
                                        WHEN documentos.fkID_subtipo = 0 THEN 15

                                        WHEN documentos.fkID_subtipo != 0 THEN documentos.fkID_subtipo 
                                    
                                    END

								where fkID_proyecto = ".$pkID." AND ".$filtro." order by documentos.pkID desc";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		//----------------------------------------------------------
		//getProyectosFiltro($filtro)
		public function getProyectosFiltro($filtro){

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado, empresa.nombre as empresa 

								FROM `proyectos`

								INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

								INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

								INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa

								WHERE ".$filtro." ORDER BY proyectos.pkID desc";				
			//print_r($this->q_general);
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getProyectosFiltroUser($pkID_usuario,$pkID_empresa,$filtro){

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado, usuarios.nombre as nom_user, usuarios.apellido as apellido_user 

								FROM `proyectos`

								INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

								INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado
				                
				                INNER JOIN proyectos_usuarios ON proyectos_usuarios.fkID_proyecto = proyectos.pkID
				                
				                INNER JOIN usuarios ON usuarios.pkID = proyectos_usuarios.fkID_usuario 

								WHERE (proyectos_usuarios.fkID_usuario = ".$pkID_usuario." and proyectos.fkID_empresa = ".$pkID_empresa.") and ".$filtro;

								//echo $this->q_general;								
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getEstadoId($pkID){

			$this->q_general = "select * FROM `estado_proyecto` WHERE pkID = ".$pkID;			
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
		//----------------------------------------------------------
		//funcion de empresas para usuarios y validacion
		public function getEmpresasId($pkID_usuario){

	      $query = "select empresa.*, usuarios.alias 

	                FROM empresa

	                INNER JOIN usuarios_empresas ON usuarios_empresas.fkID_empresa = empresa.pkID

	                INNER JOIN usuarios ON usuarios_empresas.fkID_usuario = usuarios.pkID

	                WHERE usuarios.pkID = ".$pkID_usuario;

	      return GenericoDAO::EjecutarConsulta($query);

	    }

	    public function getEmpresaId($pkID){
			
			$this->q_general = "select * FROM `empresa` WHERE pkID=".$pkID;		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		public function getProyectosFuntecso(){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado, empresa.nombre as empresa  

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa

				WHERE proyectos.fkID_empresa = 2

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getProyectosFuntecsoEjecucion(){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado, empresa.nombre as empresa  

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa

				WHERE proyectos.fkID_empresa = 2 AND proyectos.fkID_estado = 2

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getProyectosFuntecsoTerminado(){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado, empresa.nombre as empresa  

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa

				WHERE proyectos.fkID_empresa = 2 AND proyectos.fkID_estado = 3

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getProyectosFuntecsoLiquidado(){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado, empresa.nombre as empresa  

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa

				WHERE proyectos.fkID_empresa = 2 AND proyectos.fkID_estado = 1

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getProyectosFiltroFuntecso($filtro){

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado, empresa.nombre as empresa

								FROM `proyectos`

								INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

								INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

								INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa

								WHERE ".$filtro." AND proyectos.fkID_empresa = 2 ORDER BY proyectos.pkID desc";				
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getEmpresas(){
			
			$this->q_general = "select * FROM `empresa` WHERE empresa.pkID != 10";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}





		//-----------------------------------------------------------------------------------------
		public function getProyectosEjecucionT(){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado,empresa.nombre as empresa 

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa

				WHERE proyectos.fkID_estado = 2

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getProyectosEjecucion($filtro){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado,empresa.nombre as empresa 

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa

				WHERE ".$filtro." AND proyectos.fkID_estado = 2

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getProyectosTerminadoT(){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado,empresa.nombre as empresa 

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa

				WHERE proyectos.fkID_estado = 3

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getProyectosTerminado($filtro){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado,empresa.nombre as empresa 

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa

				WHERE ".$filtro." AND proyectos.fkID_estado = 3

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getProyectosLiquidadoT(){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado,empresa.nombre as empresa 

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa

				WHERE proyectos.fkID_estado = 1

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getProyectosLiquidado($filtro){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado,empresa.nombre as empresa 

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa

				WHERE ".$filtro." AND proyectos.fkID_estado = 1

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}






		//---------------------------Lider de Proyectos-------------

		public function getProyectosLiderEjecucion($usuario){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado,empresa.nombre as empresa 

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa
                
                INNER JOIN proyectos_usuarios ON proyectos_usuarios.fkID_proyecto = proyectos.pkID
                
                INNER JOIN usuarios ON usuarios.pkID=proyectos_usuarios.fkID_usuario

				WHERE proyectos.fkID_estado = 2  AND proyectos_usuarios.fkID_usuario = ".$usuario."

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getProyectosLiderTerminado($usuario){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado,empresa.nombre as empresa 

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa
                
                INNER JOIN proyectos_usuarios ON proyectos_usuarios.fkID_proyecto = proyectos.pkID
                
                INNER JOIN usuarios ON usuarios.pkID=proyectos_usuarios.fkID_usuario

				WHERE proyectos.fkID_estado = 3  AND proyectos_usuarios.fkID_usuario = ".$usuario."

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


		public function getProyectosLiderLiquidado($usuario){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado,empresa.nombre as empresa 

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa
                
                INNER JOIN proyectos_usuarios ON proyectos_usuarios.fkID_proyecto = proyectos.pkID
                
                INNER JOIN usuarios ON usuarios.pkID=proyectos_usuarios.fkID_usuario

				WHERE proyectos.fkID_estado = 1  AND proyectos_usuarios.fkID_usuario = ".$usuario."

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}

		public function getProyectosLiderTodos($usuario){			

			$this->q_general = "select proyectos.*, entidades.pkID as pkID_entidad, entidades.nombre_entidad as nom_entidad, estado_proyecto.pkID as pkID_estado, estado_proyecto.nombre nom_estado,empresa.nombre as empresa 

				FROM `proyectos`

				INNER JOIN entidades ON entidades.pkID = proyectos.fkID_entidad

				INNER JOIN estado_proyecto ON estado_proyecto.pkID = proyectos.fkID_estado 

				INNER JOIN empresa ON empresa.pkID = proyectos.fkID_empresa
                
                INNER JOIN proyectos_usuarios ON proyectos_usuarios.fkID_proyecto = proyectos.pkID
                
                INNER JOIN usuarios ON usuarios.pkID=proyectos_usuarios.fkID_usuario

				WHERE proyectos_usuarios.fkID_usuario = ".$usuario."

				ORDER BY pkID DESC";	
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}


	}

/*
	$data = new hvida();

	$datos = $data->getHvida();

	print_r($datos);
*/
 ?>