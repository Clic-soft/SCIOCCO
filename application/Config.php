<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//define('BASE_URL', 'http://192.168.50.254/Desarrollos/admin_cemcop/'); /*Para incluir archivos de lado de las vistas*/
define('BASE_URL', '/sciocco/'); /* Para incluir archivos de lado de las vistas */
//define('BASE_URL_ADMIN', '/localhost/pagina_cemcop/'); /* Para incluir archivos de lado de las vistas */
/* Va a representar el controlador por defecto en la aplicacion */
define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_LAYOUT', 'twb');

define('SESSION_TIME', 30);
define('HASH_KEY', '5061a08373f07'); //No puede ser cambiado, si se hace no se pueden recuperar contraseÃ±as

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sciocco');
define('DB_CHAR', 'utf8');
?>
