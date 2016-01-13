<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class usuariosModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getUsuarios() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT u . * , r.rol
                                                FROM usuarios AS u, roles AS r
                                                WHERE u.id_rol = r.id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getroles() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM roles WHERE 1");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getUsuario($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT u . * , r.rol
                                                FROM usuarios AS u, roles AS r
                                                WHERE u.id_rol = r.id
                                                AND u.id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function validarusuario($usuario) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT u.id FROM usuarios AS u WHERE u.usuario = '".$usuario."';");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function validarusuarioedita($usuario,$id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT u.id FROM usuarios AS u WHERE u.usuario = '".$usuario."'
                and id != $id;");
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

    public function crear_usuario($usuario, $pass, $rol) {

        $this->_db->query("INSERT INTO usuarios (usuario, pass, id_rol) VALUES
                            ('".$usuario."',
                            '". Hash::getHash('md5', $pass, HASH_KEY) ."',
                            ".$rol.");");
    }

    public function editar_usuario($id, $usuario, $rol, $estado) {

        $this->_db->query("UPDATE usuarios SET usuario='".$usuario."', 
                            id_rol=".$rol.", 
                            estado=".$estado."
                            WHERE id = $id;");
    }

    public function validarclave($pass,$id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT u.id FROM usuarios AS u WHERE u.pass = '". Hash::getHash('md5', $pass, HASH_KEY) ."'
                and id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function editar_clave($id, $pass) {

        $this->_db->query("UPDATE usuarios SET pass='". Hash::getHash('md5', $pass, HASH_KEY) ."'
                            WHERE id = $id;");
    }

    public function eliminar_usuario($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM usuarios Where id = $id;");
    }
}

?>
