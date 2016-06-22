<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Employe extends MY_Controller {

	public function affichage()
	{
            $this->load->model('simple/M_Commandes');
            
            $this->data['commande'] = $this->M_Commandes->getFirstCommande();
            $this->data['client'] = $this->data['commande']->get('client');
            $this->data['lignes'] = $this->data['commande']->get('lignes_commande');
            $this->_loadView('employe/affichage_commande');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */