<?php
require_once("Router.php");

class View
{
    protected $title;
    protected $content;

    protected $router;

    protected $menuLeft;
    protected $menuRight;

    protected $feedback;

    public function __construct(Router $router, $feedback)
    {
        $this->router = $router;
        $this->title = "Accueil";
        $this->content = null;
        $this->menuLeft = array(
            "accueil" => array("accueil","Accueil"),
            "nouveau" => array("action/nouveau","Ajouter un JVD"),
            "liste" => array("liste","Liste"),
            "a_propos" => array("a_propos","A Propos")
        );
        $this->menuRight = array(
            "connexion" => array("connexion","Connexion"),
            "inscription" => array("nvCompte","Inscription")
        );
        $this->feedback = $feedback;
    }

    public function afficheMenu()
    {
        foreach ($this->menuLeft as $key => $lien) {
            echo "<a href='".PATH.$lien[0]."' class='item'>".$lien[1]."</a>";
        }
        echo "<div class='right menu'>";
        foreach ($this->menuRight as $key => $lien) {
            echo "<a href='".PATH.$lien[0]."' class='item'>".$lien[1]."</a>";
        }
        echo "</div>";
    }


    public function makeTestPage()
    {
        $this->title = "un titre";
        $this->content = "un contenu";
    }

    public function makeJVDPage(JVD $JVD)
    {
        $this->title = $JVD->getNom();
        $this->content = "<img class='ui top aligned small image' src='/dm-inf6c-2018/exoMVCR/".$JVD->getPhoto()."' onerror=\"this.src = '/dm-inf6c-2018/exoMVCR/upload/imgDefault.png'\">";
        $this->content .= "<span>".$JVD->getNom() . " est sortie en " . $JVD->getAnneeSortie() . ", c'est un JVD du genre " . $JVD->getGenre()."</span>";

    }

    public function makeUnknownJVDPage()
    {
        $this->title = "Jeu vidéo inconnu";

    }

    public function makeUnknownActionPage()
    {
        $this->title = "Page inconnu";
        $this->content = "Erreur 404, cette page n'existe pas!";

    }

    public function pageAccueil()
    {
        $this->title = "Accueil";
        $this->content = "Contenu de l'accueil";

    }

    public function makeListPage(array $tabJVD)
    {
        $this->title = 'Liste des jeux vidéos';
        $this->content = "<div class='ui relaxed divided list'>";
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
                              </div>";
        }
        $this->content .= "</div>";

    }

    public function makeNeedConnectionPage(){
        $this->title="Accès interdit";
        $this->content="Veuillez vous connecter pour accéder à cette page";
    }

    /**
     * @return null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param null $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param null $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    public function makeDebugPage($variable)
    {
        $this->title = 'Debug';
        $this->content = '<pre>' . var_export($variable, true) . '</pre>';

    }

    public function displayAccountCreationSuccess()
    {
        $this->router->POSTredirect("accueil", "Compte créé!", 1);
    }

    public function displayAccountAlreadyExist()
    {
        $this->router->POSTredirect("nvCompte", "Un compte avec les mêmes identifiants existe déja !", 0);
    }

    public function displayJVDCreationSuccess($id)
    {
        $this->router->POSTredirect("id/" . $id, "JVD ajouté!", 1);
    }


    public function makeLoginFormPage($erreur = null)
    {
        $this->title = " Connexion";
        $this->content =
            $erreur . " \n
                <div class='ui middle aligned center aligned grid'>
                  <div class='column'>
                    <form class='ui large form' method='post' action='" . ($_SERVER['PHP_SELF']) . "'>
                      <div class='ui stacked segment'>
                        <div class='field'>
                            <input name='Nom' placeholder='Pseudo' required type='text'>
                        </div>
                        <div class='field'>
                            <input name='pass' placeholder='Mot de passe' required type='password'>
                        </div>
                        <button class='ui fluid large teal submit button' type='submit'>Se connecter</button>
                      </div>                               
                    </form>
                
                    <div class='ui message'>
                      Nouveau ? <a href='".PATH."nvCompte'>S'inscrire</a>
                    </div>
                  </div>
                </div>";
    }

    public function makeCreateAccountFormPage($erreur = null)
    {
        $this->title = " Inscription";
        $this->content =
            $erreur . " \n
                    <div class='ui middle aligned center aligned grid'>
                          <div class='column'>
                            <form class='ui large form' method='post' action='" . ($_SERVER['PHP_SELF']) . "'>
                              <div class='ui stacked segment'>
                                <div class='field'>
                                    <input name='nomCmp' placeholder='Nom (visible par les autres utilisateurs)' required type='text'>
                                </div>
                                <div class='field'>
                                    <input name='pseudoCmp' placeholder='Pseudo' required type='text'>
                                </div>
                                <div class='field'>
                                    <input name='passCmp' placeholder='Mot de passe' required type='password'>
                                </div>
                                <button class='ui fluid large teal submit button' type='submit'>S'inscrire</button>
                              </div>                               
                            </form>
                        
                            <div class='ui message'>
                              Déja inscrit ? <a href='".PATH."connexion'>Se connecter</a>
                            </div>
                          </div>
                        </div>";

    }

    public function makeDeconnexionPage()
    {
        $this->title = " Déconnexion";
        $this->content = "
                <p>Vous êtes connecté en tant que " . $_SESSION['user']->getNom() . ", vous êtes sur le point de vous déconnecter.</p>
                <form method='post' action='" . ($_SERVER['PHP_SELF']) . "'>
                        <input type='submit' value='Se déconnecter' name='deconnexion'>
                </form>";

    }

    public function makeAPropos()
    {
        $this->title = " A Propos";
        $this->content = "
            <h3>Membres du binôme</h3>
            <ul>
                <li> 21402838</li>
                <li> 21404260</li>
            </ul>
            <h3>Présentation</h3>
            <p>
                Nous avons utilisé le framework CSS Semantic UI afin d'avoir un site sobre et responsive. Nous avons choisi Semantic UI car nous voulions changer du très connu Framework Bootstrap.<br>
                Pour la modélisation et le code, nous avons gardé les mêmes schémas que ceux vu lors du TP.<br>
                
            </p>
            <h3>Bonus</h3>
            <ul>
                <li> Prévisualiation image lors de l'ajout ou modification d'un jeu vidéo (Javascript).</li>
                <li> Modification du fichier .htaccess afin de pouvoir utiliser un système de page plus intuitif (/dm-inf6c-2018/action/nouveau au lieu de /dm-inf6c-2018/index.php/action/nouveau.</li>
            </ul>";
    }


    public function makeJVDCreationPage(JVDBuilder $JVDBuilder)
    {
        $data = $JVDBuilder->getData();
        $this->title = "Ajouter un jeu vidéo";
        $this->content = "";
        if ($JVDBuilder->getError())
            $this->content .= "<div class='ui compact red message'><p>" . $JVDBuilder->getError() . "</p></div>";

        $this->content .= "<div class='ui middle aligned center aligned grid'>
                          <div class='column'>
                            <form class='ui large form' action='" . $this->router->getJVDSaveURL() . "' enctype='multipart/form-data' method='post'>
                              <div class='ui stacked segment'>
                                <div class='field'>
                                    <input type='text' name='" . JVDBuilder::NOM_REF . "' placeholder='Titre' value='" . $data[JVDBuilder::NOM_REF] . "' required/>
                                </div>
                                <div class='field'>
                                    <input type='text' name='" . JVDBuilder::GENRE_REF . "' placeholder='Genre' value='" . $data[JVDBuilder::GENRE_REF] . "' required/>
                                </div>
                                <div class='field'>
                                    <input type='number' name='" . JVDBuilder::ANNEE_SORTIE_REF . "' value='" . $data[JVDBuilder::ANNEE_SORTIE_REF] . "' min='1950' required/>
                                </div>
                                <input type='hidden' name'". $JVDBuilder::PSEUDO_UTILISATEUR ."' value='".$_SESSION['user']->getLogin()."'>
                                <img src='' id='previsualisation' style='max-height: 300px'>
                                <div class='field'>
                                    <label for='file' class='ui icon button'>
                                        <i class='file icon'></i>
                                        Ajouter une vignette</label>
                                    <input type='file' name='" . JVDBuilder::PHOTO_REF . "' id='file' style='display:none'>
                                </div>
                                <button class='ui fluid large teal submit button' type='submit'>Ajouter</button>
                              </div>                               
                            </form>
                          </div>
                        </div>";
    }

    public function displayJVDCreationFailure(array $data)
    {
        $this->router->POSTredirect("action/nouveau", "Impossible d'ajouter ce jeu, données invalides!", 0);
    }

    public function retourAccueil($connexion)
    {
        if($connexion)
            $this->router->POSTredirect("accueil/", "Connexion effectuée", 1);
        else
            $this->router->POSTredirect("accueil/", "Déconnexion effectuée", 1);
    }

    public function makeErreurAjoutJVDPage()
    {
        $this->title = "Erreur ajout JVD ";
        $this->content = "Vérifier les données saisies";
    }


    public function render()
    {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <title><?php echo $this->title; ?></title>
                <meta charset="UTF-8"/>
                <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">
            </head>
            <body>
                <div class="ui menu">
                    <div class="ui container">
                        <?php $this->afficheMenu(); ?>
                    </div>
                </div>
                <div class="ui main text container">
                    <?php if($this->feedback) {
                        $color = ($this->feedback[1]) ? 'green' : 'red';
                        echo "<div class='ui ".$color." message'>".$this->feedback[0]."</div> ";
                    } ?>
                    <h1 class="ui header"><?php echo $this->title; ?></h1>
                    <p><?php echo $this->content; ?></p>

                </div>
            </body>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
            <script>
                function readURL(input) {

                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#previsualisation').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $("#file").change(function() {
                    readURL(this);
                });
            </script>
        </html>
        <?php
    }
}