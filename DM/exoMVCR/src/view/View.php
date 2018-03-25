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
            "accueil" => array("jvd.php","Accueil"),
            "nouveau" => array("jvd.php?action=nouveau","Ajouter un JVD"),
            "liste" => array("jvd.php?liste","Liste")
        );
        $this->menuRight = array(
            "connexion" => array("jvd.php?connexion","Connexion"),
            "inscription" => array("jvd.php?nvCompte","Inscription")
        );
        $this->feedback = $feedback;
    }

    public function afficheMenu()
    {
        foreach ($this->menuLeft as $key => $lien) {
            echo "<a href='".$lien[0]."' class='item'>".$lien[1]."</a>";
        }
        echo "<div class='right menu'>";
        foreach ($this->menuRight as $key => $lien) {
            echo "<a href='".$lien[0]."' class='item'>".$lien[1]."</a>";
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
        $this->content = $JVD->getNom() . " est sortie en " . $JVD->getAnneeSortie() . ", c'est un JVD du genre " . $JVD->getGenre();
    }

    public function makeUnknownJVDPage()
    {
        $this->title = "JVD inconnu";

    }

    public function pageAccueil()
    {
        $this->title = "Accueil";
        $this->content = "Contenu de l'accueil";

    }

    public function makeListPage(array $tabJVD)
    {
        $this->title = 'JVD disponibles à la consultation';
        foreach ($tabJVD as $key => $JVD) {
            $nomJVD = $JVD->getNom();
            $idJVD = $JVD->getId();
            $this->content .= "<a href='" . $this->router->getJVDURL($idJVD) . "'><h5>" . $nomJVD . "</h5></a>";
        }

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

    public function displayJVDCreationSuccess($id)
    {
        $this->router->POSTredirect("jvd.php?id=" . $id, "JVD ajouté!");
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
                      Nouveau ? <a href='jvd.php?nvCompte'>S'inscrire</a>
                    </div>
                  </div>
                </div>";
    }

    public function makeCreateAccountFormPage()
    {
        $this->title = " Inscription";
        $this->content =
            "
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
                      Déja inscrit ? <a href='jvd.php?connexion'>Se connecter</a>
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

    public function makeJVDCreationPage(JVDBuilder $JVDBuilder)
    {
        $data = $JVDBuilder->getData();

        $this->title = "Ajouter un JVD";
        if (key_exists(JVDBuilder::NOM_REF, $data) && key_exists(JVDBuilder::GENRE_REF, $data) && key_exists(JVDBuilder::ANNEE_SORTIE_REF, $data)) {
            $this->content = "<p> erreur :" . $JVDBuilder->getError() . "</p>
        <form action='" . $this->router->getJVDSaveURL() . "'enctype=\"multipart/form-data\" method='post'>
            <input type='text' name='" . JVDBuilder::NOM_REF . "' id='" . JVDBuilder::NOM_REF . "' value='" . $data[JVDBuilder::NOM_REF] . "' /> <label for='nom'>" . JVDBuilder::NOM_REF . " JVD</label><br />
            <input type='text' name='" . JVDBuilder::GENRE_REF . "' id='" . JVDBuilder::GENRE_REF . "' value='" . $data[JVDBuilder::GENRE_REF] . "'/> <label for='nom'>" . JVDBuilder::GENRE_REF . " JVD</label><br />
            <input type='number' name='" . JVDBuilder::ANNEE_SORTIE_REF . "' id='" . JVDBuilder::ANNEE_SORTIE_REF . "' value='" . $data[JVDBuilder::ANNEE_SORTIE_REF] . "'/> <label for='age'>" . JVDBuilder::ANNEE_SORTIE_REF . " JVD</label><br />

            <button type='submit'>Ajouter</button>
        </form>";

        }
    }

    public function displayJVDCreationFailure()
    {
        $this->router->POSTredirect("jvd.php?action=nouveau", "Impossible d'ajouter cet JVD, données invalides!");
    }

    public function retourAccueil()
    {
        $this->router->POSTredirect("jvd.php", "Connexion effectué");
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
                    <?php if($this->feedback) { ?>
                        <div class="ui red message">
                            <?php echo $this->feedback ?>
                        </div>
                    <?php } ?>
                    <h1 class="ui header"><?php echo $this->title; ?></h1>
                    <p><?php echo $this->content; ?></p>
                </div>
            </body>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>
        </html>

        <?php


    }


}

?>



