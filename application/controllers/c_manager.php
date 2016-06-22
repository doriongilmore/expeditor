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
	public function index()
	{
            $this->load->view('welcome_message');
	}
        
        public function affichageCommande()
	{
//            $this->load->model('simple/M_Utilisateur');
//            $u = $this->M_Utilisateur->getById(1);
            $this->load->model('simple/M_Commandes');
            
            $this->data['commande'] = $this->M_Commandes->getFirstCommande();
            //$this->data['commandes'] = $this->MCommandes->getyId($id);
            $this->data['client'] = $this->data['commande']->get('client');
            $this->data['lignes'] = $this->data['commande']->get('lignes_commande');
            $this->_loadView('manager/affichage_commande');
	}
        
        public function affichageStatistique()
	{
//            $this->load->model('simple/M_Utilisateur');
//            $u = $this->M_Utilisateur->getById(1);
            $this->load->model('simple/M_Utilisateur');
            $this->load->model('simple/M_Commandes');
            
            $this->data['commandes'] = $this->M_Commandes->getAllNonTraitee();
            $this->data['statistique'] = $this->M_Utilisateur->getAllStatCommande();
                    
            $this->_loadView('manager/affichage_principale');
	}
        
        
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */