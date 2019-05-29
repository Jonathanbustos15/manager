<?php

include_once 'GenericoDAO.php';
include_once 'PermisosDAO.php';

class recursos extends GenericoDAO
{

    /*-----------------------------------------*/
    //variables
    public $q_general;
    public $permisos;
    /*-----------------------------*/
    public function __construct()
    {
        //contruye la clase GenericoDAO
        parent::__construct();
    }
    /*-----------------------------------------*/

    public function permisos($fkID_modulo, $fkID_tipo_usuario)
    {

        $this->permisos = new PermisosDAO();

        $arrayPermisos = $this->permisos->getPermisosModulo_Tipo($fkID_modulo, $fkID_tipo_usuario);

        return $arrayPermisos;

    }
    /*-----------------------------------------*/
    //funciones generales

    //Consulto los documentos
    public function getListaDocumentos()
    {

        $this->q_general = "SELECT * FROM lista_documentos";

        return GenericoDAO::EjecutarConsulta($this->q_general);

    }

    public function getProcesos()
    {

        $this->q_general = "select procesos.*, pasos_proceso.nombre as nom_paso, entidades.nombre_entidad as nom_entidad, estado_proceso.nombre as nom_estado, tipo_proceso.nombre as nom_tipo

                                FROM procesos

                                INNER JOIN pasos_proceso ON pasos_proceso.pkID = procesos.fkID_paso_actual

                                INNER JOIN entidades on entidades.pkID = procesos.fkID_entidad

                                INNER JOIN estado_proceso on estado_proceso.pkID = procesos.fkID_estado

                                INNER JOIN tipo_proceso on tipo_proceso.pkID = procesos.fkID_tipo

                                ORDER BY

                                    estado_proceso.nombre ASC, procesos.fecha_cierre ASC";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getContratos()
    {

        $this->q_general = " select contrato.pkID, concat_ws(' ', hoja_vida.nombre,hoja_vida.apellido) as persona, hoja_vida.nidentificacion as cedula, estado.nombre as empresa, tipo_contrato.nombre_tipo_contrato as Tcontrato, cargo.nombre_cargo, ciudad.nombre_ciudad, contrato.fecha_inicio, contrato.fecha_terminacion FROM hoja_vida INNER JOIN estado on estado.pkID = hoja_vida.fkID_estado INNER JOIN contrato on contrato.fkID_hvida = hoja_vida.pkID INNER JOIN tipo_contrato on tipo_contrato.pkID = contrato.fkID_tipo_contrato INNER JOIN cargo on cargo.pkID = contrato.fkID_cargo INNER JOIN ciudad on ciudad.pkID = contrato.fkID_ciudad";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getProcesosAlert()
    {

        $this->q_general = "select procesos.*, pasos_proceso.nombre as nom_paso, entidades.nombre_entidad as nom_entidad, estado_proceso.nombre as nom_estado, tipo_proceso.nombre as nom_tipo

                                FROM procesos

                                INNER JOIN pasos_proceso ON pasos_proceso.pkID = procesos.fkID_paso_actual

                                INNER JOIN entidades on entidades.pkID = procesos.fkID_entidad

                                INNER JOIN estado_proceso on estado_proceso.pkID = procesos.fkID_estado

                                INNER JOIN tipo_proceso on tipo_proceso.pkID = procesos.fkID_tipo

                                WHERE estado_proceso.nombre = 'Abierto'

                                ORDER BY procesos.fecha_cierre ASC";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getProcesoSAdMC()
    {

        $this->q_general = "select procesos.*, pasos_proceso.nombre as nom_paso, entidades.nombre_entidad as nom_entidad, estado_proceso.nombre as nom_estado, tipo_proceso.nombre as nom_tipo

                                FROM procesos

                                INNER JOIN pasos_proceso ON pasos_proceso.pkID = procesos.fkID_paso_actual

                                INNER JOIN entidades on entidades.pkID = procesos.fkID_entidad

                                INNER JOIN estado_proceso on estado_proceso.pkID = procesos.fkID_estado

                                INNER JOIN tipo_proceso on tipo_proceso.pkID = procesos.fkID_tipo

                                WHERE tipo_proceso.pkID = 6

                                ORDER BY procesos.fecha_cierre ASC";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getContratoId($pkID)
    {

        $this->q_general = "select *,c.nombre AS ciudad_cedula,tipo_contrato.nombre AS tipo_contrato,hoja_vida.direccion AS dir_empleado,DAY(fechaIni) AS dia,MONTH(fechaIni) AS mes,YEAR(fechaIni) AS anio,DAY(fechaFin) AS dia_fin,MONTH(fechaFin) AS mes_fin,YEAR(fechaFin) AS anio_fin, contratos.pkID AS pkID,CONCAT(hoja_vida.nombre,' ',hoja_vida.apellido) AS empleado,empresa.nombre AS empleador,cargo.nombre AS cargo,ciudad.nombre AS ciudad,tipo_contrato.nombre AS tipoContrato FROM contratos
                                INNER JOIN hoja_vida ON hoja_vida.pkID = contratos.fkID_empleado
                                INNER JOIN empresa ON empresa.pkID = contratos.fkID_empleador
                                INNER JOIN cargo ON cargo.pkID = contratos.fkID_cargo
                                INNER JOIN ciudad ON ciudad.pkID = contratos.fkID_ciudad
                                LEFT JOIN ciudad c ON c.pkID = hoja_vida.ciudadCed
                                INNER JOIN tipo_contrato ON tipo_contrato.pkID = contratos.fkID_tipoContrato
                                WHERE contratos.pkID = " . $pkID;

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getProcesoCod()
    {

        $this->q_general = "select * FROM `procesos`";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    //-------------------------------------------------------------------------------------------------------
    //funciones indicadores empresa

    public function getIndicadoresProceso($pkID)
    {

        $this->q_general = "select * FROM `indicadores_proceso` WHERE fkID_proceso = " . $pkID;

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getIndicadoresEmpresas()
    {

        $anio_actual = date("Y") - 1;

        //echo 'Año actual = '.$anio_actual.' <br> <br>';

        $this->q_general = "select info_financiera.*, empresa.nombre as nom_empresa

                                FROM `info_financiera`

                                INNER JOIN empresa ON empresa.pkID = info_financiera.fkID_empresa

                                WHERE info_financiera.anio = " . $anio_actual . "

                                order by info_financiera.anio DESC";

        return GenericoDAO::EjecutarConsulta($this->q_general);

    }

    //--------------------------------------------------------------------------------------------------------

    public function getUsuarioAsig($pkID_proceso)
    {

        $this->q_general = "select pasos.*, usuarios.nombre, usuarios.apellido

                                FROM pasos

                                INNER JOIN usuarios ON usuarios.pkID = pasos.pkID_usuario_asignado

                                where pasos.pkID_proceso = " . $pkID_proceso . " AND pasos.actual = 1";

        return GenericoDAO::EjecutarConsulta($this->q_general);

    }

    public function getPasosProcesoW($pkID_proceso)
    {

        $this->q_general = "select pasos.*, a.nombre as nom_paso1, b.nombre as nom_paso2

                                FROM pasos

                                INNER JOIN pasos_proceso a ON pasos.idPaso1 = a.pkID

                                INNER JOIN pasos_proceso b ON pasos.idPaso2 = b.pkID

                                where pkID_proceso = " . $pkID_proceso . " ORDER BY pasos.pkID DESC";

        return GenericoDAO::EjecutarConsulta($this->q_general);

    }

    public function getPasoProcesoC($pkID_proceso)
    {

        $this->q_general = "select pasos.fecha, pasos.idPaso2, pasos_proceso.nombre

                                FROM `pasos`

                                INNER JOIN pasos_proceso ON pasos_proceso.pkID = pasos.idPaso2

                                WHERE pasos.pkID_proceso = " . $pkID_proceso;

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getEstadoProceso()
    {

        $this->q_general = "select * FROM `estado_proceso`";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getTipoProceso()
    {

        $this->q_general = "select * FROM `tipo_proceso`";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getTipoProcesoSelect()
    {

        $this->q_general = "select * FROM `tipo_proceso` ORDER BY nombre='Contratación Directa' DESC, nombre ASC";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getPasosProceso()
    {

        $this->q_general = "select * FROM `pasos_proceso` where pkID = 1";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getEmpleado()
    {

        $this->q_general = "select *,CONCAT(nombre,' ',apellido) AS nombres FROM `hoja_vida` ORDER BY nombres";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getEmpleadoId($pkID)
    {

        $this->q_general = "select *,CONCAT(nombre,' ',apellido) AS nombres FROM `hoja_vida`
                                INNER JOIN contratos ON contratos.fkID_empleado = hoja_vida.pkID
                                WHERE contratos.pkID = " . $pkID;

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getEmpleador()
    {

        $this->q_general = "select * FROM `empresa` ORDER BY nombre";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getCargo()
    {

        $this->q_general = "select * FROM `cargo` ORDER BY nombre";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getCiudad()
    {

        $this->q_general = "select * FROM `ciudad` ORDER BY nombre";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getTipoContrato()
    {

        $this->q_general = "select * FROM `tipo_contrato` ORDER BY nombre_tipo_contrato";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getCargos()
    {

        $this->q_general = "select * FROM cargo ORDER BY nombre_cargo";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getArl()
    {

        $this->q_general = "select arl.pkID, concat_ws('  ',arl.codigo_arl, arl.nombre_arl) as nomarl FROM arl ORDER BY nombre_arl";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getEps()
    {

        $this->q_general = "select eps.pkID, concat_ws('  ',eps.codigo_eps, eps.nombre_eps) as nomeps FROM eps ORDER BY nombre_eps";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getCajac()
    {

        $this->q_general = "select caja_compensacion.pkID, concat_ws('  ',caja_compensacion.codigo_caja_compensacion, caja_compensacion.nombre_caja_compensacion) as nomcc FROM caja_compensacion ORDER BY nombre_caja_compensacion";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getCesan()
    {

        $this->q_general = "select cesantias.pkID, concat_ws('  ',cesantias.codigo_cesantias, cesantias.nombre_cesantias) as nomce FROM cesantias ORDER BY nombre_cesantias";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getPens()
    {

        $this->q_general = "select pensiones.pkID, concat_ws('  ',pensiones.codigo_pensiones, pensiones.nombre_pensiones) as nompe FROM pensiones ORDER BY nombre_pensiones";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getDepartamento()
    {

        $this->q_general = "select * FROM departamento ORDER BY nombre_departamento";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }
    /*-----------------------------------------*/

    //-----------------------------------------------------------
    //FUNCION CONTADOR DE PROcesos EN LA PAGINA DE INICIO
    public function getNumProcesos()
    {

        $this->q_general = "select count(*) as numProcesos from procesos";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }
    //-----------------------------------------------------------

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //Documentos
    public function getTipoDocumentoProceso()
    {

        $this->q_general = "select * FROM `tipo_documento_proceso`";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }
    //consulta de las cedulas hv.
    public function getCedula()
    {

        $this->q_general = "select pkID,concat_ws(' ',hoja_vida.nidentificacion, hoja_vida.nombre,hoja_vida.apellido) as nidentificacion FROM `hoja_vida` ORDER BY `nidentificacion` ASC";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getDocumentosProceso($pkID)
    {

        $this->q_general = "select documentos_proceso.*, tipo_documento_proceso.nombre_tdoc as nom_tipoDocumento

                                FROM `documentos_proceso`

                                INNER JOIN tipo_documento_proceso ON tipo_documento_proceso.pkID = documentos_proceso.fkID_tipo

                                where documentos_proceso.fkID_proceso = " . $pkID . " order by documentos_proceso.pkID desc";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
}
