<?php

include_once 'GenericoDAO.php';
include_once 'PermisosDAO.php';

/**
 * Clase que maneja todas las consultas que tienen que ver con los usuarios
 */
class UsuariosDAO extends GenericoDAO{
    
    public $permisos;

    /**
     * Constructor de la clase
     */
    public function __construct() {
        parent::__construct();
    }

    public function permisos($fkID_modulo,$fkID_tipo_usuario){

      $this->permisos = new PermisosDAO();

      $arrayPermisos = $this->permisos->getPermisosModulo_Tipo($fkID_modulo,$fkID_tipo_usuario);

      return $arrayPermisos;

    }
    
    public function getUsuarios(){        
       
      $query = "select usuarios.*, tipo_usuario.nombre as nom_tipo

                FROM `usuarios` 

                INNER JOIN tipo_usuario ON tipo_usuario.pkID = usuarios.fkID_tipo
                                
                order by usuarios.pkID desc";

      return GenericoDAO::EjecutarConsulta($query);
    }

    public function getEmpresasId($pkID_usuario){

      $query = "select empresa.*, usuarios.alias 

                FROM empresa

                INNER JOIN usuarios_empresas ON usuarios_empresas.fkID_empresa = empresa.pkID

                INNER JOIN usuarios ON usuarios_empresas.fkID_usuario = usuarios.pkID

                WHERE usuarios.pkID = ".$pkID_usuario;

      return GenericoDAO::EjecutarConsulta($query);

    }

    public function getUsuariosNoAdmin(){        
       //$sql = <<<SQL SELECT * FROM usuarios SQL;
       //return GenericoDAO::EjecutarConsulta($sql);
      $query = "select usuarios.*, tipo_usuario.nombre as nom_tipo

                FROM `usuarios` 

                INNER JOIN tipo_usuario ON tipo_usuario.pkID=usuarios.fkID_tipo                
                
                WHERE NOT usuarios.fkID_tipo = 1

                ORDER BY tipo_usuario.nombre";

      return GenericoDAO::EjecutarConsulta($query);
    }

    public function getUsuarioId($pkID){        
       //$sql = <<<SQL SELECT * FROM usuarios SQL;
       //return GenericoDAO::EjecutarConsulta($sql);
      $query = "select usuarios.*, tipo_usuario.nombre as nom_tipo

                FROM `usuarios` 

                INNER JOIN tipo_usuario ON tipo_usuario.pkID = usuarios.fkID_tipo                                            

                WHERE usuarios.pkID = ".$pkID." order by usuarios.pkID desc";

      return GenericoDAO::EjecutarConsulta($query);
    }

    public function getUsuariosReporte(){        
       //$sql = <<<SQL SELECT * FROM usuarios SQL;
       //return GenericoDAO::EjecutarConsulta($sql);
      $query = "select usuarios.pkID, usuarios.alias, usuarios.nombres, usuarios.apellidos, usuarios.numero_cc, tipo_usuario.nombre as nom_tipo

                FROM `usuarios` 

                INNER JOIN tipo_usuario ON tipo_usuario.pkID=usuarios.fkID_tipo 

                ORDER BY `usuarios`.`pkID` ASC";

      return GenericoDAO::EjecutarConsulta($query);
    }

    public function getTipoUsuarios(){        
       //$sql = <<<SQL SELECT * FROM usuarios SQL;
       //return GenericoDAO::EjecutarConsulta($sql);
      $query = "select * FROM `tipo_usuario`";

      return GenericoDAO::EjecutarConsulta($query);
    }
	
	 public static function getUsuariosLogin($p_usuario,$p_password){           	

      $query = "select usuarios.*, tipo_usuario.nombre as t_usuario

                FROM `usuarios`

                inner join tipo_usuario on tipo_usuario.pkID = usuarios.fkID_tipo

                where usuarios.alias='".$p_usuario."' and usuarios.pass=SHA1('".$p_password."')";
   			
		$Conector = new Conexion();
		$db=$Conector->connect();		
		
		return GenericoDAO::EjecutarConsulta($query);
		
    }
	
}
/*
$Usr_Mail="jsmorales";
$Usr_Clave="12345";    
$matriz=UsuariosDAO::getUsuariosLogin($Usr_Mail,$Usr_Clave);
print_r($matriz);
*/
?>
