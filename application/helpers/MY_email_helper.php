<?php  

function mailtoUser(M_Situation $sd){
    
    $pied_de_page = '<br/><br/>Merci de ne pas r&eacute;pondre &agrave; ce message, envoy&eacute; automatiquement par l&#146;application Eclat.<br/>
En cas de probl&egrave;me avec l&#146;application Eclat, vous pouvez vous adresser &agrave; l&#146;&eacute;quipe SI via cette boite aux lettres : <a href="mailto:DC-DP_P-DVOUEST-MCO-DEV/F/EDF/FR">DC-DP_P-DVOUEST-MCO-DEV</a>';
    
    switch ($sd->get('id_etat')) {
        case '1': // SD vient d'être créée
            $detecteur = $sd->get('detecteur');
            
            // Envoyer un mail aux cdt affectés au site où la SD est déclarée.            
            $subject = 'Alerte : nouvelle situation dangereuse sur le site de '.$sd->get('lib_site') . '.';
            $message = 'Bonjour,<br/><b><font color="red">' . $detecteur->nom . ' ' . $detecteur->prenom . ' a d&eacute;tect&eacute; le '.$sd->get('date_creation_fr').' 
                une situation dangereuse dont l&#146;objet est : '.$sd->get('libelle').'</font></b><br/><br/>
                Pour consulter et traiter cette alerte, veuillez vous rendre sur le site Eclat &agrave; cette adresse : <font color="blue"><a href="' . APPLICATION_URI . '/traitementC/'.$sd->get('identifiant') .'">Application Eclat</a></font>' ;
            $message .= $pied_de_page;     
            $site = $sd->get('id_site');
            $cdts = $sd->getCdtBySite($site, false) ;
            $users = '';
            foreach ($cdts as $key => $cdt) {
                $users .= $cdt->mail; 
                if ($key != count($cdts)-1)
                    $users .= ', ';
            }
            $bool = send_mail($users, $subject, $message);

            
            // Envoyer un mail au détecteur ayant déclaré la SD
            $user = $detecteur->mail;
            $subject = 'Vous venez de declarer une situation dangereuse sur le site de '.$sd->get('lib_site') . '.';
            
            $message = '<font color="red">100% Prévention</font><br/>'
                    . 'Vous venez de détecter une situation à risque.<br/>'
                    . '<b>Merci !</b> Vous êtes un acteur dynamique de l\'<b>A</b>mbition <b>Z</b>éro <b>A</b>ccident d\'EDF Commerce Ouest.<br/>'
                    . '<i><b>E</b>nsemble <b>C</b>ontre <b>L</b>es <b>A</b>ccidents du <b>T</b>ravail</i>';
//            $message .= $pied_de_page;     
            
            $bool = send_mail($user, $subject, $message);
            
            break;
            
        case '2': // SD vient d'être prise en compte
            $cdt = $sd->get('cdt_prisencompte');
            
            $subject = 'La situation dangereuse que vous avez signalee sur le site de '.$sd->get('lib_site') .' a ete prise en compte.';
            $message = 'Bonjour,<br/><b><font color="red">'.$cdt->nom.' '.$cdt->prenom.' a pris en compte le '.$sd->get('date_priseencompte_fr').' 
                la situation dangereuse suivante : '.$sd->get('libelle').'</font></b><br/><br/>
                Pour consulter l&#146;avancement dans le traitement de cette alerte, veuillez vous rendre sur le site Eclat &agrave; cette adresse : <font color="blue"><a href="' . APPLICATION_URI . '/visionner/'.$sd->get('identifiant') .'">Application Eclat</a></font>' ;
            $message .= $pied_de_page;
            
            $user = $sd->get('detecteur')->mail;
            $bool = send_mail($user, ($subject), ($message));
//            $bool = send_mail($user, utf8_decode($subject), utf8_decode($message));
            break;
        case '3': // SD vient d'être cloturée
            $cdt = $sd->get('cdt_cloture');
            $subject = 'La situation dangereuse que vous avez signalee sur le site de '.$sd->get('lib_site') .' a ete traitee.';
            $message = 'Bonjour,<br/><b><font color="red">'.$cdt->nom.' '.$cdt->prenom.' a termin&eacute; le traitement de la situation dangereuse suivante : '.$sd->get('libelle').'</font></b><br/><br/>
                Pour consulter l&#146;historique de cette alerte, veuillez vous rendre sur le site Eclat &agrave; cette adresse : <font color="blue"><a href="' . APPLICATION_URI . '/visionner/'.$sd->get('identifiant') .'">Application Eclat</a></font>' ;
            $message .= $pied_de_page;
            $user = $sd->get('detecteur')->mail;
            $bool = send_mail($user, ($subject), ($message));
//            $bool = send_mail($user, utf8_decode($subject), utf8_decode($message));
            break;
    }

    return $bool;
    
}


function send_mail($to, $subject, $message, $additional_headers = null, $additional_parameters = null){
    $headers =  'Content-type: text/html; charset=utf-8'. "\r" ;
    $headers .=  'From: application.eclat@edf.fr'. "\r"  ;
    $headers .=  'Reply-To: DC-DP_P-DVOUEST-MCO-DEV@edf.fr' ; //. "\r\n";
    if (ENVIRONMENT == 'development')
        $to = MAIL_DEV;
    
    if (!is_null($to) && $to != '') {
        return mail($to, $subject, $message, $headers);
    }
    
    return false;
}




/* End of file MY_email_helper.php */
/* Location: ./application/helpers/MY_email_helper.php */