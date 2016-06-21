<?php

Class M_BdSample extends MY_Model
{
    private $main_table = 'experience c';
    private $type_table = 'experience_type ty';
    private $role_table = 'experience_role r';
    private $tache_table = 'experience_tache ta';
    
    private $langage_table = 'langage la';
    private $langage_link_table = 'experience_langage la_li';
    
    private $logiciel_table = 'logiciel lo';
    private $logiciel_link_table = 'experience_logiciel lo_li';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getById($id){
        return parent::getById($this->main_table, $id);
    }
    
    public function getByIdUtilisateur($id){
        return parent::findBy($this->main_table, 'c.id_utilisateur', $id);
    }
    
    public function getTypeById($id_type){
        return parent::findBy($this->type_table, 'ty.identifiant', $id_type);
    }
    
    public function getTachesByIdExperience($id_experience){
        return parent::findBy($this->tache_table, 'ta.id_experience', $id_experience);
    }
    
    public function getRoleById($id_role){
        return parent::findBy($this->role_table, 'r.identifiant', $id_role);
    }
    
    public function getLangagesByIdExperience($id) {
        $this->db->select('*', false)
                 ->from($this->langage_link_table)
                 ->join($this->langage_table, 'la.identifiant = la_li.id_langage')
                 ->where('la_li.id_experience',$id);
        $res = $this->db->get()->result();
        return $res;
    }
    
    public function getLogicielsByIdExperience($id) {
        $this->db->select('*', false)
                 ->from($this->logiciel_link_table)
                 ->join($this->logiciel_table, 'lo.identifiant = lo_li.id_logiciel')
                 ->where('lo_li.id_experience',$id);
        $res = $this->db->get()->result();
        return $res;
    }
    
}
