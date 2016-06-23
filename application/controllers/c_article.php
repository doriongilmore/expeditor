<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Article extends MY_Controller {

	public function affichage()
	{
//            $this->load->model('simple/M_Utilisateur');
//            $u = $this->M_Utilisateur->getById(1);
            $this->load->model('simple/M_Article');
            $u = $this->M_Article->getAll();
            $this->data['articles'] = $u;
            $this->_loadView('manager/affichage_article');
	}
        
        public function btn_supprimer()
        {
            $this->load->model('simple/M_Article');
            $this->M_Article->delete($_GET['id']);
            $this->data['message']['valid'] = "OK";
            redirect('c_article/affichage');
        }
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */