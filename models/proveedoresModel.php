<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class proveedoresModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getProveedores() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT  p.*, td.tipo_doc
                                                FROM  proveedores AS p,  tipo_documento AS td
                                                WHERE p.id_tipo_doc = td.id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getProveedor($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT  p.*, td.tipo_doc
                                                FROM  proveedores AS p,  tipo_documento AS td
                                                WHERE p.id_tipo_doc = td.id
                                                AND p.id= $id");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function gettipo_doc() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM tipo_documento ");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function validarproveedor($num) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT p.id FROM proveedores AS p WHERE p.num_doc = '".$num."';");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function validarproveedoredita($num,$id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT p.id FROM proveedores AS p WHERE p.num_doc = '".$num."'
                and id != $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }


    public function crear_proveedor($id_tipo_doc, $num_doc, $razon_social, $rep_comercial, $contacto ,$num_contacto ,$direccion
        ,$email) {

        $this->_db->query("INSERT INTO proveedores (id_tipo_doc, num_doc, razon_social, rep_comercial, contacto ,
        num_contacto, direccion, email) VALUES 
        (".$id_tipo_doc.", '".$num_doc."', '".$razon_social."', '".$rep_comercial."', '".$contacto."','".$num_contacto."',
        '".$direccion."','".$email."');");

        echo "INSERT INTO proveedores (id_tipo_doc, num_doc, razon_social, rep_comercial, contacto ,
        num_contacto, direccion, email) VALUES 
        (".$id_tipo_doc.", '".$num_doc."', '".$razon_social."', '".$rep_comercial."', '".$contacto."','".$num_contacto."',
        '".$direccion."','".$email."');";
    }

    public function editar_proveedor($id, $id_tipo_doc, $num_doc, $razon_social, $rep_comercial, $contacto ,$num_contacto ,$direccion
        ,$email, $estado) {

        $this->_db->query("UPDATE proveedores SET id_tipo_doc=".$id_tipo_doc.", 
                            num_doc='".$num_doc."',
                            razon_social='".$razon_social."',
                            rep_comercial='".$rep_comercial."',
                            contacto='".$contacto."',
                            num_contacto='".$num_contacto."',
                            direccion='".$direccion."',
                            email='".$email."', 
                            estado=".$estado."
                            WHERE id = $id;");
    }



    public function eliminar_proveedor($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM proveedores Where id = $id;");
    }
}

?>
