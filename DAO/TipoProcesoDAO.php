<?php 

	include_once 'GenericoDAO.php';

	class tipo_proceso extends GenericoDAO{

		/*-----------------------------------------*/
		//variables
		public $q_general;		
		/*-----------------------------*/
		public function __construct(){
			//contruye la clase GenericoDAO
			parent::__construct();
		}
		/*-----------------------------------------*/

		/*-----------------------------------------*/
		
		//funciones generales

		public function getTipoProceso(){			

			$this->q_general = "select * FROM `tipo_proceso`";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}		
		
	}

 ?>