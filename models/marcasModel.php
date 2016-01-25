<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class marcasModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getMarcas() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT  m.*, p.razon_social
                                                FROM  proveedores AS p,  marca AS m
                                                WHERE m.id_proveedor = p.id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getMarca($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT  m.*, p.razon_social
                                                FROM  proveedores AS p,  marca AS m
                                                WHERE m.id_proveedor = p.id
                                                AND m.id= $id");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getProveedor() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM proveedores ");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function crear_marca($id_proveedor, $marca) {

        $this->_db->query("INSERT INTO marca (id_proveedor, marca) VALUES 
        (".$id_proveedor.", '".$marca."');");
    }

    public function editar_marca($id, $id_proveedor, $marca, $estado) {

        $this->_db->query("UPDATE marca SET id_proveedor=".$id_proveedor.", 
                            marca='".$marca."',
                            estado=".$estado."
                            WHERE id = $id;");
    }



    public function eliminar_marca($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM marca Where id = $id;");
    }

    public function foto_marca($id, $nombre, $ext) {

        $this->_db->query("UPDATE marca SET archivo='".$nombre."', ext='".$ext."' WHERE id = $id;");
    }
}

?>
