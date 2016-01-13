<?php

/*
 * Recibe peticiones por la url y las pasa al bootstrap
 * 
 */

class Request {

    //Atributos privados
    private $_modulo;
    private $_controlador;
    private $_metodo;
    private $_argumentos;

    public function __construct() {

        if (isset($_GET['url'])) {
            /*
             * filter input
             * Toma el parametro url
             * input_get se le indica que es via get
             * lo pasa por el filtro filter_sanitize_url y lo devuelve filtrado
             * 
             */
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);

            /* Crea un arreglo, cada vez que encuentre un "/" va crear un elemento metodo , controler y argumentos */
            $url = explode('/', $url);
            /* Elementos que no sean validos en el arreglo los elimina */
            $url = array_filter($url);

            /* se toma el primer parametro de la url y se le asigna al modulo */
            $this->_modulo = strtolower(array_shift($url));


            if (!$this->_modulo) {
                //Se asegura del que modulo quede falso
                $this->_modulo = false;
            } else {
                /* se almacena un modulo, pero no esta definido... */
                $this->_controlador = $this->_modulo;
                $this->_modulo = false;
            }


            /* Llega sin el primer elmento y extrae el primer elemento */
            $this->_metodo = strtolower(array_shift($url));
            /* Lo que queda lo asigna a los argumentos */
            $this->_argumentos = $url;
        }


        /* Siempre se va a devolver un controlador, metodos y argumentos */
        if (!$this->_controlador) {
            $this->_controlador = DEFAULT_CONTROLLER;
        }

        if (!$this->_metodo) {
            $this->_metodo = 'index';
        }

        if (!isset($this->_argumentos)) {
            $this->_argumentos = array();
        }
        //echo $this->_modulo . '/' . $this->_controlador . '/' . $this->_metodo . '/' ; print_r($this->_argumentos);exit;
    }

    public function getModulo() {
        return $this->_modulo;
    }

    public function getControlador() {
        return $this->_controlador;
    }

    public function getMetodo() {
        return $this->_metodo;
    }

    public function getArgs() {
        return $this->_argumentos;
    }

}

?>
