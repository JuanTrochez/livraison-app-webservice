<?php

class Client {
    //put your code here
    private $id;
    private $nom;
    private $prenom;
    private $telephone;
    private $email;

    function __construct()
    {

    }
    
    public function setId($value)
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setLogin($value)
    {
        $this->login = $value;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setPassword($value)
    {
        $this->password = $value;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setNom($value)
    {
        $this->nom = $value;
    }

    public function getNom()
    {
        return $this->nom;
    }
    
    public function setPrenom($value)
    {
        $this->prenom = $value;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }
    
    public function setTelephone($value)
    {
        $this->telephone = $value;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }
    
    public function setEmail($value)
    {
        $this->email = $value;
    }

    public function getEmail()
    {
        return $this->email;
    }
    
    public static function getClientByLivraison($bdd, $livraisonId) {
        
        $query = $bdd->prepare("SELECT * "
                . "FROM client "
                . "WHERE livraison_id = :livraison_id "
                . "LIMIT 1");
        
        $query->execute(array(
            ":livraison_id"   => $livraisonId
        ));
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
        
    }
    
    public static function getClientById($bdd, $id) {
        
        $query = $bdd->prepare("SELECT * "
                . "FROM client "
                . "WHERE id = :id "
                . "LIMIT 1");
        
        $query->execute(array(
            ":id"   => $id
        ));
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
//        var_dump($result);exit;
        
        return $result;
        
    }
    

    function __destruct()
    {

    }
}
