<?php

class JVD
{
    private $id;
    private $nom;
    private $genre;
    private $annee_sortie;
    private $photo;

    /**
     * Animal constructor.
     * @param $nom
     * @param $genre
     * @param $annee_sortie
     */
    public function __construct($id, $nom, $genre, $annee_sortie,$photo=null)
    {
        $this->id=$id;
        $this->nom = $nom;
        $this->genre = $genre;
        $this->annee_sortie = $annee_sortie;
        $this->photo=$photo;
    }

    /**
 * @return mixed
 */
    public function getId()
    {
        return $this->id;
    }

//coucou

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @return mixed
     */
    public function getAnneeSortie()
    {
        return $this->annee_sortie;
    }

    /**
     * @return null
     */
    public function getPhoto()
    {
        return $this->photo;
    }




}