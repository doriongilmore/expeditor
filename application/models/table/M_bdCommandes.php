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
                ->where('date_demande = (SELECT MIN(date_demande) FROM (`commande`))')
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
