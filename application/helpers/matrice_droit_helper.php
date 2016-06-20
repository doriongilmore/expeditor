<?php
//Matrice de droit des utilisateur
/*
 * Exemple de config :
 * 
            case 'accueil':
                return true;
                break;
                
            case 'admin':
                switch ($uri[1])
                {
                    case 'v_calculMargeB':
                        if($profil->id_profil == PROFIL_MANAGER)
                            return true;
                        break;  
                    case 'v_calculDmc':
                        if($profil->id_profil == PROFIL_MANAGER)
                            return true;
                        break;  
                }
 * Fin de l'exemple
 */
function matrice_droit($view = null, $tab_profil = null)
{
//    $id_profil = $profil->id_profil;
    //Vérification des dates du profil
//    if(time() <= strtotime($profil->date_debut) || time() >= strtotime($profil->date_fin))
//        return false;
    if (ENVIRONMENT == 'development')
    return true;
    $uri = explode("/",$view);
    
//    var_dump($uri[0]);
    
    switch ($uri[0])
    {
            case 'v_error':
            case 'authentification':
            case 'accueil':
            case 'utilisateur':
                return true;
                break;
            case 'cdt':
                if(array_key_exists(PROFIL_CDT, $tab_profil))
                    if(time() >= strtotime($tab_profil[PROFIL_CDT]->date_debut) && time() <= strtotime($tab_profil[PROFIL_CDT]->date_fin))
                        return true;
                break;
            case 'expert':
                if(array_key_exists(PROFIL_EXPERT, $tab_profil))
                    if(time() >= strtotime($tab_profil[PROFIL_EXPERT]->date_debut) && time() <= strtotime($tab_profil[PROFIL_EXPERT]->date_fin))
                        return true;
                break;
            case 'manager':
                if(array_key_exists(PROFIL_MANAGER, $tab_profil))
                        return true;
                break;
            case 'admin':
                if(array_key_exists(PROFIL_ADMIN, $tab_profil))
                    if(time() >= strtotime($tab_profil[PROFIL_ADMIN]->date_debut) && time() <= strtotime($tab_profil[PROFIL_ADMIN]->date_fin))
                        return true;
                break;
    }
    return false ;
}
