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
            $this->data['client'] = $this->data['commande']->get('client');
            $this->data['lignes'] = $this->data['commande']->get('lignes_commande');
            $this->_loadView('article/affichage_commande_manager');
	}
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */