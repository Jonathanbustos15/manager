<?php 
	/*
	error_reporting(E_ALL);
	ini_set('display_errors', '1');*/

	include("../DAO/GenericoDAO.php");

	class autocompleta_formatos extends GenericoDAO {

		public $q_general;

		/*-----------------------------*/
		function __construct(){
			//contruye la clase GenericoDAO
			parent::__construct();
		}
		/*-----------------------------------------*/

		public function getNombre($valor){

			if ($_GET["tipo"]=="categoria") {
				$this->q_general = "select nombre_cat FROM categoria where nombre_cat like '%".$valor."%' AND fkID_padre IS null";
			}elseif ($_GET["tipo"]=="subcategoria") {
				$this->q_general = "select nombre_cat FROM categoria where nombre_cat like '%".$valor."%' AND fkID_padre IS NOT null";
			}					
			
			return GenericoDAO::EjecutarConsulta($this->q_general);
		}
	}

	$data = new autocompleta_formatos();

	$a_final = array();

	$arr1 = $data->getNombre($_GET["term"]);

	for ($i=0; $i < sizeof($arr1); $i++) { 
		
		array_push($a_final, array(
				//"id"=>$arr1[$i]['pkID'],
				"label"=>$arr1[$i]['nombre_cat'],
				"value"=>$arr1[$i]['nombre_cat']
				));
	}	

	//AND fkID_padre IS NOT null

	echo json_encode($a_final);

 ?>