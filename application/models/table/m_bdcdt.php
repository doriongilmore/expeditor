<?php

Class M_BdCdt extends MY_Model
{
    public function __construct() {
        
        parent::__construct();
    }
    
    public function getAllByLibelle($lib)
    {
        $lib = $this->db->escape_like_str($lib);

        $this->db->select('u.identifiant as "identifiant", CONCAT(u.nom, " ", u.prenom, " (", u.identifiant_edf, ")") as "libelle"', false)
                    ->distinct()
                    ->from('actor.utilisateurs u')
                    ->join('habilitation h', 'h.id_utilisateur = u.identifiant', 'left')
                    ->where('h.id_profil', PROFIL_CDT)
                    ->like('CONCAT(u.nom, " ", u.prenom, " (", u.identifiant_edf, ")")', $lib)
                    ->order_by('libelle asc')
                ->limit(20);

        $q = $this->db->get();

        return $q->result();
    }
    
    /*
     * fin
     */
}
