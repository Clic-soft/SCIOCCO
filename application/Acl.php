<?php

class Acl {

    private $_registry;
    private $_db; //Objeto base de datos
    private $_id; //Id del usuario
    private $_role; //guarda el id del rol que estemos trabajando
    private $_permisos; //devolvera los permisos ya procesados

    public function __construct($id = false) {
        if ($id) {
            $this->_id = (int) $id;
        } else {
            if (Session::get('id_usuario')) {
                $this->_id = Session::get('id_usuario');
            } else {
                $this->_id = 0;
            }
        }

        $this->_registry = Registry::getInstancia();
        $this->_db = $this->_registry->_db;
        //$this->_role = $this->getRole();
        //$this->_permisos = $this->getPermisosRole();
    }


/*    public function acceso($modulo) {

        if(Session::get('autenticado_paginwebacemcop') and Session::get('autenticado_paginwebacemcop') == true){
            //Session::tiempo();
            return;
        }


        header('location:' . BASE_URL . 'login/login?modulo='.$modulo);
        // header('location:' . BASE_URL . 'error/access/5050');
        exit; //Para que no se ejecute 
    }*/
}

?>
