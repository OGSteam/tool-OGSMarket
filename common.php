<?php
/***************************************************************************
*	filename	: common.php
*	desc.		:
*	Author		: Kyser - https://www.ogsteam.fr/
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
*  @link https://ogsteam.fr
*/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

 setlocale(LC_TIME, "fr_FR");

//Récupération des paramètres de connexion à la base de données
if (file_exists("parameters/id.php")) {
	require_once("parameters/id.php");
}

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


// Protection - Vérifier l'absence de code HTML dans les GET
foreach ($_GET as $k => $secvalue) {
    if (!check_getvalue($secvalue) && $k != 'message') {
        die ("I don't like you...");
    }
}

// Protection - Vérifier l'absence de code HTML dans les POST
foreach ($_POST as $secvalue) {
    if (!check_postvalue($secvalue)) {
        Header("Location: index.php");
        die();
    }
}

//Récupération des valeur GET, POST, COOKIE
extract($_REQUEST, EXTR_PREFIX_ALL|EXTR_REFS, 'pub');

//Connexion à la base de données et chargement des configurations
if (!defined("INSTALL_IN_PROGRESS")) {
    // appel de l instance en cours
    $db = sql_db::getInstance($db_host, $db_user, $db_password, $db_database);

    if (!$db->db_connect_id) {
        die("Impossible de se connecter à la base de données");
    }


	//Récupération et encodage de l'adresse ip
	$user_ip = encode_ip($_SERVER['REMOTE_ADDR']);

	// Chargement des config stockée en DB (Table_Config et Table_info)
	init_serverconfig();

	// Chargement des données stockées en COOKIE & SESSION
	if (isset($_COOKIE["ogsmarket_session"])) {
		$user_data = $Users->init_user();
	}

	if (isset($_COOKIE["ogsmarket_uni"])) {
		$current_uni = $Universes->get_universe($_COOKIE["ogsmarket_uni"]);
	}
	else {
		list($min_id) = $db->sql_fetch_row($db->sql_query("SELECT MIN(id) FROM ".TABLE_UNIVERS));
		if (!empty($min_id)) {
			$current_uni = $Universes->get_universe($min_id);
		}
	}
}
