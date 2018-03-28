<?php

/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 31/01/2018
 * Time: 21:38
 */
class JVDStorageMySQL implements JVDStorage
{
//coucou

    private $connection;

    public function __construct($connection)
    {
        $this->connection=$connection;
    }

    public function read($id)
    {
        $req = $this->connection->prepare("SELECT * FROM jvd WHERE id=:id");
        $req->execute(array(':id' => $id));

        $result = $req->fetch();

        return new JVD($result['id'],$result['nom'],$result['genre'],$result['annee_sortie'],$result['photo']);
    }

    public function readAll()
    {
        $req = $this->connection->prepare("SELECT * FROM jvd");
        $req->execute();

        $result = $req->fetchAll();
        $tabJvd=array();
        foreach($result as $jvd){
            $nvJvd= new JVD($jvd['id'],$jvd['nom'],$jvd['genre'],$jvd['annee_sortie'],$jvd['photo']);
            array_push($tabJvd,$nvJvd);
        }

        return $tabJvd;
    }

    public function create(JVD $a)
    {

        $req = $this->connection->prepare("INSERT INTO jvd (nom,genre,annee_sortie,photo) VALUES (:nom,:genre,:annee_sortie,:photo)");
        $req->execute(array(
            "nom"=>$a->getNom(),
            "genre"=>$a->getGenre(),
            "annee_sortie"=>$a->getAnneeSortie(),
            "photo"=>$a->getPhoto()
        ));

        $rep=$this->connection->prepare("Select MAX(id) as id FROM jvd");
        $rep->execute();
        $resultRep=$rep->fetch();
        return $resultRep['id'];
    }

    public function delete($id){
        $req = $this->connection->prepare("DELETE FROM jvd WHERE id=:id");
        $req->execute(array(
            "id"=>$id
        ));
    }

    public function modification(JVD $a,$id){
        $req = $this->connection->prepare("UPDATE jvd SET nom=:nom,genre=:genre,annee_sortie=:annee_sortie,photo=:photo WHERE id=:id");
        $req->execute(array(
            "nom"=>$a->getNom(),
            "genre"=>$a->getGenre(),
            "annee_sortie"=>$a->getAnneeSortie(),
            "photo"=>$a->getPhoto(),
            "id"=>$id
        ));

    }
}