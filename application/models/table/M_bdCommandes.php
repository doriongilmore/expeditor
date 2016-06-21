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
    
    public function __construct() {
        
        parent::__construct();
    } 
    
    public function getById($id){
       $this->db->select('*')
                ->from('commande')
                ->where('id_commande', $id);
                
        $res = $this->db->get()->result();
        return $res[0];   
    }
    
     public function getByNum($num){
       $this->db->select('*')
                ->from('commande')
                ->where('num_commande', $id);
                
        $res = $this->db->get()->result();
        return $res[0];   
    }
    
 /*   public function getByClient($client){
        $this->db->select('*')
                ->from('commande')
                ->where('id_client', $client);
                
        $res = $this->db->get()->result();
        return $res[0];   
    }*/
}
