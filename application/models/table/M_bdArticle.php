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
    
    public function getAll(){
       return parent::getAll($this->main_table);
    }
    
    public function getByNom($nom){
        return parent::findBy($this->main_table, 'nom', $nom);
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
    
}
