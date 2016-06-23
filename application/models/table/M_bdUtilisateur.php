<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_bdUtilisateur
 *
 * @author Administrateur
 */
class M_bdUtilisateur extends MY_Model{
    //put your code here
    
      private $main_table = "utilisateur";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getById($id){
      return parent::getById($this->main_table, $id);
    }
    
      public function getAll(){
       return parent::getAll($this->main_table);
    }
    
    public function getByLoginPassword($login,$password){
        $this->db->select('*')
                ->from('utilisateur')
                ->where('login', $login)
                ->where('password', $password);
                
        $res = $this->db->get()->result();
        if (empty($res))
            return null;
        return $res[0];   
    }
    
    public function insert($data){
        return parent::insert($this->main_table, $data);
    }
    
    public function delete($id){
         return parent::delete($this->main_table, $id);
    }
      
    public function update($data){
        
//        $arrayData = [];
//        if(!is_array($data))
//            foreach ($data as $key => $value)
//                $arrayData[$key] = $data->get($key) ;
//        else
//            $arrayData = $data;
        
        $arrayData = array(
            'id_profil' => $data->get('id_profil'),
            'prenom' => $data->get('prenom'),
            'nom' => $data->get('nom')
        );
        
        
        $this->db->where('id_utilisateur', $data->get('id_utilisateur'));
        $this->db->update('utilisateur', $arrayData);
        $retour = ($this->db->affected_rows()>0)?true:false;
        return $retour ;
        
        
//         return parent::update($this->main_table, $data);   
    }
    
    public function getAllEmploye(){
         return parent::findBy($this->main_table,'id_profil', PROFIL_EMPLOYE);
    }
    
    
    
    
    
}
