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
            $consulta = $this->_db->get_results("SELECT * FROM banners WHERE 1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getbanner($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * FROM banners WHERE id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function nuevo_banner($nombre , $tipo, $apertura, $url) {

        $this->_db->query("INSERT INTO banners (nombre, url, tipo_apertura, tipo) 
            VALUES ('".$nombre."' , '".$url."', '".$apertura."' , ".$tipo.");");
    }

    public function editar_banner($id, $nombre , $tipo, $apertura, $url, $estado) {

        $this->_db->query("UPDATE banners SET nombre='".$nombre."',
                                            url = '".$url."',
                                            tipo_apertura = '".$apertura."',
                                            tipo = ".$tipo.",
                                            estado = $estado
                                            WHERE id = $id;");
    }

    public function eliminar_banner($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM banners Where id = $id;");
    }

    public function foto_banner($id, $nombre, $ext) {

        $this->_db->query("UPDATE banners SET archivo='".$nombre."', ext='".$ext."' WHERE id = $id;");
    }

}

?>
