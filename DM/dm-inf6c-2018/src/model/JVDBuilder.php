<?php

/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 31/01/2018
 * Time: 11:55
 */
class JVDBuilder
{
    private $data;
    private $error;
    const NOM_REF="nom";
    const GENRE_REF ="genre";
    const ANNEE_SORTIE_REF="annee_sortie";
    const PHOTO_REF="photo";
    const PSEUDO_UTILISATEUR="pseudo_utilisateur";

    /**
     * AnimalBuilder constructor.
     * @param $data
     * @param $error
     */

    public function __construct($data=null)
    {
        if ($data==null){
            $this->data = array(self::NOM_REF=>"",self::GENRE_REF=>"",self::ANNEE_SORTIE_REF=>0,self::PHOTO_REF=>null,self::PSEUDO_UTILISATEUR=>null);
        }
        else{
            $this->data=$data;
        }
        $this->error = null;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return null
     */
    public function getError()
    {
        return $this->error;
    }

    public function createJVD(){

        if (key_exists(self::NOM_REF, $this->data) && key_exists(self::GENRE_REF, $this->data) && key_exists(self::ANNEE_SORTIE_REF, $this->data) && (key_exists(self::PHOTO_REF, $this->data)) && (key_exists(self::PSEUDO_UTILISATEUR, $this->data))) {
            if($this->isValid()){
                $nvJVD = new JVD(null,$this->data[self::NOM_REF], $this->data[self::GENRE_REF], $this->data[self::ANNEE_SORTIE_REF],$this->data[self::PHOTO_REF],$this->data[self::PSEUDO_UTILISATEUR]);
                return $nvJVD;
            }
            else{
                return null;

            }
        }
    }

    public function isValid(){
        if (empty($this->data[$this::NOM_REF]) or empty($this->data[$this::GENRE_REF]) or $this->data[$this::ANNEE_SORTIE_REF] < 1950) {
            $error = "";
            if (empty($this->data[$this::NOM_REF]))
                $error .= "Nom manquant !";
            if (empty($this->data[$this::GENRE_REF]))
                $error .= "Genre manquant !";
            if (isset($this->data[$this::ANNEE_SORTIE_REF]) and $this->data[$this::ANNEE_SORTIE_REF] < 1950)
                $error .= "L'année de sortie ne peut pas être inférieur a < 1950 !";
            $this->error = $error;
            return false;
        }
        return true;
    }
}