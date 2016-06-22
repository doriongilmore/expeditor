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
                return $this->M_Profil->getById($id);
            default:
            break;
         }
     }
     
    public function getById($id){
           
        $res = $this->M_bdUtilisateur->getById($id);
        if ($res === null) return null;
        $u = $this->initialisation($res);
       return  $u;
    }
    
     public function getAll(){
         return $this->array_initialisation($this->M_bdUtilisateur->getAll());
    }
    
    public function getAllEmploye(){
         return $this->array_initialisation($this->M_bdUtilisateur->getAllEmploye());
    }
    
    public function getAllStatCommande(){
         return $this->M_bdUtilisateur->getAllStatCommande();
    }
            
    public function getByLoginPassword($login,$password){
        $res = $this->M_bdUtilisateur->getByLoginPassword($login,$password);
        return $this->initialisation($res);
    }
    
    public function checkProfil($id_profil) {
        if ($this->get('id_profil') == $id_profil)
            return true;
        return false;
    }
}
