<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Profil
 *
 * @author Administrateur
 */
class M_Profil extends MY_Model{
    //put your code here
    
    public $id_profil = null;
    public $libelle = null;
   
    
    public function __construct() {
        parent::__construct();
         $this->load->model('table/M_bdProfil');
    }
    
     public function get($key) {
        if (array_key_exists($key, get_object_vars($this))) 
            return parent::get($key);
     }
     
     
       public function getById($id){
        $res = $this->M_bdProfil->getById($id);
        if ($res === null) return null;
        
       return  $this->initialisation($res);
    }
    
     public function getAll(){
         return $this->M_bdProfil->getAll();
        
    }
    
    
}