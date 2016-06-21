<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Employe extends MY_Controller {

	public function affichage()
	{
//            $this->load->model('simple/M_Utilisateur');
//            $u = $this->M_Utilisateur->getById(1);
            $this->load->model('simple/M_Commandes');
//            $u = $this->M_Commandes->getById(1);
            
            $this->_loadView('employe/affichage_commande');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */