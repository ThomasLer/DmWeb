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
            "accueil" => array("accueil","Accueil"),
            "nouveau" => array("/action/nouveau","Ajouter un JVD"),
            "liste" => array("/liste","Liste")
        );
        $this->menuRight = array(
            "connexion" => array("/connexion","Déconnexion")
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
        $this->title = 'Liste des jeux vidéos';
        $this->content = "<div class='ui list'>";
        foreach ($tabJVD as $key => $JVD) {
            $nomJVD = $JVD->getNom();
            $idJVD = $JVD->getId();
            $photoJVD = $JVD->getPhoto();
            $genreJVD = $JVD->getGenre();
            $this->content .= "<div class=\"item\">
                                <img class=\"ui avatar image\" src=\"$photoJVD\">
                                <div class=\"content\">
                                    <a class=\"header\" href='" . $this->router->getJVDURL($idJVD) . "'>".$nomJVD."</a>
                                    <div class=\"description\">$genreJVD</div>
                                </div>
                                <a href='".$this->router->getJVDSupp($idJVD) . "'><i class=\"small trash middle icon red\"></i></a>
                                <a href='".$this->router->getJVDmodif($idJVD) . "'><i class=\"small edit middle icon blue\"></i></a>
                              </div>";
        }
        $this->content .= "</div>";
    }

    public function makeModifJvdPage(JVD $jvd){
        $this->title = "Modifier le JVD ".$jvd->getNom();
        $this->content = "";

        $this->content .= "<div class='ui middle aligned center aligned grid'>
                          <div class='column'>
                            <form class='ui large form' action='" . $this->router->getJVDSaveModifURL() . "' enctype='multipart/form-data' method='post'>
                              <div class='ui stacked segment'>
                                <div class='field'>
                                    <input type='text' name='" . JVDBuilder::NOM_REF . "' placeholder='Titre' value='" . stripslashes(htmlspecialchars($jvd->getNom(), ENT_QUOTES)) . "' required/>
                                </div>
                                <div class='field'>
                                    <input type='text' name='" . JVDBuilder::GENRE_REF . "' placeholder='Genre' value='" . stripslashes(htmlspecialchars($jvd->getGenre(), ENT_QUOTES)) . "' required/>
                                </div>
                                <div class='field'>
                                    <input type='number' name='" . JVDBuilder::ANNEE_SORTIE_REF . "' value='" . $jvd->getAnneeSortie() . "' min='1950' required/>
                                </div>
                                <img src='".$jvd->getPhoto()."' id='previsualisation' onerror=\"this.src = './upload/imgDefault.png'\" style='max-height: 300px'>
                                <div class='field'>
                                    <label for='file' class='ui icon button'>
                                        <i class='file icon'></i>
                                    Ajouter une vignette</label>
                                    <input type='file' name='" . JVDBuilder::PHOTO_REF . "' id='file' style='display:none'>
                                </div>
                                <input type='hidden' name='id' value='".$jvd->getId()."'>
                                <button class='ui fluid large teal submit button' type='submit'>Modifier</button>
                              </div>                               
                            </form>
                          </div>
                        </div>";
    }
}