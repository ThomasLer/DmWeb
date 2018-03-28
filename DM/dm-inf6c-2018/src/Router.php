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
        session_start();
    }

    public function main(JVDStorage $JVDStorage, AccountStorageMySQL $accountStorageMySQL)
    {

        $feedback = (key_exists('feedback', $_SESSION) and sizeof($_SESSION['feedback']) == 2) ? $_SESSION['feedback'] : '';
        unset($_SESSION['feedback']);

        $isConnected = false;
        if (key_exists('user', $_SESSION))
            $isConnected = true;

        if (!$isConnected)
            $uneVue = new View($this, $feedback);
        else
            $uneVue = new PrivateView($this, $feedback, $_SESSION['user']);
        $unController = new Controller($uneVue, $JVDStorage, $accountStorageMySQL);

        if(key_exists('p',$_GET))
        {
            $page = explode("/", $_GET['p']);
            if (key_exists(0,$page))
            {
                switch ($page[0]) {
                    case "id":
                        if (key_exists(1,$page))
                            $unController->showInformation($page[1]);
                        else
                            $uneVue->makeUnknownActionPage();
                        break;
                    case "liste":
                        $unController->showList();
                        break;
                    case "connexion":
                        $unController->gestionConnexionDeconnexion();
                        break;
                    case "a_propos":
                        $uneVue->makeAPropos();
                        break;
                    case "nvCompte":
                        $unController->newCompte();
                        break;
                    case "suppId":
                        if (key_exists(1,$page))
                            $unController->suppJVD($page[1]);
                        else
                            $uneVue->makeUnknownActionPage();
                        break;
                    case "modifId":
                        if (key_exists(1,$page))
                            $unController->recupJVDmodif($page[1]);
                        else
                            $uneVue->makeUnknownActionPage();
                        break;
                    case "action":
                        if (isset($page[1]) and !empty($page[1])) {
                            if($isConnected)
                                switch ($page[1]) {
                                    case "sauverNouveau":

                                        $unController->saveNewJVD($_POST);
                                        break;
                                    case "nouveau":
                                        $unController->newJVD();
                                        break;
                                    case "sauverModif":
                                        $unController->sauverModif($_POST);
                                        break;
                                    default :
                                        $uneVue->makeUnknownActionPage();
                                        break;
                                }
                            else
                                switch ($page[1]) {
                                    case "sauverNouveau":
                                    case "nouveau":
                                    case "sauverModif":
                                        $uneVue->makeNeedConnectionPage();
                                        break;
                                    default :
                                        $uneVue->makeUnknownActionPage();
                                        break;
                                }
                        } else {
                            $uneVue->makeUnknownActionPage();
                            break;
                        }
                        break;
                    case "accueil":
                        $uneVue->pageAccueil();
                        break;
                    default :
                        $uneVue->makeUnknownActionPage();
                        break;
                }
            }
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
        $url = PATH."id/" . $id;
        return $url;
    }

    public function getJVDSupp($id)
    {
        $url = PATH."suppId/" . $id;
        return $url;
    }

    public function getJVDmodif($id)
    {
        $url = PATH."modifId/" . $id;
        return $url;
    }

    public function getJVDCreationURL()
    {
        $url = PATH."action/nouveau";
        return $url;
    }

    public function getJVDSaveURL()
    {
        $url = PATH."action/sauverNouveau";
        return $url;
    }

    public function getJVDSaveModifURL()
    {
        $url = PATH."action/sauverModif";
        return $url;
    }

    public function POSTredirect($url, $feedback, $isSuccess)
    {
        $_SESSION['feedback'] = array($feedback, $isSuccess);
        session_write_close();
        header("Location: ".PATH. htmlspecialchars_decode($url), true, 303);
    }
}