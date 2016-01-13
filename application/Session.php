<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Session {

    public static function init() {
        session_name("accesa");
        session_start();
    }

    public static function destroy($clave = false) {
        if ($clave) {/* Si se envia una clave */
            if (is_array($clave)) { /* Se verifica si es un arreglo por cada coincidencia elimina la variable de session */
                for ($i = 0; $i < count($clave); $i++) {
                    if ($_SESSION[$clave[$i]]) {
                        unset($_SESSION[$clave[$i]]);
                    }
                }
            } else {/* Si no es un arreglo verifica la variable de session y la destruye */
                if ($_SESSION[$clave]) {
                    unset($_SESSION[$clave]);
                }
            }
        } else {//Si no se envia una clave 
            session_destroy();
        }
    }

    /* recibe una variable de session y la asigna */

    public static function set($clave, $valor) {
        if (!empty($clave))
            $_SESSION[$clave] = $valor;
    }

    public static function get($clave) {
        if (isset($_SESSION[$clave]))
            return $_SESSION[$clave];
    }

    public static function acceso($level) {
        if (!Session::get('autenticado_cemcop')) {
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }

        Session::tiempo();

        if (Session::getLevel($level) > Session::getLevel(Session::get('level'))) {
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }
    }

    public static function accesoView($level) {
        if (!Session::get('autenticado_cemcop')) {
            return false;
        }

        if (Session::getLevel($level) > Session::getLevel(Session::get('level'))) {
            return false;
        }

        return true;
    }

    public static function getLevel($level) {
        $role['admin'] = 3;
        $role['especial'] = 2;
        $role['usuario'] = 1;

        if (!array_key_exists($level, $role)) {
            throw new Exception('Error de acceso');
        } else {
            return $role[$level];
        }
    }

    /* Permite seleccionar ciertos grupos de usuarios para dar permisos */

    public static function accesoEstricto(array $level, $noAdmin = false) {
        if (!Session::get('autenticado_cemcop')) {
            header('location:' . BASE_URL . 'error/access/5050');
            exit;
        }

        Session::tiempo();

        if ($noAdmin == false) {
            if (Session::get('level') == 'admin') {
                return;
            }
        }
        //Si existe el leve, va salir de la funcion y le va a permitir el acceso
        if (count($level)) {
            if (in_array(Session::get('level'), $level)) {
                return;
            }
        }

        header('location:' . BASE_URL . 'error/access/5050');
    }

    public static function accesoViewEstricto(array $level, $noAdmin = false) {
        if (!Session::get('autenticado_cemcop')) {
            return false;
        }

        if ($noAdmin == false) {
            if (Session::get('level') == 'admin') {
                return true;
            }
        }

        if (count($level)) {
            if (in_array(Session::get('level'), $level)) {
                return true;
            }
        }

        return false;
    }

    public static function tiempo() {
        if (!Session::get('tiempo') || !defined('SESSION_TIME')) {
            header('location:' . BASE_URL . 'error/access/7070');
            // throw new Exception('No se ha definido el tiempo de sesion'); 
        }

        if (SESSION_TIME == 0) {
            return;
        }
        /* time devuelvel el tiemo en segundos */
        if (time() - Session::get('tiempo') > (SESSION_TIME * 60)) {
            Session::destroy();
            header('location:' . BASE_URL . 'error/access/8080');
        } else {
            Session::set('tiempo', time());
        }
    }

}

?>
