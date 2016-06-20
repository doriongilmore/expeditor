<?php

function initMessage()
{
//    $message['valid']['crea_demande'] = 'Demande créée avec succès.';
    $message['valid']['import'] = 'Import du fichier réussi.';
    $message['valid']['limite_100'] = 'Le nombre de résultats affichés est limités à 100.';
    $message['valid']['creeUser'] = 'L\'utilisateur à bien été créé.';
    $message['valid']['modifUser'] = 'L\'utilisateur à bien été modifié.';
    $message['valid']['affectUser'] = 'L\'utilisateur à bien été affecté à ce site.';
    $message['valid']['supprAffect'] = 'L\'affectation de cet utilisateur a bien été supprimée sur ce site.';
    
    $message['valid']['majSD'] = 'La fiche a bien été mise à jour.';
    $message['valid']['creationSD'] = 'La fiche a bien été prise en compte.';
    $message['valid']['updateSD'] = 'La fiche a bien été mise à jour.';
    
    $message['error']['creeUser'] = 'La création de l\'utilisateur est impossible.';
    $message['error']['modifUser'] = 'La modification de l\'utilisateur est impossible.';
    $message['error']['affectUser'] = 'L\'affectation de cet utilisateur est impossible.';
    $message['error']['alreadyAffect'] = 'Cet utilisateur est déjà affecté à ce site.';
    $message['error']['supprAffect'] = 'Affectation introuvable.';
    $message['error']['nom_de_fichier'] = 'Le nom du fichier que vous voulez importer est incorrect';
    $message['error']['champ_non_renseigne'] = 'Les champs nécessaires pour remplir la base de données ne sont pas renseignés dans le fichier.';
    $message['error']['fichier_vide'] = 'Le fichier que vous voulez importer est vide.';
    
    $message['error']['creationSD'] = 'La création de cette fiche est impossible.';
    $message['error']['updateSD'] = 'La mise à jour de cette fiche est impossible. (aucune modification effectuée)';
    
    $message['error']['test'] = 'Le fichier que vous avez fourni ne correspond pas aux exigences du fichier de configuration.<br />
                                           Vérifez les champs de votre fichier ainsi que la configuration existante pour ce type d\'import.';
    
    
    
    $message['info']['aucuneSD'] = 'Il n\'y a aucune SD à afficher ou le filtre est trop restrictif.';
    $message['info']['no_affectation'] = 'Vous n\'êtes affecté à aucun site.';
    $message['info']['no_sd_cdt'] = 'Aucune SD n\'est à traiter sur l\'un de vos sites.';
    $message['info']['no_sd_user'] = 'Vous n\'avez jamais déclaré de situation dangereuse.';
    
    
//    $message['error'][''] = '';
//    $message['info'][''] = '';
    
    return $message;
}

?>