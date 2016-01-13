<?php

/*
 * Controlador principal de donde van a extender todos los controladores
 * 
 */
/* abstrac para que no pueda ser instanciada */

abstract class Controller {

    private $_registry;
    /* atributos protegidos */
    protected $_view;
   	protected $_acl;
    protected $_request;

    public function __construct() {
        //No se crea una nueva instancia, se utiliza el mismo metodo
        $this->_registry = Registry::getInstancia();
        $this->_acl = $this->_registry->_acl;
        //Como ya la clase request esta almacenanda en el registro
        //se accede al registro
        $this->_request = $this->_registry->_request;
        $this->_view = new View($this->_request);
    }

    /* obliga a que todas las clases que hereden tengan un index */

    abstract public function index();


    /* Metodo que controla los modelos */
    /* Proporciona una instancia del modelo */

    protected function loadModel($modelo) {
        $modelo = $modelo . 'Model';
        $rutaModelo = ROOT . 'models' . DS . $modelo . '.php';



        if (is_readable($rutaModelo)) /* Verifica si el modelo existe */ {
            require_once $rutaModelo; /* Requiere el modelo */
            $modelo = new $modelo; /* Lo instancia */
            return $modelo; /* Retorna una instancia del modelo */
        } else {
            header('location:' . BASE_URL . 'error/access/1010');
        }
    }

    protected function getLibrary($libreria) {
        $rutaLibreria = ROOT . 'libs' . DS . $libreria . '.php';

        if (is_readable($rutaLibreria)) {
            require_once $rutaLibreria;
        } else {
            header('location:' . BASE_URL . 'error/access/2020');
        }
    }

    /* Automaticamente va a tomar una variable enviada por post la va a a filtrar
     * y la va a devolver filtrada
     */

    protected function getTexto($clave) {
        if (isset($_POST[$clave]) && !empty($_POST[$clave])) {
            /* Ent_quotes transformar las comillas simples y dobles */
            $_POST[$clave] = htmlspecialchars($_POST[$clave], ENT_QUOTES);
            return ucwords(strtolower($_POST[$clave]));
        }

        return '';
    }
	

    protected function getInt($clave) {
        if (isset($_POST[$clave]) && !empty($_POST[$clave])) {
            /* Ent_quotes transformar las comillas simples y dobles */
            $_POST[$clave] = filter_input(INPUT_POST, $clave, FILTER_VALIDATE_INT);
            return $_POST[$clave];
        }

        return 0;
    }

    protected function redireccionar($ruta = false) {
	
        if ($ruta) {
            header('location:' . BASE_URL . $ruta);
            exit;
        } else {
            header('location:' . BASE_URL);
            exit;
        }
    }

    protected function filtrarInt($int) {
        $int = (int) $int;
        if (is_int($int)) {
            return $int;
        } else {
            return 0;
        }
    }

    public function getPostParam($clave) {
        if (isset($_POST[$clave])) {
            return strip_tags(ucwords(strtolower($_POST[$clave])));
        }
    }

    /* Limpia los strig_taps y pasa el mysql_escape.. para evitar inyecciones sql */

    protected function getSql($clave) {
        if (isset($_POST[$clave]) && !empty($_POST[$clave])) {
            $_POST[$clave] = strip_tags($_POST[$clave]);

            if (!get_magic_quotes_gpc()) {
                $_POST[$clave] = mysql_escape_string($_POST[$clave]);
            }

            return trim($_POST[$clave]);
        }
    }

    /* Solo acepta caracteres entre a y z , 0 y 9 y _ se utiliza para sanitizar */

    protected function getAlphaNum($clave) {
        if (isset($_POST[$clave]) && !empty($_POST[$clave])) {
            $_POST[$clave] = (string) preg_replace('/[^A-Z0-9_@]/i', '', $_POST[$clave]);
            return trim($_POST[$clave]);
        }
    }

    protected function getAlphaNum2($clave) {
        if (isset($_POST[$clave]) && !empty($_POST[$clave])) {
            $_POST[$clave] = (string) preg_replace('/[^A-Z0-9]/i', '', $_POST[$clave]);
            return trim($_POST[$clave]);
        }
    }

    protected function getDecimal($clave) {
        if (strlen($_POST[$clave]) >= 1) {
            $_POST[$clave] = preg_replace('/[^0-9.]/i', '', $_POST[$clave]);
            return trim($_POST[$clave]);
        }
    }

    /* Solo acepta caracteres entre a y z , 0 y 9 y _ se utiliza para sanitizar */

    protected function getBigint($clave) {

        if (strlen($_POST[$clave]) >= 1) {
            $_POST[$clave] = (string) preg_replace('/[^0-9]/', '', $_POST[$clave]);
            return $_POST[$clave];
        }
    }

    public function validarEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    //Aumenta la cantidad de 0 a la izquierda
    function number_pad($number, $n) {
        return str_pad((int) $number, $n, "0", STR_PAD_LEFT);
    }

    //Hallar nro mas cerca en array
    function closest($array, $number) {

        sort($array);
        foreach ($array as $a) {
            if ($a >= $number)
                return $a;
        }
        return end($array); // or return NULL;
    }

    //Validar Clave
    function validar_clave($clave, &$error_clave) {
        if (strlen($clave) < 8) {
            $error_clave = "La clave debe tener al menos 6 caracteres";
            return false;
        }
        if (strlen($clave) > 16) {
            $error_clave = "La clave no puede tener más de 16 caracteres";
            return false;
        }
		//validacion minusculas
        /*if (!preg_match('`[a-z]`', $clave)) {
            $error_clave = "La clave debe tener al menos una letra minúscula";
            return false;
        }*/
        if (!preg_match('`[A-Z]`', $clave)) {
            $error_clave = "La clave debe tener al menos una letra mayúscula";
            return false;
        }
        if (!preg_match('`[0-9]`', $clave)) {
            $error_clave = "La clave debe tener al menos un caracter numérico";
            return false;
        }
        $error_clave = "";
        return true;
    }
    
    //Retornar los minutos pasando dos fechas como parametro
    function minutos_transcurridos($fecha_i, $fecha_f) {
        $minutos = (strtotime($fecha_i) - strtotime($fecha_f)) / 60;
        $minutos = abs($minutos);
        $minutos = floor($minutos);
        return $minutos;
    }

}

?>
