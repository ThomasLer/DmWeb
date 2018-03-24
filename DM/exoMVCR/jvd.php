<?php

/*
 * On indique que les chemins des fichiers qu'on inclut
 * seront relatifs au répertoire src.
 */
set_include_path("./src");

/* Inclusion des classes utilisées dans ce fichier */
require_once("Router.php");

/*
 * Cette page est simplement le point d'arrivée de l'internaute
 * sur notre site. On se contente de créer un routeur
 * et de lancer son main.
 */

DEFINE("USERNAME","root");
DEFINE("PASSWORD","");
DEFINE("HOST","localhost");
DEFINE("DB","dmweb");

$connection= new PDO("mysql:dbname=DB =;host=HOST", USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


$JVDStorage = new JVDStorageMySQL ($connection);
$AccountStorage= new AccountStorageMySQL($connection);
$router = new Router();
$router->main($JVDStorage,$AccountStorage);
