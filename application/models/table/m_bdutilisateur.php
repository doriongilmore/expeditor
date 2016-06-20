<?php
$tabNNI = Array();

Class M_BdUtilisateur extends MY_Model 
{
    public function __construct() {
        
        parent::__construct();
    }
    
    public function get($id){
        $this->db->select('CONCAT(u.nom," ",u.prenom," (",u.identifiant_edf,")") as libelle
                            ,u.nom as nom
                            ,u.prenom as prenom
                            ,u.email as mail
                            ,u.identifiant_edf
                            ,u.id_site_detaille as id_site
                            ,s.libelle as site
                            , u.tel_fixe_1 as tel
                            ,e.identifiant as entite',false)
                 ->from('actor.utilisateurs as u')
                 ->join('actor.sites_detailles as s','u.id_site_detaille = s.identifiant','left')
                 ->join('actor.rh_um as e','u.id_um = e.identifiant','left')
                 ->where('u.identifiant', $id);
        
        $q = $this->db->get();
        return $q->row();
    }
    
    public function checkPresence($id)
    {
        $this->db->from('actor.utilisateurs as u')
                 ->where('u.identifiant_edf', $id)
                 ->where('u.present', 1);
        
        $q = $this->db->count_all_results();
        return $q;
    }
    
    
    public function getLibelle($id){
        $this->db->select('CONCAT(u.nom," ",u.prenom," (",u.identifiant_edf,")") as libelle',false)
                 ->from('actor.utilisateurs as u')
                 ->where('u.identifiant', $id);
        
        $q = $this->db->get();
        $res = $q->result();
        
        return $res[0]->libelle;
    }
    
    public function getMail($id){
        $this->db->select('u.email as mail',false)
                 ->from('actor.utilisateurs as u')
                 ->where('u.identifiant', $id);
        
        $q = $this->db->get();
        $res = $q->result();
        
        return $res[0]->mail;
    }
    
    public function getNNI($id){
        $this->db->select('u.identifiant_edf',false)
                 ->from('actor.utilisateurs as u')
                 ->where('u.identifiant', $id);
        
        $q = $this->db->get();
        $res = $q->result();
        
        return $res[0]->identifiant_edf;
    }
    
    public function getSite($id){
        $this->db->select('s.libelle as site',false)
                 ->from('actor.utilisateurs as u')
                 ->join('actor.sites_detailles as s','u.id_site_detaille = s.identifiant','left')
                 ->where('u.identifiant', $id);
        
        $q = $this->db->get();
        $res = $q->result();
        
        return $res[0]->site;
    }
    
    public function getLibSite($id){
        $this->db->select('s.libelle as site',false)
                 ->from('actor.sites_detailles as s')
                 ->where('s.identifiant', $id);
        
        $q = $this->db->get();
        $res = $q->result();
        
        return $res[0]->site;
    }
    
    public function getEntite($id){
        $this->db->select('e.identifiant as entite',false)
                 ->from('actor.utilisateurs as u')
                 ->join('actor.rh_um as e','u.id_um = e.identifiant','left')
                 ->where('u.identifiant', $id);
        
        $q = $this->db->get();
        $res = $q->result();
        
        return $res[0]->entite;
    }
    
    public function getProfil($id, $manager = true){
//        return array('1'=>'Utilisateur');
        $this->db->select('h.id_profil, p.libelle, h.date_debut, h.date_fin')
                ->from('habilitation h')
                ->join('profil p', 'p.identifiant = h.id_profil', 'left')
                ->where('h.id_utilisateur',$id);
        
        $q = $this->db->get();
        $res = $q->result();
        if($manager)
        {
            if(count($this->m_bdutilisateur->getNniInf($id)) > 0)
            {
                $obj->id_profil = PROFIL_MANAGER;
                $obj->libelle = 'manager';
                $res[] = $obj;
            }
        }
        
        return $res;
    }
    
    public function setProfil($data)
    {
        $this->db->insert('habilitation',array(
                'id_utilisateur' => $data['id_user'],
                'id_profil' => $data['profil'],
                'date_debut' => $data['date_debut'],
                'date_fin' => $data['date_fin']
            ));
    }
    
    public function deleteProfil($id_user)
    {
        $this->db->where('id_utilisateur', $id_user)
                 ->delete('habilitation');
    }
    
    /*
     * a mettre autre part 
     */
    
    public function AllEntite(){
        
        $this->db->select('rh.identifiant,
                           rh.libelle_court')
                 ->from('actor.rh_um as rh');
        
        $q = $this->db->get();
        $res = $q->result();
        
        foreach ($res as $uneEntite)
            $tab_entite[$uneEntite->identifiant] = $uneEntite->libelle_court;
        
        return $tab_entite;
    }
    
    public function getIdByNni($nni)
    {
        $this->db->select('u.identifiant')
                 ->from('actor.utilisateurs as u')
                 ->where('u.identifiant_edf',$nni);
        
        $q = $this->db->get()->result();
        return $q[0]->identifiant;
    }
    
    public function getAllByLibelle($lib)
    {
        $lib = $this->db->escape_like_str($lib);

        $this->db->select('identifiant as "identifiant", CONCAT(nom, " ", prenom, " (", identifiant_edf, ")") as "libelle"', false)
                    ->distinct()
                    ->where('( nom LIKE "'.$lib.'%" OR prenom LIKE "'.$lib.'%" ) OR identifiant_edf LIKE "'.$lib.'%"')
                    ->or_where('CONCAT(nom, " ", prenom) LIKE "'.$lib.'%"')
                    ->from('actor.utilisateurs')
                    ->order_by('libelle asc')
                ->limit(20);

        $q = $this->db->get();

        return $q->result();
    }
    
    public function getOneByEMail($email)
    {
        $e_mail = $this->db->escape_like_str($email);

        $this->db->select('identifiant as "identifiant", CONCAT(nom, " ", prenom, " (", identifiant_edf, ")") as "libelle"', false)
                    ->distinct()
                    ->where('email like',$e_mail)
                    ->from('actor.utilisateurs')
                    ->limit(1);

        $q = $this->db->get();

        return $q->row();
    }
    
    
    public function getSitesAffectation($id_actor) {
        $this->db->select('*', false)
                    ->where('a.id_utilisateur', $id_actor)
                    ->from('affectation_cdt a')
                    ;

        $q = $this->db->get()->result();
        if (empty($q)) {
            return false;
        }
        return $q;
        
    }
    
    
    public function affecterCdt($id_actor, $id_site) {
        $this->db->insert('affectation_cdt',array(
            'id_site'           =>  $id_site,
            'id_utilisateur'    =>  $id_actor
        ));
        return $this->db->insert_id();
    }
    
    public function checkAffectation($id_actor, $id_site) {
        $this->db->select('*', false)
                    ->from('affectation_cdt as ac')
                    ->where('ac.id_utilisateur', $id_actor)
                    ->where('ac.id_site', $id_site)
                    ;
        $res = $this->db->get()->result();
        
        return $res ;
    }
    
    public function supprimerAffectation($id_actor, $id_site) {
        $this->db->where('id_utilisateur', $id_actor)
                    ->where('id_site', $id_site)
                    ->delete('affectation_cdt');
        
        if ($this->db->affected_rows() > 0)
            return true;
        return false;
    }
    
    // Pour avoir les N-1
    public function getNniInf($identifiantManager)
    {
        $this->db->select('sh.id_utilisateur')
                    ->from('actor.superieurs_hierarchiques as sh')
                    ->join('actor.utilisateurs as u','sh.id_utilisateur = u.identifiant', 'left')
                    ->where('u.present', 1)
                    ->where('sh.n1', $identifiantManager);
        $res = $this->db->get()->result();
        global $tabNNI;
        foreach($res as $unUtilisateur)
        {
            if(!in_array($unUtilisateur->id_utilisateur, $tabNNI))
            {
                $tabNNI[] = intval($unUtilisateur->id_utilisateur);
            }
            $this->getNniInf($unUtilisateur->id_utilisateur);
        }
        
        return $tabNNI ;
    }
    
    /*
     * fin
     */
}
