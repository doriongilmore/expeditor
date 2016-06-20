<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_bdUtilisateur
 *
 * @author Administrateur
 */
class M_bdUtilisateur extends CI_Model{
    //put your code here
    
    public function __construct() {
        
        parent::__construct();
    }
    
    public function getById($id){
       $this->db->select('*')
                ->from('utilisateur')
                ->where('id_utilisateur', $id);
                
        $res = $this->db->get()->result();
        return $res[0];   
    }
    
    public function getByLoginPassword($login,$password){
        $this->db->select('*')
                ->from('utilisateur')
                ->where('login', $login)
                ->where('password', $password);
                
        $res = $this->db->get()->result();
        return $res[0];   
    }
    
    
    
    
    
}
