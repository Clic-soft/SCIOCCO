<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class clientesModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getClientes() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT  c.id,
                                                c.num_doc,
                                                CONCAT(c.nombres,' ',c.apellidos) AS nombre,
                                                c.fecha_reg,
                                                u.usuario,
                                                td.tipo_doc
                                                FROM usuarios AS u, cliente AS c,  tipo_documento AS td
                                                WHERE c.id_usuario = u.id
                                                AND c.id_tipo_doc = td.id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

   

    public function getCliente($id) {
        //Se crea y ejecuta la consulta
        $id = (int) $id; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT  c.*,
                                                CONCAT(c.nombres,' ',c.apellidos) AS nombre,
                                                u.usuario,
                                                td.tipo_doc
                                                FROM usuarios AS u, cliente AS c,  tipo_documento AS td
                                                WHERE c.id_usuario = u.id
                                                AND c.id_tipo_doc = td.id
                                                AND c.id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

     public function getusuarios() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM usuarios WHERE 1");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    
    public function validardocumento($tipodoc, $numdoc) {
        //Se crea y ejecuta la consulta
        $tipodoc = (int) $tipodoc; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT c.id FROM cliente AS c 
                                            WHERE c.id_tipo_doc = $tipodoc
                                            AND c.num_doc = '".$numdoc."';");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function validarusuarioedita($tipodoc, $numdoc, $id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT u.id FROM usuarios AS u WHERE u.usuario = '".$usuario."'
                and id != $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
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
