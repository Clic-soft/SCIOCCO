<?php

/* DE DONDE VAN A EXTENDER TODOS LOS MODELOS
 */

class Model {

    private $_registry;
    protected $_db;

    //protected $_db2;

    public function __construct() {
        $this->_registry = Registry::getInstancia();
        $this->_db = $this->_registry->_db;
        //$this->_db2 = $this->_registry->_db2;
    }

}

?>
