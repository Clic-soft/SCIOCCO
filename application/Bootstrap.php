<?php

/*
 * Llama al controller (carpeta) que hace el pedido en el request
 * 
 */

class Bootstrap {

    public static function run(Request $peticion) {
        $controller = $peticion->getControlador() . 'Controller';
        $metodo = $peticion->getMetodo();
        $args = $peticion->getArgs();

        $rutaControlador = ROOT . 'controllers' . DS . $controller . '.php';
        // echo $rutaControlador; exit;

        /* Verifica si el archivo esta en la ruta que se manda, si existe y es valido lo importa */
        if (is_readable($rutaControlador)) {
            require_once $rutaControlador;
            $controller = new $controller;

            /* Si se envia un metodo que no es valido se llama al metodo index */
            if (is_callable(array($controller, $metodo))) {
                $metodo = $peticion->getMetodo();
            } else {
                $metodo = 'index';
            }

            /* Verificar argumentos para llamar al controlador */
            if (isset($args)) {
                /* En arreglo se envia el nombre, metodo y parametros. Se llama arreglo */
                call_user_func_array(array($controller, $metodo), $args);
            } else {
                call_user_func(array($controller, $metodo));
            }
        } else {
            header('location:' . BASE_URL . 'error/access/1210');
        }
    }

}

?>
