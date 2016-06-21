<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_commandes
 *
 * @author Administrateur
 */
class M_Commandes extends MY_Model{
    //put your code here
    
    public $id_commande = null;
    public $id_client = null;
    public $num_commande = null;
    public $date_demande = null;
    public $date_traitement = null;
    public $id_etat = null;    
    public $etat = null;    
    public $id_utilisateur_traite = null;    
      
    public function __construct() {
        parent::__construct();
         $this->load->model('table/M_bdCommandes');
    }

//    public function initialisation($tabInfo) {
//        return parent::initialisation($tabInfo);
//    }
    
    
    public function get($key) {
        if (array_key_exists($key, get_object_vars($this))) 
            return parent::get($key);
        switch ($key) {
            case 'client':
                $id = $this->get('id_client');
                $this->load->model('simple/M_Client');
                $cli = $this->M_Client->getById($id);
                return $cli;
            case 'lignes_commande':
                $this->load->model('simple/M_Lignes_Commandes');
                
                break;
            default:
                break;
        }
    }
    
    public function getFirstCommande(){
        $req = $this->M_bdCommandes->getFirstCommande();
        return $this->initialisation($req);
    }
}
