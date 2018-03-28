<?php

/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 05/03/2018
 * Time: 14:46
 */
class AccountStorageMySQL implements AccountStorage
{

    public $connection;

    public function __construct($connection){
        $this->connection=$connection;
    }

    function checkAuth($pseudo, $mdp)
    {

        $req = $this->connection->prepare("SELECT * FROM comptes WHERE pseudo=:pseudo ");
        $req->execute(array(':pseudo' => $pseudo));

        $result = $req->fetch();
        if($result){

            if(password_verify($mdp,$result['mdp'])){
                $_SESSION['user']= new Account($result['nom'],$result['pseudo'],$result['mdp'],$result['role']);
                return 1;
            }
            else{
                return 0;
            }
        }
        else{
            return -1;
        }
    }

    function isValidAccount($compte){
        $req = $this->connection->prepare("SELECT * FROM comptes WHERE pseudo=:pseudo ");
        $req->execute(array(':pseudo' => $compte->getLogin()));

        if($result = $req->fetch()){
            return false;
        }else{
            return true;
        }

    }

    function ajoutCompte($compte){
        $req = $this->connection->prepare("INSERT INTO comptes (nom,pseudo,mdp,role) VALUES (:nom,:pseudo,:mdp,:role)");
        $req->execute(array(
            "nom"=>$compte->getNom(),
            "pseudo"=>$compte->getLogin(),
            "mdp"=>password_hash($compte->getPassword(),PASSWORD_DEFAULT),
            "role"=>$compte->getStatut()
        ));
    }
}