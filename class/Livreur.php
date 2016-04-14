<?php

class Livreur {
    //put your code here
    private $id;
    private $login;
    private $password;
    private $nom;
    private $prenom;

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
    
    public function connect() {
    }

    function __destruct()
    {

    }
}
