<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Client
 *
 * @author Administrateur
 */
class M_Client extends MY_Model{
    //put your code here
    
    public $id_client = null;
    public $nom = null;
    public $prenom = null;
    public $adresse_1 = null;
    public $adresse_2 = null;
    public $code_postal = null;
    public $ville = null;
    public $telephone = null;
    public $mail = null;
    
      
    public function __construct() {
        parent::__construct();
         $this->load->model('table/M_bdClient');
    }

    public function initialisation($tabInfo) {
        return parent::initialisation($tabInfo);
    }
    
      public function get($key) {
        if (array_key_exists($key, get_object_vars($this))) 
            return parent::get($key);
      }
    
    public function getById($id){
       return $this->initialisation($this->M_bdClient->getById($id));
    }
    
}
