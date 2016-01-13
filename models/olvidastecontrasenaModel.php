<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class olvidastecontrasenaModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }


    //Funcion que trae todos los registros
    public function comprobaremail($email) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT 
													af.id,
													af.correo
													FROM ok_afiliado as af,ok_usuarios as usu
													WHERE usu.fk_afiliado = af.id
													AND correo = '".$email."'
													LIMIT 0,1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function guardarmd5_recclave($idusuario,$md5_recclave) {
			
        $this->_db->query("UPDATE ok_usuarios
							SET
								md5_rec_clave = '".$md5_recclave."'
							WHERE fk_afiliado = ".$idusuario.";");
    }


    //Funcion que trae todos los registros
    public function comprobarasociado($md5_afiliado) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT id FROM ok_afiliado
												WHERE md5(id) ='".$md5_afiliado."'
													LIMIT 0,1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
	
    //Funcion que trae todos los registros
    public function comprobar_md5usuario($md5_afiliado,$md5_repclave) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT id FROM ok_usuarios
												WHERE md5_rec_clave='".$md5_repclave."'
												AND md5(fk_afiliado)='".$md5_afiliado."'
													LIMIT 0,1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }	

    function validarPassword($password1, $password2) {
        //NO coinciden
        if ($password1 != $password2)
            return false;
        else
            return true;
    }
	
    public function setPassword($id, $password) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("UPDATE ok_usuarios
                              SET `contrasena` = '" . Hash::getHash('sha1', $password, HASH_KEY) . "',
							  md5_rec_clave=''
                            WHERE `id` = $id");
    }
						
}

?>
