<?php

include_once 'GenericoDAO.php';
include_once 'PermisosDAO.php';

class hvida extends GenericoDAO
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

    /*-----------------------------------------*/

    public function permisos($fkID_modulo, $fkID_tipo_usuario)
    {

        $this->permisos = new PermisosDAO();

        $arrayPermisos = $this->permisos->getPermisosModulo_Tipo($fkID_modulo, $fkID_tipo_usuario);

        return $arrayPermisos;

    }

    //funciones generales
    public function getHvida()
    {

        $this->q_general = "select *,CONCAT(hoja_vida.nombre,' ',apellido) AS nombres,hoja_vida.pkID AS pkID,estado.nombre AS nom_estado,hoja_vida.nombre AS nombre,(SELECT b.nombre FROM hoja_estudio a JOIN estudio b ON a.pkID_estudio=b.pkID WHERE b.fkID_tipoEstudio=8 and a.pkID_hojaVida=hoja_vida.pkID limit 0,1) as tecnicos,(SELECT b.nombre FROM hoja_estudio a JOIN estudio b ON a.pkID_estudio=b.pkID WHERE b.fkID_tipoEstudio=9 and a.pkID_hojaVida=hoja_vida.pkID limit 0,1) as tecnologos,(SELECT b.nombre FROM hoja_estudio a JOIN estudio b ON a.pkID_estudio=b.pkID WHERE b.fkID_tipoEstudio=1 and a.pkID_hojaVida=hoja_vida.pkID limit 0,1) as pregrados,(SELECT b.nombre FROM hoja_estudio a JOIN estudio b ON a.pkID_estudio=b.pkID WHERE (b.fkID_tipoEstudio=3 or b.fkID_tipoEstudio=4 or b.fkID_tipoEstudio=5 or b.fkID_tipoEstudio=6)  and a.pkID_hojaVida=hoja_vida.pkID limit 0,1) as posgrados,(SELECT b.nombre FROM hoja_estudio a JOIN estudio b ON a.pkID_estudio=b.pkID WHERE b.fkID_tipoEstudio=7 and a.pkID_hojaVida=hoja_vida.pkID limit 0,1) as certificaciones FROM hoja_vida
	 					 INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado
	 					 LEFT JOIN hoja_estudio ON hoja_estudio.pkID_hojaVida = hoja_vida.pkID WHERE hoja_vida.estadoV=1
	 					 GROUP BY hoja_vida.pkID";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getHvidaPersonal()
    {

        $this->q_general = "select hoja_vida.*, estado.nombre as nom_estado
								FROM `hoja_vida`
								INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado

                                WHERE hoja_vida.fkID_estado = 1 OR hoja_vida.fkID_estado = 3";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    /*
    consulta general de busqueda por estudios

    select hoja_vida.*, estado.nombre as nom_estado, usuarios.alias, usuarios.pkID as pkID_usuario, estudio.nombre as nom_estudio, tipo_estudio.nombre as nom_tipoEstudio

    from hoja_vida

    INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado

    INNER JOIN usuarios ON usuarios.pkID = hoja_vida.fkID_usuario

    INNER JOIN hoja_estudio on hoja_vida.pkID = hoja_estudio.pkID_hojaVida

    INNER JOIN estudio ON hoja_estudio.pkID_estudio = estudio.pkID

    INNER JOIN tipo_estudio on estudio.fkID_tipoEstudio = tipo_estudio.pkID

     */

    public function getHvidaS($param)
    {

        $this->q_general = "select hoja_vida.*, estado.nombre as nom_estado, estudio.nombre as nom_estudio, tipo_estudio.nombre as nom_tipoEstudio

								from hoja_vida

								INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado

								INNER JOIN hoja_estudio on hoja_vida.pkID = hoja_estudio.pkID_hojaVida

								INNER JOIN estudio ON hoja_estudio.pkID_estudio = estudio.pkID

								INNER JOIN tipo_estudio on estudio.fkID_tipoEstudio = tipo_estudio.pkID

								WHERE hoja_estudio.pkID_hojaVida " . $param . "

								GROUP BY hoja_vida.pkID";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getHojaEstudio()
    {

        $this->q_general = "select * FROM `hoja_estudio`";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getEstudio()
    {

        $this->q_general = "select estudio.*, tipo_estudio.nombre as nom_tipo_estudio
								FROM `estudio`
								INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    //Consulta la ciudad
    public function getCiudad()
    {

        $this->q_general = "SELECT * FROM ciudad ORDER BY nombre";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getPregrado()
    {

        $this->q_general = "select estudio.*, tipo_estudio.nombre as nom_tipo_estudio
								FROM `estudio`
								INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio
                                WHERE estudio.fkID_tipoEstudio = 1
                                ORDER BY nombre";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getTecnico()
    {

        $this->q_general = "select estudio.*, tipo_estudio.nombre as nom_tipo_estudio
								FROM `estudio`
								INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio
                                WHERE estudio.fkID_tipoEstudio = 8
                                ORDER BY nombre";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getTecnologo()
    {

        $this->q_general = "select estudio.*, tipo_estudio.nombre as nom_tipo_estudio
								FROM `estudio`
								INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio
                                WHERE estudio.fkID_tipoEstudio = 9
                                ORDER BY nombre";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getCertificacion()
    {

        $this->q_general = "select estudio.*, tipo_estudio.nombre as nom_tipo_estudio
								FROM `estudio`
								INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio
                                WHERE estudio.fkID_tipoEstudio = 7
                                ORDER BY nombre";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    //SELECT * FROM `tipo_estudio`

    public function getTipoEstudio()
    {

        $this->q_general = "select * FROM `tipo_estudio`";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getPosgrado()
    {

        $this->q_general = "select estudio.*, tipo_estudio.nombre as nom_tipo_estudio
								FROM `estudio`
								INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio
                                WHERE estudio.fkID_tipoEstudio >=3 AND estudio.fkID_tipoEstudio <=6
                                ORDER BY nombre";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getEstado()
    {

        $this->q_general = "select * from estado ORDER BY nombre";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getNumHojas()
    {

        $this->q_general = "select count(*) as numHojas from hoja_vida";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    //---------------------------------------------------------------------------------------------------------
    //Funciones específicas

    public function getHvidaId($id_hvida)
    {

        $this->q_general = "select hoja_vida.*, estado.nombre as nom_estado
								FROM `hoja_vida`
								INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado
								WHERE hoja_vida.pkID = " . $id_hvida;

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getEstudioId($id_hvida)
    {

        $this->q_general = "select hoja_vida.pkID as pkID_hojaVida, estudio.*, tipo_estudio.nombre as nom_tipoEstudio, hoja_estudio.pkID as pkID_regHojaEstudio" .

            " FROM `hoja_vida`" .

            " INNER JOIN hoja_estudio ON hoja_estudio.pkID_hojaVida = hoja_vida.pkID" .

            " INNER JOIN estudio on estudio.pkID = hoja_estudio.pkID_estudio" .

            " INNER JOIN tipo_estudio ON tipo_estudio.pkID = estudio.fkID_tipoEstudio" .

            " WHERE hoja_vida.pkID =" . $id_hvida;

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getArchivosId($id_hvida)
    {

        $this->q_general = "select * FROM `archivo` WHERE pkID_hojaVida =" . $id_hvida;

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    //--------------------------------------------------------------------------------
    //consultas para personal en el modulo proyectos

    public function getPersonalProyecto($pkID_proyecto)
    {

        $this->q_general = "select hv_proyecto.*, hoja_vida.nidentificacion,hoja_vida.nombre, hoja_vida.apellido, hoja_vida.telefono, hoja_vida.email, estado.nombre as nom_estado

								FROM `hv_proyecto` INNER JOIN hoja_vida ON hoja_vida.pkID = hv_proyecto.fkID_hv

								INNER JOIN proyectos on proyectos.pkID = hv_proyecto.fkID_proyecto

								INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado

								WHERE proyectos.pkID =" . $pkID_proyecto . " order by hv_proyecto.pkID desc";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }
    //--------------------------------------------------------------------------------

    public function getHvidaFuntecso()
    {

        $this->q_general = "select hoja_vida.*, estado.nombre as nom_estado, (select b.nombre  from hoja_estudio a join estudio b on a.pkID_estudio=b.pkID where b.fkID_tipoEstudio=1 and a.pkID_hojaVida=hoja_vida.pkID limit 0,1) as pregrados
								FROM `hoja_vida`
								INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado
							    WHERE estado.pkID = 4";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getHvidaSFuntecso($param)
    {

        $this->q_general = "select hoja_vida.*, estado.nombre as nom_estado,  estudio.nombre as nom_estudio, tipo_estudio.nombre as nom_tipoEstudio

								from hoja_vida

								INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado


								INNER JOIN hoja_estudio on hoja_vida.pkID = hoja_estudio.pkID_hojaVida

								INNER JOIN estudio ON hoja_estudio.pkID_estudio = estudio.pkID

								INNER JOIN tipo_estudio on estudio.fkID_tipoEstudio = tipo_estudio.pkID

								WHERE hoja_estudio.pkID_hojaVida " . $param . "

								AND estado.pkID = 4 GROUP BY hoja_vida.pkID";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getHojaEstudioFuntecso()
    {

        $this->q_general = "select hoja_estudio.* from hoja_vida
								INNER JOIN hoja_estudio ON hoja_vida.pkID = hoja_estudio.pkID_hojaVida
								INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado
								WHERE estado.pkID = 4 ";

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getEstadoId($pkID)
    {

        $this->q_general = "select * FROM `estado` WHERE pkID=" . $pkID;

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getHvidaFiltro($filtro)
    {

        //$this->fecha_4m = date( "Y-m-d",mktime(0, 0, 0, date("m")-4,date("d"), date("Y")));
        //$this->fecha_hoy = date( "Y-m-d",mktime(0, 0, 0, date("m"),date("d"), date("Y")));

        //echo "Mostrando gastos por <strong>Fecha Límite</strong> desde: ".$this->fecha_4m." hasta: ".$this->fecha_hoy." <br><br>";

        $this->q_general = "select hoja_vida.*, estado.nombre as nom_estado,(select b.nombre  from hoja_estudio

								 a join estudio b on a.pkID_estudio=b.pkID where

								 b.fkID_tipoEstudio=1 and a.pkID_hojaVida=hoja_vida.pkID limit 0,1) as pregrados

								FROM `hoja_vida`

								INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado


								WHERE " . $filtro;

        //print_r($this->q_general);

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getHvidaFiltroFuntecso($filtro)
    {

        //$this->fecha_4m = date( "Y-m-d",mktime(0, 0, 0, date("m")-4,date("d"), date("Y")));
        //$this->fecha_hoy = date( "Y-m-d",mktime(0, 0, 0, date("m"),date("d"), date("Y")));

        //echo "Mostrando gastos por <strong>Fecha Límite</strong> desde: ".$this->fecha_4m." hasta: ".$this->fecha_hoy." <br><br>";

        $this->q_general = "select hoja_vida.*, estado.nombre as nom_estado,(select b.nombre  from hoja_estudio

								 a join estudio b on a.pkID_estudio=b.pkID where

								 b.fkID_tipoEstudio=1 and a.pkID_hojaVida=hoja_vida.pkID limit 0,1) as pregrados

								FROM `hoja_vida`

								INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado


								WHERE " . $filtro . " AND hoja_vida.fkID_estado = 4";

        //print_r($this->q_general);

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }

    public function getHvidaBusqueda($where, $veces_array)
    {

        $this->q_general = "select *,CONCAT(hoja_vida.nombre,' ',apellido) AS nombres,COUNT(hoja_estudio.pkID_hojaVida) AS veces,hoja_vida.pkID AS pkID,estado.nombre AS nom_estado,hoja_vida.nombre AS nombre,(SELECT b.nombre FROM hoja_estudio a JOIN estudio b ON a.pkID_estudio=b.pkID WHERE b.fkID_tipoEstudio=8 and a.pkID_hojaVida=hoja_vida.pkID limit 0,1) as tecnicos,(SELECT b.nombre FROM hoja_estudio a JOIN estudio b ON a.pkID_estudio=b.pkID WHERE b.fkID_tipoEstudio=9 and a.pkID_hojaVida=hoja_vida.pkID limit 0,1) as tecnologos,(SELECT b.nombre FROM hoja_estudio a JOIN estudio b ON a.pkID_estudio=b.pkID WHERE b.fkID_tipoEstudio=1 and a.pkID_hojaVida=hoja_vida.pkID limit 0,1) as pregrados,(SELECT b.nombre FROM hoja_estudio a JOIN estudio b ON a.pkID_estudio=b.pkID WHERE (b.fkID_tipoEstudio=3 or b.fkID_tipoEstudio=4 or b.fkID_tipoEstudio=5 or b.fkID_tipoEstudio=6)  and a.pkID_hojaVida=hoja_vida.pkID limit 0,1) as posgrados,(SELECT b.nombre FROM hoja_estudio a JOIN estudio b ON a.pkID_estudio=b.pkID WHERE b.fkID_tipoEstudio=7 and a.pkID_hojaVida=hoja_vida.pkID limit 0,1) as certificaciones FROM hoja_vida
	 					 INNER JOIN estado ON estado.pkID = hoja_vida.fkID_estado
	 					 INNER JOIN hoja_estudio ON hoja_estudio.pkID_hojaVida = hoja_vida.pkID
	 					 " . $where
            . " GROUP BY hoja_estudio.pkID_hojaVida
	 					 HAVING veces = " . $veces_array;

        return GenericoDAO::EjecutarConsulta($this->q_general);
        //return $this->q_general;
    }

    //Funcion para retornar los estudios por el tipo
    public function getEstudiosFK($id_hvida, $tipo_estudio)
    {
        $this->q_general = 'SELECT * FROM hoja_estudio
								INNER JOIN estudio ON estudio.pkID = hoja_estudio.pkID_estudio
								WHERE pkID_hojaVida = ' . $id_hvida . ' AND (fkID_tipoEstudio = ' . $tipo_estudio . ')';

        return GenericoDAO::EjecutarConsulta($this->q_general);
    }
}
/*
$data = new hvida();

$datos = $data->getHvida();

print_r($datos);
 */
