<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_situation
 *
 * @author e44575
 */
Class M_Situation extends MY_Model {
    
    private $identifiant = null;
    private $id_detecteur = null;
    private $id_site = null;
    private $id_domaine = null;
    private $libelle = null;
    private $description = null;
    private $piecejointe = null;
    private $piecejointe_cdt = null;
    private $date_creation = null;
    private $com_detecteur = null;
    private $date_priseencompte = null;
    private $id_prisencompte = null;
    private $com_traitement = null;
    private $date_cloture = null;
    private $id_cloture = null;
    private $etat = null;
    private $com_prevention = null;
    private $supprimer = null;
    private $id_supprimer = null;
    private $lecteur = null;


    public function __construct() {
        parent::__construct();
        $this->load->model('table/m_bddomaine');
        $this->load->model('table/m_bdsituation');
    }
    
    public function set($name, $value)
    {
        $this->load->model('simple/m_utilisateur', 'u');
        
        switch ($name) {
            case 'identifiant':
                $this->identifiant = $value;
                break;
            case 'id_detecteur':
                $this->id_detecteur = $value;
                break;
            case 'id_site':
                $this->id_site = $value;
                break;
            case 'id_domaine':
                $this->id_domaine = $value;
                break;
            case 'libelle':
                $this->libelle = $value;
                break;
            case 'description':
                $this->description = $value;
                break;
            case 'piecejointe':
                $this->piecejointe = $value;
                break;
            case 'piecejointe_cdt':
                $this->piecejointe_cdt = $value;
                break;
            case 'date_creation':
                $this->date_creation = $value;
                break;
            case 'com_detecteur':
                $this->com_detecteur = $value;
                break;
            case 'date_priseencompte':
                $this->date_priseencompte = $value;
                break;
            case 'id_prisencompte':
                $this->id_prisencompte = $value;
                break;
            case 'com_traitement':
                $this->com_traitement = $value;
                break;
            case 'date_cloture':
                $this->date_cloture = $value;
                break;
            case 'id_cloture':
                $this->id_cloture = $value;
                break;
            case 'etat':
                $this->etat = $value;
                break;
            case 'com_prevention':
                $this->com_prevention = $value;
                break;
            case 'supprimer':
                $this->supprimer = $value;
                break;
            case 'id_supprimer':
                $this->id_supprimer = $value;
                break;
            case 'lecteur':
                $this->lecteur = $value;
                break;
            default:
                break;
        }
    }
    
    public function get($name)
    {
        switch ($name) {
            case 'identifiant':
                return $this->identifiant;
                break;
//            case 'lib_detecteur':
//                return $this->u->getUnUtilisateur($this->id_detecteur)->libelle;
//                break;
            case 'lib_detecteur':
                $u = $this->u->getUnUtilisateur($this->id_detecteur);
                return $u->nom . ' ' . $u->prenom;
                break;
            case 'tel_detecteur':
                $tel = $this->u->getUnUtilisateur($this->id_detecteur)->telephone ;
                
                if ($tel == '')
                    return $tel ;
                
                return cTel($tel);
                break;
            case 'detecteur':
                return $this->u->getUnUtilisateur($this->id_detecteur);
                break;
            case 'id_site':
                return $this->id_site;
                break;
            case 'lib_site':
                $this->load->model('table/m_bdutilisateur');
                $r = $this->m_bdutilisateur->getLibSite($this->id_site);
                return $r;
                break;
            case 'id_domaine':
                return $this->id_domaine;
                break;
            case 'lib_domaine':
                $d = $this->m_bddomaine->getLibelleDomaineById($this->id_domaine);
                return $d;
                break;
            case 'libelle':
                return $this->libelle;
                break;
            case 'description':
                return $this->description;
                break;
            case 'piecejointe':
                return $this->piecejointe;
                break;
            case 'piecejointe_cdt':
                return $this->piecejointe_cdt;
                break;
            case 'date_creation_fr':
                return date_heureMinute_to_datetime($this->date_creation);
                break;
            case 'date_creation_sql':
                return $this->date_creation;
                break;
            case 'com_detecteur':
                return $this->com_detecteur;
                break;
            case 'date_priseencompte_fr':
                return date_heureMinute_to_datetime($this->date_priseencompte);
                break;
            case 'date_priseencompte_sql':
                return ($this->date_priseencompte);
                break;
            case 'cdt_prisencompte':
                if (is_null($this->id_prisencompte))
                    return null;
                return $this->u->getUnUtilisateur($this->id_prisencompte);
                break;
            case 'lib_cdt':
                $u = $this->u->getUnUtilisateur($this->id_prisencompte);
                return $u->nom . ' ' . $u->prenom;
                break;
            case 'com_traitement':
                return $this->com_traitement;
                break;
            case 'date_cloture_fr':
                return date_heureMinute_to_datetime($this->date_cloture);
                break;
            case 'date_cloture_sql':
                return ($this->date_cloture);
                break;
            case 'cdt_cloture':
                if (is_null($this->id_cloture))
                    return null;
                return $this->u->getUnUtilisateur($this->id_cloture);
                break;
            case 'lib_cdt_cloture':
                $u = $this->u->getUnUtilisateur($this->id_cloture);
                return $u->nom . ' ' . $u->prenom;
//                return $this->u->getUnUtilisateur($this->id_cloture)->libelle;
                break;
            case 'etat':
                return $this->getEtat($this->etat);
                break;
            case 'id_etat':
                return ($this->etat);
                break;
            case 'com_prevention':
                return ($this->com_prevention);
                break;
            case 'supprimer':
                return ($this->supprimer);
                break;
            case 'cdt_supprimer':
                if (is_null($this->id_supprimer))
                    return null;
                return $this->u->getUnUtilisateur($this->id_supprimer);
                break;
            case 'lecteur':
                if (is_null($this->lecteur))
                    return null;
                return $this->u->getUnUtilisateur($this->lecteur);
                break;
            default:
                break;
        }
    }
    
    /*
     * On initialise la situation a partir d'un tableau d'information passer en paramètre 
     */
    public function initialisation($tabInfo)
    {
        if (is_array($tabInfo)){
            $this->set('identifiant', $tabInfo['identifiant']);
            $this->set('id_detecteur', $tabInfo['id_detecteur']);
            $this->set('id_site', $tabInfo['id_site']);
            $this->set('id_domaine', $tabInfo['id_domaine']);
            $this->set('libelle', $tabInfo['libelle']);
            $this->set('description', $tabInfo['description']);
            $this->set('piecejointe', $tabInfo['piecejointe']);
            $this->set('piecejointe_cdt', $tabInfo['piecejointe_cdt']);
            if (!isset($tabInfo['date_creation']))
                $this->set('date_creation', date('Y-m-d H:i:s'));
            else
                $this->set('date_creation', $tabInfo['date_creation']);
            $this->set('com_detecteur', $tabInfo['com_detecteur']);
            $this->set('date_priseencompte', $tabInfo['date_priseencompte']);
            $this->set('id_prisencompte', $tabInfo['id_prisencompte']);
            $this->set('com_traitement', $tabInfo['com_traitement']);
            $this->set('date_cloture', $tabInfo['date_cloture']);
            $this->set('id_cloture', $tabInfo['id_cloture']);
            $this->set('etat', $tabInfo['etat']);
            $this->set('com_prevention', $tabInfo['com_prevention']);
            $this->set('supprimer', $tabInfo['supprimer']);
            $this->set('id_supprimer', $tabInfo['id_supprimer']);
            
        }else{
            $this->set('identifiant', $tabInfo->identifiant);
            $this->set('id_detecteur', $tabInfo->id_detecteur);
            $this->set('id_site', $tabInfo->id_site);
            $this->set('id_domaine', $tabInfo->id_domaine);
            $this->set('libelle', $tabInfo->libelle);
            $this->set('description', $tabInfo->description);
            $this->set('piecejointe', $tabInfo->piecejointe);
            $this->set('piecejointe_cdt', $tabInfo->piecejointe_cdt);
            if (!isset($tabInfo->date_creation))
                $this->set('date_creation', date('Y-m-d H:i:s'));
            else
                $this->set('date_creation', $tabInfo->date_creation);
            $this->set('com_detecteur', $tabInfo->com_detecteur);
            $this->set('date_priseencompte', $tabInfo->date_priseencompte);
            $this->set('id_prisencompte', $tabInfo->id_prisencompte);
            $this->set('com_traitement', $tabInfo->com_traitement);
            $this->set('date_cloture', $tabInfo->date_cloture);
            $this->set('id_cloture', $tabInfo->id_cloture);
            $this->set('etat', $tabInfo->etat);
            $this->set('com_prevention', $tabInfo->com_prevention);
            $this->set('supprimer', $tabInfo->supprimer);
            $this->set('id_supprimer', $tabInfo->id_supprimer);
            
        }
        return $this;
    }

    public function getAll(){
        $res = $this->m_bdsituation->getAll();
        return $res;
    }
    
    public function getById($id){
        $res = $this->m_bdsituation->getById($id);
        if (is_null($res))
            return null;
        $res = $this->initialisation($res);
        return $res;
    }
    
    public function chargerSD($id_sd) {
        $sd = $this->getById($id_sd);
        
        if ($sd->get('id_etat') != '3') { 
           // Si la SD n'est pas cloturée, elle est modifiable et doit être bloquée pour les autres utilisateurs
            $res = $this->m_bdsituation->chargerSD($id_sd);
            if ($res == false) { // bloquer la SD pour l'utilisateur connecté
                $this->m_bdsituation->bloquerSD($id_sd);
                $sd->set('lecteur', $this->user->identifiant_actor);
            }else{ // SD déjà bloquée par un autre utilisateur
                $sd->set('lecteur', $res->user);
            }
        }
        return $sd;
    }
    
    public function debloquerSD($id_sd) {
        $this->load->model('simple/m_utilisateur');
        $sd = $this->chargerSD($id_sd);
        $bool = false ;
        
        if (!is_null($sd->get('lecteur')) && $sd->get('lecteur')->identifiant_actor == $this->user->identifiant_actor)
            $bool = $this->m_bdsituation->debloquerSD($id_sd);

        if ($bool) 
            $sd->set('lecteur', null);
        
        return $sd;
    }
    
    
    
    
    public function getSituationsByIdDetecteur($id) {
        $res = $this->m_bdsituation->getSituationsByIdDetecteur($id);
        
        return $res ;
    }
    
    public function getNbCdtBySite($id) {
        $res = $this->m_bdsituation->getNbCdtBySite($id);
        
        return $res ;
    }
    
    public function getSituationsBySiteCdt($array_site) {
        $array_res = array();
        foreach ($array_site as $id)
            $array_res = array_merge($array_res, $this->m_bdsituation->getSituationsBySiteCdt($id->id_site));
        
        foreach ($array_res as $key => $value) {
            $tpsAlerte = (HORAIRE_FIN - HORAIRE_DEBUT) * 2 ;
            $tpsCreation = CalculHorraireCSIT(($value->date_timestamp), time()) ;
            if ($value->etat == 'Créée' && $tpsCreation > $tpsAlerte)
                    $value->color = "rouge";
            
            $value->date_creation = ($value->date_creation);
        }
        
        
        return $array_res ;
    }
    
    public function cree($tabInfo)
    {
        $this->load->helper('email');
        $this->initialisation($tabInfo);
        $this->set('etat', 1);
        $this->set('identifiant', $this->m_bdsituation->insert($this));
        
        return $this->get('identifiant');
    }
    
    public function getStatsDomaine($annee){
        $liste_couleur = array( "#FE5815","#FFA02F","#C4D600","#509E2F","#005BBB","#001A70","#000000",
                                "#9900CC","#00CCFF","#006633","#663300","#FF3300","#0033FF","#CCCCCC");
        $res =  $this->m_bdsituation->getStatsDomaine($annee);
        
        $array_libelles = array(); $cpt = 0 ;
        foreach ($res as $key=>$unDomaine) {
            $array_libelles[$cpt] = array(
                'title' => $unDomaine->libelle,
                'color' => $liste_couleur[$cpt],
                'value' => intval($unDomaine->nb),
                'identifiant' => $key
            );
            $cpt++;
        }
        return $array_libelles;
    }
    
    public function getStatsSites($annee) {
        $res =  $this->m_bdsituation->getStatsSite($annee);
        
        $cpt = 0;
        $array_sites = array();
        $array_totaux = array();
        $array_enCours = array();
        foreach ($res as $unSite) {
                $array_sites[$cpt] = $unSite->libelle;
                $array_totaux[$cpt] = intval($unSite->total);
                $array_enCours[$cpt] = intval($unSite->traite);
            $cpt++;
        }

        $array = array(
            'labels' => $array_sites,
            'datasets' => array(
                array (
                    'fillColor' => 'rgba(196,214,0,1)',
                    'highlightColor' => 'rgba(255,160,47,1)',
                    'strokeColor' => 'rgba(196,214,0,1)',
                    'data' => $array_totaux,
                    'title' => 'Nombre de SD détectées',
                    'labelColor' => 'rgba(196,214,0,1)'
                ),
                array (
                    'fillColor' => 'rgba(255,160,47,1)',
                    'highlightColor' => 'rgba(196,214,0,1)',
                    'strokeColor' => 'rgba(255,160,47,1)',
                    'data' => $array_enCours,
                    'title' => 'Nombre de SD clôturées',
                    'labelColor' => 'rgba(255,160,47,1)'
                )
                
            )
        );
        return $array ;
    }
    
    function importer_img_temp($document, $traitement = false)
    {
        $tmp_filename = str_replace(array('(',')',' '),array('','','_'),convert_accented_characters($_POST['_'.$document])) ;

        $upload_path = './web/files/';
        $config['file_name'] = $tmp_filename;
//        $config['remove_spaces'] = TRUE;
        $config['overwrite'] = TRUE;
        $config['upload_path'] = './web/files/temp/';
        $config['allowed_types'] = 'jpg|jpeg|jpe|gif|png|bmp|ico|svg|svgz|tif|tiff|ai|drw|pct|psp|xcf|psd|raw';
        
        if ($traitement)
            $config['allowed_types'] .= '|pdf|txt|doc|docm|docx|docxm|xls|xlsm|xlsx|xlsxm|ppt|pptx';
        
        $this->load->library('upload', $config);
        
//        if(file_exists($config['upload_path'].$_FILES[$document]['name']))//si le fichier existe on le supprime
//            unlink($config['upload_path'].$_FILES[$document]['name']);//suppression du fichier
//        $_FILES[$document]['name'] = 'img_situation_n_'.$id.'_'.$_FILES[$document]['name'];
        if ( ! $this->upload->do_upload($document)){
            $link1 = $config['upload_path'].$tmp_filename;
            $link2 = $upload_path.$tmp_filename;
            
            if(file_exists($link1) || file_exists($link2))
                    return true;
            throw new Exception($this->upload->display_errors());
        }
        else
            return true;//Chargement réussit
    }
    
    function importer_img($document, $id, $traitement = false)
    {
        $document = str_replace(array('(',')',' '),array('','','_'),convert_accented_characters($document)) ;
        
        
        $array = explode('_', $document);
        if ($array[0] == 'img')
            $name = $document; 
        else{
            if ($traitement)
                $name = 'img_situation_n_'.$id.'_cdt_'.$document ; 
            else
                $name = 'img_situation_n_'.$id.'_'.$document ; 
        }
        $tmp = './web/files/temp/'.($document);
        $upload_path = './web/files/'.($name);
        $bool_copy = copy($tmp, $upload_path);

        if(file_exists($tmp))//si le fichier existe on le supprime
            unlink($tmp);//suppression du fichier
    }
    
    public function update($data)
    {
        return $this->m_bdsituation->update($data);
    }
    
    public function supprimerPieceJointe($id_sd, $cdt = false){
        $sd = $this->getById($id_sd);
        if ($cdt)
            $sd->set('piecejointe_cdt', '');
        else
            $sd->set('piecejointe', '');
        $res = $this->update($sd);
        return $res;
    }
    
    private function getEtat($id) {
        switch ($id) {
            case '1':
                return 'créée par '.$this->get('lib_detecteur').' le '.$this->get('date_creation_fr');
                break;
            case '2':
                return 'prise en compte par '.$this->get('lib_cdt').' le '.$this->get('date_priseencompte_fr');
                break;
            case '3':
                return 'traitement terminé par '.$this->get('lib_cdt_cloture').' le '.$this->get('date_cloture_fr');
                break;
            default:
                break;
        }
    }
    
    public function etatSuivant($sd) {
        $this->load->helper('email');
        $u = $this->user;
        $etat = $sd->get('id_etat');
        $sd->set('etat', $etat + 1);
        switch ($etat) {
            case '1':
                $sd->set('date_priseencompte', date('Y-m-d H:i:s'));
                $sd->set('id_prisencompte', $u->identifiant_actor);
                if ($this->update($sd)){
                    mailtoUser($sd);
                    return true;
                }
                break;
            case '2':
                $sd->set('date_cloture', date('Y-m-d H:i:s'));
                $sd->set('id_cloture', $u->identifiant_actor);
                if ($this->update($sd)){
                    mailtoUser($sd);
                    return true;
                }
                break;
            default:
                break;
        }
        return false ;
    }
    
    public function getSituationsByFiltre() {
        $res = $this->m_bdsituation->getSituationsByFiltre();
        return $res;
    }
    
    private function getFilename($tmp_name){
        $array = explode('_', $tmp_name);
        $filename = ''; 
        if ($array[0] == 'img'){
            $start_index = ($array[4] == 'cdt')?5:4;
            for ($index = $start_index; $index < count($array); $index++) {
                if ($index != $start_index)
                    $filename .= '_';
                $filename .= $array[$index];
            }
        }
        else
            $filename = $tmp_name; 
        
        return str_replace(array('(',')',' '),array('','','_'),convert_accented_characters($filename)) ;
    }
    
    public function enregistrerSD(&$sd, $user, $type = 'maj') {
        $resultat = false ;
        $filename = $this->getFilename($_POST['_upload']); 
        switch ($user) {
            case 'user':
                
                if ($type == 'new'){
                    $tabInfo = array(
                        'id_detecteur'  => $this->user->identifiant_actor ,
                        'id_site'       => $_POST['lst_sites'] ,
                        'id_domaine'    => $_POST['lst_domaines'] ,
                        'libelle'       => $_POST['txt_libelle'] ,
                        'description'   => $_POST['txt_desc'] ,
                        'piecejointe'   => $filename
                    );
                        $id = $this->cree($tabInfo) ;
                        if ($id && $id > 0){
                            if (!is_null($_POST['_upload']) && ($_POST['_upload'] != '' ))
                                $this->importer_img($_POST['_upload'], $id);
                            
                            mailtoUser($this);
                            
                            return $id ;
                        }
                        else
                            throw new Exception('creationSD');
//                    }
                }else{
                    $sd->set( 'id_site', $_POST['lst_sites'] );
                    $sd->set( 'id_domaine', $_POST['lst_domaines'] );
                    $sd->set( 'libelle', $_POST['txt_libelle'] );
                    $sd->set( 'description', $_POST['txt_desc'] );
                    $sd->set( 'piecejointe', $filename );
                    if ($this->update($sd)){
                        $this->importer_img($_POST['_upload'], $sd->get('identifiant'));
                        $resultat = true;
                    }
                        
                }
                break;
            case 'cdt':
                $sd->set('com_detecteur', $_POST['txt_desc_detecteur']);
                $sd->set('com_traitement', $_POST['txt_desc_final']);
                $sd->set('com_prevention', $_POST['txt_desc_prevention']);
                $sd->set('piecejointe_cdt', $filename);
                
                
                if ($type == 'next') {
                    if ($this->etatSuivant($sd)) 
                        $resultat = true ;
                }
                else
                    if ($this->update($sd))
                        $resultat = true ;
                    
                    
                if ($resultat)
                    $this->importer_img($_POST['_upload'], $sd->get('identifiant'), true);
                
                break;
        }
        
        if ($resultat == true){
//            $this->load->helper('email');
//            mailtoUser($sd);
            return true ;
        }
        else
            throw new Exception('updateSD');
        return false;
    }
    
    public function getCdtBySite($id_site = null, $concat = true){
        $res = $this->m_bdsituation->getCdtBySite($id_site);
        
        if (!$concat)
            return $res;
        
        $array_res = array();
        foreach ($res as $key => $value) 
            $array_res[$value->id] = $value->libelle;
        return $array_res;
    }
    
    public function delete($sd) {
        $sd->set('supprimer', 1);
        $sd->set('id_supprimer', $this->user->identifiant_actor);
        return $this->update($sd);
    }
    
    public function getFilename_form($sd, $cdt = false) {
        $res = null;
        
//        if (isset($_FILES['upload']['name']) && $_FILES['upload']['name'] != '')
//            $res = $_FILES['upload']['name'];
//        
//        else if (isset($_POST['_upload']) && $_POST['_upload'] != '')
//            $res = $_POST['_upload'];
        if ($cdt){
            if ($sd->get('piecejointe_cdt') != '')
                $res = 'img_situation_n_' . $sd->get('identifiant') . '_cdt_' . $sd->get('piecejointe_cdt');
        }
        else
            if ($sd->get('piecejointe') != '')
                $res = 'img_situation_n_' . $sd->get('identifiant') . '_' . $sd->get('piecejointe');
        
            
        return $res;
    }
    
    public function getNbSdByAnnee($annee) {
        $res = $this->m_bdsituation->getNbSdByAnnee($annee) ;
        return $res;
    }
    
}

?>
