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
    public $id_utilisateur_traite = null;    
      
    public function __construct() {
        parent::__construct();
         $this->load->model('table/M_bdCommandes');
    }

//    public function initialisation($tabInfo) {
//        return parent::initialisation($tabInfo);
//    }
    
    public function getById($id) {
        return $this->initialisation($this->M_bdCommandes->getById($id));
    }
    
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
                $this->load->model('simple/M_Ligne_Commandes');
                $l = $this->M_Ligne_Commandes->getByIdCommande($this->get('id_commande'));
                return $l;
            case 'utilisateur':
                $id = $this->get('id_utilisateur_traite');
                
                if($id === null){
                    $user = null;
                }else{
                    $this->load->model('simple/M_Utilisateur');
                    $user = $this->M_Utilisateur->getById($id);
                }
                return $user;
            case 'etat':
                $id = $this->get('id_etat');
                $etat = '';
                switch ($id) {
                    case ETAT_ATTENTE:
                        $etat = 'En attente';
                        break;
                    case ETAT_EN_COURS:
                        $etat = 'En cours';
                        break;
                    case ETAT_TERMINE:
                        $etat = 'Terminée';
                        break;
                    case ETAT_URGENT:
                        $etat = 'Urgente';
                        break;
                    default:
                        break;
                }
                return $etat;
                
            default:
                break;
        }
    }
    
    public function getCommandeATraiter(){
        // Commande en cours de traitement par le même utilisateur
        $commande = $this->getCommandeEnCoursByIdEmploye();
        if (is_null($commande)) {
            // Commande urgente
            $commande = $this->getCommandeUrgente();
            if (is_null($commande)){
                // Première commande de la liste
                $commande = $this->getFirstCommande();
            }
        }
        if (!is_null($commande)) {
            if ($commande->get('id_etat') != ETAT_URGENT){
                $commande->set('id_etat', ETAT_EN_COURS);
            }
            $commande->set('date_traitement', date(FORMAT_DATE_TRAITEMENT));
            $commande->set('id_utilisateur_traite', $_SESSION['user_id']);
            $this->update($commande);
        }
        return $commande;
    }
    
    public function getCommandeEnCoursByIdEmploye(){
        $req = $this->M_bdCommandes->getCommandeEnCoursByIdEmploye();
        return $this->initialisation($req);
    }
    
    public function getCommandeUrgente(){
        $req = $this->M_bdCommandes->getCommandeUrgente();
        return $this->initialisation($req);
    }
    
    public function getFirstCommande(){
        $req = $this->M_bdCommandes->getFirstCommande();
        return $this->initialisation($req);
    }
    
     public function setUrgent($id_commande){
        $com = $this->getById($id_commande);
         $com->id_etat = ETAT_URGENT;
        $com->etat = "Urgent";
        $this->update($com);
    }
    
    public function liberer($id_commande){
        $com = $this->getById($id_commande);
        $com->id_etat = ETAT_ATTENTE;
        $com->id_utilisateur_traite = null;
        $res =  $this->update($com);
        $com->etat = "En attente";
        return $res;
        
    }

     public function getAll(){
         return $this->array_initialisation($this->M_bdCommandes->getAll());
        
    }
    
     public function getAllNonTraitee(){
         return $this->array_initialisation($this->M_bdCommandes->getAllNonTraitee());
    }
    
    public function getNbCommandeByUtilisateur($id_utilisateur){
        return $this->M_bdCommandes->getNbCommandeByUtilisateur($id_utilisateur);
        
    }
    
    public function update($data) {
        return $this->M_bdCommandes->update($data);
    }
}
