<?php

error_reporting(E_PARSE);

class Paginador {

    private $_datos;
    private $_paginacion;

    public function __construct() {
        $this->_datos = array();
        $this->_paginacion = array();
    }

    public function paginar($query, $pagina = false, $limite = false, $paginacion = false) {
        if ($limite && is_numeric($limite)) {//Se revisa si existe un limite y si es numerico
            $limite = $limite;
        } else {
            $limite = 10; //Sino se envia un limite por defecto es 10
        }

        if ($pagina && is_numeric($pagina)) {//Si se envia una pagina y es numerica
            $pagina = $pagina;
            //Si envia pagina para dividirlas ejemplo: envia pagina #2 seria 2-1
            // por el limite seria 10 y traeria los registros del 11 en adelante
            $inicio = ($pagina - 1) * $limite;
        } else {
            $pagina = 1;
            $inicio = 0;
        }


        $registros = count($query);
        $total = ceil($registros / $limite); //Valor entero de dividir registros
        $this->_datos = array_slice($query, $inicio, $limite);

        /* Se llenan parametros de paginacion */
        $paginacion = array();
        $paginacion['totalregistros'] = $registros;
        $paginacion['actual'] = $pagina;
        $paginacion['total'] = $total;
        $paginacion['limite'] = $limite;

        if ($pagina > 1) {/* Para llenar primero y anterior */
            $paginacion['primero'] = 1;
            $paginacion['anterior'] = $pagina - 1;
        } else {
            $paginacion['primero'] = '';
            $paginacion['anterior'] = '';
        }

        if ($pagina < $total) {
            $paginacion['ultimo'] = $total;
            $paginacion['siguiente'] = $pagina + 1;
        } else {
            $paginacion['ultimo'] = '';
            $paginacion['siguiente'] = '';
        }

        $this->_paginacion = $paginacion; //Se llena el atributo
        $this->_rangoPaginacion($paginacion);

        return $this->_datos;
    }

    private function _rangoPaginacion($limite = false) {
        if ($limite && is_numeric($limite)) {
            $limite = $limite;
        } else {
            $limite = 10;
        }

        $total_paginas = $this->_paginacion['total']; //Total de páginas
        $pagina_seleccionada = $this->_paginacion['actual']; //Pagina que esta actualmente seleccionada
        $rango = ceil($limite / 2); //Asigna la mitad del limite dependiendo de las paginas seleccionada asigna segun el limte 
        //5 paginas del lado izquierdo y 4 paginas del lado derecho
        $paginas = array();

        /* Determinar rango de la derecha */
        $rango_derecho = $total_paginas - $pagina_seleccionada; //para completar posiciones faltantes en los lados

        if ($rango_derecho < $rango) { //Si el rango derecho es menor que el rango
            $resto = $rango - $rango_derecho;
        } else {
            $resto = 0;
        }

        /* Determinar rango de la izquierda */
        $rango_izquierdo = $pagina_seleccionada - ($rango + $resto); //se aumenta rango que quedo del lado derecho para asignarselo al izquierdo


        /* En caso de que se decremente */
        for ($i = $pagina_seleccionada; $i > $rango_izquierdo; $i--) {
            if ($i == 0) {
                break;
            }

            $paginas[] = $i; //Se llena de mayor a menor
        }

        sort($paginas); //Organiza el arreglo en orden de menor a mayor

        /* Se verifica si hay posiciones faltantes del lado izquierdo */
        if ($pagina_seleccionada < $rango) {
            $rango_derecho = $limite;
        } else {
            /* puede dar el numero mayor a las paginas */
            $rango_derecho = $pagina_seleccionada + $rango;
        }

        /* Si se coloca en la pagina seleccionada se repetiria */
        for ($i = $pagina_seleccionada + 1; $i <= $rango_derecho; $i++) {
            if ($i > $total_paginas) {//Que no sobrepase la ultima página
                break;
            }

            $paginas[] = $i; //Posiciones del lado derecho
        }

        $this->_paginacion['rango'] = $paginas;

        return $this->_paginacion;
    }

    /* Crear vista solo para paginaciones
     * link es hacia donde va a dirigirse la pagina
     */

    public function getView($vista, $link = false) {

        $rutaView = ROOT . 'views' . DS . '_paginador' . DS . $vista . '.php';
        /* Se verifica si se envio el link */
        if ($link)
            $link = BASE_URL . $link . '/';

        if (is_readable($rutaView)) {//Si existe la paginacion
            ob_start(); //apertura el buffer

            include $rutaView; //se almacena lista en el buffer

            $contenido = ob_get_contents(); //despues se almacena en la variable contenido

            ob_end_clean(); //limpia el bufer que se acaba de extraer

            return $contenido;
        }

        throw new Exception('Error de paginacion');
    }

}

?>
