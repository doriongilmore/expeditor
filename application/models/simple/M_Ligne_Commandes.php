<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Ligne_Commandes
 *
 * @author Administrateur
 */
class M_Ligne_Commandes  extends MY_Model{
    //put your code here
    
    public $id_ligne_commande = null;
    public $id_commande = null;
    public $id_article = null;
    public $quantite_demande = null;
    public $quantite_reelle = null;    
      
    public function __construct() {
        parent::__construct();
    }
    
}
