<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class micuentaModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getAfiliado($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT 
												fa.id,
												fa.nro_documento as num_docu,
												CONCAT(fa.nombres,' ',fa.apellidos) AS nombre,
												fa.fecha_nacimiento,
												fa.celular,
												fa.ciudad,
												fa.telefono,
												fa.direccion,
												fa.correo as email,
												fa.estado,
												fa.genero,
												fa.centro_costos,
												fa.empresa,
												fa.cargo,
												ciu.ciudad as ciudadnombre,
                                                td.tipo_documento
											 FROM ok_afiliado as fa,ok_ciudades as ciu,ok_tipo_documento as td
											WHERE ciu.id = fa.ciudad
                                            AND td.id = fa.tipo_documento
											AND fa.id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
	}

    function validarPassword($password1, $password2) {
        //NO coinciden
        if ($password1 != $password2)
            return false;
        else
            return true;
    }
	
    public function setPassword($id, $password) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("UPDATE ok_usuarios
                              SET `contrasena` = '" . Hash::getHash('sha1', $password, HASH_KEY) . "'
                            WHERE `id` = $id");
    }	

    public function validarPasswordactual($contrasena,$id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT 1 FROM ok_usuarios
												WHERE id =$id
												AND contrasena = '" . Hash::getHash('sha1', $contrasena, HASH_KEY) . "';");
												
        //Se retorna la consulta y se recorren los registros
        return $consulta;
	}
	
	public function getCarrito($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT c.*,(SELECT archivo FROM ok_img_producto as i where i.fk_producto = c.fk_producto order by i.fecha_creacion ASC limit 0,1) as archivo, (Select p.producto from ok_productos as p where p.id=c.fk_producto) as producto FROM ok_carrito as c WHERE c.fk_afiliado=$id and c.estado=1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
	}
		
	public function getsumasCarrito($id) { 
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT sum(c.cantidad) as cant, sum(c.subtotal) as subto FROM ok_carrito as c WHERE c.fk_afiliado=$id and c.estado=1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
	}
	
	public function BorrarListadoCarrito($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM ok_carrito Where fk_afiliado = $id;");
    }
	
	public function RealizarPedido($afiliado,$fpago,$domicilio, $observacion) {
        $afiliado = (int) $afiliado; /* Parse de la variable */
		$fpago = (int) $fpago; /* Parse de la variable */
		$domicilio = (int) $domicilio; /* Parse de la variable */
		$fechaactual = date("Y-m-d H:i:s");	
		
        $this->_db->query("INSERT INTO ok_pedido (fk_afiliado, fecha_pedido, estado,domicilio, forma_pago,ok_pedidoobservaciones) 
							VALUES($afiliado, '$fechaactual', 1, $domicilio, $fpago, '$observacion')");
    }
	
	public function idmipedidoultimo($id) {
        //Se crea y ejecuta la consulta
           $consulta = $this->_db->get_row("SELECT * FROM ok_pedido WHERE fk_afiliado=$id order by fecha_pedido desc limit 0,1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
	}
	
	public function DetallePedido($pedido,$producto,$cantidad,$precio,$subtotal) {
        $pedido = (int) $pedido; /* Parse de la variable */
		$producto = (int) $producto; /* Parse de la variable */
		$cantidad = (int) $cantidad; /* Parse de la variable */
		$precio = (int) $precio; /* Parse de la variable */
		$subtotal = (int) $subtotal; /* Parse de la variable */
		
        $this->_db->query("INSERT INTO ok_detalle_pedido (fk_pedido, fk_producto, cantidad, valor_unitario, sub_total) 
							VALUES($pedido, $producto, $cantidad, $precio, $subtotal)");
    }
	
	public function EditarEstadoCarrito($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("UPDATE ok_carrito SET `estado` = 2 WHERE `id` = $id");
    }
	
	public function ActualizarPedido($id,$total) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("UPDATE ok_pedido SET `nro_pedido` = 'PE".$id."', valor_total = $total WHERE `id` = $id");
    }
	
	public function actualizarafiliado1($id, $direccion,$email, $telefono,$ciudad) {
        $id = (int) $id; /* Parse de la variable */
		$ciudad = (int) $ciudad; /* Parse de la variable */
        $this->_db->query("UPDATE ok_afiliado SET `direccion` = '$direccion', correo = '$email', telefono='$telefono', ciudad = $ciudad WHERE `id` = $id");
    }
	
	public function actualizarafiliado2($id, $direccion, $cc,$email, $telefono,$ciudad) {
        $id = (int) $id; /* Parse de la variable */
		$ciudad = (int) $ciudad; /* Parse de la variable */
        $this->_db->query("UPDATE ok_afiliado SET `direccion` = '$direccion', centro_costos = '$cc', correo = '$email', telefono='$telefono', ciudad = $ciudad WHERE `id` = $id");
    }
	
	public function actualizarafiliado3($id, $email, $ciudad) {
        $id = (int) $id; /* Parse de la variable */
		$ciudad = (int) $ciudad; /* Parse de la variable */
        $this->_db->query("UPDATE ok_afiliado SET correo = '$email', ciudad = $ciudad WHERE `id` = $id");
    }		
	
	public function getDetalleCarrito($id) {
        //Se crea y ejecuta la consulta
           $consulta = $this->_db->get_row("SELECT * FROM ok_carrito WHERE id=$id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
	}
	
	public function getDetalleCarritoDetallado($id) {
        //Se crea y ejecuta la consulta
           $consulta = $this->_db->get_row("SELECT c.*,(SELECT archivo FROM ok_img_producto as i where i.fk_producto = c.fk_producto order by i.fecha_creacion ASC limit 0,1) as archivo, (Select p.producto from ok_productos as p where p.id=c.fk_producto) as producto FROM ok_carrito as c WHERE c.id=$id;");
        //Se retorna la consulta y se recorren los registros
		
        return $consulta;
	}
	
	public function eliminarDetalleCarrito($id) {
        //Se crea y ejecuta la consulta
           $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM ok_carrito Where id = $id;");	
	}
	
	public function ActualizarDetalleCarrito($id, $cantidad, $total) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("UPDATE ok_carrito SET `cantidad` = $cantidad, subtotal = $total WHERE `id` = $id");
    }
	
	public function getPedidos($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * from ok_pedido where fk_afiliado=$id order by fecha_pedido DESC");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
	}
	
	
	
	// documento del pedido
	
	//Funcion que trae un registro, segun el id que se le pase como parametro
    public function getPedido($id) {
        $id = (int) $id; /* Parse de la variable */
        //Se crea y ejecuta la consulta
        $consulta = $this->_db->get_row("SELECT p.*,concat(a.nombres,' ',a.apellidos) as afiliado FROM ok_pedido as p inner join ok_afiliado as a where a.id=p.fk_afiliado and p.id = $id");
        //Se retornona la consulta y se recorre el registro devuelto
        return $consulta;
    }
	
	//Funcion que trae un registro, segun el id que se le pase como parametro
    public function getempresa($id) {
        $id = (int) $id; /* Parse de la variable */
        //Se crea y ejecuta la consulta
        $consulta = $this->_db->get_row("SELECT * from ok_informacion_empresa where id= $id");
        //Se retornona la consulta y se recorre el registro devuelto
        return $consulta;
    }
	
	//Funcion que trae un registro, segun el id que se le pase como parametro
    public function getafiliado2($id) {
        $id = (int) $id; /* Parse de la variable */
        //Se crea y ejecuta la consulta
        $consulta = $this->_db->get_row("SELECT a.*,c.ciudad as ciu from ok_afiliado as a,ok_ciudades as c where a.ciudad=c.id and a.id = $id");
        //Se retornona la consulta y se recorre el registro devuelto
        return $consulta;
    }
	
	//Funcion que trae un registro, segun el id que se le pase como parametro
    public function getDetallePedido($id) {
        $id = (int) $id; /* Parse de la variable */
        //Se crea y ejecuta la consulta
        $consulta = $this->_db->get_results("SELECT dp.*,pr.codigo,pr.producto FROM ok_detalle_pedido as dp inner join ok_productos as pr on dp.fk_producto = pr.id WHERE dp.fk_pedido = $id");
        //Se retornona la consulta y se recorre el registro devuelto
        return $consulta;
    }
	
	//Funcion que trae un registro, segun el id que se le pase como parametro
    public function getmisparientes() {
        $id = (int) $id; /* Parse de la variable */
        //Se crea y ejecuta la consulta
        $consulta = $this->_db->get_results("SELECT 
												pa.id,
												pa.tipo_documento,
												pa.nro_documento,
												CONCAT(pa.nombres,' ',.pa.apellidos) AS nombres,
												pr.parentesco ,
												td.tipo_documento
											FROM ok_parientes as pa,ok_parentescos as pr,ok_tipo_documento td
											WHERE pr.id = pa.fk_parentesco 
											AND td.id = pa.tipo_documento
											AND pa.fk_afiliado = '".Session::Get('id_afiliado')."'
											ORDER BY pa.id desc");
        //Se retornona la consulta y se recorre el registro devuelto
        return $consulta;
    }
	
	public function getMisEventos($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT c.*,i.id as inscripcion FROM ok_cursos_eventos as c, ok_inscritos_cursos_eventos as i Where i.fk_persona=$id and i.fk_curso=c.id and tipo_persona = 1;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
	}
	
	public function getEventosParientes($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT c.*,p.nombres, p.apellidos,i.id as inscripcion FROM ok_cursos_eventos as c, ok_inscritos_cursos_eventos as i, ok_parientes as p Where p.fk_afiliado=$id and i.fk_persona=p.id and i.fk_curso=c.id and tipo_persona = 2;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
	}
	
	public function getCiudades() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM ok_ciudades;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
	}
			
    //Funcion que trae todos los registros
    public function getTipoDocumento() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT id,tipo_documento FROM ok_tipo_documento;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }			

    //Funcion que trae todos los registros
    public function getParentescos() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT id,parentesco FROM ok_parentescos;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }	


    public function insertarPariente(
										$tipo_documento,
										$num_docu,
										$nombres,
										$apellidos,
										$genero,
										$fecha_nacimiento,
										$parentesco,
										$fk_afiliado) {
		$fechaactual = date("Y-m-d H:i:s");	
        $this->_db->query("INSERT INTO ok_parientes
											(
												id,
												tipo_documento,
												nro_documento,
												nombres,
												apellidos,
												fecha_nacimiento,
												genero,
												fk_afiliado,
												fk_parentesco
											)
											VALUES
											(
												null,
												$tipo_documento,
												'".$num_docu."',
												'".$nombres."',
												'".$apellidos."',
												'".$fecha_nacimiento."',
												$genero,
												$fk_afiliado,
												$parentesco
											);
											");
    }
				
    public function getPariente($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT 
												id,
												tipo_documento,
												nro_documento as num_docu,
												nombres,
												apellidos,
												fecha_nacimiento,
												genero,
												fk_parentesco as parentesco 
											FROM ok_parientes
											WHERE id =$id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
	}


    public function editarpariente(
										$tipo_documento,
										$num_docu,
										$nombres,
										$apellidos,
										$genero,
										$fecha_nacimiento,
										$parentesco,
										$id) {
			
        $this->_db->query("UPDATE ok_parientes
							SET
								tipo_documento = $tipo_documento,
								nro_documento = '".$num_docu."',
								nombres = '".$nombres."',
								apellidos = '".$apellidos."',
								fecha_nacimiento = '".$fecha_nacimiento."',
								genero = $genero,
								fk_parentesco = $parentesco
							WHERE id = $id;
							");
    } 
	
    //Funcion para elminar un registro
    public function eliminarPariente($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("DELETE 
                             FROM ok_parientes  
                            WHERE id = $id");
    }
	
	public function eliminarMievento($id) {
        //Se crea y ejecuta la consulta
           $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM ok_inscritos_cursos_eventos Where id = $id;");	
	}
	
	public function eliminareventopariente($id) {
        //Se crea y ejecuta la consulta
           $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM ok_inscritos_cursos_eventos Where id = $id;");	
	}
	
	public function getinscripcion($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * FROM ok_inscritos_cursos_eventos where id=$id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
	}
					
}

?>
