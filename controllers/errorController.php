<?php

class errorController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->_view->titulo = 'Error';
        $this->_view->mensaje = $this->_getError();
        $this->_view->renderizar('index', false, true);
    }

    public function access($codigo) {
        $this->_view->titulo = 'Error';
        $this->_view->mensaje = $this->_getError($codigo);
        $this->_view->renderizar('access', false, true);
    }

    private function _getError($codigo = FALSE) {

        if ($codigo) {
            $codigo = $this->filtrarInt($codigo);
            if (is_int($codigo))
                $codigo = $codigo;
        }
        else {
            $codigo = 'default';
        }

        //Codigos de los errores
        $error['default'] = 'Ha ocurrido un error y la p&aacute;gina no puede mostrarse';
        $error['1010'] = 'Error de modelo';
        $error['2020'] = 'Error de Libreria';
        $error['5050'] = 'Acceso restringido.!';
        $error['8080'] = 'Tiempo de la sesi&oacute;n agotado';
        $error['9090'] = 'No se puede visualizar la p&aacute;gina';
        $error['7070'] = 'No se ha definido el tiempo de sesion';
        $error['1110'] = 'Error de base de modelo';
     //   $error['1210'] = 'Parece que ha habido un error con la p&aacute;gina que estabas buscando.
//Es posible que haya sido eliminada o que la direcci&oacute;n no exista.!';
        $error['1111'] = 'Error de js';
        $error['2222'] = 'Error de js plugin';

        /* si existe la clave en el arreglo */
        if (array_key_exists($codigo, $error)) /* Si no existe mensaje por defecto */ {
            return $error[$codigo];
        } else {
            return $error['default'];
        }
    }

}

?>