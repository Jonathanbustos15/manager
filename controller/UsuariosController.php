<?php

/*
Parametros para que funcionen las cookies en el servidor
socdss.com, ya que el php.ini no permite estas directivas
por seguridad.

ini_set("session.use_cookies", 0);
ini_set("session.use_only_cookies", 0);
ini_set("session.use_trans_sid", 1);
ini_set("session.cache_limiter", "");
session_start();
*/

include_once '../DAO/UsuariosDAO.php';

/**
 * La clase UsuariosController maneja toda la parte de procesamiento de datos de usuarios
 *
 */
class UsuariosController {

    //ATRIBUTOS DE LA CLASE

    public $UsuariosDAO;
    
    //CONSTRUCTOR DE LA CLASE

    public function __construct() {
        $this->UsuariosDAO = new UsuariosDAO();
    }

    //MÉTODOS DE LA CLASE

    /**
     * Función para guardar o actualizar un usuario, simplemente se encarga de guardar o actualizar
     * en la base de datos los parámetros que lleguen del usuario
     * @param Array $arrayDatos
     * @return boolean
     */
    public function guardarUsuario($arrayDatos) {
       
    }
	
	/**
     * Función para obtener usuarios
     * @param Array $arrayDatos
     * @return boolean
     */

	public function permisosUsuario($fkID_modulo,$fkID_tipo_usuario) {
        return $this->UsuariosDAO->permisos($fkID_modulo,$fkID_tipo_usuario);
    }

    public function getUsuarios() {
        return $this->UsuariosDAO->getUsuarios();
    }

    public function getTipoUsuarios() {
        
        $tipo = $this->UsuariosDAO->getTipoUsuarios();
        
        for($a=0;$a<sizeof($tipo);$a++){
        	echo "<option value='".$tipo[$a]["pkID"]."'>".$tipo[$a]["nombre"]."</option>";
        }
    }

    //---------------------------------------------------------------------------------
    public function getTablaUsuarios($tipo){

    	if ( $tipo == "Administrador") {
    		# code...

    		//get de los usuarios
	    	$usuarios = $this->UsuariosDAO->getUsuarios();

	    	//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisosUsuario(13,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//---------------------------------------------------------------------------------    

	    	//valida si hay usuarioes
	    	if( ($usuarios) && ($consulta==1) ){

	    		for($a=0;$a<sizeof($usuarios);$a++){

	             $id = $usuarios[$a]["pkID"];
	             $alias = $usuarios[$a]["alias"];                           
	             $nombres = $usuarios[$a]["nombre"];
	             $apellidos = $usuarios[$a]["apellido"];             
	             $nom_tipo = $usuarios[$a]["nom_tipo"];
	             $nom_empresa = $this->UsuariosDAO->getEmpresasId($id);
	                                             

	             echo '
	                         <tr>	                             
	                             <td>'.$alias.'</td>                                 
	                             <td>'.$nombres.'</td>
	                             <td>'.$apellidos.'</td>                             
	                             <td>'.$nom_tipo.'</td>
	                             <td>';
	                             //print_r($nom_empresa);
	                             if ( $nom_empresa != 0) {
	                             	foreach ($nom_empresa as $key => $value) {
		                             	echo $value["nombre"]."<br>";
		                             }
	                             } else {
	                             	echo "No Aplica";
	                             };	                             
	                             
	                      echo '</td>
		                         <td>
		                             <button id="btn_editar" name="edita_usuario" type="button" class="btn btn-warning" data-toggle="modal" data-target="#frm_modal_usuario" data-id-usuario = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
		                             <button id="btn_eliminar" name="elimina_usuario" type="button" class="btn btn-danger" data-id-usuario = "'.$id.'" ';  if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
		                         </td>
		                     </tr>';
	            };


	    	}elseif(($usuarios) && ($consulta==0)){

             echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		                              		                                          
		           </tr>
		           <h3>En este momento no tiene permiso de consulta para Usuarios.</h3>";
            }else{

	         echo "<tr>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>
		               <td></td>		               		                                            
		           </tr>
		           <h3>En este momento no hay Usuarios creados.</h3>";
	        };

    	} else {
    		# code...
    		$usuario = $this->UsuariosDAO->getUsuarioId($_COOKIE["log_lunelAdmin_id"]);

    		#print_r($usuario);

    		//permisos-------------------------------------------------------------------------
    		$arrPermisos = $this->permisosUsuario(13,$_COOKIE["log_lunelAdmin_IDtipo"]);
    		$edita = $arrPermisos[0]["editar"];
    		$elimina = $arrPermisos[0]["eliminar"];
    		$consulta = $arrPermisos[0]["consultar"];
    		//---------------------------------------------------------------------------------

    		for($a=0;$a<sizeof($usuario);$a++){

             $id = $usuario[$a]["pkID"];
             $alias = $usuario[$a]["alias"];                           
             $nombres = $usuario[$a]["nombre"];
             $apellidos = $usuario[$a]["apellido"];             
             $nom_tipo = $usuario[$a]["nom_tipo"];
             $nom_empresa = $this->UsuariosDAO->getEmpresasId($id);
                                             

             echo '
                         <tr>                             
                             <td>'.$alias.'</td>                                 
                             <td>'.$nombres.'</td>
                             <td>'.$apellidos.'</td>                             
                             <td>'.$nom_tipo.'</td>
                             <td>';
	                             //print_r($nom_empresa);
	                             if ( $nom_empresa != 0) {
	                             	foreach ($nom_empresa as $key => $value) {
		                             	echo $value["nombre"]."<br>";
		                             }
	                             } else {
	                             	echo "No Aplica";
	                             };	                             
	                             
	                  echo '</td>
	                         <td>
	                             <button id="btn_editar" name="edita_usuario" type="button" class="btn btn-warning" data-toggle="modal" data-target="#frm_modal_usuario" data-id-usuario = "'.$id.'" '; if ($edita != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-pencil"></span></button>		                             
	                             <button id="btn_eliminar" name="elimina_usuario" type="button" class="btn btn-danger" data-id-usuario = "'.$id.'" '; if ($elimina != 1){echo 'disabled="disabled"';} echo '><span class="glyphicon glyphicon-remove"></span></button>
	                         </td>
	                     </tr>';
            };

    	}
    	    	
    }
	
	public static function AutenticarUsuario(){
	
		$Usr_Mail=$_POST['username'];
		$Usr_Clave=$_POST['password'];
		
				
		$matriz=UsuariosDAO::getUsuariosLogin($Usr_Mail,$Usr_Clave);
		
		//print_r($matriz);
		
		$id=$matriz[0]['pkID'];
		$alias=$matriz[0]['alias'];
		$nombre=$matriz[0]['nombre'];
		$apellidos=$matriz[0]['apellido'];
		//$num_cc=$matriz[0]['numero_cc'];
		$tipo=$matriz[0]['t_usuario'];
		$id_tipo=$matriz[0]['fkID_tipo'];
		//$id_empresa=$matriz[0]['fkID_empresa'];		

		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if (($id!="") and ($nombre!="")){

			//$clientes = new clientes();

			//$res = $clientes->getClientesCc($num_cc);

			//$idCli=$res[0]['pkID'];

			/*
			setcookie("log_lunelAdmin_id", $id, time() + 3600, "/");
			//setcookie("log_lunelAdmin_idCli", $idCli, time() + 3600, "/");
			setcookie("log_lunelAdmin_alias", $alias, time() + 3600, "/");
			setcookie("log_lunelAdmin_nombre", $nombre." ".$apellidos, time() + 3600, "/");
			//setcookie("log_lunelAdmin_num_cc", $num_cc, time() + 3600, "/");
			setcookie("log_lunelAdmin_tipo", $tipo, time() + 3600, "/");*/

			setcookie("log_lunelAdmin_id", $id, time() + 3600*24, "/");
			//setcookie("log_lunelAdmin_idCli", $idCli, time() + 3600, "/");
			setcookie("log_lunelAdmin_alias", $alias, time() + 3600*24, "/");
			setcookie("log_lunelAdmin_nombre", $nombre." ".$apellidos, time() + 3600*24, "/");
			//setcookie("log_lunelAdmin_num_cc", $num_cc, time() + 3600, "/");
			setcookie("log_lunelAdmin_tipo", $tipo, time() + 3600*24, "/");
			setcookie("log_lunelAdmin_IDtipo", $id_tipo, time() + 3600*24, "/");
			//setcookie("log_lunelAdmin_IDempresa", $id_empresa, time() + 3600*24, "/");			

			//echo "la cookie queda:".$id."-".$nombre."-".$tipo;

			//echo "nombre desde la cookie:".$_COOKIE["log_usuario_nombre"];

		//	echo '<script language="JavaScript">
			//		alert("Bienvenido '.$nombre.' '.$apellidos.'");					
			//</script>';

			//print_r($res);

			//validar el tipo y redireccionar
			echo "<script language=javascript> location.href='../vistas/index.php'</script>";
				
		} else {
		
			echo '<script language="JavaScript">
					alert("Usuario o password incorrecto, en otro caso por favor verifique que su usuario este activo.");
					window.location = "javascript:history.back(-1)"
				</script>';
			}
		
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
						
	}
    
}

?>
