<?php

class admin extends MY_Controller
{
    public function __construct() {
        parent::__construct();
        
        if (!$this->user->checkProfil(PROFIL_ADMIN)) 
            redirect('c_erreur/page_interdite', 'refresh');
    }
    
    public function habilitations()
    {
        $this->load->model('simple/m_utilisateur');
        $this->data['affHab'] = "invisible";
        
        if(isset($_POST['user']))
        {
            $this->data['idUser'] = $_POST['user'];
            $this->data['affHab'] = "";
            if(isset($_POST['enregistrer']))
            {
                try
                {
                    $this->m_utilisateur->enregistrerHabilitaion($_POST);
//                    $this->data['affHab'] = "invisible"; Si on souhaite vider les champ après enregistrement
//                    $this->form_validation->clearDatas(); Si on souhaite vider les champ après enregistrement
                    $this->data['valid'] = $this->message['valid']['modifUser'];
                } 
                catch (Exception $e)
                {
                    $this->data['error'] = $this->message['error']['modifUser'];
                }
            }
        }
        $this->data['tab_habilitation'] = $this->m_utilisateur->getHabilitation($_POST['user']);
        
        $this->_loadView('admin/habilitation');
    }
  
    public function affectations(){
        $this->load->model('simple/m_situation');
        $this->load->helper('table_helper');
        $this->data['arr_data'] = $this->m_situation->getNbCdtBySite();
        $this->data['lien'] = '/affecter';
        
        $this->_loadView('admin/affectations');
    }
    
    public function affecter($id_site){
        $this->load->model('simple/m_situation');
        $this->load->model('simple/m_utilisateur');
        $this->load->model('table/m_bdutilisateur');
        $this->load->helper('table_helper');
        $this->data['lib_site'] = $this->m_bdutilisateur->getLibSite($id_site);
        $this->data['id_site'] = $id_site;
        
        if (isset($_POST['retour_liste'])) {
            redirect('affect', 'refresh');
        }
        
        if ($_POST['cdt'] != '') {
            if ($this->m_utilisateur->checkAffectation($_POST['cdt'], $id_site)){
                $res = $this->m_utilisateur->affecterCdt($_POST['cdt'], $id_site);
                if ($res)
                    $this->data['valid'] = $this->message['valid']['affectUser'];
                else
                    $this->data['error'] = $this->message['error']['affectUser'];
            }else{
                $this->data['error'] = $this->message['error']['alreadyAffect'];
            }
        }
        $this->data['arr_data'] = $this->m_situation->getCdtBySite($id_site, false);
        
        $this->_loadView('admin/modif_affectation');
    }
    
    public function supprimerAffectation($id_site, $id_actor) {
        if (empty($_POST)) {
            $this->_loadView('admin/v_suppression');
        }
        else{
            if (isset($_POST['supprCanceled'])) {
                redirect('affecter/'.$id_site, 'refresh');
            }
            else if (isset($_POST['supprFinale'])) {
                $this->load->model('table/m_bdutilisateur');
                if ($this->m_bdutilisateur->supprimerAffectation($id_actor, $id_site))
                    $this->data['valid'] = $this->message['valid']['supprAffect'];
                else
                    $this->data['error'] = $this->message['error']['supprAffect'];
                
                $this->affecter($id_site);
            }
        }
        
    }
    
    
}  