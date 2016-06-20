<?php

Class M_BdConstant extends MY_Model 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getAllProfil()
    {
        $this->db->select('*')
                ->from('profil');
        
//        foreach($this->db->get()->result() as $key => $unRes)
//            $tabDonne[$unRes->identifiant]['label'] = $unRes->libelle;
        
        return $this->db->get()->result();
    }
    
    public function getAllStatut()
    {
        $this->db->select('*')->from('statut');
        $res = $this->db->get()->result();
        
        $res_array = array();
        foreach ($res as $object)
            $res_array[$object->identifiant] = $object->libelle ;
        
        return $res_array;
    }
    
    public function getAllSitesActifs(){
        $this->db->select('s.identifiant, s.libelle')
                ->from('actor.sites_detailles s')
                ->where('s.actif', 1)
                ->order_by('s.libelle', 'ASC')
                
                ;
        $res = $this->db->get()->result();
        $array_res = array();
        
        foreach ($res as $site_detaille) {
            $array_res[$site_detaille->identifiant] = $site_detaille->libelle;
        }
        
        return $array_res;
    }
    
}
