<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_Employe extends MY_Controller {

	public function affichage()
	{
            $this->load->model('simple/M_Commandes');
            
            if (!empty($_POST)) {
                $bool = true;
                $this->load->model('simple/M_Ligne_Commandes');
                $commande = $this->M_Commandes->getById($_POST['id_commande']);
                $commande->set('id_etat', ETAT_TERMINE);
                if($this->M_Commandes->update($commande)){
                    foreach ($_POST['id_ligne_commande'] as $i => $id_ligne_commande) {
                        $ligne = $this->M_Ligne_Commandes->getById($id_ligne_commande);
                        $ligne->set('quantite_reelle', $_POST['qte_reelle'][$i]);
                        $bool = $bool && $this->M_Ligne_Commandes->update($ligne);

                    }
                    if ($bool){
                        $this->data['message']['valid'] = 'La commande est bien enregistrée';
                    }else{
                        $this->data['message']['info'] = 'Au moins une ligne n\'a pas été enregistrée. (Aucune modification) ';
                    }
                }
            }
            $this->data['commande'] = $this->M_Commandes->getCommandeATraiter();
            $_SESSION['id_commande_en_cours'] = $this->data['commande']->get('id_commande');
            $this->data['client'] = $this->data['commande']->get('client');
            $this->data['lignes'] = $this->data['commande']->get('lignes_commande');
            
            $this->_loadView('employe/affichage_commande');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */