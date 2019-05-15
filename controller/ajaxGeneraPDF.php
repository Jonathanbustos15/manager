<?php 

	//header('http-equiv="Content-Type" content="text/html; charset=utf-8"');//header para json
	
	include('crea_sql.php');

	include('../DAO/GenericoDAO.php');
	include('../DAO/CotizacionDAO.php');


	require('../controller/fpdf/fpdf.php');

	include('classReportes.php');

	include 'reportesPdfAdmin.php';

	$accion= isset($_GET['tipo'])?$_GET['tipo']:"x";

 	$r = array(); 	

 	$reporte = new reportes();

 	$repAdmin = new repAdminPdf();

 	switch ($accion) {

 		case 'genera_cotizacion':

 		$reporte->createPdfCotizacion();

 		break;

 		case 'genera_reporte_usuarios':

 			$repAdmin->createReporteUsuarios();

 		break;

 		case 'genera_reporte_clientes':

 			$repAdmin->createReporteClientes();

 		break;

 		case 'genera_reporte_materiales':

 			$repAdmin->createReporteMateriales();

 		break;

 		case 'genera_reporte_cotizaciones':

 			$repAdmin->createReporteCotizaciones();

 		break;
 	};
 	//--------------------------------------------------------------------------------------------------------

	//echo json_encode($r); //imprime el json
	

 ?>