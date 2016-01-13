<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');

//Clase extendida de la clase controller
class olvidastecontrasenaController extends Controller {

    private $_olvidastecontrasena;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_olvidastecontrasena = $this->loadModel('olvidastecontrasena');
    }

	//Formulario olviste tu clave
	public function index() {
			
		$this->_view->titulo = 'Olvidaste tu clave';
		$this->_view->navegacion = '';
		
		
		 if ($this->getInt('enviar') == 1) {
			 
			if (!$this->getSql('email')) {
                //Si no cumple la validacion sale mensaje de error
                $this->_view->_error = 'Debe introducir su correo electronico.';
                //Vista de la pagina actual
                $this->_view->renderizar('index','olvidastecontrasena');
                //Saca de la funcion principal
                exit;
            }
			if (!$this->_olvidastecontrasena->comprobaremail($this->getSql('email'))) {
                //Si no cumple la validacion sale mensaje de error
                $this->_view->_error = 'El correo ingresado no se encuentra registrado en el sistema.';
                //Vista de la pagina actual
                $this->_view->renderizar('index','olvidastecontrasena');
                //Saca de la funcion principal
                exit;
            }
			if (!$this->getSql('g-recaptcha-response')) {
                //Si no cumple la validacion sale mensaje de error
                $this->_view->_error = 'Debes ingresar el captcha';
                //Vista de la pagina actual
                $this->_view->renderizar('index','olvidastecontrasena');
                //Saca de la funcion principal
                exit;
            }
			
			$secretkey='6LeE1wgTAAAAAHXqkAfSlkA6rdkg_IcT5ChhuX4-';
 			$response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretkey."&response=".$this->getSql('g-recaptcha-response')."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
			
			if($response['success'] == false)
			{
                //Si no cumple la validacion sale mensaje de error
                $this->_view->_error = 'El captcha es incorrecto.';
                //Vista de la pagina actual
                $this->_view->renderizar('index','olvidastecontrasena');
                //Saca de la funcion principal
                exit;
			}
			elseif($response['success'] == true)
			{
			  $fechaactual = date("Y-m-d H:i:s");
			  $md5_recclave = md5($fechaactual);
			  
			  $datos_asociado = $this->_olvidastecontrasena->comprobaremail($this->getSql('email'));
			  
			  $this->_olvidastecontrasena->guardarmd5_recclave(
			  	$datos_asociado->id,
				$md5_recclave
			  );
			  
			  
			  //ENVIO DEL CORREO ELECTRONICO
			  
			$para = $datos_asociado->correo;
			
			$destinatario = "".trim($para).""; 
			$asunto = "Cambio de  Clave  - Cemcop"; 
			$cuerpo = ' 
			<html> 
			<head> 
			   <title>Cambio de  Clave - Cemcop</title> 
			</head> 
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<body> 
			<h4>Hola!</h4> 
			
			Hemos recibido una solicitud para realizar el cambio de la contraseña, por favor has clic 
			<a href="'.BASE_URL.'olvidastecontrasena/recuperar_clave/'.md5($datos_asociado->id).'/'.$md5_recclave.'">aqui</a> para realizar el proceso.<br><br>
			
			O copia y pega el siguiente link en la barra de direcciones
			'.BASE_URL.'olvidastecontrasena/recuperar_clave/'.md5($datos_asociado->id).'/'.$md5_recclave.'
			
			<br><br>
			Gracias por usar nuestros servicios.
			
			</body> 
			</html> 
			'; 
			
			//para el envío en formato HTML 
			$headers = "MIME-Version: 1.0\r\n"; 
			$headers .= "Content-type: text/html; charset=utf-8\r\n"; 
			//dirección del remitente 
			$headers .= "From: Servicio al Cliente <noreply@scga>\r\n"; 
			
			if (mail($destinatario,$asunto,$cuerpo,$headers)){
				$this->_view->datos = false;
				//Se saca mensaje
				$this->_view->_mensaje = 'Se te han enviado las instrucciones para realizar el cambio de la clave, por favor revisa tu correo electronico.';	
			}else{
				//Si no cumple la validacion sale mensaje de error
				$this->_view->_error = 'Lo sentimos no hemos podido enviar tu mensaje, por favor intentalo de nuevo.';
				//Se renderiza a la pagina actual
				$this->_view->renderizar('index','olvidastecontrasena');
				//Saca de la funcion principal
				exit;
			
				
			} 
			  
			}
		
		 }
		
		$this->_view->renderizar('index','olvidastecontrasena');  
	}


	public function recuperar_clave($idafiliado,$md5_repclave) {
			
		$this->_view->titulo = 'Cambiar tu clave';
		$this->_view->navegacion = '';
		
		if(!isset($idafiliado) or $idafiliado == ''){
			//Si no cumple la validacion sale mensaje de error
			$this->_view->_error1 = 'Lo sentimos, la ruta a la cual ingresaste es incorrecta.';
			//Vista de la pagina actual
			$this->_view->renderizar('recuperar','olvidastecontrasena');
			//Saca de la funcion principal
			exit;
		}
		if(!isset($md5_repclave) or $md5_repclave == ''){
			//Si no cumple la validacion sale mensaje de error
			$this->_view->_error1 = 'Lo sentimos, la ruta a la cual ingresaste es incorrecta.';
			//Vista de la pagina actual
			$this->_view->renderizar('recuperar','olvidastecontrasena');
			//Saca de la funcion principal
			exit;
		}		
		if (!$this->_olvidastecontrasena->comprobarasociado($idafiliado)) {
			//Si no cumple la validacion sale mensaje de error
			$this->_view->_error1 = 'Lo sentimos, la ruta a la cual ingresaste es incorrecta.';
			//Vista de la pagina actual
			$this->_view->renderizar('recuperar','olvidastecontrasena');
			//Saca de la funcion principal
			exit;
		}
		if (!$this->_olvidastecontrasena->comprobar_md5usuario($idafiliado,$md5_repclave)) {
			//Si no cumple la validacion sale mensaje de error
			$this->_view->_error1 = 'Lo sentimos, la ruta a la cual ingresaste es incorrecta.';
			//Vista de la pagina actual
			$this->_view->renderizar('recuperar','olvidastecontrasena');
			//Saca de la funcion principal
			exit;
		}	
		
					
		 if ($this->getInt('enviar') == 1) {
			 
				$this->_view->datos = (object) $_POST; /* No se debe realizar de esta formaaaa */

				if (!$this->getSql('contrasena')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar la contrase&ntilde;a.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('recuperar','olvidastecontrasena');
					//Saca de la funcion principal
					exit;
				}
				if (!$this->getSql('repitecontrasena')) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Debe ingresar la contrase&ntilde;a nuevamente.';
					//Se renderiza a la pagina actual
					$this->_view->renderizar('recuperar','olvidastecontrasena');
					//Saca de la funcion principal
					exit;
				}
				//Se valida que las dos contraseñas digitadas coincidan
				if (!$this->_olvidastecontrasena->validarPassword($this->getSql('contrasena'), $this->getSql('repitecontrasena'))) {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = 'Las contrase&ntilde;as no coiniciden';
					//Vista de la pagina actual
					$this->_view->renderizar('recuperar','olvidastecontrasena');
					//Saca de la funcion principal
					exit;
				}								

				
				$error = "";
				if ($this->validar_clave($this->getSql('contrasena'), $error)) {
					
				} else {
					//Si no cumple la validacion sale mensaje de error
					$this->_view->_error = $error;
					//Se renderiza a la pagina actual
					$this->_view->renderizar('recuperar','olvidastecontrasena');
					//Saca de la funcion principal
					exit;
				}
				
				$infousuario = $this->_olvidastecontrasena->comprobar_md5usuario($idafiliado,$md5_repclave);
				//Si pasa todas las validaciones actualizan los datos y se valida
				$this->_olvidastecontrasena->setPassword(
						$infousuario->id, $this->getSql('contrasena')
				);
				$this->_view->datos = false;

	
			
				//Se saca mensaje
				$this->_view->_mensaje = 'La contraseña se ha cambiado correctamente.';
			
		 }
		
		
		$this->_view->renderizar('recuperar','olvidastecontrasena');  
	}

	
}

?>
