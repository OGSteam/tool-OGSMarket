<?php
/***************************************************************************
*	filename	: common.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 15/11/2005
*	modified	: 30/08/2006 00:00:00
***************************************************************************/
/**
* Common.php contient toute l'initialisation d'OGSMarket.
*  - Inclusion des diff&eacute;rents fichiers de fonctions du repertoire include
*  - Suppression des donn&eacute;es utilisateurs comprom&eacute;tantes
*  - Connection &agrave; la base de donn&eacute;e via l'initiation de $db
*  @package OGSMarket
*  @subpackage main
*  @author Kyser
*  @link http://ogsteam.fr
*/
if (!defined('IN_OGSMARKET')) die("Hacking attempt");

// PHP5 with register_long_arrays off?
if (!isset($HTTP_POST_VARS) && isset($_POST))
{
    $HTTP_POST_VARS = $_POST;
    $HTTP_GET_VARS = $_GET;
    $HTTP_SERVER_VARS = $_SERVER;
    $HTTP_COOKIE_VARS = $_COOKIE;
    $HTTP_ENV_VARS = $_ENV;
    $HTTP_POST_FILES = $_FILES;

    // _SESSION is the only superglobal which is conditionally set
    if (isset($_SESSION))
    {
        $HTTP_SESSION_VARS = $_SESSION;
    }
}

//Récupération des paramètres de connexion à la base de données
if (file_exists("parameters/id.php")) 
	require_once("parameters/id.php");

if (!defined("OGSMARKET_INSTALLED") && !defined("INSTALL_IN_PROGRESS") && !defined("UPGRADE_IN_PROGRESS")) {
	header("Location: install/index.php");
	exit();
}

//Appel des fonctions
require_once("includes/config.php");
require_once("includes/functions.php");
require_once("includes/mysql.php");
require_once("includes/univers.php");
require_once("includes/trade.php");
require_once("includes/user.php");
require_once("includes/modmarket.php");
require_once("includes/ogamecalc.php");

//Récupération des valeur GET, POST, COOKIE
@import_request_variables('GP', "pub_");

foreach ($_GET as $k => $secvalue) {
    if ( ! check_getvalue ( $secvalue ) && $k!='message' ) {
        die ("I don't like you...");
    }
}

foreach ($_POST as $secvalue) {
    if ( ! check_postvalue ( $secvalue ) ) {
        Header("Location: index.php");
        die();
    }
}

//Connexion &agrave; la base de donn&eacute;es
if (!defined("INSTALL_IN_PROGRESS") || defined("UPGRADE_IN_PROGRESS")) {
	$db = false;
	if (is_array($db_host)) {
		for ($i=0 ; $i<sizeof($db_host) ; $i++) {
			$db = new sql_db($db_host[$i], $db_user[$i], $db_password[$i], $db_database[$i]);
			if ($db->db_connect_id) {
				break;
			}
		}
	}
	else {
		$db = new sql_db($db_host, $db_user, $db_password, $db_database);
	}

	if (!$db->db_connect_id) {
		die("".$LANG["common_impo"]."");
	}

	//R&eacute;cup&eacute;ration et encodage de l'adresse ip
	$user_ip = encode_ip($_SERVER['REMOTE_ADDR']);
	init_serverconfig();
	if(isset($_COOKIE["ogsmarket_session"]))
		$user_data = $Users->init_user();
	if(isset($_COOKIE["ogsmarket_uni"])) 
		$current_uni = $Universes->get_universe($_COOKIE["ogsmarket_uni"]);
	else {
		list($min_id) = $db->sql_fetch_row($db->sql_query("SELECT MIN(id) FROM ".TABLE_UNIVERS));
		if (!empty($min_id)) $current_uni = $Universes->get_universe($min_id);
	}
}
?>
