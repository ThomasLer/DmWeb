<?php

class Controller
{
    private $view;
    private $JVDStorage;
    private $accountStorageMySQL;

    public function __construct(View $view, JVDStorage $JVDStorage, AccountStorageMySQL $accountStorageMySQL)
    {
        $this->view = $view;
        $this->JVDStorage = $JVDStorage;
        $this->accountStorageMySQL=$accountStorageMySQL;
    }

    public function showInformation($id)
    {
        if ($jvd = $this->JVDStorage->read($id)) {
            $this->view->makeJVDPage($jvd);
        } else {
            $this->view->makeUnknownJVDPage();
        }
    }

    public function showList()
    {
        $this->view->makeListPage($this->JVDStorage->readAll());
    }

    public function saveNewJVD(array $data)
    {

        $JVDBuilder = new JVDBuilder($data);
        $JVDSave = $JVDBuilder->createJVD();
        if ($JVDSave !== null) {
            $id = $this->JVDStorage->create($JVDSave);
            $this->view->displayJVDCreationSuccess($id);
            unset($_SESSION['currentNewJVD']);
        } else {
            $this->view->displayJVDCreationFailure();
            $_SESSION['currentNewJVD'] = $JVDBuilder;

        }
        //$this->showList();
    }

    public function newJVD()
    {
        if (key_exists('currentNewJVD', $_SESSION)) {
            $JVDBuilder = $_SESSION['currentNewJVD'];
        } else {
            $JVDBuilder = new JVDBuilder();
        }
        $this->view->makeJVDCreationPage($JVDBuilder);
    }

    public function suppJVD($id){

        $this->JVDStorage->delete($id);
        echo "ok";
    }

    public function newCompte(){
        if(key_exists('pseudoCmp',$_POST) && key_exists('passCmp',$_POST) && key_exists('nomCmp',$_POST)){
           $ajout=$this->accountStorageMySQL->verifNvCompte(new Account($_POST['nomCmp'],$_POST['pseudoCmp'],$_POST['passCmp']));
            if($ajout==false){
                $this->view->makeCreateAccountFormPage();
            }
        }
        else{
            $this->view->makeCreateAccountFormPage();
        }
    }

    public function gestionConnexionDeconnexion(){
        if(key_exists('user',$_SESSION)){
            $this->view->makeDeconnexionPage();
        }
        else{
            $this->view->makeLoginFormPage();
        }

    }

    public function verifConnexion()
    {

        switch($this->accountStorageMySQL->checkAuth($_POST['Nom'],$_POST['pass'])){
            case 1:
                $this->view->retourAccueil();
                break;
            case 0:
                $this->view->makeLoginFormPage("Mot de passe incorecte");
                break;
            case -1:
                $this->view->makeLoginFormPage("Pseudo invalide");
                break;

        }


    }

}