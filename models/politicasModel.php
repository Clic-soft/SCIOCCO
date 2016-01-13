<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class politicasModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }


    //Funcion que trae todos los registros
    public function getAviso($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * FROM ok_avisos_legales where id = $id");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
		
}

?>
