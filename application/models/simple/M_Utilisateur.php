<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Utilisateur
 *
 * @author Administrateur
 */
class M_Utilisateur extends MY_Model{
    //put your code here
    
    public $id_utilisateur = null;
    public $id_profil = null;
    public $nom = null;
    public $prenom = null;
    public $login = null;
    public $password = null;
    
    
    public function __construct() {
        parent::__construct();
         $this->load->model('table/M_bdUtilisateur');
    }
    
     public function get($key) {
        if (array_key_exists($key, get_object_vars($this))) 
            return parent::get($key);
         switch ($key) {
            case 'profil':
               $id = $this->get('id_profil');
                $this->load->model('simple/M_Profil');
                $cli = $this->M_Profil->getById($id);
             
            default:
            break;
                    
         }
     }
     
     
       public function getById($id){
           
        $res = $this->M_bdUtilisateur->getById($id);
        if ($res === null) return null;
        
       return  $this->initialisation($res);
    }
    
    
    
}
