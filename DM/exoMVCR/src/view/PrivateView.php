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
            $this->content .= "<a href='" . $this->router->getJVDURL($idJVD) . "'><h5>" . $nomJVD . "</h5></a>
            <a href='" . $this->router->getJVDSupp($idJVD) . "'><h5>X</h5></a>
            <a href='" . $this->router->getJVDmodif($idJVD) . "'><h5>...</h5></a>";
        }

    }

    public function makeModifJvdPage(JVD $jvd){
        $this->title = "Modifier le JVD ".$jvd->getNom();
        $this->content = "";

        $this->content .= "<form action='" . $this->router->getJVDSaveModifURL() . "'enctype=\"multipart/form-data\" method='post'>
            <input type='text' name='" . JVDBuilder::NOM_REF . "' id='" . JVDBuilder::NOM_REF . "' value='" .$jvd->getNom(). "' /> <label for='nom'>" . JVDBuilder::NOM_REF . " JVD</label><br />
            <input type='text' name='" . JVDBuilder::GENRE_REF . "' id='" . JVDBuilder::GENRE_REF . "' value='" . $jvd->getGenre() . "'/> <label for='nom'>" . JVDBuilder::GENRE_REF . " JVD</label><br />
            <input type='number' name='" . JVDBuilder::ANNEE_SORTIE_REF . "' id='" . JVDBuilder::ANNEE_SORTIE_REF . "' value='" . $jvd->getAnneeSortie() . "'/> <label for='age'>" . JVDBuilder::ANNEE_SORTIE_REF . " JVD</label><br />
            <img src='".$jvd->getPhoto()."' onerror=\"this . src = './upload/imgDefault.png'\">
            <input type='file' name='" . JVDBuilder::PHOTO_REF . "' id='" . JVDBuilder::PHOTO_REF . "'/>
            <input type='hidden' name='id' value='".$jvd->getId()."'>

            <br><br><button type='submit'>Modifier</button>
        </form>";
    }
}