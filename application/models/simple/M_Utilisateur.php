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
class M_Utilisateur extends CI_Model{
    //put your code here
    
    public $id_utilisateur = null;
    public $profil = null;
    public $nom = null;
    public $prenom = null;
    public $login = null;
    public $password = null;
    
    
    public function __construct() {
        parent::__construct();
    }
    
    
    
}
