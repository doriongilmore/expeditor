<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Manager extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

    public function affichageCommande($id)
    {
        $this->load->model('simple/M_Commandes');

        //$this->data['commande'] = $this->M_Commandes->getFirstCommande();
        $this->data['commandes'] = $this->M_Commandes->getById($id);
        $this->data['client'] = $this->data['commandes']->get('client');
        $this->data['lignes'] = $this->data['commandes']->get('lignes_commande');
        $this->_loadView('manager/affichage_commande');
    }

    public function affichageStatistique()
    {
        $this->load->model('simple/M_Utilisateur');
        $this->load->model('simple/M_Commandes');

        $this->data['commandes'] = $this->M_Commandes->getAllNonTraitee();
        $this->data['statistique'] = $this->M_Utilisateur->getAllStatCommande();

        $this->_loadView('manager/affichage_principale');
    }

    function importer_fichier_temporaire($document)
    {
        $tmp_filename = str_replace(array('(',')',' '),array('','','_'),convert_accented_characters($_POST['_'.$document])) ;

        $upload_path = './web/files/';
        $config['file_name'] = $tmp_filename;
        $config['remove_spaces'] = TRUE;
        $config['overwrite'] = TRUE;
        $config['upload_path'] = './web/files/temp/';
        $config['allowed_types'] = 'xls|xlsm|xlsx|xlsxm|csv';
        
        $this->load->library('upload', $config);
        
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
    
    
    function importer_fichier($document, $id, $traitement = false)
    {
        $document = str_replace(array('(',')',' '),array('','','_'),convert_accented_characters($document)) ;
        
        
        $tmp = './web/files/temp/'.($document);
        $upload_path = './web/files/'.($document);
        $bool_copy = copy($tmp, $upload_path);

        if(file_exists($tmp))//si le fichier existe on le supprime
            unlink($tmp);//suppression du fichier
        
        return $document;
    }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */