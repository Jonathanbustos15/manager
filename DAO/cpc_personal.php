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

		public function 	getHvida($valor){

			$this->q_general = "select * FROM hoja_vida where nombre like '%".$valor."%' OR apellido LIKE '%".$valor."%' OR nidentificacion LIKE '%".$valor."%'";
							
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
	}

	$data = new autocompleta();

	$a_final = array();

	$arr1 = $data->getHvida($_GET["term"]);

	if ($arr1 != 0) {
		# code...
		/**/
		for ($i=0; $i < sizeof($arr1); $i++) { 
			
			array_push($a_final, array(
					"id"=>$arr1[$i]['pkID'],
					"label"=>"C.C. :".$arr1[$i]['nidentificacion']." -- ".$arr1[$i]['nombre']." ".$arr1[$i]['apellido']				
					//"value"=>$arr1[$i]['pkID']
					));
		}

	} else {
		# code...

		$a_final = array(

	    			 "label"=>"No hay coincidencias.",
	    			 "array"=>$arr1	    			 	
	    		);
	}
	
		
	echo json_encode($a_final);
	

 ?>