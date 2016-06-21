<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Article extends MY_Controller {

	public function affichage()
	{
//            $this->load->model('simple/M_Utilisateur');
//            $u = $this->M_Utilisateur->getById(1);
            $this->load->model('simple/M_Article');
            $u = $this->M_Article->getAll();
            $this->data['articles'] = $u;
            $this->_loadView('article/affichage_article');
	}
        
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */