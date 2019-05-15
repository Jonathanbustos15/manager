<?php 

	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	include("../DAO/GenericoDAO.php");

	class autocompleta extends GenericoDAO {

		public $q_general;

		/*-----------------------------*/
		function __construct(){
			//contruye la clase GenericoDAO
			parent::__construct();
		}
		/*-----------------------------------------*/

		public function getBeneficiario($valor){

			$this->q_general = "select * FROM externo where nombre like '%".$valor."%'";			
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
	}

	$data = new autocompleta();

	$a_final = array();

	$arr1 = $data->getBeneficiario($_GET["term"]);

	for ($i=0; $i < sizeof($arr1); $i++) { 
		
		array_push($a_final, array(
				"id"=>$arr1[$i]['pkID'],
				"label"=>$arr1[$i]['nombre'],
				//"value"=>$arr1[$i]['pkID']
				));
	}	

	echo json_encode($a_final);

 ?>