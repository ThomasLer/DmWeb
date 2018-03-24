<?php




/*
 * Une classe qui permet la persistance de données en utilisant
 * un fichier. Plus facile que d'utiliser une vraie base de données,
 * si l'application est simple et si le nombre de personnes
 * connectées en même temps est raisonnable (sinon la manipulation
 * des données ralentit, puisqu'il faut que chacun·e attende
 * son tour).
 *
 * Pour minimiser le temps d'attente, il faut faire le moins
 * de choses possibles entre un appel à loadData() et l'appel
 * à saveData() suivant (car entre les deux, le fichier est verrouillé).
 */
class FileStore {


    /* le nom du fichier dans lequel les données sont sérialisées */
    private $file;
    /* le pointeur de fichier (null si le fichier n'est pas ouvert) */
    private $fp;

    /* Construit une nouvelle instance, qui utilise le fichier donné
     * en paramètre. */
    public function __construct($file) {
        $this->file = $file;
        $this->fp = null;
    }

    public function lockFile() {
        if ($this->fp !== null) {
            /* le fichier est déjà ouvert (et donc verrouillé) */
            return;
        }
        /* ouverture du fichier */
        $this->fp = fopen($this->file, 'a');
        /* verrouillage du fichier */
        if (flock($this->fp, LOCK_EX)) {
            /* on lit le contenu */
            $content = file_get_contents($this->file);
            /* on désérialise le contenu,
             * pour récupérer ce qui y a été stocké  */
            $data = unserialize(base64_decode($content));
            return $data;
        } else {
            throw new Exception('Impossible de verrouiller le fichier "'
                . $this->file . '"');
        }
    }
    public function unlockFile() {
        if ($this->fp === null) {
            /* le fichier n'est pas ouvert, on n'a rien à faire */
            return;
        }
        /* on libère le verrou et on ferme le fichier */
        flock($this->fp, LOCK_UN);
        fclose($this->fp);
        $this->fp = null;
    }

    /*
      * Renvoie les données stockées dans le fichier,
      * et verrouille le fichier (si ce n'est pas déjà fait).
      */
    public function loadData() {
        /* Ouverture et verrouillage du fichier */
        $this->lockFile();
        /* on lit le contenu */
        $content = file_get_contents($this->file);

        /* on désérialise le contenu,
         * pour récupérer ce qui y a été stocké  */
        $data = unserialize(base64_decode($content));
        return $data;
    }

    /*
      * Écrit les données dans le fichier, et libère le verrou.
      */
    public function saveData($data) {
        /* on verrouille le fichier si besoin */
        $this->lockFile();
        if ($data !== null) {
            /* on sérialise le tableau */
            $content = base64_encode(serialize($data));
            /* on remet le curseur au début */
            ftruncate($this->fp, 0);
            /* on écrit le tableau sérialisé */
            fwrite($this->fp, $content);
        }
        /* on libère le verrou et on ferme le fichier */
        $this->unlockFile();
    }

    /*
     * Lors de la destruction de cette instance, on libère le verrou,
     * au cas où ça n'a pas été fait.
     */
    public function __destruct() {
        $this->unlockFile();
    }
}

?>