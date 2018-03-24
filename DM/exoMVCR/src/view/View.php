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
            "connexion" => array("jvd.php?connexion","Connexion")
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
                <form method=\"post\" action='" . ($_SERVER['PHP_SELF']) . "'>
                    <p>
                        <label for=\"Nom\">Votre Peudo :</label>
                        <input type=\"text\" name=\"Nom\" id=\"Nom\" required/>

                        <label for=\"pass\">Votre mot de passe :</label>
                        <input type=\"password\" name=\"pass\" id=\"pass\" required/>

                        <input type=\"submit\" value=\"connexion\">

                    </p>
                    <a href=\"jvd.php?nvCompte\"> Toujours pas de compte? </a>
                </form>";
    }

    public function makeCreateAccountFormPage()
    {
        $this->title = " Créer un nouveau Compte";
        $this->content =
            "
                <form method=\"post\" action='" . ($_SERVER['PHP_SELF']) . "'>
                    <table>
                    <tr>
                    <td>
                        <label for=\"pseudoCmp\">Votre nom de compte:</label>
                        <input type=\"text\" name=\"pseudoCmp\" id=\"pseudoCmp\" required/><br>
                    </td>
                    <td>
                        <label for=\"passCmp\">Votre mot de passe :</label>
                        <input type=\"password\" name=\"passCmp\" id=\"passCmp\" required/><br>
                    </td>
                    <td>
                        <label for=\"nomCmp\">Votre nom (visible par les autres utilisateurs) :</label>
                        <input type=\"text\" name=\"nomCmp\" id=\"nomCmp\" required/><br>
                    </td>

                    <td>
                        <input type=\"submit\" value=\"Créer votre compte\">
                    </td>
                    </tr>
                    </table>
                </form>";

    }

    public function makeDeconnexionPage()
    {
        $this->title = " Deconexion";
        $this->content = "
                <p>Vous êtes connecté en tant que " . $_SESSION['user']->getNom() . ", vous êtes sur le point de vous déconnecter</p>
                <form method='post' action='" . ($_SERVER['PHP_SELF']) . "'>
                        <input type='submit' value='déconnexion' name='deconnexion'>
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
            <link rel="stylesheet" type="text/css" href="skin/semantic.min.css">
        </head>
        <body>
            <div class="ui menu">
                <div class="ui container">
                    <?php $this->afficheMenu(); ?>
                </div>
            </div>
            <div class="ui text container">
                <h6 class="feedback"><?php echo $this->feedback ?></h6>
                <main>
                    <h1><?php echo $this->title; ?></h1>
                    <?php
                    echo $this->content;
                    ?>
                </main>
            </div>
        </body>
        <script
                src="https://code.jquery.com/jquery-3.1.1.min.js"
                integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
                crossorigin="anonymous"></script>
        <script src="skin/semantic.min.js"></script>
        </html>

        <?php


    }


}

?>



