<?php
/***************************************************************************
*	filename	: 	mail.php
*	desc.		:
*	Author		:	digiduck 
*	created		:	mardi 25 septembre 2007, 00:15:28 (UTC+0200)
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
require_once("includes/ogamecalc.php");

//Définition de l'environnement
setlocale(LC_TIME, "fr_FR.UTF8");

//Traitement du skin pour les mails d'alerte
$link_css = $user_data['skin'];

if ($link_css == ""){
	$link_css = $server_config['skin'];
}

if ($link_css == "skin/"){
	$link_css = "http://".$_SERVER['HTTP_HOST'].str_replace('index.php', '', $_SERVER['PHP_SELF']).$link_css;
}

// Mail Entete Commune
$headers ="From: ".$server_config["mail_nom_expediteur"]."<".$server_config["mail_expediteur"]."> \n";
$headers .="Reply-To: ".$server_config["mail_expediteur"]." \n";
$headers .="Content-Type: text/html; charset=\"utf-8\" \n";
$headers .="Content-Transfer-Encoding: 8bit";

// Mail Corps Commun
$message_mail = "<html><head>";
$message_mail .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$link_css."formate.css\" /></head>";
$message_mail .= "<body><center>";
$message_mail .= "<img src='";
$message_mail .= $server_config["logo_server"];
$message_mail .= "'/><br />";
$message_mail .= $server_config["mail_message"]."<br><br>";

switch ($alert){
// Mail Nouvelle Offre
	case "creer":
		$message_mail .= "<br><br><br>&nbsp;Une nouvelle offre viens d'&ecirc;tre ajout&eacute;e par ".$user_data['name']." sur ".$server_config["servername"]." : ".$current_uni["name"].".<br><br>";
		$message_mail .= "Il vous propose le march&eacute; suivant :<br><br><br><br><font size='5'> Une offre de ";
			if (intval($pub_offer_metal)>0) $message_mail .= " ".number_format(intval($pub_offer_metal), 0, ',', ' ')." k de M&eacute;tal ";
			if (intval($pub_offer_crystal)>0) $message_mail .= " ".number_format(intval($pub_offer_crystal), 0, ',', ' ')." k de Crystal ";
			if (intval($pub_offer_deuterium)>0) $message_mail .= " ".number_format(intval($pub_offer_deuterium), 0, ',', ' ')." k de Deut ";
		$message_mail .= " contre " ;
			if (intval($pub_want_metal)>0) $message_mail .= " ".number_format(intval($pub_want_metal), 0, ',', ' ')." k de M&eacute;tal ";
			if (intval($pub_want_crystal)>0) $message_mail .= " ".number_format(intval($pub_want_crystal), 0, ',', ' ')." k de Crystal ";
			if (intval($pub_want_deuterium)>0) $message_mail .= " ".number_format(intval($pub_want_deuterium), 0, ',', ' ')." k de Deut ";
		$message_mail .= "(".taux_echange($pub_offer_metal,$pub_offer_crystal,$pub_offer_deuterium,$pub_want_metal,$pub_want_crystal,$pub_want_deuterium).")<br><br>";
		$message_mail .= "Il peut livrer en <b>";
			foreach ($pub_deliver as $key=>$value) $message_mail .= " G".$value;
		$message_mail .= "</b>";
		$message_mail .= " et r&eacute;ceptionner en <b>";
			foreach ($pub_refunding as $key=>$value) $message_mail .= " G".$value;
		$message_mail .= "</b></font><br><br></p>";
		$message_mail .= "<table width='300' height='30'>";
		$message_mail .= "<tr><th valign='middle'>".$pub_note."</th></tr>";
		$message_mail .= "<tr>&nbsp</tr>";
		$expiration = time()+(intval($pub_expiration_hours)*60*60);
		$message_mail .= "<tr><th valign='middle'>Cette offre prendra fin le ".strftime("%a %d %b %H:%M:%S",$expiration)."</th></tr>";
		$message_mail .= "</table>";
		break;
		
// Mail R&eacute;activation
	case "reactiver":
		$message_mail .= "<br>&nbsp;Une offre viens d'&ecirc;tre r&eacute;activ&eacute;e par ".$user_data['name']." au ".$server_config["servername"].".<br>";
		break;
// Mail Reservation
	case "booktrade":
		$message_mail .= "<br>&nbsp;Une de vos offres viens d'&ecirc;tre r&eacute;serv&eacute;e par ".$user_data['name']." au ".$server_config["servername"].".<br>";
		break;
		
// Mail Offre Lib&eacute;r&eacute;e
	case "liberer":
		if ($user_data['id'] == $Trade['traderid']){
			$level = "[Vendeur]";
		}
		else if ($user_data['id'] == $Trade['pos_user']){
			$level = "[Acheteur]";
		}
		else{
			$level = "[Admin]";
		}
		$message_mail .= "<br>&nbsp;Une offre qui &eacute;tait r&eacute;serv&eacute;e viens d'&ecirc;tre lib&eacute;r&eacute;e par ".$user_data['name']." ".$level." sur ".$server_config["servername"].".<br>";
		break;
		
// Mail Offre Modifi&eacute;
	case "modifier":
		$level = ($user_data['id'] != $pub_traderid) ? "[Admin]" : "[Vendeur]";
		$message_mail .= "<br>Une offre viens d'&ecirc;tre modifi&eacute;e par ".$user_data['name']." ".$level." sur ".$server_config["servername"].".<br>";
		break;
// ----------		
	default:
		return false;
}
		
// Mail Pied de Page Commun
$message_mail .= "<br><A href=\"http://";
$message_mail .= $_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
$message_mail .= "\">Cliquez ici</A> si vous d&eacute;sirez plus d'informations.</center></body></html>";

// Mail Objet du Mail
$object_mail = $server_config["mail_object"];


switch ($alert){
	// Envoyer le Mail à un utilisateur.
	case "booktrade":
		$query = "SELECT `email`, `alert_mail` FROM ".TABLE_USER." WHERE `id` = '".$Trade['traderid']."'ORDER BY email asc";
		$result = $db->sql_query($query);
		list($email, $alert_mail) = $db->sql_fetch_row($result);
		if ($email != "" && $alert_mail == 1 ) { 
			mail($email, $object_mail, $message_mail, $headers);
		}
		break;

	default:
		// Envoyer le Mail à tous les utilisateurs.
		$query = "SELECT `email`, `alert_mail` FROM ".TABLE_USER." ORDER BY email asc";
		$result = $db->sql_query($query);
		while (list($email, $alert_mail) = $db->sql_fetch_row($result)) { 
			if ($email != "" && $alert_mail == 1 ) { 
				mail($email, $object_mail, $message_mail, $headers);
			}
		}
}