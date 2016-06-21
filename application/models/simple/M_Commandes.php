<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_commandes
 *
 * @author Administrateur
 */
class M_Commandes extends MY_Model{
    //put your code here
    
    public $id_commande = null;
    public $id_client = null;
    public $num_commande = null;
    public $date = null;
    public $etat = null;    
      
    public function __construct() {
        parent::__construct();
    }
    
}
