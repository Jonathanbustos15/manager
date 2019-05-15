<?php 

	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	include("../DAO/GenericoDAO.php");

	class autocompleta_proceso extends GenericoDAO {

		public $q_general;

		/*-----------------------------*/
		function __construct(){
			//contruye la clase GenericoDAO
			parent::__construct();
		}
		/*-----------------------------------------*/

		public function getCodProceso($valor){

			$this->q_general = "select codigo FROM procesos where codigo like '%".$valor."%'";			
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
	}

	$data = new autocompleta_proceso();

	$a_final = array();

	$arr1 = $data->getCodProceso($_GET["term"]);

	for ($i=0; $i < sizeof($arr1); $i++) { 
		
		array_push($a_final, array(
				//"id"=>$arr1[$i]['pkID'],
				"label"=>$arr1[$i]['codigo'],
				"value"=>$arr1[$i]['codigo']
				));
	}	

	echo json_encode($a_final);

 ?>