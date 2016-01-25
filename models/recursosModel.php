<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class recursosModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getBanners() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM roles WHERE 1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getbanner($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * FROM roles WHERE id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function nuevo_banner($rol) {

        $this->_db->query("INSERT INTO roles (rol) VALUES ('".$rol."');");
    }

    public function editar_banner($id, $rol) {

        $this->_db->query("UPDATE roles SET rol='".$rol."' WHERE id = $id;");
    }

    public function eliminar_banner($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM roles Where id = $id;");
    }

}

?>
