<?php

//Clase extendida de la clase controller
class templateController extends Controller {

    private $_template;

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
        //Se cargan el modelo
        $this->_template = $this->loadModel('template');
    }
	 public function index() {


		$this->_view->renderizar('twb/template', 'layout');
    }


}

?>
