<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function autoloadCore($class) {
    if (file_exists(APP_PATH . ucfirst(strtolower($class)) . '.php')) {
        include APP_PATH . ucfirst(strtolower($class)) . '.php';
    }
}

function autoloadLibs($class) {
    if (file_exists(ROOT . 'libs' . DS . 'class.' . strtolower($class) . '.php')) {
        include ROOT . 'libs' . DS . 'class.' . strtolower($class) . '.php';
    }
}

spl_autoload_register('autoloadCore');
spl_autoload_register('autoloadLibs');
?>
