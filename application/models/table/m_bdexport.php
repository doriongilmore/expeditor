<?php

class M_bdexport extends MY_Model
{
    public function __construct() {
        parent::__construct();
        $this->load->library('Xls_converter');
        $this->load->helper('file_helper');
    }
    
    public function export($nom, $data = '')
    {
        $arrData = null;
        $libelle_titre = '';
        
        switch ($nom)
        {
            case 'utilisateur':
                $arrData = $this->export_liste_utilisateur();
                break;
            case 'liste_demande':
                $arrData = $this->export_liste_demande();
                break;
            case 'liste_sd':
                $libelle_titre = 'situations_dangereuses';
                $arrData = $this->export_liste_situations_dangereuses();
                break;
            case 'liste_sd_manageur':
                $libelle_titre = 'situations_dangereuses_par_manageur';
                $this->load->model('simple/m_manager');
                $arrData = $this->m_manager->getSituationDangereuseByEmployeInf();
                break;
            
        }
        
        if($arrData != null)
        {
            $this->xls_converter->processDatas($arrData);
            $this->xls_converter->convert();
            if($libelle_titre == '')
                send_file($this->xls_converter->getFile(),'EXPORT_'.NOM_APPLICATION.'_'.$nom.'.xls');
            else
                send_file($this->xls_converter->getFile(),'EXPORT_'.NOM_APPLICATION.'_'.$libelle_titre.'.xls');
        }
        else
            return 0;
    }
    
    public function export_liste_situations_dangereuses() {
//        $img_path = APPLICATION_URI . '/web/files/img_situation_n_'. $sd->get('identifiant') .'_'. $sd->get('piecejointe') ;
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
                s.com_traitement as commentaire_interne,
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
                
                
                ;
        return $this->db->get()->result();
    }
    
    public function exportTab($arrData)
    {
        if($arrData != null)
        {
            $this->xls_converter->processDatas($arrData);
            $this->xls_converter->convert();
            send_file($this->xls_converter->getFile(),'EXPORT_BANETTE.xls');
        }
    }
    
//    *******************************************************************************************
//    METHODES D'EXPORT
//    *******************************************************************************************
    //Exemple
//    private function export_liste_utilisateur()
//    {
//        $this->db->select('
//                            CONCAT(u.nom, " ",u.prenom," ",u.identifiant_edf) as "Nom Prenom NNI",
//                            p.libelle as "profil",
//                            h.date_debut,
//                            h.date_fin')
//                ->from('habilitation h')
//                ->join('profil p', 'h.id_profil = p.identifiant','left')
//                ->join('actor.utilisateurs u', 'u.identifiant = h.id_utilisateur', 'left');
//        $q = $this->db->get();
//        return $q->result();
//    }
}
?>
