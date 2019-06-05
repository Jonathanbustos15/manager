<?php
include '../DAO/RecursosDAO.php';
include '../funciones/NumerosEnLetras.php';

class recursosController extends recursos
{

    //-------------------------------------
    //variables
    public $recurso;
    public $recursos;
    public $recursoId;
    //-------------------------------------
    public $id_modulo;

    public $ruta_visor;

    //-------------------------------------
    public $arr_reporte;
    //-------------------------------------

    public function __construct()
    {
        $this->id_modulo   = 28;
        $this->arr_reporte = array();
    }

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //Consulta los datos para el contrato
    public function getContrato($id_contrato)
    {
        $contrato = $this->getContratoId($id_contrato);

        $resultado = $this->getContratoTipo($contrato);

        return $resultado;
    }

    //Consulta los documentos del empleado.
    public function getDocumentos()
    {
        $cedulaSelect = $this->getCedula();

        echo '<select name="selectCedula" id="selectCedula" class="form-control" required = "true">
                        <option></option>';
        for ($i = 0; $i < sizeof($cedulaSelect); $i++) {
            echo '<option value="' . $cedulaSelect[$i]["pkID"] . '" data-nom-estudio="' . $tecnicoSelect[$i]["nombre"] . '">' . $cedulaSelect[$i]["nidentificacion"] . '</option>';
        };
        echo '</select>';
     }

     //Consulta los tipos de contratos.
     public function getSeleccion_Contrato()
    {
        $cedulaSelect = $this->getTipoContrato();

        echo '<select name="selectC" id="selectC" class="form-control" required = "true">
                        <option value="" selected>Elije el tipo de contrato</option>';
        for ($i = 0; $i < sizeof($cedulaSelect); $i++) {
            echo '<option value="' . $cedulaSelect[$i]["pkID"] . '" data-nom-estudio="' . $tecnicoSelect[$i]["nombre_tipo_contrato"] . '">' . $cedulaSelect[$i]["nombre_tipo_contrato"] . '</option>';
        };
        echo '</select>';
     }

     //Consulta los cargos.
     public function getSeleccion_Cargo()
    {
        $cargoSelect = $this->getCargos();

        echo '<select name="selectCar" id="selectCar" class="form-control" required = "true">
                        <option value="" selected>Elije el cargo</option>';
        for ($i = 0; $i < sizeof($cargoSelect); $i++) {
            echo '<option value="' . $cargoSelect[$i]["pkID"] . '" data-nom-estudio="' . $cargoSelect[$i]["nombre_cargo"] . '">' . $cargoSelect[$i]["nombre_cargo"] . '</option>';
        };
        echo '</select>';
     }

     //Consulta las ARL.
     public function getSeleccion_arl()
    {
        $arlSelect = $this->getArl();

        echo '<select name="selectarl" id="selectarl" class="form-control" required = "true">
                        <option value="">Elije la arl</option>';
        for ($i = 0; $i < sizeof($arlSelect); $i++) {
            echo '<option value="' . $arlSelect[$i]["pkID"] . '" data-nom-estudio="' . $arlSelect[$i]["nomarl"] . '">' . $arlSelect[$i]["nomarl"] . '</option>';
        };
        echo '</select>';
     }

     //Consulta las Eps
     public function getSeleccion_eps()
    {
        $epsSelect = $this->getEps();

        echo '<select name="selecteps" id="selecteps" class="form-control" required = "true">
                        <option value="">Elije la eps</option>';
        for ($i = 0; $i < sizeof($epsSelect); $i++) {
            echo '<option value="' . $epsSelect[$i]["pkID"] . '" data-nom-estudio="' . $epsSelect[$i]["nomeps"] . '">' . $epsSelect[$i]["nomeps"] . '</option>';
        };
        echo '</select>';
     }

     //Consulta la Caja de Compensación
     public function getSeleccion_cajac()
    {
        $cajaSelect = $this->getCajac();

        echo '<select name="selectcaja" id="selectcaja" class="form-control" required = "true">
                        <option value="">Elije la caja de compensación</option>';
        for ($i = 0; $i < sizeof($cajaSelect); $i++) {
            echo '<option value="' . $cajaSelect[$i]["pkID"] . '" data-nom-estudio="' . $cajaSelect[$i]["nomcc"] . '">' . $cajaSelect[$i]["nomcc"] . '</option>';
        };
        echo '</select>';
     }

      //Consulta las Cesantias
     public function getSeleccion_cesantias()
    {
        $cesanSelect = $this->getCesan();

        echo '<select name="selectcesan" id="selectcesan" class="form-control" required = "true">
                        <option value="">Elije las cesantias</option>';
        for ($i = 0; $i < sizeof($cesanSelect); $i++) {
            echo '<option value="' . $cesanSelect[$i]["pkID"] . '" data-nom-estudio="' . $cesanSelect[$i]["nomce"] . '">' . $cesanSelect[$i]["nomce"] . '</option>';
        };
        echo '</select>';
     }

      //Consulta las Pensiones
     public function getSeleccion_pensiones()
    {
        $penSelect = $this->getPens();

        echo '<select name="selectpensi" id="selectpensi" class="form-control" required = "true">
                        <option value="">Elije las pensiones</option>';
        for ($i = 0; $i < sizeof($penSelect); $i++) {
            echo '<option value="' . $penSelect[$i]["pkID"] . '" data-nom-estudio="' . $penSelect[$i]["nompe"] . '">' . $penSelect[$i]["nompe"] . '</option>';
        };
        echo '</select>';
     }

     //Consulta las Pensiones
     public function getSeleccion_departamento()
    {
        $deparSelect = $this->getDepartamento();

        echo '<select name="selectDep" id="selectDep" class="form-control" required = "true">
                        <option value="">Elije el departamento</option>';
        for ($i = 0; $i < sizeof($deparSelect); $i++) {
            echo '<option value="' . $deparSelect[$i]["pkID"] . '" data-nom-estudio="' . $deparSelect[$i]["nombre_departamento"] . '">' . $deparSelect[$i]["nombre_departamento"] . '</option>';
        };
        echo '</select>';
     }

    //Consulta los datos para la certificacion
    public function getCertificacion($id_contrato, $ext)
    {
        $contrato = $this->getContratoId($id_contrato);

        $resultado = $this->getCertificacionTipo($contrato, $ext);

        return $resultado;
    }

    //Funcion para nombre mes
    public function nombreMes($mes)
    {
        switch ($mes) {
            case '1':
                $nombre = 'Enero';
                break;
            case '2':
                $nombre = 'Febrero';
                break;
            case '3':
                $nombre = 'Marzo';
                break;
            case '4':
                $nombre = 'Abril';
                break;
            case '5':
                $nombre = 'Mayo';
                break;
            case '6':
                $nombre = 'Junio';
                break;
            case '7':
                $nombre = 'Julio';
                break;
            case '8':
                $nombre = 'Agosto';
                break;
            case '9':
                $nombre = 'Septiembre';
                break;
            case '10':
                $nombre = 'Octubre';
                break;
            case '11':
                $nombre = 'Noviembre';
                break;
            case '12':
                $nombre = 'Diciembre';
                break;
            default:
                $nombre = 'No hay';
                break;
        }

        return $nombre;
    }

    //Funcion para la ruta del archivo
    public function rutaFondo($empresa)
    {
        //Fondo
        switch ($empresa) {
            case '1':
                $ruta_fondo = "../img/fondo_lunel.jpg";
                break;

            case '12':
                $ruta_fondo = "../img/fondo_servi.jpg";
                break;

            case '3':
                $ruta_fondo = "../img/fondo_ci.jpg";
                break;

            case '4':
                $ruta_fondo = "../img/fondo_imagine.jpg";
                break;

            default:
                $ruta_fondo = "No hay formato";
                break;
        }

        return $ruta_fondo;
    }

    //Verifica el tipo de formato para cambiar ruta de firma
    public function firma($ext)
    {
        switch ($ext) {
            case 'pdf':
                $imagen = '<br><br><img src="../img/firma.png"><br>';
                break;

            case 'word':
                $imagen = '<img src="http://manager.lunel-ie.com/img/firma.png" width="20%"><br>';
                break;

            default:
                $imagen = '<h1>No hay firma</h1>';
                break;
        }

        return $imagen;
    }

    public function getCertificacionTipo($contrato, $ext)
    {

        //Toma el tipo de contrato
        $tipo_contrato = $contrato[0]["fkID_tipoContrato"];
        //Salario en letras
        $salario_letras = NumerosEnLetras::convertir($contrato[0]["salario"]);
        //Pasa a mayusculas
        $salario_letras = strtoupper($salario_letras);

        //Toma el dia, año y mes fecha ingreso
        $dia     = $contrato[0]["dia"];
        $mes_num = $contrato[0]["mes"];
        $anio    = $contrato[0]["anio"];

        //Toma el dia, año y mes fecha terminacion
        $dia_fin     = $contrato[0]["dia_fin"];
        $mes_num_fin = $contrato[0]["mes_fin"];
        $anio_fin    = $contrato[0]["anio_fin"];

        //Nombre mes
        $mes     = $this->nombreMes($mes_num);
        $mes_fin = $this->nombreMes($mes_num_fin);

        //Toma la ruta
        $ruta_fondo = $this->rutaFondo($contrato[0]["fkID_empleador"]);

        $head = '<!DOCTYPE html>
					<html>
					<head>
					<style>
						body {
  							background-image: url("' . $ruta_fondo . '");
  							background-repeat: no-repeat;
						}
					</style>
						<title>' . $ruta_fondo . '</title>
						<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
					</head>
					<body>';

        //Valida la fecha de terminacion
        if ($contrato[0]["dia_fin"] != 0) {
            $laboro    = ' laboró ';
            $fecha_fin = ' al ' . $contrato[0]["dia_fin"] . ' de ' . $mes_fin . ' de ' . $contrato[0]["anio_fin"] . '';
        } else {
            $laboro    = ' labora ';
            $fecha_fin = '';
        }

        $body = '<br/><br/><br/><br/><h3 align="center"><b>' . $contrato[0]["empleador"] . '</b></h3>';

        $body .= '<h3 align="center"><b>NIT: ' . $contrato[0]["nit"] . '</b></h3>';

        $body .= '<h3 align="center"><b>CERTIFICA QUE:</b></h3><br><br><br/><br/>';

        $body .= '<p align="justify">El(La) señor(a) <b>' . $contrato[0]["empleado"] . '</b>, identificado(a) con cedula de ciudadanía No <b>' . $contrato[0]["nidentificacion"] . '</b> de ' . $contrato[0]["ciudad_cedula"] . ', ' . $laboro . ' en nuestra compañía como <b>' . $contrato[0]["cargo"] . '</b>, desde el ' . $contrato[0]["dia"] . ' de ' . $mes . ' de ' . $contrato[0]["anio"] . ' ' . $fecha_fin . ' ,</b> devengando un salario de <b>$(' . number_format($contrato[0]["salario"], 0, '.', '.') . ') ' . $salario_letras . '</b>, mediante un tipo de contrato: <b>' . $contrato[0]["tipo_contrato"] . '.</p><br><br><br><br><br>';

        $imagen = $this->firma($ext);

        $firma = '<b>NATALIA BUITRAGO CASTRO</b><br>
					Departamento de Recursos Humanos<br>
					' . $contrato[0]["empleador"] . '<br>
					NIT: ' . $contrato[0]["nit"] . '<br>
					TEL: ' . $contrato[0]["telefono"] . '<br>';

        $foot = '</body>
					</html>';
        //Muestra el contrato
        return $head . $body . $imagen . $firma . $foot;
    }

    public function getContratoTipo($contrato)
    {
        $head = '<!DOCTYPE html>
					<html>
					<head>
						<title></title>
						<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
					</head>
					<body>';

        $foot = '</body>
					</html>';

        //Toma el tipo de contrato
        $tipo_contrato = $contrato[0]["fkID_tipoContrato"];
        //Salario en letras
        $salario_letras = NumerosEnLetras::convertir($contrato[0]["salario"]);
        //Pasa a mayusculas
        $salario_letras = strtoupper($salario_letras);

        //Apertura tabla
        $apertura  = '<table align="center" width="90%" border="1">';
        $apertura2 = '<table align="center" width="100%">';
        $cierre    = '</table>';

        //Consulta las funciones segun el cargo
        $funciones = $contrato[0]["funciones"];

        //Toma el dia, año y mes fecha ingreso
        $dia     = $contrato[0]["dia"];
        $mes_num = $contrato[0]["mes"];
        $anio    = $contrato[0]["anio"];

        //Toma el dia, año y mes fecha terminacion
        $dia_fin     = $contrato[0]["dia_fin"];
        $mes_num_fin = $contrato[0]["mes_fin"];
        $anio_fin    = $contrato[0]["anio_fin"];

        //Nombre mes
        $mes     = $this->nombreMes($mes_num);
        $mes_fin = $this->nombreMes($mes_num_fin);

        //Variables
        $titulo    = '';
        $clausulas = '';

        $espacio = '<tr>
        <td>&nbsp;</td>
        </tr>';

        $encabezado = '
        <tr>
        <td>NOMBRE DEL EMPLEADOR</td>
        <td align="right">' . $contrato[0]["empleador"] . '</td>
        </tr>
        <tr>
        <td>NIT</td>
        <td align="right">' . $contrato[0]["nit"] . '</td>
        </tr>
        <tr>
        <td>REPRESENTANTE LEGAL</td>
        <td align="right">' . $contrato[0]["representante_legal"] . '</td>
        </tr>
        <tr>
        <td>CEDULA</td>
        <td align="right">' . number_format($contrato[0]["cedula"], 0, ".", ".") . '</td>
        </tr>
        <tr>
        <td>NOMBRE DEL TRABAJADOR</td>
        <td align="right">' . $contrato[0]["empleado"] . '</td>
        </tr>
        <tr>
        <td>DIRECCION Y TELEFONO</td>
        <td align="right">' . $contrato[0]["dir_empleado"] . '</td>
        </tr>
        <tr>
        <td>CEL.</td>
        <td align="right">' . $contrato[0]["telefono"] . '</td>
        </tr>
        <tr>
        <td>CEDULA DE CUIDADANIA</td>
        <td align="right">' . number_format($contrato[0]["nidentificacion"], 0, ".", ".") . '</td>
        </tr>
        <tr>
        <td>CARGO   U  OFICIO QUE DESEMPEÑA EL TRABAJADOR</td>
        <td align="right">' . $contrato[0]["cargo"] . '</td>
        </tr>
        <tr>
        <td>SALARIO</td>
        <td align="right">' . number_format($contrato[0]["salario"], 0, ".", ".") . '</td>
        </tr>
        <tr>
        <td>FECHA DE INICIACION DE LABORES</td>
        <td align="right">' . $contrato[0]["fechaIni"] . '</td>
        </tr>
        <tr>
        <td>CUIDAD DONDE HA SIDO CONTRATRADO EL TRABAJADOR</td>
        <td align="right">' . $contrato[0]["ciudad"] . '</td>
        </tr>
        <tr>
        <td>FECHA DE TERMINACION DEL CONTRATO</td>
        <td align="right">' . $contrato[0]["fechaFin"] . '</td>
        </tr>';

        $enunciado = '
        <tr>
        <td colspan="2" align="justify">Entre el empleador y el trabajador, de las condiciones ya dichas identificados como aparece al pie de sus correspondientes firmas se ha celebrado el presente contrato individual de trabajo, regido además por las siguientes cláusulas:</td>
        </tr>';

        $fecha = '
        <tr>
        <td colspan="2">Se firma por las partes, el día ' . $dia . ' del mes ' . $mes . ' de ' . $anio . '.</td>
        </tr>';

        $firmas = '
        <tr>
        <td><b>EL EMPLEADOR <br> _______________________________ <br> ' . $contrato[0]["empleador"] . ' <br> NIT ' . $contrato[0]["nit"] . ' <br> REPRESENTANTE LEGAL</b></td>
        <td><b>EL TRABAJADOR <br> _______________________________ <br> ' . $contrato[0]["empleado"] . ' <br> NIT ' . number_format($contrato[0]["nidentificacion"], 0, ".", ".") . ' <br> &nbsp;</b></td>
        </tr>
        </table>';

        switch ($tipo_contrato) {
            case 1:

                $titulo = '<tr><td colspan="2" align="center"><b>CONTRATO INDIVIDUAL DE TRABAJO A TERMINO FIJO</b></td></tr>';

                $clausulas = '<tr>
        <td colspan="2" align="justify">
        <b>PRIMERA:</b> El empleador contrata los servicios personales del trabajador y este
        se obliga: a) A poner al servicio del empleador toda su capacidad normal de trabajo,
        en forma exclusiva en el desempeño de las funciones propias del oficio mencionado y
        las labores anexas y complementarias del mismo, de conformidad con las órdenes e
        instrucciones que le imparta el empleador o sus representantes, y b) A no prestar
        directa ni indirectamente servicios laborales a otros empleadores, ni a trabajar por
        cuenta propia en el mismo oficio, durante la vigencia de este contrato.
        <b>SEGUNDA:</b> FUNCIONES. El Empleador contrata al Trabajador(a) para desempeñarse
        como ' . $contrato[0]["cargo"] . ', ejecutando sus labores como:
        ';

                if ($funciones != '') {
                    $clausulas .= '
        </td>
        </tr>
        <tr>
        <td colspan="2" align="justify">' . $funciones . '';
                };

                $clausulas .= '
        <b>TERCERA:</b> Elementos de trabajo. Corresponde al empleador suministrar los
        elementos necesarios para el normal desempeño de las funciones del cargo
        contratado.
        <b>CUARTA:</b> Obligaciones del contratado. El trabajador(a) por su parte, prestará su
        fuerza laboral con fidelidad y entrega, cumpliendo debidamente el Articulo 58 del
        Código Sustantivo del Trabajo y acatando las órdenes e instrucciones que le
        imparta el empleador o sus representantes, al igual que no laborar por cuenta
        propia o a otro empleador en el mismo oficio, mientras esté vigente este contrato.
        <b>QUINTA:</b> Término del contrato. El presente contrato tendrá una duración hasta el
        dia ' . $dia_fin . ' de ' . $mes_fin . ' del ' . $anio_fin . ', como ' . $contrato[0]["cargo"] . ',
        pero podrá darse por terminado por cualquiera  de las partes, cumpliendo con las
        exigencias legales al respecto.
        <b>SEXTA:</b> Son justas causas para dar por terminado unilateralmente este contrato
        por cualquiera de las partes, las enumeradas en los artículo 62 y 63 del Código
        Sustantivo del Trabajo; y, además, por parte del empleado, las faltas que para el
        efecto se califiquen como graves en el espacio reservado para las cláusulas
        adicionales en el presente contrato.';

                if ($funciones == '') {
                    $clausulas .= '
        </td>
        </tr>
        <tr>
        <td colspan="2" align="justify">' . $funciones . '';
                };

                $clausulas .= '
        <b>SEPTIMA:</b> Salario. El empleador cancelará
        al trabajador(a) un salario mensual de ' . $salario_letras . ' ($ ' . number_format($contrato[0]["salario"], 0, ".", ".") . ')    pagaderos en el lugar de trabajo, a los 5 primeros
        días de cada mes. Dentro de este pago se encuentra incluida la remuneración de los
        descansos dominicales y festivos de    que tratan los capítulos I y II del título VII del
        Código Sustantivo del Trabajo.Se aclara y se conviene que en los casos en los que el trabajador devengue comisiones o cualquiera otra modalidad de salario variable, el 82.5% de dichos ingresos, constituye remuneración ordinaria, y el 17.5% restante está destinado a remunerar el descanso en los días dominicales y festivos de que tratan los capítulos I y II del título VII del Código Sustantivo del Trabajo.
        <b>OCTAVA:</b> Trabajo extra, en dominicales y festivos. El trabajo
        suplementario o en horas extras, así como el trabajo en domingo o festivo que
        correspondan a descanso, al igual que los nocturnos, será remunerado conforme al
        código laboral. Es de advertir que dicho trabajo debe ser autorizado u ordenado por el
        empleador para efectos de su reconocimiento. Cuando se presenten situaciones
        urgentes o inesperadas que requieran la necesidad de este trabajo suplementario, se
        deberá ejecutar y se dará cuenta de ello por escrito, en el menor tiempo posible al
        jefe inmediato, de lo contrario, las horas laboradas de manera suplementaria que no se
        autorizó o no se notificó no será reconocido.';

                if ($funciones != '') {
                    $clausulas .= '
        </td>
        </tr>
        <tr>
        <td colspan="2" align="justify">';
                };

                $clausulas .= '
        <b>NOVENA:</b> se obliga a laborar la jornada ordinaria presencial de tiempo completo,
        equivalente a 48 horas semanales laboradas de lunes a sábado; en turnos rotativos y
        entro de las horas señaladas por El Empleador, pudiendo hacer éste ajustes o cambios
        de horario cuando lo estime conveniente. Por el acuerdo expreso o tácito de las artes,
        podrán repartirse las horas de la jornada ordinaria en la forma prevista en el
        artículo 164 del Código Sustantivo del Trabajo, modificado por el artículo 23 de la
        Ley 50 de 1990, teniendo en cuenta que los tiempos de descanso entre las secciones de
        la jornada no se computan dentro de la misma, según el artículo 167 ibídem.
        <b>DECIMA:</b> Pago a Seguridad Social: Es obligación del empleador afiliar al
        trabajador a la seguridad social como es salud, pensión y riesgos profesionales,
        autorizando el trabajador el descuento en su salario, los valores que le
        corresponda aportan, en la proporción establecida por la ley.
        <b>DECIMA PRIMERA:</b> Las partes podrán convenir que el trabajo se preste en lugar
        distinto al inicialmente contratado, siempre que tales traslados no desmejoren las
        condiciones laborales, el empleador está obligado a remunerar los traslados del
        trabajador; Los gastos que se originen con el traslado serán cubiertos por el
        empleador de conformidad con el numeral 8º del artículo 57 del Código Sustantivo
        del Trabajo. El trabajador se obliga a aceptar los cambios de oficio que decida el
        empleador dentro de su poder subordinante, siempre que se respeten las condiciones
        laborales del trabajador y no se le causen perjuicios. Todo ello sin que se afecte
        el honor, la dignidad y los derechos mínimos del trabajador, de conformidad con el
        artículo 23 del Código Sustantivo del Trabajo, modificado por el artículo 1º de la
        Ley 50 de 1990.
        <b>DECIMA SEGUNDA:</b> Modificaciones: Cualquier modificación al presente contrato
        debe efectuarse por escrito y anexarse a este documento.
        <b>DECIMA TERCERA:</b> DOCUMENTOS E INFORMACIÓN CONFIDENCIAL Y RESERVADA: Sobre la
        base de considerar como confidencial y reservada toda información que EL
        TRABAJADOR reciba del EMPLEADOR o de terceros en razón de su cargo, que incluye,
        pero sin que se limite a los elementos descritos, la información objeto de derecho
        de autor, patentes, técnicas, modelos, invenciones, know-how, procesos,
        algoritmos, programas ejecutables, investigaciones, detalles de diseño,
        información financiera, lista de clientes, inversionistas, empleados, relaciones
        de negocios y contractuales, pronósticos de negocios, planes de mercadeo e
        cualquier información revelada sobre terceras personas, salvo la que expresamente
        y por escrito se le manifieste que no tiene dicho carácter, o la que se tiene
        disponible para el público en general, EL TRABAJADOR se obliga a: a) Abstenerse de
        revelar o usar información relacionada con los trabajos o actividades que
        desarrolla la EMPRESA, ni durante el tiempo de vigencia del contrato de trabajo ni
        después de finalizado éste hasta por 2 años, ya sea con terceras personas
        naturales o jurídicas, ni con personal de la misma EMPRESA no autorizado para
        conocer información confidencial salvo autorización expresa del EMPLEADOR. b)
        Entregar al EMPLEADOR cuando finalice el contrato de trabajo todos los archivos en
        original o copias con información confidencial que se encuentren en su poder, ya
        sea que se encuentre en documentos escritos, gráficos o archivos magnéticos como
        video, audio o disquetes. C) el empleador realizara la terminación del contrato
        inmediato, si el trabajador incumple con dicha cláusula. d) En caso de violación de
        esta confidencialidad durante la vigencia del contrato de trabajo y los dos años
        posteriores a la terminación del mismo el trabajador será responsable de los
        perjuicios económicos que genere al empleador quién podrá iniciar las acciones
        penales y civiles correspondientes.';

                if ($funciones == '') {
                    $clausulas .= '
        </td>
        </tr>
        <tr>
        <td colspan="2" align="justify">' . $funciones . '';
                };

                $clausulas .= '
        <b>DECIMA CUARTA:</b> Se estipula un periodo de prueba de tres (3) meses, en el cual
        cualquiera de las partes puede dar por terminado el contrato unilateralmente sin que
        esto genere ningún tipo de prejuicio.
        <b>DECIMA QUINTA:</b> El presente contrato reemplaza en su integridad y deja sin efecto
        alguno cualquiera otro contrato verbal o escrito celebrado por las partes con
        anterioridad. Las modificaciones que se acuerden al presente contrato se anotarán a
        continuación de su texto. <b>DECIMA SEXTA:</b> Este contrato ha sido redactado
        estrictamente de acuerdo con la ley y la jurisprudencia y será interpretado de buena
        fe y en consonancia con el Código Sustantivo del Trabajo cuyo objeto, definido en su
        artículo 1º, es lograr la justicia en las relaciones entre empleadores y
        trabajadores dentro de un espíritu de coordinación económica y equilibrio social.
        </td>
        </tr>';

                break;

            case 2:
                $titulo = '<tr><td colspan="2" align="center"><b>CONTRATO INDIVIDUAL DE TRABAJO A TERMINO INDEFINIDO</b></td></tr>';

                $clausulas = '<tr>
        <td colspan="2" align="justify">
        <b>PRIMERA:</b> OBJETO. EL EMPLEADOR contrata los servicios personales del TRABAJADOR y éste se obliga: a) a poner al servicio del EMPLEADOR toda su capacidad normal de trabajo, en forma exclusiva en el desempeño de las funciones propias del oficio mencionado y en las labores anexas y complementadas del mismo, de conformidad con las órdenes e instrucciones que le imparta EL EMPLEADOR directamente o a través de sus representantes. b) a no prestar directa ni indirectamente servicios laborales a otros EMPLEADORES, ni a trabajar por cuenta propia en el mismo oficio, durante la vigencia de este contrato; y c) a guardar absoluta reserva sobre los hechos, documentos, informaciones y en general, sobre todos los asuntos y materias que lleguen a su conocimiento por causa o con ocasión de su contrato de trabajo.
        <b>PARAGRAFO: ' . $contrato[0]["cargo"] . '.</b> La descripción anterior es general y no excluye ni limita para ejecutar labores conexas complementarias, accesorias o similares y en general aquellas que sean necesarias para un mejor resultado en la ejecución de la causa que dio origen al contrato, pudiendo en consecuencia complementar e implementar la descripción que por vía de ejemplo se establecen en este acuerdo.
        <b>SEGUNDA:</b> REMUNERACION. EL EMPLEADOR pagará al TRABAJADOR por la prestación de sus servicios el salario indicado, pagadero en las oportunidades mensualmente sin que ello signifique que unilateralmente el empleador pueda pagar por periodos menores. Dentro de la retribución acordada se encuentra incluida los descansos dominicales y festivos. En caso de que se cancele alguna comisión u otra modalidad de salario variable las partes acuerden que el 82.5% de dichos ingresos, constituye remuneración de la labor realizada, y el 17.5% restante está destinado a remunerar el descanso en los días dominicales y festivos establecido en la ley. PARAGRAFO: El trabajador autoriza al empleador para que la retribución, así como cualquier otro beneficio, sea prestacional, descanso vacaciones etc. originado en la existencia y/o terminación del contrato sean consignadas o trasladadas a cuenta que desde ya el trabajador autoriza al empleador para que sea Abierta a su nombre en una institución financiera.
        </td>
        </tr>
        <tr>
        <td colspan="2" align="justify">
        <b>TERCERA:</b> TRABAJO NOCTURNO, SUPLEMENTARIO, DOMINICALY/O FESTIVO. Para el reconocimiento y pago del trabajo suplementario, nocturno, dominical o festivo, EL EMPLEADOR o sus representantes deberán haberlo autorizado previamente y por escrito. Cuando la necesidad de este trabajo se presente de manera imprevista o inaplazable, deberá ejecutarse y darse cuenta de él por escrito, a la mayor brevedad, al EMPLEADOR o a sus representantes para su aprobación. EL EMPLEADOR, en consecuencia, no reconocerá ningún trabajo suplementario, o trabajo nocturno o en días de descanso legalmente obligatorio que no haya sido autorizado previamente o que, habiendo sido avisado inmediatamente, no haya sido aprobado como queda dicho. El empleador fijara las jornadas laborales de acuerdo a las necesidades del servicio pudiendo variarlas durante la ejecución del presente contrato.
        <b>CUARTA:</b> JORNADA DE TRABAJO. EL TRABAJADOR se obliga a laborar la jornada máxima legal, salvo estipulación expresa y escrita en contrario, en los turnos y dentro de las horas señalados por el EMPLEADOR, pudiendo hacer éste ajustes o cambios de horario cuando lo estime conveniente. Por el acuerdo expreso o tácito de las partes, podrán repartiese las horas de la jornada ordinaria en la forma prevista en la ley, teniendo en cuenta que los tiempos de descanso entre las secciones de la jornada no se computan dentro de las mismas.
        <b>QUINTA:</b> PERIODO DE PRUEBA. Los primeros tres meses del presente contrato se consideran como período de prueba y, por consiguiente, cualquiera de las partes podrá terminar el contrato unilateralmente, en cualquier momento durante dicho período, sin que se cause el pago de indemnización alguna.
        <b>SEXTA:</b> DURACION DEL CONTRATO. La duración del contrato será indefinida, mientras subsistan las causas que le dieron origen y la materia del trabajo.
        <b>SEPTIMA:</b> TERMINACION UNILATERAL. Son justas causas para dar por terminado unilateralmente este contrato, por cualquiera de las partes, las que establece la Ley, el reglamento interno, el presente contrato y/o las circulares que al o largo de la ejecución del presente contrato establezcan conductas no previstas en virtud de hechos o tecnologías o cambios de actividad diferentes a las consideradas en el presente contrato. Se trata de reglamentaciones, órdenes instrucciones de carácter general o particular que surjan con posterioridad al presente acuerdo, cuya violación sea calificada como grave. Expresamente se califican en este acto como faltas graves la violación a las obligaciones y prohibiciones contenidas en la cláusula primera del presente contrato y además las siguientes: A) El incumplimiento de las normas y políticas que tenga la compañía para el uso de los sistemas, informática, software, claves de seguridad, que la empresa entrega al trabajador para la mejor ejecución de sus funciones. Así como violación al lo contenido en el anexo de seguridad informática que hace parte integral de este contrato B) El incumplimiento de las políticas o instrucciones del empleador relacionadas con el régimen de incompatibilidades e inhabilidades, conducta en los negocios y conflictos de interés. C) La utilización para fines distintos a los considerados por el empleador para el cumplimiento de su objeto social de las bases de datos de su propiedad D) Desconocer o actuar omisiva o positivamente en relación con las políticas estatales sobre lavados de activos, manejo de divisas. E) Conceder créditos a compañeros o solicitarlos a su favor. Tramitar créditos de manera fraudulenta en su propio beneficio o facilitar las condiciones para que terceros lo hagan. F) resultar embargados por autoridades judiciales sistemáticamente. G) Ejecutar o desarrollar actividades paralelas a las propias del objeto social del empleador sin haber recibido la autorización explícita correspondiente. H) Desatender las actividades de capacitación programadas por el empleador así sea en horario diferente a la jornada ordinaria. I) Descuadrarse en caja debitar o acreditar en forma inequívoca cuentas de cualquier naturaleza cuando se compruebe dolo, fraude o improbidad. J) la mala atención y desinterés para con el usuario de los servicios comunicada por los clientes o por el superior inmediato. K) Desatender las obligaciones antes mencionadas constituye justa causa para dar por terminado el contrato por parte del Empleador.

        <b>OCTAVA:</b> INVENCIONES. Las invenciones realizadas por EL TRABAJADOR le pertenecen a la empresa siempre y cuando estas sean realizadas con ocasión y dentro de la ejecución del contrato de trabajo, y como parte del cumplimiento de las obligaciones del cargo. También lo son aquellas que se obtienen mediante los datos y medios conocidos o utilizados en razón de la labor desempeñada.
        <b>NOVENA:</b> DERECHOS DE AUTOR. Los derechos patrimoniales de autor sobre las obras creadas por el TRABAJADOR en ejercicio de sus funciones o con ocasión ellas pertenecen al EMPLEADOR. Todo lo anterior sin perjuicio de los derechos morales de autor que permanecerán en cabeza del creador de la obra, de acuerdo con la ley 23 de 1982 y la Decisión 351 de la Comisión del Acuerdo de Cartagena.
        </td>
        </tr>
        <tr>
        <td colspan="2" align="justify">
        <b>DECIMA:</b> TRASLADOS: Desde ya el trabajador acuerda que el empleador podrá trasladarlo desde el lugar, cargo y/o sitio de trabajo de acuerdo a las necesidades del servicio siempre y cuando no se menos cabe el honor la dignidad o se produzca un una desmejora sustancial o grave perjuicio con ocasión a la citada orden. El empleador esta obligado a asumir los gastos originados en el traslado. Siempre que sea una decisión unilateral de la empresa.
        <b>DECIMA PRIMERA:</b> BENEFICIOS EXTRALEGALES: El empleador podrá reconocer beneficios, primas, prestaciones de naturaleza extra legal, lo que se hace a titulo de mera liberalidad y estos subsistirán hasta que el empleador decida su modificación o supresión, atendiendo su capacidad, todos los cuales se otorgan y reconocen, y el trabajador así lo acuerdan sin que tengan carácter salarial y por lo tanto no tienen efecto prestacional o incidencia en la base de aportes en la seguridad social o parafiscal en especial este acuerdo se refiere a auxilios en dinero o en especie, primas periódicas o de antigüedad o en general beneficios de esa naturaleza los que podrán ser modificados o suprimidos por el empleador de acuerdo con su determinación unilateral tal como fue otorgado.
        <b>DECIMA SEGUNDA:</b> DESCUENTOS: El Trabajador autoriza para que el Empleador descuente cualquier suma de dinero que se cause dentro de la existencia y terminación del contrato de trabajo ya sea por concepto de préstamos, alimentación a bajo costo, bonos de alimentación, vivienda, utilización de medios de comunicación, fondos de empleados, aportes bienes dados a cargo y no reintegrados, Este descuento se podrá realizar de la nómina mensual o de las prestaciones sociales, indemnizaciones, descansos o cualquier beneficio que resulte con ocasión de la existencia o terminación del contrato por cualquier motivo.
        <b>DECIMA TERCERA:</b> MODIFICACION DE LAS CONDICIONES LABORALES. El TRABAJADOR acepta desde ahora expresamente todas las modificaciones determinadas por el EMPLEADOR, en ejercicio de su poder subordínenle, de sus condiciones laborales, tales como la jornada de trabajo, el lugar de prestación de servicio, el cargo u oficio y/o funciones y la forma de remuneración, siempre que tales modificaciones no afecten su honor, dignidad o sus derechos mínimos ni impliquen desmejoras sustanciales o graves perjuicios para él, de conformidad con lo dispuesto en la Ley.
        <b>DECIMA CUARTA:</b> DIRECCION DEL TRABAJADOR. EL TRABAJADOR se compromete a informar por escrito AL EMPLEADOR cualquier cambio de dirección teniéndose como suya, para todos los efectos, la última dirección registrada en la empresa.
        <b>DECIMA QUINTA:</b> EFECTOS. El presente contrato reemplaza en su integridad y deja sin efecto cualquiera otro contrato, verbal o escrito, celebrado entre las partes con anterioridad, pudiendo las partes convenir por escrito modificaciones al mismo, las que formarán parte integrante de este contrato.
        </td>
        </tr>';
                break;

            case 3:
                $titulo = '<tr><td colspan="2" align="center"><b>CONTRATO INDIVIDUAL DE TRABAJO DE OBRA</b></td></tr>';

                $clausulas = '<tr>
        <td colspan="2" align="justify">
        <b>PRIMERA:</b> El empleador contrata los servicios personales del trabajador y este
        se obliga: a) A poner al servicio del empleador toda su capacidad normal de trabajo,
        en forma exclusiva en el desempeño de las funciones propias del oficio mencionado y
        las labores anexas y complementarias del mismo, de conformidad con las órdenes e
        instrucciones que le imparta el empleador o sus representantes, y b) A no prestar
        directa ni indirectamente servicios laborales a otros empleadores, ni a trabajar por
        cuenta propia en el mismo oficio, durante la vigencia de este contrato.
        <b>SEGUNDA:</b> FUNCIONES. El Empleador contrata al Trabajador(a) para desempeñarse
        como ' . $contrato[0]["cargo"] . ', ejecutando sus labores como: ' . $funciones . '
        </td>
        </tr>
        <tr>
        <td colspan="2" align="justify">
        <b>TERCERA:</b> Elementos de trabajo. Corresponde al empleador suministrar los
        elementos necesarios para el normal desempeño de las funciones del cargo
        contratado.
        <b>CUARTA:</b> Obligaciones del contratado. El trabajador(a) por su parte, prestará su
        fuerza laboral con fidelidad y entrega, cumpliendo debidamente el Articulo 58 del
        Código Sustantivo del Trabajo y acatando las órdenes e instrucciones que le
        imparta el empleador o sus representantes, al igual que no laborar por cuenta
        propia o a otro empleador en el mismo oficio, mientras esté vigente este contrato.
        <b>QUINTA:</b> Término del contrato. El presente contrato tendrá una duración hasta cuando se finalice la obra de ' . $contrato[0]["cargo"] . ',
        pero podrá darse por terminado por cualquiera  de las partes, cumpliendo con las
        exigencias legales al respecto.
        <b>SEXTA:</b> Son justas causas para dar por terminado unilateralmente este contrato
        por cualquiera de las partes, las enumeradas en los artículo 62 y 63 del Código
        Sustantivo del Trabajo; y, además, por parte del empleado, las faltas que para el
        efecto se califiquen como graves en el espacio reservado para las cláusulas
        adicionales en el presente contrato.
        <b>SEPTIMA:</b> Salario. El empleador cancelará al trabajador(a) un salario mensual de
        ' . $salario_letras . ' ($ ' . number_format($contrato[0]["salario"], 0, ".", ".") . ')
        pagaderos en el lugar de trabajo, a los 5 primeros días de cada mes. Dentro de este
        pago se encuentra incluida la remuneración de los descansos dominicales y festivos de
        que tratan los capítulos I y II del título VII del Código Sustantivo del Trabajo. Se
        aclara y se conviene que en los casos en los que el trabajador devengue comisiones o
        cualquiera otra modalidad de salario variable, el 82.5% de dichos ingresos, constituye
        remuneración ordinaria, y el 17.5% restante está destinado a remunerar el descanso en
        los días dominicales y festivos de que tratan los capítulos I y II del título VII del
        Código Sustantivo del Trabajo.
        <b>OCTAVA:</b> Trabajo extra, en dominicales y festivos. El trabajo
        suplementario o en horas extras, así como el trabajo en domingo o festivo que
        correspondan a descanso, al igual que los nocturnos, será remunerado conforme al
        código laboral. Es de advertir que dicho trabajo debe ser autorizado u ordenado por el
        empleador para efectos de su reconocimiento. Cuando se presenten situaciones
        urgentes o inesperadas que requieran la necesidad de este trabajo suplementario, se
        deberá ejecutar y se dará cuenta de ello por escrito, en el menor tiempo posible al
        jefe inmediato, de lo contrario, las horas laboradas de manera suplementaria que no se
        autorizó o no se notificó no será reconocido.
        <b>NOVENA:</b> se obliga a laborar la jornada ordinaria presencial de tiempo completo,
        equivalente a 48 horas semanales laboradas de lunes a sábado; en turnos rotativos y
        entro de las horas señaladas por El Empleador, pudiendo hacer éste ajustes o cambios
        de horario cuando lo estime conveniente. Por el acuerdo expreso o tácito de las artes,
        podrán repartirse las horas de la jornada ordinaria en la forma prevista en el
        artículo 164 del Código Sustantivo del Trabajo, modificado por el artículo 23 de la
        Ley 50 de 1990, teniendo en cuenta que los tiempos de descanso entre las secciones de
        la jornada no se computan dentro de la misma, según el artículo 167 ibídem.
        </td>
        </tr>
        <tr>
        <td colspan="2" align="justify">
        <b>DECIMA:</b> Afiliación y pago a seguridad social. Es obligación de la empleadora
        afiliar a la trabajadora a la seguridad social como es salud, pensión y riesgos
        profesionales, autorizando el trabajador el descuento en su salario, los valores que
        le corresponda aportan, en la proporción establecida por la ley.
        <b>DECIMA PRIMERA:</b> Nueva obra o cambio del término del contrato. Si al finalizar la obra contratada, el empleador desea continuar con el trabajador en otra obra distinta a la aquí contratada o vincularlo mediante un periodo fijo o término indefinido, se deberá hacer un nuevo contrato de trabajo y no se entenderá como prorroga por desaparecer las causas contractuales que dieron origen a este contrato.
        <b>DECIMA SEGUNDA:</b> Modificaciones: Cualquier modificación al presente contrato
        debe efectuarse por escrito y anexarse a este documento.
        <b>DECIMA TERCERA:</b> EFECTOS. El presente contrato reemplaza en su integridad y deja sin efecto cualquiera otro contrato, verbal o escrito, celebrado entre las partes con anterioridad, pudiendo las partes convenir por escrito modificaciones al mismo, las que formarán parte integrante de este contrato.
        </td>
        </tr>';
                break;

            case 4:

                $titulo = '<tr><td colspan="2" align="center"><b>CONTRATO INDIVIDUAL DE TRABAJO POR PRESTACION DE SERVICIOS</b></td></tr>';

                $enunciado = '';

                $enunciado = '
        <tr>
        <td colspan="2">
        <p align="justify">Entre los suscritos a saber, <b>' . $contrato[0]["empleador"] . '</b>,identificada con <b>NIT: ' . $contrato[0]["nit"] . '</b> legalmente
        constituida y con domicilio principal en la ciudad de <b>BOGOTÁ</b> quien en
        adelante se denominará <b>EL CONTRATANTE</b>, representada legalmente por <b>
        ' . $contrato[0]["representante_legal"] . '</b>, identificada como aparece al pie de
        su firma, según certificado de la cámara de comercio de BOGOTA D.C., según
        consta en el certificado de existencia y representación legal expedido por la
        cámara de comercio de Bogotá, y por la otra, <b>' . $contrato[0]["empleado"] . '</b>,
        identificado con la cedula de ciudadanía <b>No ' . $contrato[0]["nidentificacion"] . '
        </b>, mayor de edad y vecino de Bogotá, quien para efectos del presente contrato
        se denominará <b>EL CONTRATISTA</b>, convienen en celebrar el presente contrato de
        prestación de servicios que se regulará por las cláusulas que a continuación se
        expresan y en general por las disposiciones del código civil y código de comercio
        aplicables a la materia que trata este contrato, el cual se regirá por la
        siguientes cláusulas:
        </p>
        </td>
        </tr>';

                $clausulas = '<tr>
        <td colspan="2" align="justify">
        <b>PRIMERA:</b> - OBJETO: El presente contrato tiene por objeto, la prestación de servicios profesionales por parte del <b>CONTRATISTA. El CONTRATISTA</b> de manera independiente, sin subordinación o dependencia, utilizando sus propios medios, elementos de trabajo, personal a su cargo, prestará los servicios profesionales por parte del <b>CONTRATISTA</b>, como <b>' . $contrato[0]["cargo"] . '</b>
        <b>SEGUNDA:</b> OBLIGACIONES DEL CONTRATISTA: <b>EL CONTRATISTA</b> se obliga a cumplir a cabalidad con lo establecido en el objeto del presente contrato en forma oportuna, dentro del término establecido, y de conformidad con las calidades propias de su profesión. Adicionalmente, se obliga:' . $funciones . '
        </tr>
        <tr>
        <td colspan="2" align="justify">
        <b>TERCERA:</b> OBLIGACIONES DEL CONTRATANTE: <b>EL CONTRATANTE</b> se obliga a prestar la colaboración necesaria <b>AL CONTRATISTA</b> para facilitarle la adecuada prestación del servicio.
        <b>CUARTA:</b> NATURALEZA DEL CONTRATO: Por la naturaleza del contrato <b>EL CONTRATANTE</b> solo se obliga a pagar <b>AL CONTRATISTA</b> el valor correspondiente a los honorarios pactados en el presente contrato, no habiendo lugar al pago por concepto de prestaciones sociales, horas extras, indemnizaciones o cualquiera otra remuneración de carácter laboral.
        <b>QUINTA:</b> VALOR DE LOS SERVICIOS Y FORMA DE PAGO: Por la prestación de los servicios pactados en este contrato <b>EL CONTRATANTE</b> le pagará <b>AL CONTRATISTA</b> Honorarios de ' . $salario_letras . ' ($ ' . number_format($contrato[0]["salario"], 0, '.', '.') . ') pagaderos a razón de pagos mensuales durante el periodo de ejecución del contrato, previa entrega y recibo a satisfacción de los productos pactados en el presente contrato, incluido el informe mensual con el detalle de las actividades realizadas soportadas con planillas de aportes de pago a seguridad social ( ARL, EPS,FONDO DE PENSIONES), certificación bancaria .PARÁGRAFO 1: Los respectivos pagos se harán contra cuenta de cobro, que debe contar con el visto bueno del Gerente de proyecto designado por <b>' . $contrato[0]["empleador"] . '</b> quien certificará el cumplimiento a satisfacción de las responsabilidades pactadas en este contrato y los aportes realizados al Sistema General de Seguridad Social.
        <b>SEXTA</b> DURACIÓN: El término del presente contrato es hasta el día ' . $dia_fin . ' de ' . $mes_fin . 'del ' . $anio_fin . ' contados a partir de ' . $dia . ' de ' . $mes . ' de ' . $anio . '. <b>EL CONTRATANTE</b> o <b>EL CONTRATISTA</b> podrán dar por terminado el presente contrato en cualquier tiempo, por lo cual dará aviso a la otra parte con una antelación no menor a cinco (5) días.
        <b>SEPTIMA:</b> SUPERVISIÓN: La vigilancia, supervisión y seguimiento al cumplimiento de las obligaciones derivadas del presente contrato estarán a cargo del Gerente de proyecto designado por <b>' . $contrato[0]["empleador"] . '</b>
        <b>OCTAVA:</b> AFILIACIÓN AL SISTEMA GENERAL DE RIESGOS PROFESIONALES: <b>EL CONTRATISTA</b> realizará de manera personal y por su cuenta y riesgo la actividad contratada en las oficinas de <b>' . $contrato[0]["empleador"] . '</b> o en los espacios que <b>' . $contrato[0]["empleador"] . '</b> designe para el desarrollo del proyecto, localizada en la ciudad de Bogotá o municipios aledaños.<b>EL CONTRATISTA</b> se afiliará al Sistema General de Riesgos Profesionales en la categoría que <b>EL CONTRATANTE</b> designe y el monto de la cotización correspondiente será asumida por <b>EL CONTRATISTA</b> en su totalidad. Adicionalmente, <b>EL CONTRATISTA</b> declara que previamente se encuentra afiliado al Sistema General de Seguridad Social en Salud y de Pensiones. Todo lo anterior, de acuerdo con lo dispuesto en el Decreto No. 2800 de 2003 y las demás normas concordantes y vigentes sobre la materia.
        <b>NOVENA:</b> DERECHOS DE AUTOR: Si en la ejecución del presente contrato de prestación de servicios, se desarrollan manuales, informes, procedimientos, reglamentos y otras innovaciones, <b>EL CONTRATISTA</b> será el titular de los derechos morales, y se obliga a ceder los derechos patrimoniales al CONTRATANTE, mediante documento privado, autenticado e inscrito en Notaría. De conformidad con lo anterior, <b>EL CONTRATISTA</b> al firmar el contrato de cesión respectivo,transferirá a <b>' . $contrato[0]["empleador"] . '</b> o a quien corresponda todos los derechos patrimoniales de autor que surjan de las obras creadas por éste, de tal manera que <b>EL CONTRATANTE</b> será el titular exclusivo de los derechos patrimoniales de autor por la vida DEL CONTRATISTA y cincuenta años más.
        </td>
        </tr>
        <tr>
        <td colspan="2" align="justify">
        <b>DÉCIMA:</b> CONFIDENCIALIDAD: En este contrato se entiende como información cualquier tipo de comunicación, bien sea escrita, oral o por medios electrónicos expuesta o entregada o puesta a disposición por <b>EL CONTRATANTE</b> o a la cual tenga acceso <b>EL CONTRATISTA</b> en razón a las actividades que desempeña para <b>EL CONTRATANTE</b>. La información es propiedad exclusiva DEL CONTRATANTE y por lo tanto tiene carácter confidencial, siendo así considerada como “Información Confidencial”. Se incluye como Información Confidencial, sin limitación alguna, todas las características, descripciones, procedimientos, instrucciones datos, productos, procesos operaciones, métodos, fórmulas, know-how, ideas y cualquier otra información de naturaleza técnica o económica (incluye la comercial, financiera y contable) perteneciente AL CONTRATANTE o a sus diferentes clientes, así como documentos, contratos, comunicaciones, telecomunicaciones, tele-conferencias y demás información que por cualquier medio hubiere conocido <b>EL CONTRATISTA</b>. No obstante, dentro de la Información Confidencial no se incluirá: (a) aquello que sea del dominio público, por una razón diferente del incumplimiento a la confidencialidad aquí pactada, (b) que esté en posesión D<b>EL CONTRATISTA</b> y que la haya recibido con anterioridad a la celebración de este contrato, (c) que deba revelarse a cualquier entidad oficial, nacional o internacional competente, que haya solicitado tal revelación dentro de sus facultades. De conformidad con lo anterior, por medio del presente contrato <b>EL CONTRATISTA</b> se obliga a: (a) Responder frente AL CONTRATANTE directamente por la utilización de la Información Confidencial. (b) No utilizar la Información Confidencial de ninguna manera que pudiere causar perjuicio directo o indirecto AL CONTRATANTE. (c) Abstenerse de copiar, reproducir, distribuir, o transmitir la Información Confidencial por cualquier medio, en todo o en parte, sin el consentimiento previo, escrito y expreso DEL CONTRATANTE, salvo para lo que resulte necesario en el ejercicio de las actividades del CONTRATISTA.
        <b>DÉCIMA PRIMERA:</b> MODIFICACIONES CONTRACTUALES: Cuando se presenten circunstancias debidamente comprobadas que justifiquen la modificación de cualquiera de las cláusulas del contrato, las partes suscribirán el documento pertinente que contendrá con claridad y precisión la reforma requerida.
        <b>DÉCIMA SEGUNDA:</b> CAUSALES DE TERMINACION DEL CONTRATO. - Además de las otras causas legales y de la señalada en el parágrafo de la cláusula séptima, el presente contrato, podrá terminarse antes del vencimiento del plazo en los siguientes casos: 1) Por incumplimiento, de una o algunas de las obligaciones a cargo del CONTRATISTA, o por su ejecución tardía, defectuosa o en forma diferente a la acordada; lo cual no dará lugar a indemnización para <b>EL CONTRATISTA</b>; 2) Por mutuo acuerdo entre las partes.
        <b>DÉCIMA TERCERA:</b> PERFECCIONAMIENTO: El presente contrato requiere para su perfeccionamiento la firma de las partes contratantes.
        <b>DÉCIMA CUARTA:</b> COMPROMISORIA: Toda controversia o diferencia relativa a este contrato, su ejecución y liquidación, se resolverá por un tribunal de arbitramento que por economía será designado por las partes y será del domicilio donde se debió ejecutar el servicio contratado o en su defecto en el domicilio de la parte que lo convoque. El tribunal de arbitramento se sujetará a lo dispuesto en el decreto1818 de 1998 o estatuto orgánico de los sistemas alternativos de solución de conflictos y demás normas concordantes.
        <b>DÉCIMA QUINTA:</b> CALIDAD, AMBIENTAL E ISO. Es compromiso y obligación por parte del CONTRATISTA conocer, aceptar, aplicar y colaborar en todos los aspectos correspondientes al Sistema de Gestión de Calidad, Ambiental e ISO implementado por <b>EL CONTRATANTE</b> , así como tener siempre presente las políticas de Alcohol y Drogas , colocando las capacidades personales a disposición del buen funcionamiento del sistema.
        <b>DÉCIMA SEXTA:</b> BIENESTAR. Es compromiso y obligación por parte del CONTRATISTA conocer, aplicar y tomar las medidas necesarias que salvaguarden el bienestar y la salud del CONTRATANTE, así como también es obligación del CONTRATANTE, la utilización de todos los elementos de protección personal propios de la actividad que realice.
        </td>
        </tr>';
                break;
        }

        //Muestra el contrato
        return $head . $apertura . $titulo . $encabezado . $cierre . $apertura2 . $espacio . $enunciado . $espacio . $clausulas . $espacio . $fecha . $espacio . $firmas . $cierre . $foot;
    }
    //Consulta para exportar a PDF
    public function getContratoPDF($id)
    {
        $table = '<h1>HTML</h1>';
        return $table;
    }

    //Consulta la tabla hoja_vida para traer los empleados
    public function selectEmpleado()
    {

        $empleadoSelect = $this->getEmpleado();

        echo '<option value="">Seleccione...</option>';

        for ($i = 0; $i < sizeof($empleadoSelect); $i++) {

            echo '<option value="' . $empleadoSelect[$i]["pkID"] . '">' . $empleadoSelect[$i]["nombres"] . '</option>';
        };
    }

    //Consulta la tabla empresas para traer los empleadores
    public function selectEmpleador()
    {

        $empleadorSelect = $this->getEmpleador();

        echo '<option value="">Seleccione...</option>';

        for ($i = 0; $i < sizeof($empleadorSelect); $i++) {

            echo '<option value="' . $empleadorSelect[$i]["pkID"] . '">' . $empleadorSelect[$i]["nombre"] . '</option>';
        };
    }

    //Consulta la tabla ciudad
    public function selectCargo()
    {

        $cargoSelect = $this->getCargo();

        echo '<option value="">Seleccione...</option>';

        for ($i = 0; $i < sizeof($cargoSelect); $i++) {

            echo '<option value="' . $cargoSelect[$i]["pkID"] . '">' . $cargoSelect[$i]["nombre"] . '</option>';
        };
    }

    //Consulta la tabla ciudad
    public function selectCiudad()
    {

        $ciudadSelect = $this->getCiudad();

        echo '<option value="">Seleccione...</option>';

        for ($i = 0; $i < sizeof($ciudadSelect); $i++) {

            echo '<option value="' . $ciudadSelect[$i]["pkID"] . '">' . $ciudadSelect[$i]["nombre"] . '</option>';
        };
    }

    //Consulta de la tabla Tipo de contrato
    public function selectTipoContrato()
    {

        $tipoContratoSelect = $this->getTipoContrato();

        echo '<option value="">Seleccione...</option>';

        for ($i = 0; $i < sizeof($tipoContratoSelect); $i++) {

            echo '<option value="' . $tipoContratoSelect[$i]["pkID"] . '">' . $tipoContratoSelect[$i]["nombre"] . '</option>';
        };
    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function createTableContratos()
    {

        echo '
			    <div class="dataTable_wrapper table-responsive">

				 <table class="table table-striped table-bordered table-hover" id="tbl_contrato">
		              <thead>
		                  <tr>
		                      <th class="tabla-form-ancho">Empleado</th>
		                      <th class="tabla-form-ancho">Empleador</th>
		                      <th class="tabla-form-ancho">Cargo</th>
		                      <th class="tabla-form-ancho">Salario</th>
		                      <th class="tabla-form-ancho">Fecha ingreso</th>
		                      <th class="tabla-form-ancho">Fecha finalizacion</th>
		                      <th class="tabla-form-ancho">Ciudad</th>
		                      <th class="tabla-form-ancho">Tipo contrato</th>
		                      <th data-orderable="false" class="tabla-form-ancho">Opciones</th>
		                  </tr>
		              </thead>
		              <tbody>';

        $this->getTablaRecursos();

        echo '    </tbody>
		          </table>
		        </div>';
    }

    public function createTableCertificaciones()
    {

        echo '
			    <div class="dataTable_wrapper table-responsive">

				 <table class="table table-striped table-bordered table-hover" id="tbl_contrato">
		              <thead>
		                  <tr>
		                      <th class="tabla-form-ancho">Empleado</th>
		                      <th class="tabla-form-ancho">Empleador</th>
		                      <th class="tabla-form-ancho">Cargo</th>
		                      <th class="tabla-form-ancho">Ciudad</th>
		                      <th class="tabla-form-ancho">Tipo contrato</th>
		                      <th data-orderable="false" class="tabla-form-ancho">Opciones</th>
		                  </tr>
		              </thead>
		              <tbody>';

        $this->getTablaCertificaciones();

        echo '    </tbody>
		          </table>
		        </div>';
    }

    public function createTableDocumentos()
    {

        echo '
			    <div class="dataTable_wrapper table-responsive">

				 <table class="table table-striped table-bordered table-hover" id="tbl_contrato">
		              <thead>
		                  <tr>
		                      <th class="tabla-form-ancho">Empleado</th>
		                      <th class="tabla-form-ancho">Empleador</th>
		                      <th class="tabla-form-ancho">Cargo</th>
		                      <th class="tabla-form-ancho">Ciudad</th>
		                      <th class="tabla-form-ancho">Tipo contrato</th>
		                      <th data-orderable="false" class="tabla-form-ancho">Opciones</th>
		                  </tr>
		              </thead>
		              <tbody>';

        $this->getTablaDocumentos();

        echo '    </tbody>
		          </table>
		        </div>';
    }

    public function getTablacontratos($filtro)
    {

        //------------------------------------------------------------------------------------------------
            if ($filtro == '*' || $filtro == '') {
                //obtenemos los datos de la consulta getcontratos
                $this->recursos = $this->getContratos();
            }
            //se establecen los permisos 
            $arrPermisos = $this->permisos($this->id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);
            $edita       = $arrPermisos[0]["editar"];
            $elimina     = $arrPermisos[0]["eliminar"];
            $consulta    = $arrPermisos[0]["consultar"];
            
            $cuento=sizeof($this->recursos);
            if (empty($this->recursos)) {
            } else {
                for ($a = 0; $a < sizeof($this->recursos); $a++) {

                $id         = $this->recursos[$a]["pk"];
                $idc  = $this->recursos[$a]["pkID"];
                $nombres    = $this->recursos[$a]["persona"];
                $cedula   = $this->recursos[$a]["cedula"];
                $nom_estado = $this->recursos[$a]["empresa"];
                $tcontra =   $this->recursos[$a]["Tcontrato"];
                $Ncargo =   $this->recursos[$a]["nombre_cargo"];
                $Nciudad =   $this->recursos[$a]["nombre_ciudad"];
                $Finicio =   $this->recursos[$a]["fecha_inicio"];
                $Fterminacion =   $this->recursos[$a]["fecha_terminacion"];


                echo '

                             <tr>
                                 <td >' . $nombres . '</td>
                                 <td >' . $cedula . '</td>
                                 <td >' . $nom_estado . '</td>
                                 <td >' . $tcontra . '</td>
                                 <td >' . $Ncargo . '</td>
                                 <td >' . $Nciudad . '</td>
                                 <td >' . $Finicio . '</td>
                                 <td >' . $Fterminacion . '</td>

                                 <td>
                                     <button id="btn_editar_contrato" title="Editar"  name="edita_contrato" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_contrato" data-id-contrato = "'. $idc .'"data-id-contratoh = "' . $id . '" ';if ($edita != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-pencil"></span></button>

                                     <button id="btn_eliminar_contrato" title="Eliminar" name="elimina_contrato" type="button" class="btn btn-danger" data-id-contrato = "'. $idc .'"data-id-contratoh = "' . $id . '" ';if ($edita != 1)  {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-remove"></span></button>
                                 </td>
                             </tr>';
            };
            }
            
    }

    public function getTablaCertificaciones()
    {

        $this->proceso = $this->getContratos();

        //permisos-------------------------------------------------------------------------
        $arrPermisos = $this->permisos($this->id_modulo, $_COOKIE["log_lunelAdmin_IDtipo"]);
        $edita       = $arrPermisos[0]["editar"];
        $elimina     = $arrPermisos[0]["eliminar"];
        $consulta    = $arrPermisos[0]["consultar"];
        //---------------------------------------------------------------------------------

        //valida si hay proceso
        if (($this->proceso) && ($consulta == 1)) {

            /**/
            for ($a = 0; $a < sizeof($this->proceso); $a++) {
                //variables de los procesos
                $id            = $this->proceso[$a]["pkID"];
                $empleado      = $this->proceso[$a]["empleado"];
                $empleador     = $this->proceso[$a]["empleador"];
                $cargo         = $this->proceso[$a]["cargo"];
                $ciudad        = $this->proceso[$a]["ciudad"];
                $tipo_contrato = $this->proceso[$a]["tipoContrato"];
                $ruta_pdf      = "../../informes/inf_certificaciones_pdf.php?pkID=" . $id;
                $ruta_word     = "../../informes/inf_certificaciones_word.php?pkID=" . $id;

                echo '<tr>';

                echo '<td>' . $empleado . '</td>';

                echo '<td>' . $empleador . '</td>';

                echo '<td>' . $cargo . '</td>';

                echo '<td>' . $ciudad . '</td>';

                echo '<td>' . $tipo_contrato . '</td>';

                echo '<td>
                     		<a id="btn_doc" title="Descargar PDF" name="download_documento" type="button" class="btn btn-success" href = "subidas/' . $ruta_pdf . '" target="_blank" ><span class="glyphicon glyphicon-file"></span></a>

                  			<a id="btn_doc" title="Descargar WORD" name="download_documento" type="button" class="btn btn-primary" href = "subidas/' . $ruta_word . '" target="_blank" ><span class="glyphicon glyphicon-save-file"></span></a>

                   			<button id="btn_editar" title="Editar" name="edita_proceso" type="button" class="btn btn-warning" data-toggle="modal" data-target="#form_modal_recursos" data-id-contrato = "' . $id . '" ';if ($edita != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-pencil"></span></button>

		                    <button id="btn_eliminar" title="Eliminar" name="elimina_contrato" type="button" class="btn btn-danger" data-id-contrato = "' . $id . '" ';if ($elimina != 1) {echo 'disabled="disabled"';}echo '><span class="glyphicon glyphicon-remove"></span></button>
		                </td>
		            </tr>';
            };

        } elseif (($this->proceso) && ($consulta == 0)) {

            echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		En este momento no tiene permiso de <strong>Consulta</strong> para <strong>Procesos.</strong>
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
		           </tr>
		           <div class='alert alert-danger' role='alert'>
		           		En este momento no hay <strong>Procesos</strong> creados.
				   </div>";
        };

    }

}
