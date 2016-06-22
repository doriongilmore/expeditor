<?php

/**
 * Description of ajax :
 * Controller dédié aux requêtes asynchrones de technologie AJAX.
 *
 * date 30 juin 2011
 */
class ajax extends MY_Controller {

    public $showAll = false;
    
    public function __construct() {
        parent::__construct();
        
        if (!$this->input->is_ajax_request())
            redirect('c_erreur/page_interdite', 'refresh');
    }
	
   
    public function cdtBySite($id_site) {
        if ($id_site == 0) 
            $id_site = null ;
        
        $this->load->model('table/m_bdsituation');
        $res = $this->m_bdsituation->getCdtBySite($id_site);
        $str = '';
        
        foreach ($res as $object) {
            $val = 'value="' . $object->id . '"';
            $str .= '<option ' . $val . ' >' . $object->libelle . '</option>';
        }
        
        echo $str;
    }

    public function debloquerSD($id_sd) {
        $this->load->model('simple/m_situation');
        $sd = $this->m_situation->debloquerSD($id_sd);
        if (is_null($sd->get('lecteur')))
            echo 'true';
        else
            echo 'false';
    }
    
    public function liberer($id_commande){
        $this->load->model('table/M_bdCommandes');
        $res = $this->M_bdCommandes->liberer($id_commande);
    }
    
}