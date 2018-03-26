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

/*
 * DATABASE
 */
define('SERVERHOST',$_SERVER['HTTP_HOST']);
define('PATH', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));
echo PATH;
if(SERVERHOST == "localhost")
{
    define("HOST", "localhost");
    define("USER", "root");
    define("PASSWORD", "");
    define("DATABASE", "autoevaluation_projetl3");
}
else if(SERVERHOST == "dev-21404260.users.info.unicaen.fr")
{
    DEFINE("USERNAME","21402838");
    DEFINE("PASSWORD","Aiqu1IeVaeT8EC2b");
    DEFINE("HOST","mysql.info.unicaen.fr");
    DEFINE("DB","21402838_dev");
}

try {
    $connection = new PDO("mysql:dbname=".DB.";host=".HOST, USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
}
catch (PDOException $e) {
    echo $e;
}

$JVDStorage = new JVDStorageMySQL ($connection);
$AccountStorage= new AccountStorageMySQL($connection);
$router = new Router();
$router->main($JVDStorage,$AccountStorage);
