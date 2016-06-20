<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_bdArticle
 *
 * @author Administrateur
 */
class M_bdArticle {
    
     public function __construct() {
        
        parent::__construct();
    } 
    
    public function getById($id){
       $this->db->select('*')
                ->from('article')
                ->where('id_article', $id);
                
        $res = $this->db->get()->result();
        return $res[0];   
    }
    
    public function getByNom($nom){
        $this->db->select('*')
                ->from('article')
                ->where('nom', $nom);
                
        $res = $this->db->get()->result();
        return $res[0];   
    }
    
    
}
