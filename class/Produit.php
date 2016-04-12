<?php

class Produit {
    //put your code here
    private $id;
    private $reference;
    private $quantite;
    private $statut;
    private $commentaire;

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

    public function setReference($value)
    {
        $this->reference = $value;
    }

    public function getReference()
    {
        return $this->reference;
    }
    
    public function setQuantite($value)
    {
        $this->quantite = $value;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }
    
    public function setStatut($value)
    {
        $this->statut = $value;
    }

    public function getStatut()
    {
        return $this->statut;
    }
    
    public function setCommentaire($value)
    {
        $this->commentaire = $value;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }
    

    function __destruct()
    {

    }
}
