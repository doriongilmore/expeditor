<?php

Class M_BdSituation extends MY_Model 
{
    public function __construct() {
        parent::__construct();
    }
    
    public function getAll(){
        $this->db->select('*')
                ->from('situations');
        $res = $this->db->get()->result();
        return $res;
    }
    public function getById($id){
        $this->db->select('*')
                ->from('situations s')
                ->where('s.identifiant', $id)
                ;
        $res = $this->db->get()->result();
        return $res[0];
    }
    
    private function getSituations() {
        $this->db->select('
            s.identifiant, 
            DATE_FORMAT(s.date_creation, "%d/%m/%y %k:%i" ) as date_creation, 
            UNIX_TIMESTAMP(s.date_creation) as date_timestamp,
            a.libelle as site, 
            CONCAT(u.nom, " ", u.prenom) as detecteur,
            st.libelle as etat, s.libelle as libelle,
            d.libelle as domaine,
            IF(ISNULL(s.id_cloture),
                    IF(ISNULL(s.id_prisencompte),
                                    null,
                                    CONCAT(u1.nom, " ", u1.prenom)),
                    CONCAT(u2.nom, " ", u2.prenom)) as cdt
 
            ', false)
                ->from('situations as s')
                ->join('domaine as d','d.identifiant = s.id_domaine','left')
                ->join('actor.utilisateurs as u','u.identifiant = s.id_detecteur','left')
                ->join('actor.sites_detailles as a','a.identifiant = s.id_site','left')
                ->join('statut as st','st.identifiant = s.etat','left')
                ->join('actor.utilisateurs as u1','s.id_prisencompte = IF(ISNULL(s.id_prisencompte),NULL,u1.identifiant)','left')
                ->join('actor.utilisateurs as u2','s.id_cloture = IF(ISNULL(s.id_cloture),NULL,u2.identifiant)','left')
                ->order_by('identifiant', 'DESC');
        $this->db->where('s.supprimer', '0' );
        
    }


    public function getSituationsByManageur($tabNniInf){
        $this->db->select('s.identifiant,
            DATE_FORMAT(s.date_creation, "%d-%m-%Y %H:%i") as date_creation,
            a.libelle as site,
            CONCAT(u0.nom, " ", u0.prenom, " (", u0.identifiant_edf, ")") as detecteur,
            st.libelle as etat ,
            s.libelle as libelle_sd,
            d.libelle as domaine,
            s.description as description,
            DATE_FORMAT(s.date_priseencompte, "%d-%m-%Y %H:%i") as pris_en_compte_le,
            CONCAT(u1.nom, " ", u1.prenom, " (", u1.identifiant_edf, ")") as pris_en_compte_par,
            s.com_detecteur as commentaire_public,
            DATE_FORMAT(s.date_cloture, "%d-%m-%Y %H:%i") as cloture_le,
            CONCAT(u2.nom, " ", u2.prenom, " (", u2.identifiant_edf, ")") as cloture_par,
            s.com_prevention as message_prevention, 
            IF(ISNULL(s.piecejointe) or s.piecejointe = "",null,
            CONCAT("'.APPLICATION_URI.'/web/files/img_situation_n_", s.identifiant, "_", s.piecejointe) )
            as piecejointe
            '
            , false)
            ->from('situations as s')
            ->join('domaine as d','d.identifiant = s.id_domaine','left')
            ->join('actor.utilisateurs as u0','u0.identifiant = s.id_detecteur','left')
            ->join('actor.utilisateurs as u1','u1.identifiant = s.id_prisencompte','left')
            ->join('actor.utilisateurs as u2','u2.identifiant = s.id_cloture','left')
            ->join('actor.sites_detailles as a','a.identifiant = s.id_site','left')
            ->join('statut as st','st.identifiant = s.etat','left')
            ->where('s.supprimer', '0' )
            ->where_in('s.id_detecteur', $tabNniInf);
        $res = $this->db->get()->result();
        return $res;
    }


    public function getSituationsByIdDetecteur($id){
        $this->getSituations();
        $this->db->where('u.identifiant', $id);
        $res = $this->db->get()->result();
        return $res;
    }
    
    public function getSituationsBySiteCdt($id){
        $this->getSituations();
        $this->db->where('s.id_site', $id);
        $this->db->where('s.etat < 3');
        $res = $this->db->get()->result();
        return $res;
    }
    
    public function getAnneesStats() {
        $this->db->select('DISTINCT(YEAR(s.date_creation)) as "annee"', false)
                    ->from('situations s')
                    ->where('s.supprimer', 0);
        $array = ($this->db->get()->result());
        $return_value = array() ;
        foreach ($array as $key => $value) 
            $return_value[$value->annee] = $value->annee ;
        
        return  $return_value;
    }
    
    public function getStatsDomaine($annee){
        $this->db->select('d.libelle, count(*) as nb')
                 ->from('situations as s')
                 ->join('domaine as d','d.identifiant = s.id_domaine','left');
        
        $this->db->where('YEAR(s.date_creation)', $annee);
        $this->db->where('supprimer', 0);
        $this->db->group_by('d.libelle');
        $this->db->order_by('d.identifiant');
        $res = $this->db->get()->result();
        return $res;
    }
    
    public function getStatsSite($annee){
        $annee = $this->db->escape($annee);
        $requete = "select site.libelle as 'libelle', 
                    count(site.identifiant)as 'total',
                    IF(ISNULL(tab_traite.nb),0,tab_traite.nb) as 'traite'

                    from situations as sd 

                    left join actor.sites_detailles site on site.identifiant = sd.id_site 
                    left join (
                                            select s.id_site id,count(s.identifiant) nb
                                            from situations as s 
                                            where s.etat = 3 
                                            and YEAR(s.date_creation) = $annee
                                            group by s.id_site
                                    ) tab_traite on tab_traite.id = sd.id_site

                    where sd.supprimer = 0 
                    and YEAR(sd.date_creation) = $annee
                    group by site.libelle 
                    ";
        
        $res = $this->db->query($requete)->result();
        return $res;
    }
        
    
    public function insert($data)
    {
        $this->db->insert('situations',array(
            'id_detecteur'           =>  $data->get('detecteur')->identifiant_actor,
            'id_site'        =>  $data->get('id_site'),
            'id_domaine'          =>  $data->get('id_domaine'),
            'libelle'       =>  $data->get('libelle'),
            'description'   =>  $data->get('description'),
            'piecejointe'       =>  $data->get('piecejointe'),
            'date_creation'       =>  $data->get('date_creation_sql')
        ));
        return $this->db->insert_id();
    }
    
    public function update($data)
    {
        $array = array(
            'id_detecteur'           =>  $data->get('detecteur')->identifiant_actor,
            'id_site'        =>  $data->get('id_site'),
            'id_domaine'          =>  $data->get('id_domaine'),
            'libelle'       =>  $data->get('libelle'),
            'description'   =>  $data->get('description'),
            'piecejointe'       =>  $data->get('piecejointe'),
            'piecejointe_cdt'       =>  $data->get('piecejointe_cdt'),
            'date_creation'       =>  $data->get('date_creation_sql'),
            'com_detecteur'       =>  $data->get('com_detecteur'),
            'date_priseencompte'       =>  $data->get('date_priseencompte_sql'),
            'id_prisencompte'       =>  $data->get('cdt_prisencompte')->identifiant_actor,
            'com_traitement'       =>  $data->get('com_traitement'),
            'date_cloture'       =>  $data->get('date_cloture_sql'),
            'id_cloture'       =>  $data->get('cdt_cloture')->identifiant_actor,
            'etat'       =>  $data->get('id_etat'),
            'com_prevention'       =>  $data->get('com_prevention'),
            'supprimer'       =>  $data->get('supprimer'),
            'id_supprimer'       =>  $data->get('cdt_supprimer')->identifiant_actor
        );
        
        $this->db->where('identifiant', $data->get('identifiant'));
        $q = $this->db->update('situations', $array);
        if ($this->db->affected_rows() > 0)
            return true;
        return false;
    }
    
    private function filtrer() {
        $filtre = $_SESSION["filtre_sd"];
        
        if (isset($filtre['user']) && $filtre['user'] != '')
            $this->db->where('s.id_detecteur', $filtre['user']);
        
        if (isset($filtre['filtre_site']) && $filtre['filtre_site'] != '0')
            $this->db->where('s.id_site', $filtre['filtre_site']);
        
        if (isset($filtre['filtre_cdt']) && $filtre['filtre_cdt'] != '0'){
            $cdt = 's.id_prisencompte = '.$filtre['filtre_cdt'].' or s.id_cloture = '. $filtre['filtre_cdt'] ;
            $this->db->where('('.$cdt.')');
        }
        
        if (isset($filtre["filtre_etat"]) && $filtre['filtre_etat'] != '0')
            $this->db->where('s.etat', $filtre['filtre_etat']);
        
        if (isset($filtre["filtre_domaine"]) && $filtre['filtre_domaine'] != '0')
            $this->db->where('s.id_domaine', $filtre['filtre_domaine']);
        
        if (isset($filtre["filtre_mot_cle"]) && $filtre["filtre_mot_cle"] != '' ){
            $keywords = $filtre['filtre_mot_cle'];
            $array = explode(' ', $keywords);
            $com0 = ' ';            $com1 = ' ';            $com2 = ' ';            $com3 = ' ';            $com4 = ' ';
            $cpt = 0;
            foreach ($array as $key) {
                if ($cpt == 0){
                    $com0 .= 's.description like "%' . $key . '%" ';
                    $com1 .= 's.com_detecteur like "%' . $key . '%" ';
                    $com2 .= 's.com_traitement like "%' . $key . '%" ';
                    $com3 .= 's.com_prevention like "%' . $key . '%" ';
                    $com4 .= 's.libelle like "%' . $key . '%" ';
                    $cpt++;
                }
                else{
                    $com0 .= ' or s.description like "%' . $key . '%" ';
                    $com1 .= ' or s.com_detecteur like "%' . $key . '%" ';
                    $com2 .= ' or s.com_traitement like "%' . $key . '%" ';
                    $com3 .= ' or s.com_prevention like "%' . $key . '%" ';
                    $com4 .= ' or s.libelle like "%' . $key . '%" ';
                }
            }

            $this->db->where('('.$com0.' or '.$com1.' or '.$com2.' or '.$com3.' or '.$com4.')');
            
        }
    }
    
    public function getSituationsByFiltre() {
        $this->getSituations();
        $this->filtrer();
        return $this->db->get()->result();
    }
    
    public function getCdtBySite($id_site = null) {
        $this->db->select('a.id_utilisateur as id,
            CONCAT(u.nom, " ", u.prenom, " (", u.identifiant_edf, ")") as libelle, 
            u.nom, u.prenom, u.identifiant_edf nni, u.email mail', false)
                ->from('affectation_cdt a')
                ->join('actor.utilisateurs as u','u.identifiant= a.id_utilisateur','left');
        
        if (!is_null($id_site))
            $this->db->where('a.id_site', $id_site);
        
        $res = $this->db->get()->result();
        return $res;
    }
    
    public function chargerSD($id_sd) {
        $this->db->select('id_situation sd, id_actor user, debut_lecture')
                ->from('lecture_situation ls')
                ->where('ls.id_situation', $id_sd)
                ;
        $res = $this->db->get()->result();
        if (empty($res))
            return false ;
        return $res[0];
    }
    
    public function bloquerSD($id_sd) {
        return $this->db->insert('lecture_situation',array(
            'id_situation'           =>  $id_sd,
            'id_actor'        => $this->user->identifiant_actor
        ));
    }
    
    public function debloquerSD($id_sd) {
        $this->db->delete('lecture_situation',array(
            'id_situation'           =>  $id_sd,
            'id_actor'        => $this->user->identifiant_actor
        ));
        
        if ($this->db->affected_rows() > 0)
            return true;
        return false;
    }
    
    public function getNbCdtBySite() {
        $this->db->select('site.identifiant,  site.libelle libelle_site, count(ac.id_utilisateur) nb')
                ->from('actor.sites_detailles as site')
                ->join('affectation_cdt ac ','ac.id_site = site.identifiant','left')
                ->where('site.actif', '1')
                ->group_by('site.identifiant,  site.libelle')
                ->order_by('site.libelle ASC, nb DESC')
                ;
        $res = $this->db->get()->result();
        return $res;
    }
    
    public function getNbSdByAnnee($annee) {
        $this->db->select('count(*) nb')
                ->from('situations s')
                ->where('s.supprimer', '0')
                ->where('YEAR(s.date_creation)', $annee)
                ;
        $res = $this->db->get()->result();

        if (empty($res)) 
            return 0 ;
        
        return $res[0]->nb;
    }
    
    
}
