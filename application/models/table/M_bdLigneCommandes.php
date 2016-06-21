<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_bdLigneCommandes
 *
 * @author Administrateur
 */
class M_bdLigneCommandes extends MY_Model{
   
    private $main_table = "ligne_commande";
    
    public function getById($id){
      return parent::getById($this->main_table, $id);
    }
    
    public function getByCommandes($id){
      return parent::findBy($this->main_table,'id_commande', $id);
    }
    
    public function __construct() {
        parent::__construct();
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
