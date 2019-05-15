<?php

include '../DAO/HvidaDAO.php';

class HvidaController extends hvida
{

    //-------------------------------------
    //variables
    public $hvida;
    public $personal;
    public $id_modulo;
    //-------------------------------------
    public function __construct()
    {

        //include('../conexion/datos.php');

        //$this->id_modulo = --; id de la tabla modulos
        //$this->NameCookieApp = $NomCookiesApp;
        $this->id_modulo = 1;
    }
    //---------------------------------------------------------------------------------

    //Consulta la tabla ciudad
    public function selectCiudad()
    {

        $ciudadSelect = $this->getCiudad();

        echo '<option value="">Seleccione...</option>';

        for ($i = 0; $i < sizeof($ciudadSelect); $i++) {

            echo '<option value="' . $ciudadSelect[$i]["pkID"] . '">' . $ciudadSelect[$i]["nombre"] . '</option>';
        };
    }

    public function numHojas()
    {

        $numHojas = $this->getNumHojas();

        echo $numHojas[0]["numHojas"];
    }

    public function getSelectTecnico()
    {

        $tecnicoSelect = $this->getTecnico();

        echo '<select name="selectEstudioTecnico" id="selectEstudioTecnico" class="form-control" required = "true">
                        <option></option>';
        for ($i = 0; $i < sizeof($tecnicoSelect); $i++) {
            echo '<option value="' . $tecnicoSelect[$i]["pkID"] . '" data-nom-estudio="' . $tecnicoSelect[$i]["nombre"] . '" data-nom-tipoestudio="' . $tecnicoSelect[$i]["nom_tipo_estudio"] . '">' . $tecnicoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectTecnicoBusqueda()
    {

        $tecnicoSelect = $this->getTecnico();

        echo '<select name="selectEstudioTecnicoBusqueda" id="selectEstudioTecnicoBusqueda" class="form-control" required = "true">
                        <option></option>';
        for ($i = 0; $i < sizeof($tecnicoSelect); $i++) {
            echo '<option value="' . $tecnicoSelect[$i]["pkID"] . '" data-nom-estudio="' . $tecnicoSelect[$i]["nombre"] . '" data-nom-tipoestudio="' . $tecnicoSelect[$i]["nom_tipo_estudio"] . '">' . $tecnicoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }
    public function getSelectTecnologo()
    {

        $tecnologoSelect = $this->getTecnologo();

        echo '<select name="selectEstudioTecnologo" id="selectEstudioTecnologo" class="form-control" required = "true">
                        <option></option>';
        for ($i = 0; $i < sizeof($tecnologoSelect); $i++) {
            echo '<option value="' . $tecnologoSelect[$i]["pkID"] . '" data-nom-estudio="' . $tecnologoSelect[$i]["nombre"] . '" data-nom-tipoestudio="' . $tecnologoSelect[$i]["nom_tipo_estudio"] . '">' . $tecnologoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectTecnologoBusqueda()
    {

        $tecnologoSelect = $this->getTecnologo();

        echo '<select name="selectEstudioTecnologoBusqueda" id="selectEstudioTecnologoBusqueda" class="form-control" required = "true">
                        <option></option>';
        for ($i = 0; $i < sizeof($tecnologoSelect); $i++) {
            echo '<option value="' . $tecnologoSelect[$i]["pkID"] . '" data-nom-estudio="' . $tecnologoSelect[$i]["nombre"] . '" data-nom-tipoestudio="' . $tecnologoSelect[$i]["nom_tipo_estudio"] . '">' . $tecnologoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectPregrado()
    {

        $pregradoSelect = $this->getPregrado();

        echo '<select name="selectEstudio" id="selectEstudio" class="form-control" required = "true">
                        <option></option>';
        for ($i = 0; $i < sizeof($pregradoSelect); $i++) {
            echo '<option value="' . $pregradoSelect[$i]["pkID"] . '" data-nom-estudio="' . $pregradoSelect[$i]["nombre"] . '" data-nom-tipoestudio="' . $pregradoSelect[$i]["nom_tipo_estudio"] . '">' . $pregradoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectPregradoBusqueda()
    {

        $pregradoSelect = $this->getPregrado();

        echo '<select name="selectEstudioPregradoBusqueda" id="selectEstudioPregradoBusqueda" class="form-control" required = "true">
                        <option></option>';
        for ($i = 0; $i < sizeof($pregradoSelect); $i++) {
            echo '<option value="' . $pregradoSelect[$i]["pkID"] . '" data-nom-estudio="' . $pregradoSelect[$i]["nombre"] . '" data-nom-tipoestudio="' . $pregradoSelect[$i]["nom_tipo_estudio"] . '">' . $pregradoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectPosgrado()
    {

        $posgradoSelect = $this->getPosgrado();

        echo '<select name="selectEstudioPos" id="selectEstudioPos" class="form-control">
                        <option></option>';
        for ($i = 0; $i < sizeof($posgradoSelect); $i++) {
            echo '<option value="' . $posgradoSelect[$i]["pkID"] . '" data-nom-estudio="' . $posgradoSelect[$i]["nombre"] . '" data-nom-tipoestudio="' . $posgradoSelect[$i]["nom_tipo_estudio"] . '">' . $posgradoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectPosgradoBusqueda()
    {

        $posgradoSelect = $this->getPosgrado();

        echo '<select name="selectEstudioPosgradoBusqueda" id="selectEstudioPosgradoBusqueda" class="form-control">
                        <option></option>';
        for ($i = 0; $i < sizeof($posgradoSelect); $i++) {
            echo '<option value="' . $posgradoSelect[$i]["pkID"] . '" data-nom-estudio="' . $posgradoSelect[$i]["nombre"] . '" data-nom-tipoestudio="' . $posgradoSelect[$i]["nom_tipo_estudio"] . '">' . $posgradoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectCertificacion()
    {

        $certificacionSelect = $this->getCertificacion();

        echo '<select name="selectEstudioCertificacion" id="selectEstudioCertificacion" class="form-control">
                        <option></option>';
        for ($i = 0; $i < sizeof($certificacionSelect); $i++) {
            echo '<option value="' . $certificacionSelect[$i]["pkID"] . '" data-nom-estudio="' . $certificacionSelect[$i]["nombre"] . '" data-nom-tipoestudio="' . $certificacionSelect[$i]["nom_tipo_estudio"] . '">' . $certificacionSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectCertificacionBusqueda()
    {

        $certificacionSelect = $this->getCertificacion();

        echo '<select name="selectEstudioCertificacionBusqueda" id="selectEstudioCertificacionBusqueda" class="form-control">
                        <option></option>';
        for ($i = 0; $i < sizeof($certificacionSelect); $i++) {
            echo '<option value="' . $certificacionSelect[$i]["pkID"] . '" data-nom-estudio="' . $certificacionSelect[$i]["nombre"] . '" data-nom-tipoestudio="' . $certificacionSelect[$i]["nom_tipo_estudio"] . '">' . $certificacionSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }
    //------------------------------------------------------------------------------------

    public function getSelectPregradoS()
    {

        $pregradoSelect = $this->getPregrado();

        echo '<select name="searchEstudio" id="searchEstudio" class="form-control">
                        <option></option>';
        for ($i = 0; $i < sizeof($pregradoSelect); $i++) {
            echo '<option value="' . $pregradoSelect[$i]["pkID"] . '" data-nom-estudio="' . $pregradoSelect[$i]["nombre"] . '" data-nom-tipoestudio="' . $pregradoSelect[$i]["nom_tipo_estudio"] . '">' . $pregradoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getSelectPosgradoS()
    {

        $posgradoSelect = $this->getPosgrado();

        echo '<select name="searchEstudioPos" id="searchEstudioPos" class="form-control">
                        <option></option>';
        for ($i = 0; $i < sizeof($posgradoSelect); $i++) {
            echo '<option value="' . $posgradoSelect[$i]["pkID"] . '" data-nom-estudio="' . $posgradoSelect[$i]["nombre"] . '" data-nom-tipoestudio="' . $posgradoSelect[$i]["nom_tipo_estudio"] . '">' . $posgradoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    //------------------------------------------------------------------------------------

    //---------------------------------------------------------------------------------
    //Funciones detalles hoja de vida

    public function getHvidaTitulo($id_hoja)
    {

        $hojaDeVida = $this->getHvidaId($id_hoja);

        $estudiosHvida = $this->getEstudioId($id_hoja);

        //print_r($hojaDeVida);

        echo '<div class="panel panel-default titulo-barra-amarilla">
                    <div class="icono_hvs-foto"></div>
                      <div class="panel-body titulo-hvs-det-fot">
                        ' . $hojaDeVida[0]['nombre'] . ' ' . $hojaDeVida[0]['apellido'] . '<br>' . $estudiosHvida[0]["nombre"] . '
                      </div>
                    </div>
    			</div>';
    }

    public function getHvidaDatosGen($id_hoja)
    {

        $hojaDeVida = $this->getHvidaId($id_hoja);

        //print_r($hojaDeVida);

        echo "<div class='icono_dgenerales'></div><h3>Datos Generales</h3>";

        if ($hojaDeVida > 0) {

            echo '<ul class="list-group">
	    			      <li class="list-group-item"><strong>Número de Identificación</strong>: ' . $hojaDeVida[0]["nidentificacion"] . '</li>
	                      <li class="list-group-item"><strong>Nombre</strong>: ' . $hojaDeVida[0]["nombre"] . ' </li>
	                      <li class="list-group-item"><strong>Apellido</strong>: ' . $hojaDeVida[0]["apellido"] . '</li>
	                      <li class="list-group-item"><strong>Teléfono</strong>: ' . $hojaDeVida[0]["telefono"] . '</li>
	                      <li class="list-group-item"><strong>Email</strong>: ' . $hojaDeVida[0]["email"] . '</li>
	                      <li class="list-group-item"><strong>Estado</strong>: ' . $hojaDeVida[0]["nom_estado"] . '</li>
	                    </ul>
	            ';

        } else {

            echo "<div class='alert alert-warning' role='alert'>
  						Esta persona no tiene Datos generales.
				   	  </div>";
        }
    }

    public function getEstudiosHvidaId($id_hoja)
    {

        $estudiosHvida = $this->getEstudioId($id_hoja);

        //print_r($estudiosHvida);

        echo "<div class='icono_destudios'></div><h3>Estudios</h3>";

        if ($estudiosHvida > 0) {

            for ($i = 0; $i < sizeof($estudiosHvida); $i++) {

                echo '<ul class="list-group">
		                      <li class="list-group-item"><strong>Nombre</strong>: ' . $estudiosHvida[$i]["nombre"] . ' </li>
		                      <li class="list-group-item"><strong>Tipo</strong>: ' . $estudiosHvida[$i]["nom_tipoEstudio"] . '</li>
		                    </ul>
		            ';
            }

        } else {
            echo "<div class='alert alert-warning' role='alert'>
  						Esta persona no tiene estudios relacionados.
				   	  </div>";
        }

    }

    public function getArchivosHvidaId($id_hoja)
    {

        $archivosHvida = $this->getArchivosId($id_hoja);

        //print_r($archivosHvida);

        echo "<h3>&nbsp;&nbsp;&nbsp;&nbsp;Archivos</h3>";

        if ($archivosHvida > 0) {

            for ($i = 0; $i < sizeof($archivosHvida); $i++) {

                echo '<blockquote>';

                echo '<p><a href="../server/php/files/' . $archivosHvida[$i]["url_archivo"] . '" target="_blank"><span class="glyphicon glyphicon-file"></span> ' . $archivosHvida[$i]["url_archivo"] . '</a></p>
							<small><span class="glyphicon glyphicon-comment"></span> ' . $archivosHvida[$i]["des_archivo"] . '</small>
			    		';

                echo '</blockquote>';
            }

        } else {

            echo "<div class='alert alert-warning' role='alert'>
  						Esta hoja de vida no tiene archivos.
				   	  </div>";
        }

    }

    public function getTablaPersonalProyecto($pkID_proyecto)
    {

        $this->personal = $this->getPersonalProyecto($pkID_proyecto);

        //print_r($this->personal);

        //permisos-------------------------------------------------------------------------
        $arrPermisos      = $this->permisos(11, $_COOKIE["log_lunelAdmin_IDtipo"]);
        $editaPersonal    = $arrPermisos[0]["editar"];
        $eliminaPersonal  = $arrPermisos[0]["eliminar"];
        $consultaPersonal = $arrPermisos[0]["consultar"];
        //---------------------------------------------------------------------------------

        if (($this->personal) && ($consultaPersonal == 1)) {

            for ($a = 0; $a < sizeof($this->personal); $a++) {

                $id              = $this->personal[$a]["fkID_hv"];
                $nidentificacion = $this->personal[$a]["nidentificacion"];
                $nombre          = $this->personal[$a]["nombre"];
                $apellido        = $this->personal[$a]["apellido"];
                $telefono        = $this->personal[$a]["telefono"];
                $email           = $this->personal[$a]["email"];
                //$url_archivo = $this->hvida[$a]["url_archivo"];
                //$nom_estado = $this->hvida[$a]["nom_estado"];
                //$usuario = $this->hvida[$a]["alias"];
                $rol           = $this->personal[$a]["rol"];
                $observaciones = $this->personal[$a]["observaciones"];

                echo '
                             <tr>

                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $nidentificacion . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $nombre . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $apellido . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $telefono . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $email . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $rol . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $observaciones . '</td>
		                         <td>
		                             <button id="btn_editarpersonal" title="Editar" name="edita_hv_proyecto" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_personal" data-id-hv-proyecto = "' . $id . '" ';if ($editaPersonal != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-pencil"></span></button>

		                             <button id="btn_eliminarpersonal" title="Eliminar" name="elimina_hv_proyecto" type="button" class="btn btn-danger" data-id-hv-proyecto = "' . $id . '" ';if ($eliminaPersonal != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td>
		                     </tr>';
            };

        } elseif (($this->presupuesto) && ($consultaPersonal == 0)) {

            echo "<tr>

		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Proyectos/Personal.</strong>
				   </div>";
        } else {

            echo "<tr>

		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		En este momento no hay <strong>Personal</strong> asignado a este <strong>Proyecto.</strong>
				   </div>";
        };
    }

    public function getSelectEstado()
    {

        $estadoSelect = $this->getEstado();

        echo '<select name="estado_filtro" id="estado_filtro" class="form-control">
                        <option></option>';
        for ($i = 0; $i < sizeof($estadoSelect); $i++) {
            echo '<option value="' . $estadoSelect[$i]["pkID"] . '">' . $estadoSelect[$i]["nombre"] . '</option>';
        };
        echo '</select>';
    }

    public function getTablahvida($filtro)
    {

        //------------------------------------------------------------------------------------------------

        if ($filtro == '*' || $filtro == '') {

            $tipoUsuario = $_COOKIE['log_lunelAdmin_IDtipo'];
            if ($tipoUsuario == 13) {
                $this->hvida = $this->getHvidaFuntecso();
            } else {
                $this->hvida = $this->getHvida();
            }

        } else {

            # code...
            $cambio = array("AND", "hoja_vida.");

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
                echo "<br><br>";*/

                if ($arr_campos1[0] == "fkID_estado") {
                    # code...
                    $estadoId = $this->getEstadoId($arr_campos1[1]);

                    //print_r($estadoId);

                    echo "<span class='badge'>Estado:" . $estadoId[0]["nombre"] . "</span>";
                }

            }
            /*echo "<br><br>";
            print_r($filtro);    */
            echo "<br> <br>";

            if ($tipoUsuario == 13) {
                $this->hvida = $this->getHvidaFiltroFuntecso();
            } else {
                $this->hvida = $this->getHvidaFiltro($filtro);
            }

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
        //---------------------------------------------------------------------------------

        //valida si hay hojas de vida
        if (($this->hvida) && ($consulta == 1)) {

            for ($a = 0; $a < sizeof($this->hvida); $a++) {

                $id         = $this->hvida[$a]["pkID"];
                $nombres    = $this->hvida[$a]["nombres"];
                $telefono   = $this->hvida[$a]["telefono"];
                $nom_estado = $this->hvida[$a]["nom_estado"];

                //Consulta los estudios de tipo tecnico
                $tecnico      = '';
                $arrayTecnico = $this->getEstudiosFK($id, 8);
                for ($b = 0; $b < sizeof($arrayTecnico); $b++) {
                    $tecnico .= $arrayTecnico[$b]["nombre"] . '<br>';
                }

                //Consulta los estudios de tipo tecnologo
                $tecnologo      = '';
                $arrayTecnologo = $this->getEstudiosFK($id, 9);
                for ($b = 0; $b < sizeof($arrayTecnologo); $b++) {
                    $tecnologo .= $arrayTecnologo[$b]["nombre"] . '<br>';
                }

                //Consulta los estudios de tipo pregrado
                $pregrado      = '';
                $arrayPregrado = $this->getEstudiosFK($id, 1);
                for ($b = 0; $b < sizeof($arrayPregrado); $b++) {
                    $pregrado .= $arrayPregrado[$b]["nombre"] . '<br>';
                }

                //Consulta los estudios de tipo certificado
                $posgrado      = '';
                $arrayPosgrado = $this->getEstudiosFK($id, '3 OR fkID_tipoEstudio = 4 OR fkID_tipoEstudio = 5 OR fkID_tipoEstudio = 6');
                for ($b = 0; $b < sizeof($arrayPosgrado); $b++) {
                    $posgrado .= $arrayPosgrado[$b]["nombre"] . '<br>';
                }

                //Consulta los estudios de tipo certificado
                $certificado      = '';
                $arrayCertificado = $this->getEstudiosFK($id, 7);
                for ($b = 0; $b < sizeof($arrayCertificado); $b++) {
                    $certificado .= $arrayCertificado[$b]["nombre"] . '<br>';
                }

                echo '
                             <tr>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $nombres . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $telefono . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $nom_estado . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $tecnico . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $tecnologo . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $pregrado . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $posgrado . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $certificado . '</td>

		                         <td>
		                             <button id="btn_editar" title="Editar" name="edita_hvida" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_hvida" data-id-hvida = "' . $id . '" ';if ($edita != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-pencil"></span></button>

		                             <button id="btn_eliminar" title="Eliminar" name="elimina_hvida" type="button" class="btn btn-danger" data-id-hvida = "' . $id . '" ';if ($elimina != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td>
		                     </tr>';
            };

        } elseif (($this->hvida) && ($consulta == 0)) {

            echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		           </tr>
		           <div class='alert alert-danger' role='alert'>
  						En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Hojas de Vida.</strong>
				   </div>";
        } else {

            echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		           </tr>

		           <div class='alert alert-danger' role='alert'>
  						En este momento no hay <strong>Hojas de Vida.</strong>
				   </div>";
        };

    }

    public function getTablahvidaBusqueda($where, $veces)
    {

        $resultado = $this->getHvidaBusqueda($where, $veces);

        if (sizeof($resultado) > 0) {

            if ($resultado[0]["pkID"] != '') {
                echo '<thead>
                    <tr>
                        <th class="tabla-form-ancho">Nombres</th>
                        <th class="tabla-form-ancho">Teléfono</th>
                        <th class="tabla-form-ancho">Estado</th>
                        <th class="tabla-form-ancho">Tecnico</th>
                        <th class="tabla-form-ancho">Tecnologo</th>
                        <th class="tabla-form-ancho">Pregrado</th>
                        <th class="tabla-form-ancho">Posgrado</th>
                        <th class="tabla-form-ancho">Certificacion</th>
                        <th data-orderable="false">Opciones</th>
                    </tr>
                </thead>';

                //permisos-------------------------------------------------------------------------
                $arrPermisos = $this->permisos($this->id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);
                $edita       = $arrPermisos[0]["editar"];
                $elimina     = $arrPermisos[0]["eliminar"];
                $consulta    = $arrPermisos[0]["consultar"];
                //echo "Consulta:".$consulta;
                //---------------------------------------------------------------------------------

                for ($a = 0; $a < sizeof($resultado); $a++) {
                    $id              = $resultado[$a]["pkID"];
                    $nidentificacion = $resultado[$a]["nidentificacion"];
                    $nombres         = $resultado[$a]["nombres"];
                    $apellido        = $resultado[$a]["apellido"];
                    $telefono        = $resultado[$a]["telefono"];
                    $email           = $resultado[$a]["email"];
                    $nom_estado      = $resultado[$a]["nom_estado"];
                    //Consulta los estudios de tipo tecnico
                    $tecnico      = '';
                    $arrayTecnico = $this->getEstudiosFK($id, 8);
                    for ($b = 0; $b < sizeof($arrayTecnico); $b++) {
                        $tecnico .= $arrayTecnico[$b]["nombre"] . '<br>';
                    }

                    //Consulta los estudios de tipo tecnologo
                    $tecnologo      = '';
                    $arrayTecnologo = $this->getEstudiosFK($id, 9);
                    for ($b = 0; $b < sizeof($arrayTecnologo); $b++) {
                        $tecnologo .= $arrayTecnologo[$b]["nombre"] . '<br>';
                    }

                    //Consulta los estudios de tipo pregrado
                    $pregrado      = '';
                    $arrayPregrado = $this->getEstudiosFK($id, 1);
                    for ($b = 0; $b < sizeof($arrayPregrado); $b++) {
                        $pregrado .= $arrayPregrado[$b]["nombre"] . '<br>';
                    }

                    //Consulta los estudios de tipo certificado
                    $posgrado      = '';
                    $arrayPosgrado = $this->getEstudiosFK($id, '3 OR fkID_tipoEstudio = 4 OR fkID_tipoEstudio = 5 OR fkID_tipoEstudio = 6');
                    for ($b = 0; $b < sizeof($arrayPosgrado); $b++) {
                        $posgrado .= $arrayPosgrado[$b]["nombre"] . '<br>';
                    }

                    //Consulta los estudios de tipo certificado
                    $certificado      = '';
                    $arrayCertificado = $this->getEstudiosFK($id, 7);
                    for ($b = 0; $b < sizeof($arrayCertificado); $b++) {
                        $certificado .= $arrayCertificado[$b]["nombre"] . '<br>';
                    }

                    echo '
                             <tr>

                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $nombres . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $telefono . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $nom_estado . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $tecnico . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $tecnologo . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $pregrado . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $posgrado . '</td>
                                 <td title="Click Ver Detalles" href="hvidaDetalles.php?id_hoja=' . $id . '" class="detail">' . $certificado . '</td>
                                 <td>
                                     <button id="btn_editar" title="Editar" name="edita_hvida" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_hvida" data-id-hvida = "' . $id . '" ';if ($edita != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-pencil"></span></button>

                                     <button id="btn_eliminar" title="Eliminar" name="elimina_hvida" type="button" class="btn btn-danger" data-id-hvida = "' . $id . '" ';if ($elimina != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-remove"></span></button>
                                 </td>
                             </tr>';
                }
            } else {
                echo 'No se encontraron resultados con los criterios de busqueda.';
            }
        } else {
            echo 'No se encontraron resultados con los criterios de busqueda.';
        }
    }

}

if (isset($_REQUEST['arrEstudiosBusqueda'])) {
    //TOMO EL ARRAY
    $estudios = explode(',', $_REQUEST['arrEstudiosBusqueda']);

    if (count($estudios) > 0) {
        $where = "WHERE hoja_estudio.pkID_estudio IN (";
    }

    $veces = 0;
    for ($a = 0; $a < sizeof($estudios); $a++) {
        $where .= $estudios[$a];
        $where .= ",";
        $veces++;
    }

    //Borra parte del string para dejar correcto el query
    $where = substr($where, 0, -1);
    $where = $where . ')';
    //Instancia la clase
    $hvidainst = new HvidaController;
    $hvidainst->getTablahvidaBusqueda($where, $veces);
} else {
    $tipo = '';
}
