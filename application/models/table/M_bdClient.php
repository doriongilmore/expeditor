<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_bdClient
 *
 * @author Administrateur
 */
class M_bdClient {public function __construct() {
        
        parent::__construct();
    } 
    
    public function getById($id){
       $this->db->select('*')
                ->from('client')
                ->where('id_client', $id);
                
        $res = $this->db->get()->result();
        return $res[0];   
    }
    
    public function getByNom($nom){
        $this->db->select('*')
                ->from('client')
                ->where('nom', $nom);
                
        $res = $this->db->get()->result();
        return $res[0];   
    }
}
