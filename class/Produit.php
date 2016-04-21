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
    
    public static function getProduitByLivraison($bdd, $livraisonId) {
        
        $query = $bdd->prepare("SELECT * "
                . "FROM produit "
                . "WHERE livraison_id = :livraison_id ");
        
        $query->execute(array(
            ":livraison_id"   => $livraisonId
        ));
        
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
        
    }
    
    public function updateProduitById($bdd, $id, $commentaire, $statut) {
        $query = $bdd->prepare("UPDATE produit "
                . "SET commentaire = :commentaire, "
                . "statut = :statut"
                . "WHERE livraison_id = :livraison_id ");
        
        $query->execute(array(
            ":commentaire" => $commentaire,
            ":statut" => $statut,
            ":livraison_id"   => $livraisonId
        ));
        
        return $result;
        
    }
    
    public function getProduitById($bdd, $id) {
        
        $query = $bdd->prepare("SELECT * "
                . "FROM produit "
                . "WHERE id = :id ");
        
        $query->execute(array(
            ":id"   => $id
        ));
        
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
        
    } 

    function __destruct()
    {

    }
}
