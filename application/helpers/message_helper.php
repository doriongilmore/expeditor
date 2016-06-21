<?php


function initMessage()
{
//    $message['valid']['crea_demande'] = 'Demande créée avec succès.';
    $message['valid']['creeCampagne'] = 'Votre campagne à été crée avec succès.';
    $message['valid']['affecterProspect'] = 'Les prospects ont été affectés avec succès.';
    $message['valid']['supprimerProspect'] = 'Les prospects ont été supprimés avec succès.';
    $message['valid']['habilitation'] = 'Les habilitations ont été enregistrées.';
    
    $message['info']['aucunProspect'] = 'Il n\'y a aucun prospect à afficher pour cette campagne ou le filtre est trop restrictif.';
    
    $message['error']['affecterProspect']['bdd'] = 'Une erreur est survenue lors de l\'affectation des prospects.';
    $message['error']['affecterProspect']['vendeur'] = "Veuillez sélectionner un vendeur pour lui affecter les prospects sélectionnés";
    $message['error']['affecterProspect']['prospects'] = "Veuillez sélectionner des prospects à affecter au vendeur sélectionné.";
    $message['error']['supprimerProspect']['prospects'] = "Veuillez sélectionner des prospects à supprimer.";
    $message['error']['supprimerProspect']['bdd'] = 'Une erreur est survenue lors de la suppression des prospects.';
    $message['error']['nom_de_fichier'] = 'Le nom du fichier que vous voulez importer est incorrect';
    
//    $message['error'][''] = '';
//    $message['info'][''] = '';
    
    return $message;
}