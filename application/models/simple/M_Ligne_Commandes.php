<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Ligne_Commandes
 *
 * @author Administrateur
 */
class M_Ligne_Commandes  extends MY_Model{
    //put your code here
    
    public $id_ligne_commande = null;
    public $id_commande = null;
    public $id_article = null;
    public $quantite_demande = null;
    public $quantite_reelle = null;    
      
    public function __construct() {
        parent::__construct();
        $this->load->model('table/M_bdLigneCommandes');
    }
    
    
     public function get($key) {
        if (array_key_exists($key, get_object_vars($this))) 
            return parent::get($key);
        switch ($key) {
            case 'commande':
                $id = $this->get('id_commande');
                $this->load->model('simple/M_Commandes');
                $commande = $this->M_Commandes->getById($id);
                return $commande;
            case 'article':
                $id = $this->get('id_article');
                $this->load->model('simple/M_Article');
                $article = $this->M_Article->getById($id);
                return $article;
            default:
                break;
        }
     }
     
    public function getAll(){
        return $this->M_bdLigneCommandes->getAll();
    }
    
    public function getByIdCommande($id) {
        return $this->array_initialisation($this->M_bdLigneCommandes->getByCommandes($id));
        
    }
}
