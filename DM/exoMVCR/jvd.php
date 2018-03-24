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

const USERNAME = "21402838";
const PASSWORD = "Aiqu1IeVaeT8EC2b";
const HOST = "mysql.info.unicaen.fr";
const DB = "21402838_dev";

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