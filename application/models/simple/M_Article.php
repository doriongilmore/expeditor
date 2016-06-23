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
        $this->load->model('table/M_bdArticle');
    }
    
    
    public function get($key) {
        if (array_key_exists($key, get_object_vars($this))) 
            return parent::get($key);
    }
    
    public function getById($id) {
        return $this->initialisation($this->M_bdArticle->getById($id));
    }
    
    public function getByNom($nom) {
        $std = $this->M_bdArticle->getByNom($nom);
        return $this->initialisation($std[0]);
    }
    
    public function getAll(){
         return $this->array_initialisation($this->M_bdArticle->getAll());
        
    }
        
    public function delete($id)
    {
        return $this->M_bdArticle->delete($id);
    }
    
    public function update($id)
    {
        return $this->M_bdArticle->update($id);
    }
    
}
