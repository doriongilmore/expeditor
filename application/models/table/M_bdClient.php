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
class M_bdClient extends MY_Model {
    
    private $main_table = "client";
    
    public function __construct() {
        
        parent::__construct();
    } 
    
    public function getById($id){
       $res = parent::getById($this->main_table, $id);
       return $res;
    }
    
    public function getByNom($nom){
         return parent::findBy($this->main_table, 'nom', $nom); 
    }
    
    
    public function getByNomAdresse($nom,$adr){
        $this->db->select('*')
                ->from($this->main_table)
                ->where('nom', $nom)
                ->where('CONCAT(adresse_1, " - ", code_postal, " ", ville)', $adr);
//                ->where('adresse_1', $adr);
        return $this->db->get()->result();
    }
    
      public function getAll(){
       return parent::getAll($this->main_table);
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
