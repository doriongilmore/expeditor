<?php

Class M_BdDomaine extends MY_Model 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getAllDomaine()
    {
        $this->db->select('*')
                ->from('domaine');
        $res = $this->db->get()->result();
        $res_array = array();
        foreach($res as $key => $unRes)
            $res_array[$unRes->identifiant] = $unRes->libelle;
        
        return $res_array;
    }
    
    public function getLibelleDomaineById($id){
        $this->db->select('*')
                ->from('domaine d')
                ->where('d.identifiant', $id)
                ;
        $res = $this->db->get()->result();
        return $res[0]->libelle;
    }
    
    
}
