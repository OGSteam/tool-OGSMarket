<?php
/***********************************************************************
 * filename	:	index.php
 * desc.	:	Fichier principal
 * created	: 	05/06/2006 ericalens
 *
 * *********************************************************************/

define("IN_OGSMARKET", true);
//define("MODE_DEBUG", true);

session_start();

require_once("common.php");

$php_start = benchmark();
$sql_timing = 0;

if (defined("MODE_DEBUG")) require_once("views/debug.php");

if (!isset($pub_action)) {
	$pub_action = "";
}

switch ($pub_action) {
	//mod market
	case "market_create":
		market_create();
		break;

	//utilisateur
	case "inscription":
		require_once("views/inscription.php");
		break;

	case "newaccount":
		$result = $Users->newaccount($pub_password, $pub_name, $pub_repassword, $pub_email, $pub_pm_link, $pub_irc_nick, $pub_note, $pub_active);
		if ($result !== true) {
			$pub_info = $result;
			include("views/inscription.php");
		} else {
			$message = "Merci de vous être inscrit sur notre server OGSMarket.
			<br>Il se peut que votre compte ne soit pas activé, si c'est le cas, merci de contacter l'administrateur.";
			require_once("views/message.php");
		}
		break;

	case "login":
		if ($Users->login($pub_name, $pub_password)) {
			redirection("index.php");
		} else {
			unset($_SESSION["username"]);
			unset($_SESSION["userpass"]);
			$message = "<span  style=\"color: yellow; font-size: medium; \"><b>L'identifiant ou le mot de passe saisi est invalide</b></span>";
			require_once("views/message.php");
		}
		break;
		
	case "profile":
		require_once("views/profile.php");
		break;
		
	case "set_profile" :
		$Users->set_profile($pub_email, $pub_pm_link, $pub_irc_nick, $pub_avatar_link, $pub_alert_mail, $pub_skin, $pub_note, $pub_modepq, $pub_deliver, $pub_refunding);
		break;
		
	case "logout":
		$Users->logout();
		redirection("index.php");
	break;
	
	case "change_uni":
		if (isset($pub_uni))
			$Universes->init_current_uni();
		redirection("index.php?action=listtrade");
	break;

	//autres
	case "rss":
		require_once("views/rss.php");
		break;
	
	case "FAQ":
		require_once("views/FAQ.php");
		break;

	case "contributeur":
		require_once("views/contributeur.php");
		break;
	
	//xml
	case "listtradexml":
		$sub = "trade";
		require_once("views/xml.php");
		break;

	case "listuniversexml":
		$sub = "univers";
		require_once("views/xml.php");
		break;

	case "pingxml":
		$sub = "ping";
		require_once("views/xml.php");
		break;

	//trades
	case "listtrade":
		require_once("views/listtrade.php");
		break;
	
	case "newtrade":
		$value = "Creer";
		require_once("views/trade.php");
		break;
		
	case "modifytrade":
		$value = "Modifier";
		require_once("views/trade.php");
		break;

	case "closetrade":
		$message = close_trade($pub_tradeid);
		$retour = "index.php?action=listtrade";
		require_once("views/message.php");
		break;
	case "closedtrades":
			require_once("views/closedtrades.php");
	break;

    case "deletetrade":
        $message = delete_trade($pub_tradeid);
        $retour = "index.php?action=closedtrades";
        require_once("views/message.php");
        break;
	
	case "upd_trade":
		$message = update_trade();
		$retour = "index.php?action=listtrade&subaction=usertrades";
		require_once("views/message.php");
		break;
		
	case "reactive_trade":
		$message = reactive_trade($pub_id);
		$retour = "index.php?action=listtrade";
		require_once("views/message.php");
		break;
		
	case "addtrade":
		$message = add_trade();
		$retour = "index.php?action=listtrade";
		include "./views/message.php";
		break;

	case "betontrade":
		$message = beton_trade($pub_tradeid);
		$retour = "index.php?action=listtrade";
		include "./views/message.php";
		break;
		
	case "unbetontrade":
		$message = unbeton_trade($pub_tradeid);
		$retour = "index.php?action=listtrade";
		include "./views/message.php";
		break;

	//Convertisseur de ressources
	case "Convertisseur":
		require_once("views/convertisseur.php");
		break;

	//admin
	case "admin":
		require_once("views/admin.php");
		break;
	
	case "admin_new_univers_execute":
		$message = $Universes->insert_new($pub_info, $pub_name, $pub_g);
		$retour = "index.php?action=admin&subaction=uni";
		require_once("views/message.php");
		break;
		
	case "admin_edit_univers_execute":
		$message = $Universes->edit_universe($pub_id, $pub_info, $pub_name, $pub_g);
		$retour = "index.php?action=admin&subaction=uni";
		require_once("views/message.php");
		break;

	case "admin_delete_univers":
		$message = $Universes->delete_universe($pub_universeid);
		$retour = "index.php?action=admin&subaction=uni";
		require_once("views/message.php");
		break;

	case "admin_delete_user":
		$message = $Users->delete_account($pub_user_id);
		$retour = "index.php?action=admin&subaction=members";
		require_once("views/message.php");
		break;

	case "admin_set_active":
		$message = $Users->set_active($pub_user_id);
		$retour = "index.php?action=admin&subaction=members";
		require_once("views/message.php");
		break;

	case "admin_unset_active":
		$message = $Users->unset_active($pub_user_id);
		$retour = "index.php?action=admin&subaction=members";
		require_once("views/message.php");
		break;

	case "admin_set_admin":
		$message = $Users->set_admin($pub_user_id);
		$retour = "index.php?action=admin&subaction=members";
		require_once("views/message.php");
		break;

	case "admin_unset_admin":
		$message = $Users->unset_admin($pub_user_id);
		$retour = "index.php?action=admin&subaction=members";
		require_once("views/message.php");
		break;

	case "admin_set_moderator":
		$message = $Users->set_moderator($pub_user_id);
		$retour = "index.php?action=admin&subaction=members";
		require_once("views/message.php");
		break;

	case "admin_unset_moderator":
		$message = $Users->unset_moderator($pub_user_id);
		$retour = "index.php?action=admin&subaction=members";
		require_once("views/message.php");
		break;
		
	case "admin_config_set" :
		$message = admin_config_set();
		$retour = "index.php?action=admin";
		require_once("views/message.php");
		break;
		
	case "admin_market_set" :
		$message = admin_market_set();
		$retour = "index.php?action=admin&subaction=trade";
		require_once("views/message.php");
		break;
	
	case "manque_info" :
		$message = "Il manque des informations!";
		if ($pub_goto != "") $retour = "index.php?action=".$pub_goto;
		require_once("views/message.php");
		break;
	
//page en défaut

	default:
		require_once("views/home.php");
		break;

}
