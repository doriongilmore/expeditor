<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller']  = "accueil";

$route['authentification']  = "accueil/authentification";
$route['habilitation']  = "admin/habilitations";
$route['affect']  = "admin/affectations";
$route['affecter/(:any)']  = "admin/affecter/$1";
$route['supprAffect/(:any)/(:any)']  = "admin/supprimerAffectation/$1/$2";

$route['formulaire']  = "c_situation/creation";
$route['liste_d']  = "c_situation/liste";
$route['liste_c']  = "c_situation/liste_cdt";

$route['traitementS/(:any)']  = "c_situation/traitementSearchList/$1";
$route['traitementC/(:any)']  = "c_situation/traitementClassicList/$1";
//$route['traitement/(:any)']  = "c_situation/traitement/$1";
$route['visionner/(:any)']  = "c_situation/visionner/$1";
$route['modifier/(:any)']  = "c_situation/modifier/$1";
$route['messCreation/(:any)']  = "c_situation/messCreation/$1";
$route['supprSD/(:any)']  = "c_situation/supprimer/$1";

$route['filtreSituation']  = "c_situation/filtrer";
$route['search']  = "c_situation/rechercher";
$route['export']  = "c_situation/export";
$route['export/(:any)']  = "c_situation/export/$1";
$route['exportManager']  = "c_situation/exportManager";
$route['statistiques']  = "c_situation/stats";




/* End of file routes.php */
/* Location: ./application/config/routes.php */