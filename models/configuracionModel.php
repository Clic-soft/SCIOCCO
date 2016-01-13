<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class configuracionModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getRoles() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM roles WHERE 1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getRol($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * FROM roles WHERE id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function nuevo_rol($rol) {

        $this->_db->query("INSERT INTO roles (rol) VALUES ('".$rol."');");
    }

    public function editar_rol($id, $rol) {

        $this->_db->query("UPDATE roles SET rol='".$rol."' WHERE id = $id;");
    }

    public function eliminar_rol($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM roles Where id = $id;");
    }

    public function getT_Documentos() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM tipo_documento WHERE 1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function gett_documento($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * FROM tipo_documento WHERE id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function nuevo_t_doc($tipo_doc) {

        $this->_db->query("INSERT INTO tipo_documento (tipo_doc) VALUES ('".$tipo_doc."');");

        echo "INSERT INTO tipo_documento (tipo_doc) VALUES ('".$tipo_doc."');";
    }

    public function editar_t_doc($id, $tipo_doc) {

        $this->_db->query("UPDATE tipo_documento SET tipo_doc='".$tipo_doc."' WHERE id = $id;");
    }

    public function eliminar_t_documento($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM tipo_documento Where id = $id;");
    }  

    public function getT_Novedades() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM tipo_novedad WHERE 1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function gett_novedad($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * FROM tipo_novedad WHERE id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function nuevo_t_nov($nombre) {

        $this->_db->query("INSERT INTO tipo_novedad (nombre) VALUES ('".$nombre."');");
    }

    public function editar_t_nov($id, $nombre, $estado) {

        $this->_db->query("UPDATE tipo_novedad SET nombre='".$nombre."', estado = $estado WHERE id = $id;");
    }

    public function eliminar_t_nov($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM tipo_novedad Where id = $id;");
    }    

}

?>
