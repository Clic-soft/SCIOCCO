<?php

$dbhost="localhost";
$dblogin="root";
$dbpwd="";
$dbname="sciocco";
  
$db =  mysql_connect($dbhost,$dblogin,$dbpwd);
mysql_select_db($dbname);  
?>