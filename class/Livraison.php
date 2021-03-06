<?php
//include_once 'Client.php';
//include_once 'Produit.php';

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
                . "AND DATE(date) = CURDATE() "
                . "AND statut = 0 "
                . "ORDER BY id ASC");
        
        $query->execute(array(
            ":livreur_id"   => $idLivreur
        ));
        
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    public function getLastDaysLivraisonByLivreur($bdd, $idLivreur) {
        $query = $bdd->prepare("SELECT * FROM livraison "
                . "WHERE livreur_id = :livreur_id "
                . "AND DATE(date) < CURDATE() "
                . "AND statut = 0 "
                . "ORDER BY id ASC");
        
        $query->execute(array(
            ":livreur_id"   => $idLivreur
        ));
        
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    public static function getDetailLivraison($bdd, $livraisonId) {
        $result = array();
        
        $result['client'] = Client::getClientById($bdd, $livraisonId);
        $result['produits'] = Produit::getProduitByLivraison($bdd, $livraisonId);
        
        return $result;
    }
    
    public function getLivraisonById($bdd, $id) {
        
        $query = $bdd->prepare("SELECT * "
                . "FROM livraison "
                . "WHERE id = :id ");
        
        $query->execute(array(
            ":id"   => $id
        ));
        
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;        
    } 
    
    public function updateLivraisonStatutById($bdd, $id, $statut) {
        $query = $bdd->prepare("UPDATE livraison "
                . "SET statut = :statut "
                . "WHERE id = :livraison_id ");
        
        $query->execute(array(
            ":livraison_id"   => $id,
            ":statut" => $statut
        ));
        
        return $result;
    }

    function __destruct()
    {

    }
}
