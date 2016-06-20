<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['ldap'] = array(

	'servers' 			=> array('recette-ldap-gardian.edf.fr', 'cla-gardiansesame.edf.fr'),
	'bind_dn'			=> "uid=9TSLQ001,ou=Applis,dc=gardiansesame",
	'bind_pwd'			=> "Mmdp-3325"

    /**
     * Uri for a connection to the main LDAP server
     */
//    'MAIN_SERVER'      => 'ldaps://cla-gardiansesame.edf.fr',

    /**
     * Uri for a connection to the emergency LDAP server
     */
//    'EMERGENCY_SERVER' => '',

    /**
     * DN (Distinguish Name)of the software account for connecting the LDAP server
     */
//    'APP_USER'         => 'uid=9TPOE001,ou=Applis,dc=gardiansesame',

    /**
     * Password of the software account for connecting the LDAP server
     */
//    'APP_PWD'          => 'riL*3hxdXmxA',

     /**
      * Base pour l'authentification user.
      */
//    'DN_BASE'          => 'ou=People,dc=gardiansesame',

);