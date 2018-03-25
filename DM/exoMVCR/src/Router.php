<?php

require_once("view/View.php");
require_once("view/PrivateView.php");
require_once("control/Controller.php");
require_once("model/JVD.php");
require_once("model/JVDStorage.php");
require_once("model/JVDBuilder.php");
require_once("model/JVDStorageMySQL.php");
require_once("model/AccountStorage.php");
require_once("model/AccountStorageMySQL.php");
require_once("model/Account.php");

class Router
{

    /**
     * Router constructor.
     */
    public function __construct()
    {
    }

    public function main(JVDStorage $JVDStorage, AccountStorageMySQL $accountStorageMySQL)
    {

        session_start();

        $feedback = (key_exists('feedback', $_SESSION) and sizeof($_SESSION['feedback']) == 2) ? $_SESSION['feedback'] : '';
        unset($_SESSION['feedback']);

        $etatCo = null;
        if (key_exists('user', $_SESSION)) {
            $etatCo = 1;
        }
        if ($etatCo !== 1) {
            $uneVue = new View($this, $feedback);
        } else {
            $uneVue = new PrivateView($this, $feedback, $_SESSION['user']);
        }

        $unController = new Controller($uneVue, $JVDStorage, $accountStorageMySQL);
        if (key_exists('id', $_GET)) {
            $unController->showInformation($_GET['id']);
        } elseif (key_exists('liste', $_GET)) {
            $unController->showList();
        } elseif (key_exists('action', $_GET) && $etatCo == 1) {
            if ($_GET['action'] == 'nouveau') {
                $unController->newJVD();
            } elseif ($_GET['action'] == 'sauverNouveau') {
                $unController->saveNewJVD($_POST);
            } elseif ($_GET['action'] == 'sauverModif') {
                $unController->
            }

        } elseif (key_exists('action', $_GET) && $etatCo !== 1) {
            if ($_GET['action'] == 'nouveau') {
                $uneVue->makeNeedConnectionPage();
            }
        } elseif (key_exists('connexion', $_GET)) {
            $unController->gestionConnexionDeconnexion();
        } elseif (key_exists('nvCompte', $_GET) and !key_exists('user', $_SESSION)) {
            $unController->newCompte();
        } elseif (key_exists(('suppId'), $_GET) && $etatCo == 1) {
            $unController->suppJVD($_GET['suppId']);
        } elseif (key_exists(('modifId'), $_GET) && $etatCo == 1) {
            $unController->recupJVDmodif($_GET['modifId']);
        } else {
            $uneVue->pageAccueil();
        }
        if (key_exists('Nom', $_POST) && key_exists('pass', $_POST)) {
            $unController->verifConnexion();
        }
        if (key_exists('pseudoCmp', $_POST) && key_exists('passCmp', $_POST)) {
            $unController->newCompte();
        }
        if (key_exists('deconnexion', $_POST)) {
            unset($_SESSION['user']);
            $uneVue->retourAccueil(0);

        }

        $uneVue->render();

    }

    public function getJVDURL($id)
    {

        $url = "jvd.php?id=" . $id;
        return $url;
    }

    public function getJVDSupp($id)
    {
        $url = "jvd.php?suppId=" . $id;
        return $url;
    }

    public function getJVDmodif($id)
    {
        $url = "jvd.php?modifId=" . $id;
        return $url;
    }

    public function getJVDCreationURL()
    {
        $url = "jvd.php?action=nouveau";
        return $url;
    }

    public function getJVDSaveURL()
    {
        $url = "jvd.php?action=sauverNouveau";
        return $url;
    }

    public function getJVDSaveModifURL()
    {
        $url = "jvd.php?action=sauverModif";
        return $url;
    }

    public function POSTredirect($url, $feedback, $isSuccess)
    {
        $_SESSION['feedback'] = array($feedback, $isSuccess);
        session_write_close();
        header("Location: " . htmlspecialchars_decode($url), true, 303);
    }
}