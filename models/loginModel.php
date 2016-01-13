<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class loginModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }


    public function getUsuario($usuario, $password) {
        $datos = $this->_db->get_row(
                "SELECT 
					u.id as id_usuario,
					u.usuario,
					u.tipo_usuario,
					u.estado as estado_usuario,
					a.id as id_afiliado,
					a.nro_documento,
					a.nombres,
					a.apellidos,
					a.estado as estado_afiliado
				 FROM ok_usuarios as u, ok_afiliado as a
					WHERE a.id = u.fk_afiliado
					AND usuario ='" . $this->_db->escape($usuario) . "'
					AND contrasena = '" . Hash::getHash('sha1', $password, HASH_KEY) . "'");
	
        return $datos;
    }

	public function bitacora_login($id_usuario) {
        $id_usuario = (int) $id_usuario; /* Parse de la variable */
		$fechaactual = date("Y-m-d H:i:s");	
		$sitio_ingreso = 2; //pagina web
        $this->_db->query("INSERT INTO ok_bitacora_inicio
							(
								id,
								fecha_ingreso,
								fk_usuario,
								sitio_ingreso
							)
							VALUES
							(
								null,
								'".$fechaactual."',
								$id_usuario,
								$sitio_ingreso
							);
							");
							
        $this->_db->query("UPDATE ok_usuarios
							SET
								ultimo_ingreso = '".$fechaactual."'
							WHERE id = $id_usuario");
    }

	public function bitacora_login_cerrar($id_usuario) {
        $id_usuario = (int) $id_usuario; /* Parse de la variable */
		$fechaactual = date("Y-m-d H:i:s");	

        $datos = $this->_db->get_row("SELECT id FROM ok_bitacora_inicio
											WHERE fk_usuario = $id_usuario
										ORDER BY id DESC
										LIMIT 0,1;");
							
        $this->_db->query("UPDATE ok_bitacora_inicio
							SET
								fecha_desconexion = '".$fechaactual."'
							WHERE id = $datos->id");
							

    }		
}

?>
