<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_bdCommandes
 *
 * @author Administrateur
 */
class M_bdCommandes extends MY_Model{
    
    private $main_table = "commande";
    
    public function __construct() {
        
        parent::__construct();
    } 
    
    public function getById($id){
     return parent::getById($this->main_table, $id);
    }
    
    public function getAll(){
       return parent::getAll($this->main_table);
    }
    
    public function getAllNonTraitee(){
       $this->db->select('*')
                 ->from($this->main_table)
                 ->where('id_etat != ',ETAT_TERMINE);
        $res = $this->db->get()->result();
        if(empty($res))
            return null;
        return $res;
    }
    
    public function getNbCommandeByUtilisateur($id_utilisateur){
           $this->db->select('count(*) nb')
                 ->from($this->main_table)
                 ->where('DAY(date_traitement)',12)
                 ->where('id_utilisateur_traite', $id_utilisateur);
        $res = $this->db->get()->result();
        if(empty($res))
            return null;
        return $res[0]->nb;
          
    
        
        
    }
    
    public function getByNum($num){
      return parent::findBy($this->main_table,'num_commande', $num); 
    }
    
  
    
     public function insert($data){
        return parent::insert($this->main_table, $data);
    }
    
    public function delete($id){
         return parent::delete($this->main_table, $id);
    }
      
    public function update($data){
         return parent::update($this->main_table, $data);   
    }
    
    public function getFirstCommande() {
       $this->db->select('*', false)
                ->from('commande')
//                ->where('date_demande = (SELECT MIN(date_demande) FROM (`commande`))')
                ->where('id_etat != ', ETAT_TERMINE)
                ->order_by('date_demande', 'ASC')
               
                ;
                
        $res = $this->db->get()->result();
        if (!empty($res)) {
            return $res[0];   
        }
        return null;
    }
    
    public function getCommandeUrgente() {
       $this->db->select('*', false)
                ->from('commande')
//                ->where('date_demande = (SELECT MIN(date_demande) FROM (`commande`))')
                ->where('id_etat', ETAT_URGENT)
               ->order_by('date_demande', 'ASC')
                ;
                
        $res = $this->db->get()->result();
        if (!empty($res)) {
            return $res[0];   
        }
        return null;
    }
    
    public function getCommandeEnCoursByIdEmploye() {
       $this->db->select('*', false)
                ->from('commande')
//                ->where('date_demande = (SELECT MIN(date_demande) FROM (`commande`))')
                ->where('id_etat != ', ETAT_TERMINE)
                ->where('id_utilisateur_traite', $_SESSION['user_id'])
                ;
                
        $res = $this->db->get()->result();
        if (!empty($res)) {
            return $res[0];   
        }
        return null;
    }
 /*   public function getByClient($client){
        $this->db->select('*')
                ->from('commande')
                ->where('id_client', $client);
                
        $res = $this->db->get()->result();
        return $res[0];   
    }*/
}
