<?php 

	include_once 'GenericoDAO.php';

	class entidad extends GenericoDAO{

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

		public function getEntidades(){			

			$this->q_general = "select * FROM `entidades`";		
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}		
		
	}
/*
	$data = new hvida();

	$datos = $data->getHvida();

	print_r($datos);
*/
 ?>