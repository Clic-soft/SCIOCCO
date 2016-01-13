<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class empresaModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getDatosEmpresa($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * FROM empresa WHERE id= $id");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
	}

    public function ActualizarDatosEmpresa($id, $nit, $razon, $rep, $tel, $cel, $dir, $email) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("UPDATE empresa SET nit=".$nit.",
            razon_social='".$razon."',
            rep_comercial='".$rep."',
            num_contacto=".$tel.",
            celular=".$cel.",
            direccion='".$dir."',
            email_contacto='".$email."' 
            WHERE id =".$id." ;");
    }

    public function getinfoemp() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM info_empresa WHERE 1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getinfo_emp($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * FROM info_empresa WHERE id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function nueva_info_emp($nombre, $descripcion) {

        $this->_db->query("INSERT INTO info_empresa(nombre, descripcion) VALUES ('".$nombre."', '".$descripcion."');");
    }

    public function editar_info_emp($id, $nombre, $descripcion) {

        $this->_db->query("UPDATE info_empresa SET nombre='".$nombre."',
            descripcion='".$descripcion."'
            WHERE id = $id;");
    }

    public function eliminar_info_emp($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM info_empresa Where id = $id;");
    }   


    public function getredes_sociales() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM redes_sociales WHERE 1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getred_social($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * FROM redes_sociales WHERE id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function nueva_red_social($nombre, $url) {

        $this->_db->query("INSERT INTO redes_sociales(nombre, url) VALUES ('".$nombre."', '".$url."');");
    }

    public function editar_red_social($id, $nombre, $url) {

        $this->_db->query("UPDATE redes_sociales SET nombre='".$nombre."',
            url='".$url."'
            WHERE id = $id;");
    }

    public function eliminar_red_social($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM redes_sociales Where id = $id;");
    } 	
}

?>
