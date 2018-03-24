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

const USERNAME = "root";
const PASSWORD = "";
const HOST = "localhost";
const DB = "dmweb";

$username = USERNAME;
$password = PASSWORD;
$host = HOST;
$db = DB;
$connection= new PDO("mysql:dbname=$db;host=$host", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));


$JVDStorage = new JVDStorageMySQL ($connection);
$AccountStorage= new AccountStorageMySQL($connection);
$router = new Router();
$router->main($JVDStorage,$AccountStorage);
?>