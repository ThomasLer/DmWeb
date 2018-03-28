<?php

class JVD
{
    private $id;
    private $nom;
    private $genre;
    private $annee_sortie;
    private $photo;
    private $pseudo_utilisateur;

    /**
     * Animal constructor.
     * @param $nom
     * @param $genre
     * @param $annee_sortie
     */
    public function __construct($id, $nom, $genre, $annee_sortie, $photo=null, $pseudo_utilisateur)
    {
        $this->id=$id;
        $this->nom = $nom;
        $this->genre = $genre;
        $this->annee_sortie = $annee_sortie;
        $this->photo = $photo;
        $this->pseudo_utilisateur = $pseudo_utilisateur;
    }

    /**
 * @return mixed
 */
    public function getId()
    {
        return $this->id;
    }

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

    public function getPseudoUtilisateur()
    {
        return $this->pseudo_utilisateur;
    }





}