<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Registry {
    /* Se usara singleton para asegurar que en la aplicación completa solo exista
     * un objeto del registro
     */

    //instancia del registro
    private static $_instancia;
    //Se guardaran clases almacenadas en el registro
    private $_data;

    //Se asegura que no se pueda crear una instancia de la clase
    private function __construct() {
        //Solamente se puede instanciar desde dentro de la clase
    }

    //Singleton
    //Metodo estatico para acceder a atributo estatico
    //que va a contener la instancia
    public static function getInstancia() {

        //Si el atributo no contiene una instancia de registro
        if (!self::$_instancia instanceof self) {
            //Crea la instancia de registro
            self::$_instancia = new Registry();
        }
        //Retorna la instancia
        return self::$_instancia;
    }

    //Data guardar un arreglo de objetos de clases compartidas
    //__Set, en la data se crea arreglo asociativo
    public function __set($name, $value) {
        $this->_data[$name] = $value;
    }

    public function __get($name) {
        //Si existe un objeto, retorna el elemento del arreglo
        if (isset($this->_data[$name])) {
            return $this->_data[$name];
        }

        return false;
    }

}

?>
