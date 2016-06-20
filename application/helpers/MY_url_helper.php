<?php
/**
 * Ajout de fonctions utiles qui étendent le helper URL de CI.
 * date 4 juil. 2011
 */

function current_url()
{
  $CI =& get_instance();
  return $CI->config->item('real_base_url').'/'.$CI->uri->uri_string().$CI->config->item('url_suffix');
}

/**
 * Prépare une chaine pour url en remplaçant les "-" par des "_".
 * Appelle le helper url_title.
 *
 * @param String $url La chaîne à tranformer
 * @param String $p1 cf param de url_title pour les underscores
 * @param Boolean $p2 cf param de url_title pour les majuscules
 * @return String
 */
function str2url($url, $p1 = 'underscore', $p2 = true)
{
  $url = str_replace('-', '_', convert_accented_characters($url));
  return url_title(cStr($url), $p1, $p2);
}

/**
 * Renvoie un lien formater pour un  utilisateur.
 * @param Integer $id l'identfiant BDD de l'utilisateur
 * @param String $lib le texte (nom prénom) représentant l'utilisateur
 * @param Boolean $img Si TRUE, le lien sera l'image loupe. si FALSE le lien portera sur $lib
 * @return String
 */
function user_anchor($id, $lib, $img = false)
{
  $txt = $img ? '<img src="/img/buttons/magnifier.gif" class="myPngFix" />' : ucwords(cStr($lib));

  $site_url = site_url('mouv/fiche_utilisateur/'.str2url($lib).'_'.$id);

  return '<a href="'.$site_url.'" title="Voir la fiche mouv de '.ucwords(cStr($lib)).'">'.$txt.'</a>';
}

/**
 * Renvoi un lien vers mappy pour les parmaètres donnés.
 *
 * @param String $adresse
 * @param String $codePostal
 * @param String $ville
 * @return String
 */
function mappy_url($adresse, $codePostal, $ville)
{
  $baseURL    = 'fr.mappy.com/new#/TSearch/';
  $URLparams  = 'S'.urlencode($adresse).'+'.urlencode($codePostal).'+'.urlencode($ville);

  return prep_url($baseURL.$URLparams);
}

/**
 * Renvoi un lien vers google maps pour les parmaètres donnés.
 *
 * @param String $adresse
 * @param String $codePostal
 * @param String $ville
 * @return String
 */
function google_maps_url($adresse, $codePostal, $ville)
{
  $baseURL    = 'maps.google.com/maps?';
  $URLparams  = 'q='.urlencode($adresse).'+'.urlencode($ville).'+'.substr($codePostal, 0, 2);

  return prep_url($baseURL.$URLparams);
}


/**
 * Mailto Link
 *
 * @access	public
 * @param	string	the email address
 * @param	string	the link title
 * @param	mixed	any attributes
 * @return	string
 */
function mailto($email, $title = '', $attributes = '')
{
  $mailtoMaxLength = 230;

  $title = (string) $title;

  if ($title == "")
  {
    $title = $email;
  }

  if (strlen($email) > $mailtoMaxLength)
    $attributes['class'] = isset($attributes['class']) ? $attributes['class'].' alt_mailto' : 'alt_mailto';

  $attributes = _parse_attributes($attributes);

  if (strlen($email) <= $mailtoMaxLength)
    return '<a href="mailto:'.$email.'"'.$attributes.'>'.$title.'</a>';
  else
    return '<a href="#"'.$attributes.'>'.$title.'</a>';
}


function url_segment($url, $segment_no = null)
{
  $CI =& get_instance();
  $CI->load->library('user_agent');

  $arrSegments    = explode('/', $url);
  $arrSegments[1] = $arrSegments[0];
  
  unset($arrSegments[0]);

  if ($segment_no && array_key_exists($segment_no, $arrSegments))
    return $arrSegments[$segment_no];
  elseif ( ! $segment_no)
    return $arrSegments;
  else
    return false;
}