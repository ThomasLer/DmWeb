<?php

/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 21/02/2018
 * Time: 22:10
 */
class PrivateView extends View
{


    /**
     * PrivateView constructor.
     */
    private $account;
    public function __construct(Router $router, $feedback, Account $account)
    {
        $this->router = $router;
        $this->title = "Accueil";
        $this->content = null;
        $this->menuLeft = array(
            "accueil" => array("jvd.php","Accueil"),
            "nouveau" => array("jvd.php?action=nouveau","Ajouter un JVD"),
            "liste" => array("jvd.php?liste","Liste")
        );
        $this->menuRight = array(
            "connexion" => array("jvd.php?connexion","Déconnexion")
        );
        $this->feedback = $feedback;
        $this->account = $account;
    }

    public function pageAccueil(){
        $this->title="Bonjour ".$this->account->getNom();
        $this->content="Vous êtes connecté en tant que : ".ucfirst($this->account->getStatut());
    }

    public function makeListPage(array $tabJVD)
    {
        $this->title = 'JVD disponibles à la consultation';
        foreach ($tabJVD as $key => $JVD) {
            $nomJVD = $JVD->getNom();
            $idJVD = $JVD->getId();
            $this->content .= "<a href='" . $this->router->getJVDURL($idJVD) . "'><h5>" . $nomJVD . "</h5></a><a href='" . $this->router->getJVDSupp($idJVD) . "'><h5>X</h5></a>";
        }

    }
}