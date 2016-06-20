<?php 

Class M_Manager extends MY_Model 
{
    public function getSituationDangereuseByEmployeInf()
    {
        $this->load->model('table/m_bdsituation');
        $tabInf = $this->m_bdutilisateur->getNniInf($this->user->identifiant_actor);
        $tabInf[] = $this->user->identifiant_actor;
        
//        var_dump($tabInf);
//        echo '<br>';
//        echo '<br>';
//        echo '<br>';
//        var_dump($this->m_bdsituation->getSituationsByManageur($tabInf));
//        exit(0);
        return $this->m_bdsituation->getSituationsByManageur($tabInf);
    }
}
