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
class M_bdArticle extends MY_Model {
    
    private $main_table ='article';
    
     public function __construct() {
        
        parent::__construct();
    } 
    
    public function getById($id){
       return parent::getById($this->main_table, $id);
    }
    
    public function getByNom($nom){
        return parent::findBy($this->main_table, 'nom', $nom);
    }
    
    
}
