<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class itemsModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getCategorias() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM categoria_producto WHERE 1 ORDER BY nombre_cat ASC;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getCategoriasestado() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM categoria_producto WHERE estado = 1 ORDER BY nombre_cat ASC;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getcategoria($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * FROM categoria_producto WHERE id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function nueva_categoria($nombre_cat) {

        $this->_db->query("INSERT INTO categoria_producto (nombre_cat) VALUES ('".$nombre_cat."');");
    }

    public function editar_categoria($id, $nombre_cat,$estado) {

        $this->_db->query("UPDATE categoria_producto SET nombre_cat='".$nombre_cat."', estado =".$estado." WHERE id = $id;");
    }

    public function eliminar_categoria($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM categoria_producto Where id = $id;");
    }

    public function getsubCategorias() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT sc.*, c.nombre_cat FROM subcategoria_producto as sc,
            categoria_producto as c WHERE sc.id_categoria = c.id ORDER BY c.nombre_cat ASC , sc.nombre_subcategoria ASC;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getsubCategoriasestado() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM subcategoria_producto 
                WHERE estado = 1 ORDER BY nombre_subcategoria ASC;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getsubCategoriascombo($id_categoria) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM subcategoria_producto 
                WHERE estado = 1 AND id_categoria = $id_categoria ORDER BY nombre_subcategoria ASC;");
        //Se retorna la consulta y se recorren los registros
        return json_encode($consulta);
    }


    public function getsubcategoria($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT sc.*,c.nombre_cat FROM subcategoria_producto as sc ,
                categoria_producto as c WHERE sc.id_categoria = c.id AND sc.id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function nueva_subcategoria($nombre_subcategoria , $id_categoria) {

        $this->_db->query("INSERT INTO subcategoria_producto (nombre_subcategoria, id_categoria) 
            VALUES ('".$nombre_subcategoria."',".$id_categoria.");");
    }

    public function editar_subcategoria($id, $nombre_subcategoria, $id_categoria, $estado) {

        $this->_db->query("UPDATE subcategoria_producto SET nombre_subcategoria='".$nombre_subcategoria."',
                                                            id_categoria=".$id_categoria.",
                                                            estado =".$estado." 
                                                            WHERE id = $id;");
    }

    public function eliminar_subcategoria($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM subcategoria_producto Where id = $id;");
    }

    public function gettallas() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM tallas  WHERE 1 ORDER BY talla ASC;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function gettalla($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * FROM tallas WHERE id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function nueva_talla($talla) {

        $this->_db->query("INSERT INTO tallas (talla) VALUES ('".$talla."');");
    }

    public function editar_talla($id, $talla) {

        $this->_db->query("UPDATE tallas SET talla='".$talla."' WHERE id = $id;");
    }

    public function eliminar_talla($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM tallas Where id = $id;");
    }

    public function getproductos() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT p.*,
                                                t.talla as tropa,
                                                m.marca as marca,
                                                c.nombre_cat as categoria,
                                                sc.nombre_subcategoria as subcategoria
                                                FROM productos as p,
                                                tallas as t,
                                                subcategoria_producto as sc,
                                                categoria_producto as c,
                                                marca as m
                                                WHERE p.id_marca = m.id
                                                ANd p.id_categoria = c.id
                                                ANd p.id_subcategoria = sc.id
                                                AND p.talla = t.id 
                                                ORDER BY p.referencia ASC;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getproducto($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT p.*,
                                                t.talla as tropa,
                                                m.marca as marca,
                                                c.nombre_cat as categoria,
                                                sc.nombre_subcategoria as subcategoria
                                                FROM productos as p,
                                                tallas as t,
                                                subcategoria_producto as sc,
                                                categoria_producto as c,
                                                marca as m
                                                WHERE p.id_marca = m.id
                                                ANd p.id_categoria = c.id
                                                ANd p.id_subcategoria = sc.id
                                                AND p.talla = t.id 
                                                AND p.id=$id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function nuevo_producto($marca, $categoria, $subcategoria, $referencia, $color , $talla, $precio) {

        $this->_db->query("INSERT INTO productos (id_marca, id_categoria, id_subcategoria, referencia, color, talla, precio) 
                        VALUES (".$marca.",".$categoria.",".$subcategoria.",'".$referencia."','".$color."',".$talla.",".$precio.",);");
    }

    public function editar_producto($id, $marca, $categoria, $subcategoria, $referencia, $color , $talla, $precio, $estado) {

        $this->_db->query("UPDATE productos SET id_marca=".$marca.",
                                                id_categoria=".$categoria.",
                                                id_subcategoria=".$subcategoria.",
                                                referencia='".$referencia."',
                                                color='".$color."',
                                                talla=".$talla.",
                                                precio=".$precio.",
                                                estado=".$estado."
                                                WHERE id = $id;");
    }

    public function eliminar_producto($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM productos Where id = $id;");
    }

    public function getmarcas() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM marca  WHERE 1 ORDER BY marca ASC;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getimg_productos($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM img_productos WHERE id_producto=$id;");
            echo "SELECT * FROM img_productos WHERE id_producto=$id;";
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function foto_item_nueva($id, $nombre, $ext) {

        $this->_db->query("INSERT INTO img_productos (id_producto, archivo, ext) 
                        VALUES (".$id.",'".$nombre."','".$ext."');");
    }

    public function getfotoproducto($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT * FROM img_productos WHERE id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function foto_item_eliminar($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM img_productos Where id = $id;");
    }
}

?>
