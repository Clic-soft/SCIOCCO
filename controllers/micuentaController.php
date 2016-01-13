<?php

//Clase extendida de la clase controller
class micuentaController extends Controller {

    private $_micuenta;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_micuenta = $this->loadModel('micuenta');
    }
	//INFORMACION DE MI CUENTA
	public function index() {
			
			$modulo="micuenta";
        	$this->_acl->acceso($modulo);
			$this->_view->titulo = 'Mi Cuenta';
			$this->_view->navegacion = '';
			
			$this->_view->infoperfil = $this->_micuenta->getAfiliado(Session::get('id_afiliado'));
			$this->_view->setJs(array('micuenta'));
			
			/* VALIDACION */
			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */

				if (!$this->getSql('contrasenaactual')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar la contrase&ntilde;a actual.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('micuenta','micuenta');
					//Saca de la funcion principal
					exit;
				}	
				if (!$this->getSql('contrasena')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar la contrase&ntilde;a.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('micuenta','micuenta');
					//Saca de la funcion principal
					exit;
				}
				if (!$this->getSql('repitecontrasena')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar la contrase&ntilde;a nuevamente.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('micuenta','micuenta');
					//Saca de la funcion principal
					exit;
				}
				//Se valida que las dos contraseñas digitadas coincidan
				if (!$this->_micuenta->validarPassword($this->getSql('contrasena'), $this->getSql('repitecontrasena'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Las contrase&ntilde;as no coiniciden';
					//Vista de la pagina actual
					$this->_view->renderizar('micuenta','micuenta');
					//Saca de la funcion principal
					exit;
				}								
				//Se valida que las dos contraseñas digitadas coincidan
				if (count($this->_micuenta->validarPasswordactual($this->getSql('contrasenaactual'),Session::Get('id_usuario'))) == 0) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'La contrase&ntilde;a actual es incorrecta.';
					//Vista de la pagina actual
					$this->_view->renderizar('micuenta','micuenta');
					//Saca de la funcion principal
					exit;
				}	
				
				$error = "";
				if ($this->validar_clave($this->getSql('contrasena'), $error)) {
					
				} else {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = $error;
					//Se renderiza a la pagina actual
					$this->_view->renderizar('micuenta','micuenta');
					//Saca de la funcion principal
					exit;
				}
				//Si pasa todas las validaciones actualizan los datos y se valida
				$this->_micuenta->setPassword(
						Session::Get('id_usuario'), $this->getSql('contrasena')
				);
				$this->_view->datos = false;

	
			
				//Se saca mensaje
				$this->_view->_mensaje = 'La contraseña se ha cambiado correctamente.';
			}
			
			$this->_view->infoperfil = $this->_micuenta->getAfiliado(Session::get('id_afiliado'));

			$this->_view->renderizar('micuenta','micuenta');
	}
	
	//LISTADO DE MIS PEDIDOS
	public function Listadopedidos() {
		
			$modulo="micuenta";
        	$this->_acl->acceso($modulo);	
			$this->_view->titulo = 'Mis Pedidos';
			$this->_view->navegacion = '';
			$this->_view->metadescripcion = 'Cooperativa Multiactiva de Empleados Colgate Palmolive, compre sus productos en linea, productos para el cuidado personal, productos para el cuidado oral, productos para el cuidado de la ropa, etc.';
			
			//Se instancia la libreria
		$paginador = new Paginador();
		
		$this->_view->pedidos = $paginador->paginar($this->_micuenta->getPedidos(Session::get('id_afiliado')),1,10);
		$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
		$this->_view->setJs(array('mispedidos'));
		
			$this->_view->renderizar('mispedidos','micuenta');
	}
	
	// paginacion listado
	public function paginacionDinamicaPedido() {
        
		$modulo="micuenta";
        	$this->_acl->acceso($modulo);
        $pagina = $this->getInt('pagina');
				
        $paginador = new Paginador();
        $this->_view->pedidos = $paginador->paginar($this->_micuenta->getPedidos(Session::get('id_afiliado')), $pagina,10);
        $this->_view->paginacion = $paginador->getView('paginacion_dinamica');

        $this->_view->renderizar('refresca_listado_pedido', false, true);
		
    }
	
	public function ver_pedido($id) {
		
        //VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	$modulo="micuenta";
        	$this->_acl->acceso($modulo);

        //paginar y se le pasa como parametro la cantidad de registros y la cantidad de paginas
        $this->_view->pedido = $this->_micuenta->getPedido($this->filtrarInt($id));
		$this->_view->empresa = $this->_micuenta->getempresa(1);
		$ped = $this->_micuenta->getPedido($this->filtrarInt($id));
		$this->_view->afiliado = $this->_micuenta->getafiliado2($ped->fk_afiliado);
		$this->_view->detalle = $this->_micuenta->getDetallePedido($this->filtrarInt($id));
        //Se crea variable para paginar y se llama la vista del paginador
        $this->_view->titulo = 'Pedido PE'.$id;
		$this->_view->metadescripcion = 'Cooperativa Multiactiva de Empleados Colgate Palmolive, compre sus productos en linea, productos para el cuidado personal, productos para el cuidado oral, productos para el cuidado de la ropa, etc.';
        //Se renderiza a la pagina index
        $this->_view->renderizar('pedido', false, true);
    }
	
	//LISTADO Carrito
	public function ListadoCarrito() {
		
			$modulo="micuenta";
        	$this->_acl->acceso($modulo);	
			$this->_view->titulo = 'Mi Carrito';
			$this->_view->navegacion = '';
			$this->_view->metadescripcion = 'Cooperativa Multiactiva de Empleados Colgate Palmolive, compre sus productos en linea, productos para el cuidado personal, productos para el cuidado oral, productos para el cuidado de la ropa, etc.';
			$this->_view->setJs(array('micarrito'));
			
			$carrito = $this->_micuenta->getCarrito(Session::get('id_afiliado'));
			$paginador = new Paginador();
			$this->_view->totales = $this->_micuenta->getsumasCarrito(Session::get('id_afiliado'));
			$this->_view->Micarrito = $paginador->paginar($this->_micuenta->getCarrito(Session::get('id_afiliado')), 1,50);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');

			$this->_view->renderizar('micarrito','micuenta');
	}
	
	// paginacion listado
	public function paginacionDinamicaCarrito() {
        
		$modulo="micuenta";
        	$this->_acl->acceso($modulo);
        $pagina = $this->getInt('pagina');
				
        $paginador = new Paginador();
		$this->_view->totales = $this->_micuenta->getsumasCarrito(Session::get('id_afiliado'));
        $this->_view->Micarrito = $paginador->paginar($this->_micuenta->getCarrito(Session::get('id_afiliado')), $pagina,50);
        $this->_view->paginacion = $paginador->getView('paginacion_dinamica');

        $this->_view->renderizar('refresca_listado_Carrito', false, true);
		
    }
	
	//LISTADO Carrito 
	public function BorrarListadoCarrito() {
		
			$modulo="micuenta";
        	$this->_acl->acceso($modulo);	
			$this->_view->titulo = 'Mi Carrito';
			$this->_view->navegacion = '';
			$this->_view->metadescripcion = 'Cooperativa Multiactiva de Empleados Colgate Palmolive, compre sus productos en linea, productos para el cuidado personal, productos para el cuidado oral, productos para el cuidado de la ropa, etc.';
			
			$this->_view->Micarrito = $this->_micuenta->BorrarListadoCarrito(Session::get('id_afiliado'));		
			$this->_view->Micarrito = $this->_micuenta->getCarrito(Session::get('id_afiliado'));
			$this->_view->renderizar('micarrito','micuenta');
	}
	
	//ELIMINAR Detalle Carrito
    public function eliminarDetalleCarrito($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	$modulo="micuenta";
        	$this->_acl->acceso($modulo);
		
		if (!$this->filtrarInt($id)) {
            //Se redirecciona al index
            $this->redireccionar('micarrito','micuenta');
        }
        //Si no existe un registro con ese id
        if (!$this->_micuenta->getDetalleCarrito($this->filtrarInt($id))) {
            //Se redirecciona al index
            $this->redireccionar('micarrito','micuenta');
        }
		
		 $this->_micuenta->eliminarDetalleCarrito($this->filtrarInt($id));
    }
	
	//ELIMINAR Detalle Carrito
    public function EditarDetalle($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	$modulo="micuenta";
        	$this->_acl->acceso($modulo);
		
		if (!$this->filtrarInt($id)) {
            //Se redirecciona al index
            $this->redireccionar('micarrito','micuenta');
        }
        //Si no existe un registro con ese id
        if (!$this->_micuenta->getDetalleCarrito($this->filtrarInt($id))) {
            //Se redirecciona al index
            $this->redireccionar('micarrito','micuenta');
        }
		
		 $this->_view->detalle = $this->_micuenta->getDetalleCarritoDetallado($this->filtrarInt($id));
		 $detalle = $this->_micuenta->getDetalleCarritoDetallado($this->filtrarInt($id));
		 /* VALIDACION */
			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan
				if (!$this->getInt('cantidad')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Ingresar La Cantidad';
					//Vista de la pagina actual
					$this->_view->renderizar('editardetallecarrito',false,true);
					//Saca de la funcion principal
					exit;
				}
				
				$subtotal=	$this->getInt('cantidad') * $detalle->precio;
				$this->_micuenta->ActualizarDetalleCarrito($id,$this->getInt('cantidad'),$subtotal);
				
				$this->_view->_mensaje = 'Producto En Carrito Actualizado Correctamente';
			}		
		 	
			$this->_view->detalle = $this->_micuenta->getDetalleCarritoDetallado($this->filtrarInt($id));
			
		 $this->_view->renderizar('editardetallecarrito',false,true);
    }
	
	//LISTADO Carrito
	public function RealizarPedido() {
		
			$modulo="micuenta";
        	$this->_acl->acceso($modulo);	
			
			$this->_view->Micarrito = $this->_micuenta->getCarrito(Session::get('id_afiliado'));
			$this->_view->afiliado = $this->_micuenta->getAfiliado(Session::get('id_afiliado'));
			$this->_view->ciudades = $this->_micuenta->getCiudades(Session::get('id_afiliado'));
			$carrito = $this->_micuenta->getCarrito(Session::get('id_afiliado'));
			
			/* VALIDACION */
			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
			//Se valida que las dos contraseñas digitadas coincidan
				if (!$this->getInt('fpago')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Seleccionar la Forma de Pago';
					//Vista de la pagina actual
					$this->_view->renderizar('realizarpedido',false,true);
					//Saca de la funcion principal
					exit;
				}
				
				if (!$this->getInt('domicilio')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe Seleccionar Si Desea Domicilio';
					//Vista de la pagina actual
					$this->_view->renderizar('realizarpedido',false,true);
					//Saca de la funcion principal
					exit;
				}
				
				if ($this->getInt('domicilio') == 1) {
					if (!$this->getSql('direccion')) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la Direccion del Domicilio';
						//Vista de la pagina actual
						$this->_view->renderizar('realizarpedido',false,true);
						//Saca de la funcion principal
						exit;
					}
				}
				
				if ($this->getInt('domicilio') == 3) {
					if (!$this->getSql('direccion')) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar la Direccion del Domicilio';
						//Vista de la pagina actual
						$this->_view->renderizar('realizarpedido',false,true);
						//Saca de la funcion principal
						exit;
					}
					
					if (!$this->getSql('cc')) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Ingresar el Centro de Costos';
						//Vista de la pagina actual
						$this->_view->renderizar('realizarpedido',false,true);
						//Saca de la funcion principal
						exit;
					}
					
				}
				
				if (!$this->getInt('ciudad')) {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = 'Debe Seleccionar la Ciudad';
						//Vista de la pagina actual
						$this->_view->renderizar('realizarpedido',false,true);
						//Saca de la funcion principal
						exit;
					}
				
				$this->_micuenta->RealizarPedido(Session::get('id_afiliado'), $this->getInt('fpago'),$this->getInt('domicilio'),$this->getSql('observacion'));
				$id = $this->_micuenta->idmipedidoultimo(Session::get('id_afiliado'));
				
				if ($this->getInt('domicilio') == 1) {
					$this->_micuenta->actualizarafiliado1(Session::get('id_afiliado'), $this->getSql('direccion'),$this->getSql('email'),$this->getInt('telefono'),$this->getInt('ciudad'));
					}
					
				if ($this->getInt('domicilio') == 2) {
					$this->_micuenta->actualizarafiliado3(Session::get('id_afiliado'), $this->getSql('email'),$this->getInt('ciudad'));
					}	
				
				if ($this->getInt('domicilio') == 3) {
					$this->_micuenta->actualizarafiliado2(Session::get('id_afiliado'), $this->getSql('direccion'), $this->getSql('cc'),$this->getSql('email'),$this->getInt('telefono'),$this->getInt('ciudad'));
					}
				
				foreach ($carrito as $carro):
				$this->_micuenta->DetallePedido($id->id, $carro->fk_producto, $carro->cantidad, $carro->precio, $carro->subtotal);
				$this->_micuenta->EditarEstadoCarrito($carro->id);
				endforeach;

				$subtotal =0;
				$total=0;
				foreach ($carrito as $carro):
				$subtotal=$carro->cantidad * $carro->precio;
				$total= $total+$subtotal;					
				endforeach;

				
				$this->_micuenta->ActualizarPedido($id->id,$total);
				
				$afiliado = $this->_micuenta->getAfiliado(Session::get('id_afiliado'));
				$pedido = $this->_micuenta->getPedido($id->id);
				$detalle = $this->_micuenta->getDetallePedido($id->id);
				
				
				
			$para = $afiliado->email;
			$nombre =$afiliado->nombre;
			$telefono =$afiliado->telefono;
			$ciudad =$afiliado->ciudadnombre;
		
			//ENVIAR CORREO
			$destinatario = "".trim($para).""; 
			$asunto = "Pedido desde la pagina web Cemcop"; 
			$cuerpo = ' 
			<html> 
			<head> 
			   <title>Pedido desde la pagina web Cemcop</title> 
			</head> 
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<body> 
			<h4>Hola!</h4> 
			
			Has recibido un nuevo mensaje de solicitud de Pedido Realizado, 
				el cual contiene la siguiente informaci&oacute;n:
			<br><br>
			Nombre: '.$nombre.'<br>
			Telefono:'.$telefono.'<br>
			Ciudad:'.$ciudad.'<br>
			
			Pedido:'.$pedido->nro_pedido.'<br>
			Fecha:'.$pedido->fecha_pedido.'<br><br><br>
			
		<table style="width:800px;"  ><tr><td>';  
    	if (isset($detalle) && count($detalle)) : 
		$cuerpo .= '<table align="center" class="table table-bordered table-condensed table-striped" style="width:800px;">
        <tr> 
        <td >CÓDIGO</td>
        <td >PRODUCTO</td>
        <td >CANTIDAD</td>
        <td >VALOR UNITARIO</td>
        <td >SUB TOTAL</td>
        </tr>';
         foreach ($detalle as $detalles):   
		$cuerpo .='<tr>
        <td >'.$detalles->codigo.'</td>
        <td >'.$detalles->producto .'</td>
        <td align="center">'. $detalles->cantidad .'</td>
        <td align="right">$'. number_format($detalles->valor_unitario,0,",",".").'</td>
        <td align="right">$'. number_format($detalles->sub_total,0,",",".").'</td>
 		</tr>';
         endforeach;
       $cuerpo .=  '<tr><td colspan="4" align="center">TOTAL</td><td align="right">$'.number_format($pedido->valor_total,0,",",".").
        '</td></tr>	</table>';
        endif;
    $cuerpo .= '</td></tr></table>
			
			</body> 
			</html>' 
			; 
			
			//para el envío en formato HTML 
			$headers = "MIME-Version: 1.0\r\n"; 
			$headers .= "Content-type: text/html; charset=utf-8\r\n"; 
			//dirección del remitente 
			$headers .= "From: Servicio al Cliente <noreply@scga>\r\n"; 
			
			if (mail($destinatario,$asunto,$cuerpo,$headers)){
				$this->_view->datos = false;
				//Se saca mensaje
				$this->_view->_mensaje = 'Tu mensaje a sido enviado correctamente, Gracias por contactarnos.';	
			}else{
				//Si no cumple la validacion sale mensaje de error
				$this->_view->_error = 'Lo sentimos no hemos podido enviar tu mensaje, por favor intentalo de nuevo.';
				//Se renderiza a la pagina actual
				$this->_view->renderizar('realizarpedido',false,true);
				//Saca de la funcion principal
				exit;
			
				
			}
				
				
				
				$this->_view->_mensaje = 'Pedido Realizado Correctamente';
			}				


			$this->_view->renderizar('realizarpedido',false,true);
	}
	
	//LISTADO DE EVENTOS
	public function Listadoeventos() {
		
			$modulo="micuenta";
        	$this->_acl->acceso($modulo);
			$this->_view->titulo = 'Mis Eventos';
			$this->_view->navegacion = '';
			$this->_view->setJs(array('miseventos'));
			
			$paginador = new Paginador();
			$this->_view->miseventos = $paginador->paginar($this->_micuenta->getMisEventos(Session::get('id_afiliado')), 1,10);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');


			$this->_view->renderizar('miseventos','micuenta');
	}
	
	//LISTADO DE EVENTOS
	public function eventosparientes() {
		
			$modulo="micuenta";
        	$this->_acl->acceso($modulo);
			$this->_view->titulo = 'Eventos De Mis Parientes';
			$this->_view->navegacion = '';
			$this->_view->setJs(array('eventosfamiliares'));
			
			$paginador = new Paginador();
			$this->_view->parientes = $paginador->paginar($this->_micuenta->getEventosParientes(Session::get('id_afiliado')), 1,10);
			$this->_view->paginacion = $paginador->getView('paginacion_dinamica');


			$this->_view->renderizar('eventosparientes','micuenta');
	}
	
	// paginacion listado
	public function paginacionDinamicaMiseventos() {
        
		$modulo="micuenta";
        	$this->_acl->acceso($modulo);
        $pagina = $this->getInt('pagina');
				
        $paginador = new Paginador();
		$this->_view->miseventos = $paginador->paginar($this->_micuenta->getMisEventos(Session::get('id_afiliado')), $pagina,10);
		$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
		$this->_view->renderizar('refresca_listado_miseventos', false, true);
		
    }
	
	// paginacion listado
	public function paginacionDinamicaEventosFamiliares() {
        
		$modulo="micuenta";
        	$this->_acl->acceso($modulo);
        $pagina = $this->getInt('pagina');
				
        $paginador = new Paginador();
		$this->_view->parientes = $paginador->paginar($this->_micuenta->getEventosParientes(Session::get('id_afiliado')), $pagina,10);
		$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
		$this->_view->renderizar('refresca_listado_eventosfamilia', false, true);
		
    }
	
	
	//CAMBIAR FOTO DEL ASOCIADO
	public function subirFoto() {
	
		$modulo="micuenta";
        	$this->_acl->acceso($modulo);
			//Si no existe un registro con ese id
			if (!$this->_micuenta->getAfiliado(Session::Get('id_afiliado'))) {
				$this->redireccionar('micuenta');
			}
				

			/* VALIDACION */
			if ($this->getInt('guardar') == 1) {
				if ($_FILES['archivo']['name'] != "") {
					//Ruta donde se va a guardar el archivo
					$ruta = ROOT_ADMIN . 'views/afiliados/fotos' . DS . 'grande' . DS;
					$ruta1 = ROOT_ADMIN . 'views/afiliados/fotos' . DS;
					$ruta2 = ROOT_ADMIN . 'views/afiliados/fotos' . DS . 'cuadrada' . DS;
	
					// echo $ruta; exit;
					//Se instancia la libreria
					$upload = new upload($_FILES['archivo'], 'es_Es');
	
					/* Extensiones permitidas */
					$upload->allowed = array('image/jpeg','image/png');
					/* Renombrando */
					$upload->file_new_name_body = Session::Get('id_afiliado');
					
					/* extencion */
					$upload->file_new_name_ext = 'jpg';
					//Se evita que se auto-renombre
					$upload->file_auto_rename = false;
					//Se sobrescribe el archivo
					$upload->file_overwrite = true;
					//habilita redimesion de imagenes
					$upload->image_resize = true;
					//Crop de la imagen
					$upload->image_ratio = true;
					$upload->image_x = 600;
					$upload->image_y = 374;
					/* Se llama metodo para indicar ruta donde se guarda el archivo */
					$upload->process($ruta);
	
					/* Se verifica si ha sido exitoso */
					if ($upload->processed) {
						/* Extensiones permitidas */
						$upload->allowed = array('image/jpeg','image/png');
						/* Renombrando */
						$upload->file_new_name_body = Session::Get('id_afiliado');
						/* extencion */
						$upload->file_new_name_ext = 'jpg';
						//Se evita que se auto-renombre
						$upload->file_auto_rename = false;
						//Se sobrescribe el archivo
						$upload->file_overwrite = true;
						//habilita redimesion de imagenes
						$upload->image_resize = true;
						//Crop de la imagen
						$upload->image_ratio = false;
						$upload->image_x = 300;
						$upload->image_y = 187;
						$upload->process($ruta1);
						
						if ($upload->processed) {
							/* Extensiones permitidas */
							$upload->allowed = array('image/jpeg','image/png');
							/* Renombrando */
							$upload->file_new_name_body = Session::Get('id_afiliado');
							/* extencion */
							$upload->file_new_name_ext = 'jpg';
							//Se evita que se auto-renombre
							$upload->file_auto_rename = false;
							//Se sobrescribe el archivo
							$upload->file_overwrite = true;
							//habilita redimesion de imagenes
							$upload->image_resize = true;
							//Crop de la imagen
							$upload->image_ratio_crop = true;
							$upload->image_x = 70;
							$upload->image_y = 70;
							$upload->process($ruta2);
						}else{
							//Si no cumple la validacion sale mensaje de error
							$this->_view->_error = $upload->error;
							//Vista de la pagina actual
							$this->_view->renderizar('foto', false, true);
							//Saca de la funcion principal
							exit;	
						}
						
						
					} else {
						//Si no cumple la validacion sale mensaje de error
						$this->_view->_error = $upload->error;
						//Vista de la pagina actual
						$this->_view->renderizar('foto', false, true);
						//Saca de la funcion principal
						exit;
					}
					
					$this->_view->_mensaje = 'Foto subida Correctamente';
				}

			}
			
			//Se renderiza a la pagina actual
			$this->_view->renderizar('foto',false,true);
	}

	//ELIMINAR FOTO
    public function eliminarFoto() {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	$modulo="micuenta";
        	$this->_acl->acceso($modulo);
		
		//IMAGEN PEQUEÑA
        if (file_exists(ROOT_ADMIN . "views/afiliados/fotos/" . Session::get('id_afiliado') . ".jpg")):
            unlink(ROOT_ADMIN . 'views/afiliados/fotos/' . Session::get('id_afiliado') . ".jpg");
        endif;
		
		//IMAGEN GRANDE
        if (file_exists(ROOT_ADMIN . "views/afiliados/fotos/grande/" . Session::get('id_afiliado') . ".jpg")):
            unlink(ROOT_ADMIN . 'views/afiliados/fotos/grande/' . Session::get('id_afiliado') . ".jpg");
        endif;
    }		
	
	//LISTADO MIS PARIENTES
	public function ListadoParientes() {
		
		$modulo="micuenta";
        	$this->_acl->acceso($modulo);	
		//Se instancia la libreria
		$paginador = new Paginador();
		
		$this->_view->misparientes = $paginador->paginar($this->_micuenta->getmisparientes(),1,15);
		$this->_view->paginacion = $paginador->getView('paginacion_dinamica');
		$this->_view->setJs(array('misparientes'));
		
		$this->_view->titulo = 'Mis parientes';
		$this->_view->navegacion = '';


		$this->_view->renderizar('misparientes','micuenta');  
	}
	
	// PAGINACION LISTADO DE MIS PARIENTES
	public function paginacionDinamicaParientes() {
        
		$modulo="micuenta";
        	$this->_acl->acceso($modulo);	
        $pagina = $this->getInt('pagina');
		//Se instancia la libreria
		$paginador = new Paginador();
		
        $this->_view->misparientes = $paginador->paginar($this->_micuenta->getmisparientes(), $pagina,15);
        $this->_view->paginacion = $paginador->getView('paginacion_dinamica');

        $this->_view->renderizar('refresca_listado_parientes', false, true);
		
    }	
	//CREAR PARIENTE
	public function nuevopariente() {


		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	$modulo="micuenta";
        	$this->_acl->acceso($modulo);

			if (!$this->_micuenta->getAfiliado($this->filtrarInt(Session::Get('id_afiliado')))) {
				$this->redireccionar('micuenta');
			}
					
			//Titulo de la pagina
			$this->_view->titulo = 'Nuevo Pariente';
			
	
			$this->_view->tipo_documento = $this->_micuenta->getTipoDocumento();
			$this->_view->parentescos = $this->_micuenta->getParentescos();
			
			/* VALIDACION */
			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
	
				//Se valida que el campo sea obligatorio y un texto
				if (!$this->getInt('tipo_documento')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el tipo de documento.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('nuevopariente', false,true);
					//Saca de la funcion principal
					exit;
				}
				if (!$this->getTexto('num_docu')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el n&uacute;mero de documento.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('nuevopariente', false,true);
					//Saca de la funcion principal
					exit;
				}
				if (!$this->getTexto('nombres')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el nombre.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('nuevopariente', false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('parentesco')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el parentesco.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('nuevopariente', false,true);
					//Saca de la funcion principal
					exit;
				}

				
				//Si pasa todas las validaciones se ingresan los
				//datos y se validan 
				$this->_micuenta->insertarPariente(
						$this->getInt('tipo_documento'),
						$this->getTexto('num_docu'),
						$this->getSql('nombres'),
						$this->getSql('apellidos'),
						$this->getInt('genero'),
						$this->getTexto('fecha_nacimiento'),
						$this->getInt('parentesco'),
						Session::Get('id_afiliado')
						);
	
				$this->_view->datos = false;
				//Se saca mensaje
				$this->_view->_mensaje = 'Datos Ingresados correctamente';
			}
			//Se renderiza a la pagina actual
			$this->_view->renderizar('nuevopariente', false,true);
		
	}
	
	//EDITAR PARIENTE
	public function editarpariente($id) {


    			//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	$modulo="micuenta";
        	$this->_acl->acceso($modulo);

			//si no es un numero
			if (!$this->filtrarInt($id)) {
				$this->redireccionar('micuenta');
			}
	
			//Si no existe un registro con ese id
			if (!$this->_micuenta->getPariente($this->filtrarInt($id))) {
				$this->redireccionar('micuenta');
			}
				
			//Titulo de la pagina
			$this->_view->titulo = 'Editar Pariente';
				
			$this->_view->tipo_documento = $this->_micuenta->getTipoDocumento();
			$this->_view->parentescos = $this->_micuenta->getParentescos();
			
			$this->_view->datos = $this->_micuenta->getPariente($this->filtrarInt($id));
			
			/* VALIDACION */
			if ($this->getInt('guardar') == 1) {
				
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */
	
				//Se valida que el campo sea obligatorio y un texto
				if (!$this->getInt('tipo_documento')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el tipo de documento.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('editarpariente', false,true);
					//Saca de la funcion principal
					exit;
				}
				if (!$this->getTexto('num_docu')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el n&uacute;mero de documento.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('editarpariente', false,true);
					//Saca de la funcion principal
					exit;
				}
				if (!$this->getTexto('nombres')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el nombre.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('editarpariente', false,true);
					//Saca de la funcion principal
					exit;
				}

				if (!$this->getInt('parentesco')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar el parentesco.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('editarpariente', false,true);
					//Saca de la funcion principal
					exit;
				}
				
				//Si pasa todas las validaciones se ingresan los
				//datos y se validan 
				$this->_micuenta->editarpariente(
						$this->getInt('tipo_documento'),
						$this->getTexto('num_docu'),
						$this->getSql('nombres'),
						$this->getSql('apellidos'),
						$this->getInt('genero'),
						$this->getTexto('fecha_nacimiento'),
						$this->getInt('parentesco'),
						$this->filtrarInt($id)
						);

	
				//Se saca mensaje
				$this->_view->_mensaje = 'Datos actualizados correctamente';
			}
			
			$this->_view->datos = $this->_micuenta->getPariente($this->filtrarInt($id));
			//Se renderiza a la pagina actual
			$this->_view->renderizar('editarpariente',false,true);
		
	}

	//ELIMINAR PARIENTE
    public function eliminarPariente($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	$modulo="micuenta";
        	$this->_acl->acceso($modulo);
        //Si el id no es un nro entero
        if (!$this->filtrarInt($id)) {
            //Se redirecciona al index
            $this->redireccionar('micuenta');
        }

		//Si no existe un registro con ese id
			if (!$this->_micuenta->getPariente($this->filtrarInt($id))) {
				$this->redireccionar('micuenta');
			}

        $this->_micuenta->eliminarPariente($this->filtrarInt($id));
    }	
	
	
	//ELIMINAR inscripcion mi evento
    public function eliminarMiEvento($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	$modulo="micuenta";
        	$this->_acl->acceso($modulo);
		
		if (!$this->filtrarInt($id)) {
            //Se redirecciona al index
            $this->redireccionar('miseventos','micuenta');
        }
        //Si no existe un registro con ese id
        if (!$this->_micuenta->getinscripcion($this->filtrarInt($id))) {
            //Se redirecciona al index
            $this->redireccionar('miseventos','micuenta');
        }
		
		 $this->_micuenta->eliminarMievento($this->filtrarInt($id));
    }
	
	
	
	//ELIMINAR inscripcion evento familiar
    public function eliminarEventoFamilia($id) {
		
		//VALIDAR QUE ESTE LOGUEADO EL USUARIO
    	$modulo="micuenta";
        	$this->_acl->acceso($modulo);
		
		if (!$this->filtrarInt($id)) {
            //Se redirecciona al index
            $this->redireccionar('eventosparientes','micuenta');
        }
        //Si no existe un registro con ese id
        if (!$this->_micuenta->getinscripcion($this->filtrarInt($id))) {
            //Se redirecciona al index
            $this->redireccionar('eventosparientes','micuenta');
        }
		
		 $this->_micuenta->eliminareventopariente($this->filtrarInt($id));
    }
	
}

?>
