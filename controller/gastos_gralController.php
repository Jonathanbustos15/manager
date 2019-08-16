<?php
/**/
include_once '../DAO/gastos_gralDAO.php';

class gastos_gralController extends gastos_gralDAO
{

    //public $NameCookieApp;
    public $id_modulo;
    public $id_moduloProyecto;
    public $gasto;
    public $gastoProyecto;
    public $gastoProyectoNoAct;
    public $empresaSelect;
    public $externoSelect;

    public function __construct()
    {

        //include('../conexion/datos.php');

        //$this->id_modulo = --; id de la tabla modulos
        //$this->NameCookieApp = $NomCookiesApp;
        $this->id_modulo         = 16;
        $this->id_moduloProyecto = 18;
    }

    //Funciones-------------------------------------------
    //Espacio para las funciones de esta clase.

    public function getSelectEmpresas()
    {

        $empresaSelect = $this->getEmpresas();

        echo '<select name="fkID_empresa" id="fkID_empresa" class="form-control add-selectElement" data-accion="select" required = "true">
                        <option></option>';
        for ($i = 0; $i < sizeof($empresaSelect); $i++) {
            echo '<option id="fkID_empresa_' . $empresaSelect[$i]["pkID"] . '" value="' . $empresaSelect[$i]["pkID"] . '" data-nombre = "' . $empresaSelect[$i]["nombre"] . '" >' . $empresaSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectProyectos()
    {

        $proyectoSelect = $this->getProyectos();

        echo '<select name="fkID_proyecto" id="fkID_proyecto" class="form-control">
                        <option></option>';
        for ($i = 0; $i < sizeof($proyectoSelect); $i++) {
            echo '<option value="' . $proyectoSelect[$i]["pkID"] . '" >' . $proyectoSelect[$i]["nom_entidad"] . ' : ' . $proyectoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectProyectosFiltro()
    {

        $proyectoSelect = $this->getProyectos();

        echo '<select name="fuente_filtro" id="fuente_filtro" class="form-control select-filtro">
                        <option></option>';
        for ($i = 0; $i < sizeof($proyectoSelect); $i++) {
            echo '<option value="' . $proyectoSelect[$i]["pkID"] . '" >' . $proyectoSelect[$i]["nom_entidad"] . ' : ' . $proyectoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectEmpresasFiltro()
    {

        $empresaSelect = $this->getEmpresas();

        echo '<select name="empresa_filtro" id="empresa_filtro" class="form-control select-filtro">
                        <option value="">Todo</option>';
        for ($i = 0; $i < sizeof($empresaSelect); $i++) {
            echo '<option value="' . $empresaSelect[$i]["pkID"] . '" >' . $empresaSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectFechasFiltro()
    {

        $tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];

        if ($tipoUsuario != 13) {

            $fechasSelect = $this->getFechas();
        } else {

            $fechasSelect = $this->getFechasFuntecso();
        }

        echo '<select name="fechas_filtro" id="fechas_filtro" class="form-control">
                        <option value="">Todo</option>';
        for ($i = 0; $i < sizeof($fechasSelect); $i++) {
            echo '<option value="\'' . $fechasSelect[$i]["fecha_aprobacion"] . '\'" >' . $fechasSelect[$i]["fecha_aprobacion"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectAnioFiltro()
    {

        $tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];

        if ($tipoUsuario != 13) {

            $fechasSelect = $this->getFechasAnio();
        } else {

            $fechasSelect = $this->getFechasAnioFuntecso();
        }

        echo '<select name="fecha_anio_filtro" id="fecha_anio_filtro" class="form-control">
                        <option value="">Todo</option>';
        for ($i = 0; $i < sizeof($fechasSelect); $i++) {
            echo '<option value="\'' . $fechasSelect[$i]["anio"] . '\'" >' . $fechasSelect[$i]["anio"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectExternos()
    {

        $externoSelect = $this->getExternos();

        echo '<select name="fkID_externo" id="fkID_externo" class="form-control add-selectElement" required = "true">
                        <option>Todo</option>';
        for ($i = 0; $i < sizeof($externoSelect); $i++) {
            echo '<option value="' . $externoSelect[$i]["pkID"] . '" >' . $externoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getTablagastos_gral($filtro)
    {

        //------------------------------------------------------------------------------------------------

        if ($filtro == '*') {
            # code...
            echo "<span class='badge'>Empresa: Todas</span>";
            echo "<br> <br>";
            $this->gasto = $this->getGastos();

        } else {

            # code...
            $cambio = array("AND", "gasto_gral.");

            $campos_str = str_replace($cambio, "", $filtro);

            $arr_campos = explode(" ", $campos_str);

            $arr_completo = array();
            //print_r ($arr_campos);

            echo "<p>Filtrando por:</p>";

            for ($i = 0; $i < sizeof($arr_campos); $i++) {
                # code...
                //echo $arr_campos[$i].'<br>';

                $arr_campos1 = explode("=", $arr_campos[$i]);

                /*print_r($arr_campos1);
                echo "<br><br>";
                echo "<br><br>";
                 */
                if ($arr_campos1[0] == "fkID_empresa") {
                    # code...
                    $empresaId = $this->getEmpresasId($arr_campos1[1]);

                    //print_r($empresaId);

                    echo "<span class='badge'>Empresa:" . $empresaId[0]["nombre"] . "</span>";
                }

                if ($arr_campos1[0] == "aprobado") {

                    if ($arr_campos1[1] == "0") {
                        # code...
                        echo "<span class='badge'>Aprobado:No</span>";
                    } else {
                        echo "<span class='badge'>Aprobado:Sí</span>";
                    }
                }

                if ($arr_campos1[0] == "pagado") {

                    if ($arr_campos1[1] == "0") {
                        # code...
                        echo "<span class='badge'>Pagado:No</span>";
                    } else {
                        echo "<span class='badge'>Pagado:Sí</span>";
                    }
                }
                if ($arr_campos1[0] == "fecha_aprobacion") {
                    # code...
                    //$fecha = $this->getFechasAp($arr_campos1[1]);

                    //print_r($fecha);
                    //echo "<br><br>";
                    //print_r($arr_campos1[1]);
                    //echo "<br><br>";

                    echo "<span class='badge'>Fecha de aprobacion:" . $arr_campos1[1] . "</span>";
                }
                if ($arr_campos1[0] == "anio") {
                    # code...
                    //$fecha = $this->getFechasAp($arr_campos1[1]);

                    //print_r($fecha);
                    //echo "<br><br>";
                    //print_r($arr_campos1[1]);
                    //echo "<br><br>";

                    echo "<span class='badge'>Año:" . $arr_campos1[1] . "</span>";
                }

            }
            /*echo "<br><br>";
            print_r($filtro);    */
            echo "<br> <br>";

            $this->gasto = $this->getGastosFiltro($filtro);
            //print_r($this->gasto);

        }

        //print_r($formatosNoSub);
        //mete los formatos sin subcategoria
        //array_merge($this->Formatos, $formatosNoSub);

        //print_r($this->Formatos);

        //valida si hay formatos

        //permisos-------------------------------------------------------------------------
        $arrPermisos = $this->permisos($this->id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);
        $edita       = $arrPermisos[0]["editar"];
        $elimina     = $arrPermisos[0]["eliminar"];
        $consulta    = $arrPermisos[0]["consultar"];
        //echo "Consulta:".$consulta;
        //---------------------------------------------------------------------------------

        if (($this->gasto) && ($consulta == 1)) {

            for ($a = 0; $a < sizeof($this->gasto); $a++) {

                $id                = $this->gasto[$a]["pkID"];
                $empresa           = $this->gasto[$a]["nom_empresa"];
                $externo           = $this->gasto[$a]["nom_externo"];
                $descripcion       = $this->gasto[$a]["descripcion"];
                $fecha_pago_limite = $this->gasto[$a]["fecha_pago_limite"];
                $valor             = $this->gasto[$a]["valor"];
                $pago              = $this->gasto[$a]["pago"];
                $diferencia        = $this->gasto[$a]["diferencia"];
                $observaciones     = $this->gasto[$a]["observaciones"];
                //---------------------------------------------------------
                $aprobado         = $this->gasto[$a]["aprobado"];
                $pagado           = $this->gasto[$a]["pagado"];
                $fecha_pago       = $this->gasto[$a]["fecha_pago"];
                $fecha_aprobacion = $this->gasto[$a]["fecha_aprobacion"];
                //---------------------------------------------------------

                echo '<tr';if (is_null($pagado) || $pagado == '' || $pagado == 0) {
                    # code...
                    echo ' style="background-color: red; color : black;" ';
                }
                echo '>
                             	 <td>' . $empresa . '</td>
                                 <td>' . $externo . '</td>
                                 <td>' . $descripcion . '</td>
                                 <td hidden=true>' . $valor . '</td>
                                 <td>' . $fecha_pago_limite . '</td>
                                 <td>' . '$' . number_format($valor, 0, '', '.') . '</td>
                                 <td>' . '$' . number_format($pago, 0, '', '.') . '</td>
                                 <td>' . '$' . number_format($diferencia, 0, '', '.') . '</td>
                                 <td>' . $observaciones . '</td>
                                 <td>';if ($aprobado == 1) {echo "SI";} else {echo "NO";}echo '</td>
                                 <td>';if ($pagado == 1) {echo "SI";} else {echo "NO";}echo '</td>
                                 <td>' . $fecha_pago . '</td>
                                 <td>' . $fecha_aprobacion . '</td>
		                         <td>
		                             <button id="btn_editar" title="Editar" name="edita_gasto_gral" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_gasto_gral" data-id-gasto_gral = "' . $id . '" ';if ($edita != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_gasto_gral" type="button" class="btn btn-danger" data-id-gasto_gral = "' . $id . '" ';if ($elimina != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-remove"></span></button>
		                             <button id="btn_aprobar" title="Aprobar" name="aprobar_gasto_gral" type="button" class="btn btn-primary" data-id-gasto_gral = "' . $id . '" ';if (($_COOKIE["log_lunelAdmin_IDtipo"] == 3) || ($_COOKIE["log_lunelAdmin_IDtipo"] == 1)) {echo '';} else {echo 'style="display: none;"';};if (is_null($aprobado) || $aprobado == '' || $aprobado == 0) {echo '';} else {echo 'style="display: none;"';};
                echo '><span class="glyphicon glyphicon-ok"></span></button>
		                         </td>
		                     </tr>';
            };

        } elseif (($this->gasto) && ($consulta == 0)) {

            echo "<tr>
             		   <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-exclamation-sign'></span> En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Gastos General.</strong>
				   </div>";
        } else {

            echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		           </tr>

		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-alert'></span> En este momento no hay gastos creados o no se encuentran en este filtro.
				   </div>";
        };

    }

    public function getTablagastos_gralProyecto($pkID_proyecto)
    {

        $this->gastoProyecto      = $this->getGastosProyecto($pkID_proyecto);
        $this->gastoProyectoNoAct = $this->getGastosProyectoNoAct($pkID_proyecto);
        //print_r($this->gastoProyecto);
        //print_r($this->gastoProyectoNoAct);
        //permisos-------------------------------------------------------------------------
        $arrPermisos = $this->permisos($this->id_moduloProyecto, $_COOKIE["log_lunelAdmin_IDtipo"]);
        $consultaP   = $arrPermisos[0]["consultar"];
        //echo "Consulta:".$consulta;
        //---------------------------------------------------------------------------------
        if (($this->gastoProyecto) && ($consultaP == 1)) {

            for ($a = 0; $a < sizeof($this->gastoProyecto); $a++) {

                $id                = $this->gastoProyecto[$a]["pkID"];
                $empresa           = $this->gastoProyecto[$a]["nom_empresa"];
                $externo           = $this->gastoProyecto[$a]["nom_externo"];
                $descripcion       = $this->gastoProyecto[$a]["descripcion"];
                $fecha_pago_limite = $this->gastoProyecto[$a]["fecha_pago_limite"];
                $valor             = $this->gastoProyecto[$a]["valor"];
                $observaciones     = $this->gastoProyecto[$a]["observaciones"];
                //---------------------------------------------------------
                $aprobado   = $this->gastoProyecto[$a]["aprobado"];
                $pagado     = $this->gastoProyecto[$a]["pagado"];
                $fecha_pago = $this->gastoProyecto[$a]["fecha_pago"];
                //---------------------------------------------------------
                $nom_actividad = $this->gastoProyecto[$a]["nom_actividad"];

                echo '
                             <tr';if (is_null($pagado) || $pagado == '' || $pagado == 0) {
                    # code...
                    echo ' style="background-color: red;" ';
                }
                echo '>

                                 <td>' . $externo . '</td>
                                 <td>' . $descripcion . '</td>
                                 <td>' . $fecha_pago_limite . '</td>
                                 <td>' . '$' . number_format($valor, 0, '', '.') . '</td>
                                 <td>' . $observaciones . '</td>
                                 <td>' . $nom_actividad . '</td>
		                     </tr>';
            };

            //---------------------------------------------------------------------------------------------------------
            if (($this->gastoProyectoNoAct) && ($consultaP == 1)) {

                for ($a = 0; $a < sizeof($this->gastoProyectoNoAct); $a++) {

                    $id                = $this->gastoProyectoNoAct[$a]["pkID"];
                    $empresa           = $this->gastoProyectoNoAct[$a]["nom_empresa"];
                    $externo           = $this->gastoProyectoNoAct[$a]["nom_externo"];
                    $descripcion       = $this->gastoProyectoNoAct[$a]["descripcion"];
                    $fecha_pago_limite = $this->gastoProyectoNoAct[$a]["fecha_pago_limite"];
                    $valor             = $this->gastoProyectoNoAct[$a]["valor"];
                    $observaciones     = $this->gastoProyectoNoAct[$a]["observaciones"];
                    //---------------------------------------------------------
                    $aprobado   = $this->gastoProyectoNoAct[$a]["aprobado"];
                    $pagado     = $this->gastoProyectoNoAct[$a]["pagado"];
                    $fecha_pago = $this->gastoProyectoNoAct[$a]["fecha_pago"];
                    //---------------------------------------------------------
                    $nom_actividad = "No Aplica";

                    echo '
	                             <tr';if (is_null($pagado) || $pagado == '' || $pagado == 0) {
                        # code...
                        echo ' style="background-color: red;" ';
                    }
                    echo '>

	                                 <td>' . $externo . '</td>
	                                 <td>' . $descripcion . '</td>
	                                 <td>' . $fecha_pago_limite . '</td>
	                                 <td>' . '$' . number_format($valor, 0, '', '.') . '</td>
	                                 <td>' . $observaciones . '</td>
	                                 <td>' . $nom_actividad . '</td>
			                     </tr>';
                };

            }
            //---------------------------------------------------------------------------------------------------------

        } elseif (($this->gastoProyectoNoAct) && ($consultaP == 1)) {

            for ($a = 0; $a < sizeof($this->gastoProyectoNoAct); $a++) {

                $id                = $this->gastoProyectoNoAct[$a]["pkID"];
                $empresa           = $this->gastoProyectoNoAct[$a]["nom_empresa"];
                $externo           = $this->gastoProyectoNoAct[$a]["nom_externo"];
                $descripcion       = $this->gastoProyectoNoAct[$a]["descripcion"];
                $fecha_pago_limite = $this->gastoProyectoNoAct[$a]["fecha_pago_limite"];
                $valor             = $this->gastoProyectoNoAct[$a]["valor"];
                $observaciones     = $this->gastoProyectoNoAct[$a]["observaciones"];
                //---------------------------------------------------------
                $aprobado   = $this->gastoProyectoNoAct[$a]["aprobado"];
                $pagado     = $this->gastoProyectoNoAct[$a]["pagado"];
                $fecha_pago = $this->gastoProyectoNoAct[$a]["fecha_pago"];
                //---------------------------------------------------------
                $nom_actividad = "No Aplica";

                echo '
                             <tr';if (is_null($pagado) || $pagado == '' || $pagado == 0) {
                    # code...
                    echo ' style="background-color: red;" ';
                }
                echo '>

                                 <td>' . $externo . '</td>
                                 <td>' . $descripcion . '</td>
                                 <td>' . $fecha_pago_limite . '</td>
                                 <td>' . '$' . number_format($valor, 0, '', '.') . '</td>
                                 <td>' . $observaciones . '</td>
                                 <td>' . $nom_actividad . '</td>
		                     </tr>';
            };

        } elseif (($this->gasto) && ($consulta == 0)) {

            echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-exclamation-sign'></span> En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Gastos De este Proyecto.</strong>
				   </div>";
        } else {

            echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		           </tr>

		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-alert'></span> En este momento no hay gastos relacionados para este proyecto.
				   </div>";
        };
        //---------------------------------------------------------------------------------

    }
    //---------------------------------------------------------------------------------

    public function getSumagastosVal($filtro)
    {

        if ($filtro == '*') {
            # code...
            $suma = $this->getSumagastos();
        } else {
            # code...
            $suma = $this->getSumagastosFiltro($filtro);
        }

        echo number_format($suma[0]['total_gastos'], 0, '', '.');
    }

    public function getSumaValPago($filtro)
    {

        if ($filtro == '*') {
            # code...
            $suma = $this->getSumaPagos();
        } else {
            # code...
            $suma = $this->getSumaPagosFiltro($filtro);
        }

        echo number_format($suma[0]['total_pagos'], 0, '', '.');
    }
    public function getSumagastosValProyecto($pkID_proyecto)
    {

        $suma = $this->getSumagastosProyecto($pkID_proyecto);

        echo number_format($suma[0]['total_gastos'], 0, '', '.');
    }

    //consulta filtro

    /*
    select gasto_gral.*, empresa.nombre as nom_empresa, externo.nombre nom_externo FROM `gasto_gral` INNER JOIN empresa ON empresa.pkID = gasto_gral.fkID_empresa INNER JOIN externo ON externo.pkID = gasto_gral.fkID_externo WHERE gasto_gral.fkID_empresa = 1 AND gasto_gral.aprobado = 0 AND gasto_gral.pagado = 1
     */

    public function getTablagastos_gralFuntecso($filtro)
    {

        //------------------------------------------------------------------------------------------------

        if ($filtro == '*') {
            # code...
            $this->gasto = $this->getGastosFuntecso();

        } else {

            # code...
            $cambio       = array("AND", "gasto_gral.");
            $campos_str   = str_replace($cambio, "", $filtro);
            $arr_campos   = explode(" ", $campos_str);
            $arr_completo = array();
            //print_r ($arr_campos);

            echo "<p>Filtrando por:</p>";

            for ($i = 0; $i < sizeof($arr_campos); $i++) {
                # code...
                //echo $arr_campos[$i].'<br>';

                $arr_campos1 = explode("=", $arr_campos[$i]);

                /*print_r($arr_campos1);
                echo "<br><br>";
                echo "<br><br>";
                 */
                /*if ($arr_campos1[0] == "fkID_empresa") {
                # code...
                $empresaId = $this->getEmpresasId($arr_campos1[1]);

                //print_r($empresaId);

                echo "<span class='badge'>Empresa:".$empresaId[0]["nombre"]."</span>";
                }*/

                if ($arr_campos1[0] == "aprobado") {

                    if ($arr_campos1[1] == "0") {
                        # code...
                        echo "<span class='badge'>Aprobado:No</span>";
                    } else {
                        echo "<span class='badge'>Aprobado:Sí</span>";
                    }
                }

                if ($arr_campos1[0] == "pagado") {

                    if ($arr_campos1[1] == "0") {
                        # code...
                        echo "<span class='badge'>Pagado:No</span>";
                    } else {
                        echo "<span class='badge'>Pagado:Sí</span>";
                    }
                }
                if ($arr_campos1[0] == "fecha_aprobacion") {
                    # code...
                    //$fecha = $this->getFechasAp($arr_campos1[1]);

                    //print_r($fecha);
                    //echo "<br><br>";
                    //print_r($arr_campos1[1]);
                    //echo "<br><br>";

                    echo "<span class='badge'>Fecha de aprobacion:" . $arr_campos1[1] . "</span>";
                }
                if ($arr_campos1[0] == "aniog") {
                    # code...
                    //$fecha = $this->getFechasAp($arr_campos1[1]);

                    //print_r($fecha);
                    //echo "<br><br>";
                    //print_r($arr_campos1[1]);
                    //echo "<br><br>";

                    echo "<span class='badge'>Año:" . $arr_campos1[1] . "</span>";
                }

            }
            /*echo "<br><br>";
            print_r($filtro);    */
            echo "<br> <br>";

            $this->gasto = $this->getGastosFiltroFuntecso($filtro);
            //print_r($this->gasto);

        }

        //print_r($formatosNoSub);
        //mete los formatos sin subcategoria
        //array_merge($this->Formatos, $formatosNoSub);

        //print_r($this->Formatos);

        //valida si hay formatos

        //permisos-------------------------------------------------------------------------
        $arrPermisos = $this->permisos($this->id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);
        $edita       = $arrPermisos[0]["editar"];
        $elimina     = $arrPermisos[0]["eliminar"];
        $consulta    = $arrPermisos[0]["consultar"];
        //echo "Consulta:".$consulta;
        //---------------------------------------------------------------------------------

        if (($this->gasto) && ($consulta == 1)) {

            for ($a = 0; $a < sizeof($this->gasto); $a++) {

                $id                = $this->gasto[$a]["pkID"];
                $empresa           = $this->gasto[$a]["nom_empresa"];
                $externo           = $this->gasto[$a]["nom_externo"];
                $descripcion       = $this->gasto[$a]["descripcion"];
                $fecha_pago_limite = $this->gasto[$a]["fecha_pago_limite"];
                $valor             = $this->gasto[$a]["valor"];
                $pago              = $this->gasto[$a]["pago"];
                $diferencia        = $this->gasto[$a]["diferencia"];
                $observaciones     = $this->gasto[$a]["observaciones"];
                //---------------------------------------------------------
                $aprobado         = $this->gasto[$a]["aprobado"];
                $pagado           = $this->gasto[$a]["pagado"];
                $fecha_pago       = $this->gasto[$a]["fecha_pago"];
                $fecha_aprobacion = $this->gasto[$a]["fecha_aprobacion"];
                //---------------------------------------------------------

                echo '<tr';if (is_null($pagado) || $pagado == '' || $pagado == 0) {
                    # code...
                    echo ' style="background-color: red;" ';
                }
                echo '>
                             	 <td>' . $empresa . '</td>
                                 <td>' . $externo . '</td>
                                 <td>' . $descripcion . '</td>
                                 <td hidden=true>' . $valor . '</td>
                                 <td>' . $fecha_pago_limite . '</td>
                                 <td>' . '$' . number_format($valor, 0, '', '.') . '</td>
                                 <td>' . '$' . number_format($pago, 0, '', '.') . '</td>
                                 <td>' . '$' . number_format($diferencia, 0, '', '.') . '</td>
                                 <td>' . $observaciones . '</td>
                                 <td>' . $aprobado . '</td>
                                 <td>' . $pagado . '</td>
                                 <td>' . $fecha_pago . '</td>
                                 <td>' . $fecha_aprobacion . '</td>
		                         <td>
		                             <button id="btn_editar" title="Editar" name="edita_gasto_gral" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_gasto_gral" data-id-gasto_gral = "' . $id . '" ';if ($edita != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-pencil"></span></button>
		                             <button id="btn_eliminar" title="Eliminar" name="elimina_gasto_gral" type="button" class="btn btn-danger" data-id-gasto_gral = "' . $id . '" ';if ($elimina != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-remove"></span></button>
		                             <button id="btn_aprobar" title="Aprobar" name="aprobar_gasto_gral" type="button" class="btn btn-primary" data-id-gasto_gral = "' . $id . '" ';if (($_COOKIE["log_lunelAdmin_IDtipo"] == 3) || ($_COOKIE["log_lunelAdmin_IDtipo"] == 1)) {echo '';} else {echo 'style="display: none;"';};if (is_null($aprobado) || $aprobado == '' || $aprobado == 0) {echo '';} else {echo 'style="display: none;"';};
                echo '><span class="glyphicon glyphicon-ok"></span></button>
		                         </td>
		                     </tr>';
            };

        } elseif (($this->gasto) && ($consulta == 0)) {

            echo "<tr>
             		   <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-exclamation-sign'></span> En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Gastos General.</strong>
				   </div>";
        } else {

            echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		           </tr>

		           <div class='alert alert-danger' role='alert'>
		           		<span class='glyphicon glyphicon-alert'></span> En este momento no hay gastos creados o no se encuentran en este filtro.
				   </div>";
        };

    }

    public function getTablagastos_gralProco($filtro)
    {

        //------------------------------------------------------------------------------------------------

        if ($filtro == '*') {
            # code...
            $this->gasto = $this->getGastosProco();

        } else {

            # code...
            $cambio       = array("AND", "gasto_gral.");
            $campos_str   = str_replace($cambio, "", $filtro);
            $arr_campos   = explode(" ", $campos_str);
            $arr_completo = array();
            //print_r ($arr_campos);

            echo "<p>Filtrando por:</p>";

            for ($i = 0; $i < sizeof($arr_campos); $i++) {
                # code...
                //echo $arr_campos[$i].'<br>';

                $arr_campos1 = explode("=", $arr_campos[$i]);

                /*print_r($arr_campos1);
                echo "<br><br>";
                echo "<br><br>";
                 */
                /*if ($arr_campos1[0] == "fkID_empresa") {
                # code...
                $empresaId = $this->getEmpresasId($arr_campos1[1]);

                //print_r($empresaId);

                echo "<span class='badge'>Empresa:".$empresaId[0]["nombre"]."</span>";
                }*/

                if ($arr_campos1[0] == "aprobado") {

                    if ($arr_campos1[1] == "0") {
                        # code...
                        echo "<span class='badge'>Aprobado:No</span>";
                    } else {
                        echo "<span class='badge'>Aprobado:Sí</span>";
                    }
                }

                if ($arr_campos1[0] == "pagado") {

                    if ($arr_campos1[1] == "0") {
                        # code...
                        echo "<span class='badge'>Pagado:No</span>";
                    } else {
                        echo "<span class='badge'>Pagado:Sí</span>";
                    }
                }
                if ($arr_campos1[0] == "fecha_aprobacion") {
                    # code...
                    //$fecha = $this->getFechasAp($arr_campos1[1]);

                    //print_r($fecha);
                    //echo "<br><br>";
                    //print_r($arr_campos1[1]);
                    //echo "<br><br>";

                    echo "<span class='badge'>Fecha de aprobacion:" . $arr_campos1[1] . "</span>";
                }
                if ($arr_campos1[0] == "aniog") {
                    # code...
                    //$fecha = $this->getFechasAp($arr_campos1[1]);

                    //print_r($fecha);
                    //echo "<br><br>";
                    //print_r($arr_campos1[1]);
                    //echo "<br><br>";

                    echo "<span class='badge'>Año:" . $arr_campos1[1] . "</span>";
                }

            }
            /*echo "<br><br>";
            print_r($filtro);    */
            echo "<br> <br>";

            $this->gasto = $this->getGastosFiltroProco($filtro);
            //print_r($this->gasto);

        }

        //print_r($formatosNoSub);
        //mete los formatos sin subcategoria
        //array_merge($this->Formatos, $formatosNoSub);

        //print_r($this->Formatos);

        //valida si hay formatos

        //permisos-------------------------------------------------------------------------
        $arrPermisos = $this->permisos($this->id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);
        $edita       = $arrPermisos[0]["editar"];
        $elimina     = $arrPermisos[0]["eliminar"];
        $consulta    = $arrPermisos[0]["consultar"];
        //echo "Consulta:".$consulta;
        //---------------------------------------------------------------------------------

        if (($this->gasto) && ($consulta == 1)) {

            for ($a = 0; $a < sizeof($this->gasto); $a++) {

                $id                = $this->gasto[$a]["pkID"];
                $empresa           = $this->gasto[$a]["nom_empresa"];
                $externo           = $this->gasto[$a]["nom_externo"];
                $descripcion       = $this->gasto[$a]["descripcion"];
                $fecha_pago_limite = $this->gasto[$a]["fecha_pago_limite"];
                $valor             = $this->gasto[$a]["valor"];
                $pago              = $this->gasto[$a]["pago"];
                $diferencia        = $this->gasto[$a]["diferencia"];
                $observaciones     = $this->gasto[$a]["observaciones"];
                //---------------------------------------------------------
                $aprobado         = $this->gasto[$a]["aprobado"];
                $pagado           = $this->gasto[$a]["pagado"];
                $fecha_pago       = $this->gasto[$a]["fecha_pago"];
                $fecha_aprobacion = $this->gasto[$a]["fecha_aprobacion"];
                //---------------------------------------------------------

                echo '<tr';if (is_null($pagado) || $pagado == '' || $pagado == 0) {
                    # code...
                    echo ' style="background-color: red;" ';
                }
                echo '>
                                 <td>' . $empresa . '</td>
                                 <td>' . $externo . '</td>
                                 <td>' . $descripcion . '</td>
                                 <td hidden=true>' . $valor . '</td>
                                 <td>' . $fecha_pago_limite . '</td>
                                 <td>' . '$' . number_format($valor, 0, '', '.') . '</td>
                                 <td>' . '$' . number_format($pago, 0, '', '.') . '</td>
                                 <td>' . '$' . number_format($diferencia, 0, '', '.') . '</td>
                                 <td>' . $observaciones . '</td>
                                 <td>' . $aprobado . '</td>
                                 <td>' . $pagado . '</td>
                                 <td>' . $fecha_pago . '</td>
                                 <td>' . $fecha_aprobacion . '</td>
                                 <td>
                                     <button id="btn_editar" title="Editar" name="edita_gasto_gral" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_gasto_gral" data-id-gasto_gral = "' . $id . '" ';if ($edita != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-pencil"></span></button>
                                     <button id="btn_eliminar" title="Eliminar" name="elimina_gasto_gral" type="button" class="btn btn-danger" data-id-gasto_gral = "' . $id . '" ';if ($elimina != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-remove"></span></button>
                                     <button id="btn_aprobar" title="Aprobar" name="aprobar_gasto_gral" type="button" class="btn btn-primary" data-id-gasto_gral = "' . $id . '" ';if (($_COOKIE["log_lunelAdmin_IDtipo"] == 3) || ($_COOKIE["log_lunelAdmin_IDtipo"] == 1)) {echo '';} else {echo 'style="display: none;"';};if (is_null($aprobado) || $aprobado == '' || $aprobado == 0) {echo '';} else {echo 'style="display: none;"';};
                echo '><span class="glyphicon glyphicon-ok"></span></button>
                                 </td>
                             </tr>';
            };

        } elseif (($this->gasto) && ($consulta == 0)) {

            echo "<tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                   </tr>
                   <div class='alert alert-danger' role='alert'>
                        <span class='glyphicon glyphicon-exclamation-sign'></span> En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Gastos General.</strong>
                   </div>";
        } else {

            echo "<tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                   </tr>

                   <div class='alert alert-danger' role='alert'>
                        <span class='glyphicon glyphicon-alert'></span> En este momento no hay gastos creados o no se encuentran en este filtro.
                   </div>";
        };

    }

    public function getSelectFechasFiltroFuntecso()
    {

        $fechasSelect = $this->getFechasFuntecso();

        echo '<select name="fechas_filtro" id="fechas_filtro" class="form-control">
                        <option value="">Todo</option>';
        for ($i = 0; $i < sizeof($fechasSelect); $i++) {
            echo '<option value="\'' . $fechasSelect[$i]["fecha_aprobacion"] . '\'" >' . $fechasSelect[$i]["fecha_aprobacion"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectFechasFiltroProco()
    {

        $fechasSelect = $this->getFechasProco();

        echo '<select name="fechas_filtro" id="fechas_filtro" class="form-control">
                        <option value="">Todo</option>';
        for ($i = 0; $i < sizeof($fechasSelect); $i++) {
            echo '<option value="\'' . $fechasSelect[$i]["fecha_aprobacion"] . '\'" >' . $fechasSelect[$i]["fecha_aprobacion"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectProyectosFuntecso()
    {

        $proyectoSelect = $this->getProyectosFuntecso();

        echo '<select name="fuente_filtro" id="fuente_filtro" class="form-control">
                        <option></option>';
        for ($i = 0; $i < sizeof($proyectoSelect); $i++) {
            echo '<option value="' . $proyectoSelect[$i]["pkID"] . '" >' . $proyectoSelect[$i]["nom_entidad"] . ' : ' . $proyectoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectProyectosProco()
    {

        $proyectoSelect = $this->getProyectosProco();

        echo '<select name="fuente_filtro" id="fuente_filtro" class="form-control">
                        <option></option>';
        for ($i = 0; $i < sizeof($proyectoSelect); $i++) {
            echo '<option value="' . $proyectoSelect[$i]["pkID"] . '" >' . $proyectoSelect[$i]["nom_entidad"] . ' : ' . $proyectoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSumagastosValFuntecso($filtro)
    {

        if ($filtro == '*') {
            # code...
            $suma = $this->getSumaGastosFuntecso();
        } else {
            # code...
            $suma = $this->getSumaGastosFiltroFuntecso($filtro);
        }

        echo number_format($suma[0]['total_gastos'], 0, '', '.');
    }

    public function     getSumagastosValProco($filtro)
    {

        if ($filtro == '*') {
            # code...
            $suma = $this->getSumaGastosProco();
        } else {
            # code...
            $suma = $this->getSumaGastosFiltroProco($filtro);
        }

        echo number_format($suma[0]['total_gastos'], 0, '', '.');
    }

    public function getSumaValPagosFuntecso($filtro)
    {

        if ($filtro == '*') {
            # code...
            $suma = $this->getSumaPagosFuntecso();
        } else {
            # code...
            $suma = $this->getSumaPagosFiltroFuntecso($filtro);
        }

        echo number_format($suma[0]['total_pagos'], 0, '', '.');
    }

    public function getSumaValPagosProco($filtro)
    {

        if ($filtro == '*') {
            # code...
            $suma = $this->getSumaPagosProco();
        } else {
            # code...
            $suma = $this->getSumaPagosFiltroProco($filtro);
        }

        echo number_format($suma[0]['total_pagos'], 0, '', '.');
    }
}
