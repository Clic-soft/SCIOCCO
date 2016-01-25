<?php

ini_set('display_erros', 1);
ini_set("memory_limit", "2048M"); // Aumentar memoria
//echo uniqid();exit; id unico
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('ROOT_ADMIN', "sciocco" . DS);

define('APP_PATH', ROOT . 'application' . DS);


//echo md5('1234');exit;


try {
    require_once APP_PATH . 'Autoload.php';
    require_once APP_PATH . 'Config.php';
    require_once APP_PATH . 'Config2.php';
    require_once APP_PATH . 'ez_sql_core.php';
    require_once APP_PATH . 'ez_sql_mysql.php';

//echo Hash::getHash('sha1', '1234', HASH_KEY);exit;
    Session::init();

    //Se crea una nueva instancia de registro
    $registry = Registry::getInstancia();
    $registry->_request = new Request();
    $registry->_db = new ezSQL_mysql(DB_USER, DB_PASS, DB_NAME, DB_HOST, DB_CHAR);
    $registry->_db->query("SET NAMES utf8");
    //$registry->_db2 = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_CHAR);
    $registry->_acl = new Acl();

    Bootstrap::run($registry->_request);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>