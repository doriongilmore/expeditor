<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Gestion_Employe extends MY_Controller {

	public function affichage()
	{
//            $this->load->model('simple/M_Utilisateur');
//            $u = $this->M_Utilisateur->getById(1);
            $this->load->model('simple/M_Utilisateur');
            $u = $this->M_Utilisateur->getAll();
            $this->data['employes'] = $u;
            $this->_loadView('manager/gestion_employe');
	}
        
        public function btn_supprimer()
        {
            $this->load->model('simple/M_Utilisateur');
            $this->M_Utilisateur->delete($_GET['id']);
            $this->data['message']['valid'] = "OK";
            redirect('c_gestion_employe/affichage');
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */