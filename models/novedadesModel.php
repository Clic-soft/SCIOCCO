<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class novedadesModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getNovedades() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT n.* ,tn.nombre as tnov
                                                FROM novedades as n,
                                                tipo_novedad as tn
                                                WHERE tn.id=n.id_tipo_novedad");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

   

    public function getNovedad($id) {
        //Se crea y ejecuta la consulta
        $id = (int) $id; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT n.* ,tn.nombre as tnov
                                                FROM novedades as n,
                                                tipo_novedad as tn
                                                WHERE tn.id=n.id_tipo_novedad
                                                AND n.id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function gettnovs() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT tn.* FROM tipo_novedad as tn where estado = 1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function crear_novedad($nombre, $desc, $tnov) {
        $fechaactual = date("Y-m-d H:i:s");
        $this->_db->query("INSERT INTO novedades (nombre, descripcion, id_tipo_novedad, fecha_creacion) VALUES
                            ('".$nombre."',
                            '".$desc."',
                            ".$tnov.",
                            '".$fechaactual."');");
    }

    public function editar_novedad($id, $nombre, $desc, $tnov) {

        $this->_db->query("UPDATE novedades SET nombre='".$nombre."', 
                            descripcion='".$desc."', 
                            id_tipo_novedad=".$tnov."
                            WHERE id = $id;");
    }

    public function foto_novedad($id, $nombre, $ext) {

        $this->_db->query("UPDATE novedades SET archivo='".$nombre."', ext='".$ext."' WHERE id = $id;");
    }




    public function eliminar_usuario($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM usuarios Where id = $id;");
    }
}

?>
