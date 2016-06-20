<?php

class C_Situation extends MY_Controller
{ 
   
    public function __construct($lightMode = false) {
        parent::__construct();
        $this->load->model('table/m_bdconstant');
        $this->load->model('simple/m_situation', 'uneSD');
        $this->load->model('table/m_bddomaine');
        $this->load->helper('table_helper');
        $this->data['arr_domaines'] = $this->m_bddomaine->getAllDomaine();
        $this->data['arr_sites'] = $this->m_bdconstant->getAllSitesActifs();
    }
    
    public function creation() {
//        var_dump($this->data['id_sd']);
        $this->data['user_lib'] = $this->user->libelle;
        $this->data['id_site'] = $this->user->id_site;
        if (!empty($_POST)) {
            if (isset($_POST['annuler']))
                redirect('liste_d', 'refresh');
            if (isset($_POST['modifier']))
                redirect('modifier/'.$this->data['id_sd'], 'refresh');
            if (isset($_FILES['upload']['name']) && $_FILES['upload']['name'] != '')
                $this->data['name'] = $_FILES['upload']['name'];
            else if (isset($_POST['_upload']) && $_POST['_upload'] != '')
                $this->data['name'] = $_POST['_upload'];
            
            
            try {
                if ($this->uneSD->importer_img_temp('upload') && $this->form_validation->run('creationSD')) {
                    $id_sd = $this->uneSD->enregistrerSD($this->uneSD, 'user', 'new');
                    $this->data['valid'] = $this->message['valid']['creationSD'];
                    $this->visionner($id_sd);
                    return;
                }else
                    $this->data['error'] = validation_errors();
            } catch (Exception $exc) {
                $this->traiterErreur($exc);
            }
        }
        $this->_loadView('utilisateur/v_creation');
    }
    
    public function liste() {
        $this->data['arr_etats'] = $this->m_bdconstant->getAllStatut();
        $this->data['arr_data'] = $this->uneSD->getSituationsByIdDetecteur($this->user->identifiant_actor);
        if (!$this->data['arr_data']) 
            $this->data['message'] = $this->message['info']['no_sd_user'];
        $this->data['lien'] = '/visionner';
        $this->_loadView('utilisateur/v_liste');
    }
    
    



    public function traitementClassicList($id_sd) {
        $this->verif_droit(PROFIL_CDT);
        $this->data['sd'] = $this->uneSD->chargerSD($id_sd);
        $this->data['redirect'] = 'traitementC';
        if (isset($_POST['annuler'])){
            $this->uneSD->debloquerSD($id_sd);
            redirect('liste_c', 'refresh');
        }
        $this->traitement($id_sd);
    }
    public function traitementSearchList($id_sd) {
        $this->verif_droit(PROFIL_CDT);
        $this->data['sd'] = $this->uneSD->chargerSD($id_sd);
        $this->data['redirect'] = 'traitementS';
        if (isset($_POST['annuler'])){
            $this->uneSD->debloquerSD($id_sd);
            redirect('search', 'refresh');
        }
        $this->traitement($id_sd);
    }

    public function traitement($id_sd) {
        $this->data['id_sd'] = ($id_sd);
        $this->data['traitement'] = true;
//        $this->data['tab_info_sd'] = $this->getTabInfoSD($this->data['sd']);
        $this->data['desc_situation'] = $this->chargerDescription($this->data['sd']);
        $this->checkBlocageSD();
        
        $pj = $this->data['sd']->get('piecejointe_cdt');
//        var_dump($pj);
//        else if (isset($_POST['_upload']) && $_POST['_upload'] != '')
//                $this->data['name'] = $_POST['_upload'];
        if (isset($this->data['sd']) && !is_null($pj) && !empty($pj))
            $this->data['name'] = $this->uneSD->getFilename_form($this->data['sd'], true)    ;//  $this->data['sd']->get('piecejointe_cdt');
        else if (isset($_FILES['upload']['name']) && $_FILES['upload']['name'] != '')
                $this->data['name'] = $_FILES['upload']['name'];
        
        
        if (isset($_POST['supprCanceled']))
            $this->data['info'] = 'Suppression annulée.';
        else if (isset($_POST['supprFinale'])){
            if ($this->uneSD->delete($this->data['sd']))
                $this->data['valid'] = 'Demande supprimée';
        }
        else if (isset($_POST['supprimer'])){
            $this->supprimer($id_sd);
            return;
        }
        else if (isset($_POST['suivant']) || isset($_POST['enregistrer'])){ // enregistrer les commentaires et avancer l'Ã©tat de la situation
            $next = (isset($_POST['suivant']))?'next':null;
            try {
                if ( ($this->data['name'] == $pj ) || ($this->uneSD->importer_img_temp('upload', true)) ){
                    $bool = $this->uneSD->enregistrerSD($this->data['sd'], 'cdt', $next);
                    $this->data['valid'] = $this->message['valid']['updateSD'];
                }
            } catch (Exception $exc) {
                $this->traiterErreur($exc);
            }
        }
        
        if ($this->data['sd']->get('id_etat') == '3' ){
            $this->visionner($id_sd);
            return;
        }
        $this->_loadView('cdt/v_traitement');
    }
    
    public function modifier ($id_sd) {
        $this->data['id_sd'] = $id_sd;
        $this->data['sd'] = $this->uneSD->chargerSD($id_sd);
        
        $canModify = ($this->data['sd']->get('id_etat') == 1 && $this->data['sd']->get('detecteur')->identifiant_actor == $this->user->identifiant_actor );
        if (!$canModify)
            redirect ('c_erreur/page_interdite', 'refresh');
        
        $this->checkBlocageSD();
        if(!is_null($this->data['sd']))
                $this->data['name'] = $this->uneSD->getFilename_form($this->data['sd']);
        if (!empty($_POST)){
            if (isset($_POST['annuler'])){
                $this->uneSD->debloquerSD($id_sd);
                redirect('visionner/'.$id_sd, 'refresh');
            }
            else if (isset($_POST['supprCanceled'])){
                $this->data['info'] = 'Suppression annulée.';
            }
            else if (isset($_POST['supprFinale'])){
                if ($this->uneSD->delete($this->data['sd']))
                    $this->data['valid'] = 'Demande supprimée';
            }
            else if (isset($_POST['supprimer'])){
                $this->supprimer($id_sd);
                return;
            }
            else if (isset($_POST['enregistrer'])){
                try {
                    if ($this->uneSD->importer_img_temp('upload') && $this->form_validation->run('creationSD')) {
                            $bool = $this->uneSD->enregistrerSD($this->data['sd'], 'user');
                            $this->data['valid'] = $this->message['valid']['updateSD'];
                            $this->uneSD->debloquerSD($id_sd);
                            $this->visionner($id_sd);
                            return;
                    }else
                        $this->data['error'] = validation_errors();
                } catch (Exception $exc) {
                    $this->traiterErreur($exc);
                }
            }
        }
        $this->_loadView('utilisateur/v_modif');
    }
    
    public function visionner($id_sd) {
        $this->data['id_sd'] = $id_sd;
        $this->data['sd'] = $this->uneSD->getById($id_sd);
//        $this->data['tab_info_sd'] = $this->getTabInfoSD($this->data['sd']);
        $this->data['desc_situation'] = $this->chargerDescription($this->data['sd']);
        if (isset($_POST['annuler']))
            redirect('liste_d', 'refresh');
        else if (isset($_POST['modifier']))
            redirect('modifier/'.$id_sd, 'refresh');
//        else if (!empty($_POST))
//            redirect('liste_d', 'refresh');
        
        $this->data['canModify']  = ($this->data['sd']->get('id_etat') == 1 && $this->data['sd']->get('detecteur')->identifiant_actor == $this->user->identifiant_actor );
        
        $this->_loadView('utilisateur/v_traitement');
    }
    
    public function stats() {
        $this->verif_droit(PROFIL_EXPERT);
        $this->load->model('table/m_bdsituation');
        $this->load->helper('graph_helper');
        $this->data['listeAnnees'] = $this->m_bdsituation->getAnneesStats();
        
        
        if (isset($_POST['lst_annee'])) 
            $this->data['annee'] = $_POST['lst_annee'];
        else
            $this->data['annee'] = date('Y');
        
        $this->data['nbTotal'] = $this->uneSD->getNbSdByAnnee($this->data['annee']);
        
        
        $tab_info_graph_sdByDomaine = $this->uneSD->getStatsDomaine($this->data['annee']);
        $tab_info_graph_sdBySite = $this->uneSD->getStatsSites($this->data['annee']);
            
        /*info graph sdByDomaine */
          
        $this->data['tab_info_graph'] = $tab_info_graph_sdByDomaine;
        $this->data['graph']['sdByDomaine']['info_ie'] = $tab_info_graph_sdByDomaine;
        $this->data['graph']['sdByDomaine']['info'] = json_encode($tab_info_graph_sdByDomaine);
        $this->data['graph']['sdByDomaine']['param'] = array('height'=>'300px', 'width'=>'400px', 'titre' => 'Nombre de demandes par domaine :');

        /* Fin init graph */
        
        
        /*info graph sdBySiteAndStatut */
          
        $this->data['tab_info_graph'] = $tab_info_graph_sdBySite;
        $this->data['graph']['sdBySite']['info_ie'] = $tab_info_graph_sdBySite;
        $this->data['graph']['sdBySite']['info'] = json_encode($tab_info_graph_sdBySite);
        $this->data['graph']['sdBySite']['param'] = array('height'=>550, 'width'=>'900px', 'titre' => 'Nombre de demandes par sites :');

        /* Fin init graph */
        
        $this->_loadView('expert/v_stats');
    }
    
    public function rechercher() {
        $this->verif_droit(array(PROFIL_CDT, PROFIL_EXPERT));
        if (isset($_POST['filtrer']))
            $this->ajout_POST_a_la_session();
        elseif (isset($_POST['reinitialiser'])){
            unset($_SESSION['filtre_sd']);
            unset($_POST);
        }
        
        if (isset($_SESSION["filtre_sd"]["filtre_site"]) && $_SESSION["filtre_sd"]["filtre_site"] != 0 )
            $this->data['arr_cdt'] = $this->uneSD->getCdtBySite($_SESSION["filtre_sd"]["filtre_site"]);
        else
            $this->data['arr_cdt'] = $this->uneSD->getCdtBySite();
        
            
        $this->data['filtre'] = $_SESSION["filtre_sd"];
        $this->data['arr_data'] = $this->uneSD->getSituationsByFiltre();
        if (empty($this->data['arr_data']))
            $this->data['info'] = $this->message['info']['aucuneSD'];
        $this->data['arr_etats'] = $this->m_bdconstant->getAllStatut();
        $this->data['lien'] = '/traitementS';
        $this->_loadView('cdt/v_recherche');
    }
    
    public function liste_cdt() {
        $this->verif_droit(PROFIL_CDT);
        $this->data['arr_etats'] = $this->m_bdconstant->getAllStatut();
        $sites = $this->user->getSitesAffectation($this->user->identifiant_actor);
        if ($sites) {
            $this->data['arr_data'] = $this->uneSD->getSituationsBySiteCdt($sites);
            if (!$this->data['arr_data']) 
                $this->data['message'] = $this->message['info']['no_sd_cdt'];
        }
        else
            $this->data['message'] = $this->message['info']['no_affectation'];
        
        $this->data['lien'] = '/traitementC';
        $this->data['legende'] = '<div class="form_row clear" id="table_legend"><div class="label"><label>Légende : </label></div><div class="red_legend tr_rouge">Détectée depuis plus de 48h sans traitement</div></div>';
        $this->_loadView('utilisateur/v_liste');
    }
    
    public function export() {
        $this->verif_droit(PROFIL_EXPERT);
        $this->load->model('table/m_bdexport');
        $this->m_bdexport->export('liste_sd');
        redirect('accueil', 'refresh');
    }
    
    public function exportManager() {
        $this->verif_droit(PROFIL_MANAGER);
        $this->load->model('table/m_bdexport');
        $this->m_bdexport->export('liste_sd_manageur');
        redirect('accueil', 'refresh');
    }
 
    
    private function ajout_POST_a_la_session(){
        if (isset($_POST['_user']))
            $_SESSION["filtre_sd"]["_user"] = $_POST["_user"];
        if (isset($_POST['user']))
            $_SESSION["filtre_sd"]["user"] = $_POST["user"];
        if (isset($_POST['filtre_site']))
            $_SESSION["filtre_sd"]["filtre_site"] = $_POST["filtre_site"];
        if (isset($_POST['filtre_cdt']))
            $_SESSION["filtre_sd"]["filtre_cdt"] = $_POST["filtre_cdt"];
        if (isset($_POST["filtre_etat"]))
            $_SESSION["filtre_sd"]["filtre_etat"] = $_POST["filtre_etat"];
        if (isset($_POST["filtre_domaine"]))
            $_SESSION["filtre_sd"]["filtre_domaine"] = $_POST["filtre_domaine"];
        if (isset($_POST["filtre_mot_cle"]))
            $_SESSION["filtre_sd"]["filtre_mot_cle"] = $_POST["filtre_mot_cle"];

    }
 
    private function traiterErreur($exception){
        if (isset($this->message['error'][$exception->getMessage()]))
            $this->data['error'] = $this->message['error'][$exception->getMessage()];
        else
            $this->data['error'] = $exception->getMessage();
    }
    
    public function supprimer($id_sd){
        $this->data['id_sd'] = $id_sd;
        
        $this->_loadView('utilisateur/v_suppression');
    }
    
    private function checkBlocageSD() {
        $lecteur = $this->data['sd']->get('lecteur');
        $this->data['sd_is_blocked'] = (!is_null($lecteur) && $lecteur->identifiant_actor != $this->user->identifiant_actor)
                                            ?true
                                            :false;
        if ($this->data['sd_is_blocked']) {
            $nom = $this->data['sd']->get('lecteur')->libelle ;
            $this->data['info'] = 'Situation dangereuse ouverte par '.$nom;
        }
    }
 
    private function verif_droit($id_profil) {
        if (is_array($id_profil)) {
            $bool = false ;
            foreach ($id_profil as $id) {
                if (!$bool)
                    $bool = $this->user->checkProfil($id);
            }
        }else{
            $bool = $this->user->checkProfil($id_profil) ;
        }
        if (!$bool)
            redirect('c_erreur/page_interdite', 'refresh');
        
    }
    
    private function getTabInfoSD(M_Situation $sd){
        if ($sd->get('tel_detecteur') != '')
            $tel = ' (' . $sd->get('tel_detecteur') . ')' ;
        else
            $tel = '';
        $array = array(
                'Nom détecteur' => $sd->get('lib_detecteur') . $tel,
                'Site concerné' => $sd->get('lib_site'),
                'Domaine concerné' => $sd->get('lib_domaine'),
                'Libellé SD' => $sd->get('libelle'),
                'Date création' => $sd->get('date_creation_fr'),
                'Description' => nl2br($sd->get('description'))
            );
        $s = form_array_row_label($array);
        return $s;
    }
    
    private function chargerDescription(M_Situation $sd) {
        $img_path_download = '<img src="'.APPLICATION_URI . '/web/img/picto_pagination_bas.png"/>';
        $desc = '<div class="parti_gauche">';
        $desc .= $this->getTabInfoSD($sd);
        $desc .= '</div>';
        $bool_detecteur = ($sd->get('piecejointe') != '');
        $path_img_detect = ($bool_detecteur)?APPLICATION_URI . '/web/files/img_situation_n_'. $sd->get('identifiant') .'_'. $sd->get('piecejointe'):'' ;
        if ($bool_detecteur) {
            $desc .= '<div class="parti_droite" id="div_piecejointe">';
            $desc .= '<div class="bloc light-green-white div_piecejointe">';
            $desc .= '<h2><a href="'.$path_img_detect.'" download>Télécharger la photo</a></h2>';
            $desc .= '<div><a href="'.$path_img_detect.'" download>
                <img alt="Aucune pièce jointe" src="'.$path_img_detect.'" id="img_piecejointe" />
                    </a></div></div></div>';
        } 
        
//        $bool_cdt = ($sd->get('piecejointe_cdt') != '');
//        $path_img_cdt = ($bool_cdt)?APPLICATION_URI . '/web/files/img_situation_n_'. $sd->get('identifiant') .'_cdt_'. $sd->get('piecejointe_cdt'):'' ;
//        if ($bool_cdt) {
//            $desc .= '<div class="bloc light-green-white div_piecejointe">';
//            $desc .= '<h2 class="affichage_accordeon">PiÃ¨ce jointe du chargÃ© de traitement <a href="'.$path_img_cdt.'" download>'.$img_path_download.'</a></h2>';
//            $desc .= '<div><a href="'.$path_img_cdt.'" download>
//                <img alt="Aucune pièce jointe" src="'.$path_img_cdt.'" id="img_piecejointe" />
//                    </a></div></div>';
//        } 
        
        return $desc;
    }
    
}
?>
