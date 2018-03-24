<?php

/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 21/02/2018
 * Time: 15:54
 */
class Account
{
private $nom;
private $login;
private $password;
private $statut;

    /**
     * Account constructor.
     * @param $nom
     * @param $login
     * @param $password
     * @param $statut
     */
    public function __construct($nom, $login, $password, $statut=null)
    {
        $this->nom = $nom;
        $this->login = $login;
        $this->password = $password;
        $this->statut = $statut;
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
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }



}