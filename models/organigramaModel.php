<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class organigramaModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

	    //Funcion que trae todos los registros
    public function getInfoReglamentos() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT 
													do.id,
													do.titulo,
													do.archivo,
													do.extension
												 FROM ok_documentos as do
												ORDER BY do.id DESC;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }			
}

?>
