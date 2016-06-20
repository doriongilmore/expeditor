<?php 

Class M_Utilisateur extends MY_Model 
{
    
    
    public $identifiant_actor = null;
    public $identifiant_edf = null;
    public $libelle = null;
    public $nom = null;
    public $prenom = null;
    public $mail = null;
    public $id_site = null;
    public $site = null;
    public $entite = null;
    public $profil = null;
    public $liste_stats = null;
    public $telephone = null;
    
    
    public function __construct() {
        parent::__construct();
        $this->load->model('table/m_bdutilisateur');
        $this->load->model('table/m_bdconstant');
    }
    
    public function init($id_actor = null)
    {
        //regarde si l'utilsiateur est connecte ou était connecté récement
        if(is_null($id_actor))
            if($this->session->userdata('identifiant'))
                $id_actor = $this->session->userdata('identifiant');
            else
            {
                $this->identifiant_actor = null;
                return false;
            }
        
        $this->identifiant_actor = $id_actor; 
        
//        $this->libelle = $this->m_bdutilisateur->getLibelle($this->identifiant_actor);
//        $this->mail = $this->m_bdutilisateur->getMail($this->identifiant_actor);
//        $this->site = $this->m_bdutilisateur->getSite($this->identifiant_actor);
//        $this->entite = $this->m_bdutilisateur->getEntite($this->identifiant_actor);
//        $this->profil = $this->m_bdutilisateur->getProfil($this->identifiant_actor);
//        $this->identifiant_edf = $this->m_bdutilisateur->getNNI($this->identifiant_actor);
        $info = $this->m_bdutilisateur->get($this->identifiant_actor);
        $this->libelle = $info->libelle;
        $this->nom = $info->nom;
        $this->prenom = $info->prenom;
        $this->mail = $info->mail;
        $this->id_site = $info->id_site;
        $this->site = $info->site;
        $this->telephone = $info->tel;
        $this->entite = $info->entite;
        $this->profil = $this->m_bdutilisateur->getProfil($this->identifiant_actor);
        $this->identifiant_edf = $info->identifiant_edf;
    }
    
    // Si on veut initialiser un utilisateur autre que celui connecter on passe un paramètre
    public function getUnUtilisateur($id_actor)
    {
        $unUser = new M_Utilisateur();
        //on initialise toute les données d'un utilisateur nécessaire à toute les pages
        $this->identifiant_actor = $id_actor; 
        
        $info = $this->m_bdutilisateur->get($this->identifiant_actor);
        $this->libelle = $info->libelle;
        $this->nom = $info->nom;
        $this->prenom = $info->prenom;
        $this->mail = $info->mail;
        $this->site = $info->site;
        $this->telephone = $info->tel;
        $this->entite = $info->entite;
        $this->profil = $this->m_bdutilisateur->getProfil($this->identifiant_actor);
        $this->identifiant_edf = $info->identifiant_edf;
        
        return $this;
    }
    
    public function getByNni($nni)
    {
        return $this->m_bdutilisateur->getIdByNni($nni);
    }
    
    public function updateProfil()
    {
        
    }
    
    public function rechercheParNomPrenom_champs_unique($nomEtPrenom)
    {
        $q = $this->m_bdutilisateur->getAllByLibelle(strtoupper($nomEtPrenom));
        
        if(count($q) == 1)
            return $q[0]->identifiant;
        else
            return false;
    }
    
    public function rechercheParNomPrenom($nom, $prenom)
    {
        $q = $this->m_bdutilisateur->getAllByLibelle(strtoupper($nom).' '.strtoupper($prenom));
        
        if(count($q) == 1)
            return $q[0]->identifiant;
        else
            return false;
    }
    
    public function rechercheParEMail($email)
    {
        $q = $this->m_bdutilisateur->getOneByEMail($email);
        
        $this->getUnUtilisateur($q->identifiant);
        return $this;
    }
    
    public function checkEMailPreference()
    {
        foreach($this->profil as $p)
        {
            if($p->libelle == 'mail')
                return true;
        }
        return false;
    }
    
    public function checkHabilitation($id)
    {
        $q = $this->m_bdutilisateur->checkPresence($id);
        if(intval($q)>0)
          return true;
        else
          return false; 
    }
    
    public function getHabilitation($id = null)
    {
        if(is_null($id))
        {
            foreach($this->m_bdconstant->getAllProfil() as $une_habilitation)
                $tab_hab[$une_habilitation->identifiant]['label'] = $une_habilitation->libelle;
            return $tab_hab;
        }
        else
        {
            foreach($this->m_bdutilisateur->getProfil(intval($id), false) as $une_habilitation)
            {
                    $tab_hab[$une_habilitation->id_profil]['identifiant'] = $une_habilitation->identifiant;
                    $tab_hab[$une_habilitation->id_profil]['label'] = $une_habilitation->libelle;
                    $tab_hab[$une_habilitation->id_profil]['date_debut'] = date(('d-m-Y'),  strtotime($une_habilitation->date_debut));
                    $tab_hab[$une_habilitation->id_profil]['date_fin'] = date(('d-m-Y'),  strtotime($une_habilitation->date_fin));
                    $tab_hab[$une_habilitation->id_profil]['checked'] = true;
            }
              
            foreach ($this->m_bdconstant->getAllProfil() as $une_habilitation) 
                if(!array_key_exists($une_habilitation->identifiant, $tab_hab))
                    $tab_hab[$une_habilitation->identifiant]['label'] = $une_habilitation->libelle;
                
            return $tab_hab;
        }
    }
    
    public function enregistrerHabilitaion($data)
    {
        $this->m_bdutilisateur->deleteProfil(intval($data['user']));
        $tab_hab = array();
        foreach ($this->m_bdconstant->getAllProfil() as $une_habilitation) 
        {
            if(array_key_exists('check_habilitation_'.$une_habilitation->identifiant, $data))
            {
                $tab_hab[$une_habilitation->identifiant]['id_user'] = intval($data['user']);
                $tab_hab[$une_habilitation->identifiant]['profil'] = $une_habilitation->identifiant;                
                if(isset($data['date_debut_'.$une_habilitation->identifiant]))
                    $tab_hab[$une_habilitation->identifiant]['date_debut'] = date('Y-m-d',strtotime($data['date_debut_'.$une_habilitation->identifiant]));
                else
                    $tab_hab[$une_habilitation->identifiant]['date_debut'] = date('Y-m-d');
                    
                if(isset($data['date_debut_'.$une_habilitation->identifiant]))
                    $tab_hab[$une_habilitation->identifiant]['date_fin'] = date('Y-m-d',strtotime($data['date_fin_'.$une_habilitation->identifiant]));
                else
                    $tab_hab[$une_habilitation->identifiant]['date_fin'] = date('Y-m-d',mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y')+3));
            }
        }
        if(count($tab_hab) > 0)
            foreach($tab_hab as $uneHab)
                $this->m_bdutilisateur->setProfil($uneHab);
    }
    
    public function checkProfil($id_profil)
    {
        if(is_int($id_profil))
            foreach ($this->profil as $p)
                if($p->id_profil == $id_profil)
                    return true;
        if(is_array($id_profil))
            foreach($id_profil as $p_check)
                foreach ($this->profil as $p)
                    if($p->id_profil == $p_check)
                        return true;
            
        return false;
    }
    
    public function getSitesAffectation($id_actor) {
//        $array_res = array();
//        foreach ($array_actor as $id_actor) {
//            $array_res += $this->m_bdutilisateur->getSitesAffectation($id_actor);
//        }
//        var_dump($array_res);
        return $this->m_bdutilisateur->getSitesAffectation($id_actor) ;
    }
    
    public function affecterCdt($id_actor, $id_site) {
        $res =  $this->m_bdutilisateur->affecterCdt($id_actor, $id_site) ;
        if ($res > 0) 
            return true;
        else
            return false;
    }
    
    public function checkAffectation($id_actor, $id_site) {
        $res =  $this->m_bdutilisateur->checkAffectation($id_actor, $id_site) ;
        if (empty($res)) 
            return true;
        else
            return false;
    }
    
}