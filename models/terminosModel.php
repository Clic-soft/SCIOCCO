<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class terminosModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function get_terminos() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM terminos WHERE 1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function get_termino($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * FROM terminos WHERE id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function nuevo_termino($nombre, $descripcion) {

        $this->_db->query("INSERT INTO terminos(nombre, descripcion) VALUES ('".$nombre."', '".$descripcion."');");
    }

    public function editar_termino($id, $nombre, $descripcion) {

        $this->_db->query("UPDATE terminos SET nombre='".$nombre."',
            descripcion='".$descripcion."'
            WHERE id = $id;");
    }

    public function eliminar_termino($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM terminos Where id = $id;");
    }   

}

?>
