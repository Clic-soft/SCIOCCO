<?php

class View {

    private $_request;
    private $_js;
    //private $_acl;
    private $_rutas;
    private $_jsPlugin;
    private $_template;
    private $_item;
    private $_db;

    public function __construct(Request $peticion) {

        /* Se inicializan variables en el constructor */
        $this->_request = $peticion;
        $this->_js = array();
        //$this->_acl = $_acl;
        $this->_rutas = array();
        $this->_jsPlugin = array();
        $this->_template = DEFAULT_LAYOUT;
        $this->_item = '';

        $controlador = $this->_request->getControlador();
        /* Se verifica si se trabaja en base a un modelo 
         * o controlador para llenar las rutas
         */

        $this->_rutas['view'] = ROOT . 'views' . DS . $controlador . DS;
        $this->_rutas['js'] = BASE_URL . 'views/' . $controlador . '/js/';
    }

    public function renderizar($vista, $item = false, $noLayout = false) {

        $this->template_dir = ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS;

        if ($item) {
            $this->_item = $item;
        }

        $_params = array(
            'ruta_css' => BASE_URL . 'views/layout/' . $this->_template . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . $this->_template . '/img/',
            'ruta_js' => BASE_URL . 'views/layout/' . $this->_template . '/js/',
            'item' => $this->_item,
            'js' => $this->_js,
            'js_plugin' => $this->_jsPlugin,
            'root' => BASE_URL
        );

        if (is_readable($this->_rutas['view'] . $vista . '.phtml')) {
            if ($noLayout) {
                $this->template_dir = $this->_rutas['view'];
                $this->_layoutParams = $_params;
                /* Para poder realizar consultas en las vistas */
                $this->_db = new ezSQL_mysql(DB_USER, DB_PASS, DB_NAME, DB_HOST, DB_CHAR);
                $this->_db->query("SET NAMES utf8");
                include_once $this->_rutas['view'] . $vista . '.phtml';
                exit;
            }

            $this->_contenido = $this->_rutas['view'] . $vista . '.phtml';
        } else {
             echo  $this->_contenido = $this->_rutas['view'] . $vista . '.phtml'; exit;
            throw new Exception('Error de vista');
        }


        //$this->_acl = $this->_acl;
        $this->_layoutParams = $_params;
        /* Para poder realizar consultas en las vistas */
        $this->_db = new ezSQL_mysql(DB_USER, DB_PASS, DB_NAME, DB_HOST, DB_CHAR);
        $this->_db->query("SET NAMES utf8");
        include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'template.phtml';
    }

    public function setJs(array $js) {
        if (is_array($js) && count($js)) {
            for ($i = 0; $i < count($js); $i++) {
                $this->_js[] = $this->_rutas['js'] . $js[$i] . '.js';
            }
        } else {
            header('location:' . BASE_URL . 'error/access/1111');
        }
    }

    public function setJsPlugin(array $js) {
        if (is_array($js) && count($js)) {
            for ($i = 0; $i < count($js); $i++) {
                $this->_jsPlugin[] = BASE_URL . 'public/js/' . $js[$i] . '.js';
            }
        } else {
            header('location:' . BASE_URL . 'error/access/2222');
        }
    }

}

?>
