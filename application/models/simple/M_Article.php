<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_Article
 *
 * @author Administrateur
 */
class M_Article extends MY_Model{
    //put your code here
    
    public $id_article = null;
    public $nom = null;
    public $quantite_stock = null;
    public $poids = null;
    public $prix = null;
    
      
    public function __construct() {
        parent::__construct();
    }
    
}