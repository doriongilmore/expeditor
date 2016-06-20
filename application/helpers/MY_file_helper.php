<?php
/**
 * Description of MY_file_helper
 * date 22 juil. 2011
 */

/**
 * Fonction qui permet d'envoyer en download des chaines ou des fichiers au
 * client en fournissant les données à envoyer et éventuellement un nom.
 * Si aucun nom, le nom du fichier sera utilisé comme nom de fichier.
 * Si $datas est une chaine et que $fileName n'existe pas, le nom de la page sera utilisé.
 *
 * @param Mixed $datas Les données à anvoyer sous forme de chaine ou de fichier.
 * @param String $fileName Le nom de fichier à associer à $datas.
 */
function send_file($datas, $fileName = '')
{
  if ( ! $fileName)
    $fileName = $datas;

  if (is_file($datas))
    $datas = file_get_contents($datas);
  
  $CI =& get_instance();
  $CI->load->helper('download');
  force_download($fileName, $datas);
}