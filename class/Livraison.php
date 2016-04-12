<?php

class Livraison {
    //put your code here
    private $id;
    private $adresse;
    private $numero;
    private $codePostal;
    private $ville;
    private $latitude;
    private $longitude;
    private $date;

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

    public function setAdresse($value)
    {
        $this->adresse = $value;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }
    
    public function setNumero($value)
    {
        $this->numero = $value;
    }

    public function getNumero()
    {
        return $this->numero;
    }
    
    public function setCodePostal($value)
    {
        $this->codePostal = $value;
    }

    public function getCodePostal()
    {
        return $this->codePostal;
    }
    
    public function setVille($value)
    {
        $this->ville = $value;
    }

    public function getVille()
    {
        return $this->ville;
    }
    
    public function setLatitude($value)
    {
        $this->latitude = $value;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }
    
    public function setLongitude($value)
    {
        $this->longitude = $value;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }
    
    public function setDate($value)
    {
        $this->date = $value;
    }

    public function getDate()
    {
        return $this->date;
    }
    
    public function getDailyLivraisonByLivreur($bdd, $idLivreur) {
        $query = $bdd->prepare("SELECT * FROM livraison "
                . "WHERE livreur_id = :livreur_id "
                . "AND DATE(date)=CURDATE()");
        $query->execute(array(
            ":livreur_id"   => $idLivreur
        ));
        
        $result = $query->fetchAll();
        
        return $result;
    }

    function __destruct()
    {

    }
}
