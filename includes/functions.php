<?php
/***********************************************************************
 * filename	:	functions.php
 * desc.	:	Fonctions diverses
 * created	: 	04/06/2006
 *
 * *********************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

/* Redirection Page web (kyser)*/
function redirection($url){
	if (headers_sent()) {
		die('<meta http-equiv="refresh" content="2; URL='.$url.'">');
	} else {
		header("Location: ".$url);
		exit();
	}
}

/* fonctions nessesaires aux cookies */
function serialise($data){
	return str_replace('"', '`', serialize($data));
}

function unserialise($data){
	return unserialize(str_replace('`', '"', $data));
}

/**
 * Verifie qu'il n'y a aucun code HTML dans la variable $secvalue.
 */
function check_getvalue($secvalue) {
    if ( ! is_array ( $secvalue ) ) {
    	if ((preg_match("/<[^>]*script*\"?[^>]*>/i", $secvalue)) ||
	    (preg_match("/<[^>]*object*\"?[^>]*>/i", $secvalue)) ||
    	(preg_match("/<[^>]*iframe*\"?[^>]*>/i", $secvalue)) ||
	    (preg_match("/<[^>]*applet*\"?[^>]*>/i", $secvalue)) ||
    	(preg_match("/<[^>]*meta*\"?[^>]*>/i", $secvalue)) ||
	    (preg_match("/<[^>]*style*\"?[^>]*>/i", $secvalue)) ||
    	(preg_match("/<[^>]*form*\"?[^>]*>/i", $secvalue)) ||
	    (preg_match("/<[^>]*img*\"?[^>]*>/i", $secvalue)) ||
    	(preg_match("/\([^>]*\"?[^)]*\)/i", $secvalue)) ||
	    (preg_match("/\"/i", $secvalue))) {
		    return false;
    	}
    }
    else {
        foreach ( $secvalue as $subsecvalue ) {
            if ( ! check_getvalue ( $subsecvalue ) )
                return false;
        }
    }
    return true;
}

/**
 * Verifie qu'il n'y a aucun code HTML dans la variable $secvalue.
 */
function check_postvalue($secvalue) {
    if ( ! is_array ( $secvalue ) ) {
        if ((preg_match("/<[^>]*script*\"?[^>]*>/i", $secvalue)) ||    (preg_match("/<[^>]*style*\"?[^>]*>/", $secvalue))) {
		    return false;
    	}
    }
    else {
        foreach ( $secvalue as $subsecvalue ) {
            if ( ! check_postvalue ( $subsecvalue ) )
                return false;
        }
    }
    return true;
}

/*image oui/non */
function affiche_icone($ouinon) {
	if ($ouinon == 1)
		return "<img src=\"images/graphic_ok.gif\" width=\"20\"/>";
	else
		return "<img src=\"images/graphic_cancel.gif\" width=\"20\"/>";
}

/* recuperation des univers */
function get_universe($universeid) {

		global $db;
		$sql =   "SELECT id,info,name"
			." FROM ".TABLE_UNIVERS
			." WHERE id=".intval($universeid);

		$result = $db->sql_query( $sql );

		if ( list($id,$info,$name) = $db->sql_fetch_row( $result)) {
			$uni=Array();

			$uni["id"] = $id;
			$uni["info"] = $info;
			$uni["name"] = $name;

			return $uni;			
		}
		return false;
}

/* Chronometrage des fonctions (kyser) */
function benchmark() {
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];

	return $mtime;
}

function init_serverconfig() {
    global $db, $server_config, $infos_config;

    $request_config = "select name,value from ".TABLE_CONFIG;
    $result_config = $db->sql_query($request_config);
    $request_infos = "select name,value from ".TABLE_INFOS;
    $result_infos = $db->sql_query($request_infos);

    while (list($name, $value) = $db->sql_fetch_row($result_config)) {
        $server_config[$name] = $value;
        
    }
    while (list($name, $value) = $db->sql_fetch_row($result_infos)) {
        $infos_config[$name] = $value;
    }
}

function text_datediff($fromtime,$totime=''){
	$Delay=bib_datediff($fromtime,$totime);
	$retvals='';
	if ($Delay["days"]) $retvals .= $Delay["days"]." j ";
	if ($Delay["hours"]) $retvals .= $Delay["hours"]." h ";
	if ($Delay["minutes"]) $retvals .= $Delay["minutes"]." min ";
	if ($Delay["seconds"]) $retvals .= $Delay["seconds"]." sec ";
	return $retvals;
}
// http://fr3.php.net/manual/fr/function.mktime.php#61259
function bib_datediff($fromtime, $totime=''){
	if($totime=='')        $totime = time();

	if($fromtime>$totime){
		$tmp = $totime;
		$totime = $fromtime;
		$fromtime = $tmp;
	}

	$timediff = $totime-$fromtime;
	//check for leap years in the middle
	for($i=date('Y',$fromtime); $i<=date('Y',$totime); $i++){
		if ((($i%4 == 0) && ($i%100 != 0)) || ($i%400 == 0)) {
			$timediff -= 24*60*60;
		}
	}
	$remain = $timediff;
	$ret['years']    = intval($remain/(365*24*60*60));
	$remain            = $remain%(365*24*60*60);
	$ret['days']    = intval($remain/(24*60*60));
	$remain            = $remain%(24*60*60);

	$m[0]    = 31;        $m[1]    = 28;        $m[2]    = 31;        $m[3]    = 30;
	$m[4]    = 31;        $m[5]    = 30;        $m[6]    = 31;        $m[7]    = 31;
	$m[8]    = 30;        $m[9]    = 31;        $m[10]    = 30;        $m[11]    = 31;
	//if leap year, february has 29 days
	if (((date('Y',$totime)%4 == 0) && (date('Y',$totime)%100 != 0)) || (date('Y',$totime)%400 == 0)){

		$m[1] = 29;
	}
	$ret['months']        = 0;
	foreach($m as $value){
		if($ret['days']>$value){
			$ret['months']++;
			$ret['days'] -=$value;
		} else {
			break;
		}
	}
	$ret['hours']    = intval($remain/(60*60));
	$remain            = $remain%(60*60);
	$ret['minutes']    = intval($remain/60);
	$ret['seconds']    = $remain%60;
	return $ret;
}
function get_htmlspecialchars( $given, $quote_style = ENT_QUOTES ){
   return htmlspecialchars( html_entity_decode( $given, $quote_style ), $quote_style );
}

/**
* Ecriture de texte dans un fichier
* @param string $file Nom du fichier
* @param string $mode Mode d'ouverture
* @param mixed $text texte ou tableau de texte a &eacute;crire
* @return bool true si succ&eacute;s, false sinon
*/
function write_file($file, $mode, $text) {
	if ($fp = fopen($file, $mode)) {
		if (is_array($text)) {
			foreach ($text as $t) {
				fwrite($fp, rtrim($t));
				fwrite($fp, "\r\n");
			}
		}
		else {
			fwrite($fp, $text);
			fwrite($fp, "\r\n");
		}
		fclose($fp);
		return true;
	}
	else return false;
}

/**
* Transforme une ip de la notation decimale en hexadecimale
* @param string $ip L'ip en entr&eacute;e sous la forme '192.168.0.1'
* @return string Encodage hexadecimale sous la forme 'B0AA0001'
*/

function encode_ip($ip) {
	$ip_sep = explode('.', $ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}
/**
* Transforme une ip de la notation hexadecimale en deecimal
* @param string $ip L'ip en entr&eacute;e sous la forme 'B0AA0001'
* @return string DesEncodage decimal sous la forme '192.168.0.1'
*/

function decode_ip($ip_encode) {
	$hexipbang = explode('.', chunk_split($ip_encode, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}

/*
 * Formate un nombre a la francaise
 * Pas le choix pour les decimal car les ressources appartiennent a |N ^^
 */

function formate_number ($number)
{
	return number_format ($number, '0', ',', ' ');
}

/**
* Verification des donn&eacute;es envoy&eacute;s par l'utilisateur
* @return bool true si correct 
*/

function check_var($value, $type_check, $mask = "", $auth_null = true) {
	if ($auth_null && $value == "") {
		return true;
	}
	
	switch ($type_check) {
		//Pseudo des membres
		case "Pseudo_Groupname" :
		if (!preg_match("#^[\w\s\-]{3,15}$#", $value)) {
			log_("check_var", array("Pseudo_Groupname", $value));
			return false;
		}
		break;

		//Mot de passe des membres
		case "Password" :
		if (!preg_match("#^[\w\s\-]{6,15}$#", $value)) {
			return false;
		}
		break;

		//Chaîne de caract&egrave;res avec espace
		case "Text" :
		if (!preg_match("#^[\w'\s\.\*\-]+$#", $value)) {
			log_("check_var", array("Text", $value));
			return false;
		}
		break;

		//Chaîne de caract&egrave;res et  chiffre
		case "CharNum" :
		if (!preg_match("#^[\w\.\*\-]+$#", $value)) {
			log_("check_var", array("CharNum", $value));
			return false;
		}
		break;

		//Caract&egrave;res
		case "Char" :
		if (!preg_match("#^[[:alpha:]_\.\*\-]+$#", $value)) {
			log_("check_var", array("Char", $value));
			return false;
		}
		break;

		//Chiffres
		case "Num" :
		if (!preg_match("#^[[:digit:]]+$#", $value)) {
			log_("check_var", array("Num", $value));
			return false;
		}
		break;

		//Adresse internet
		case "URL":
		if (!preg_match("#^(((?:http?)://)?(?(2)(www\.)?|(www\.){1})[-a-z0-9~_]{2,}\.[-a-z0-9~._]{2,}[-a-z0-9~_\/&\?=.]{2,})$#i", $value)) {
			log_("check_var", array("URL", $value));
			return false;
		}
		break;

		//Plan&egrave;te, Joueur et alliance
		case "Galaxy":
//		if (!preg_match("#^[\w\s\.\*\-]+$#", $value)) {
//			log_("check_var", array("Galaxy", $value));
//			return false;
//		}
		break;

		//Rapport d'espionnage
		case "Spyreport":
//		if (!preg_match("#^[\w\s\[\]\:\-'%\.\*]+$#", $value)) {
//			log_("check_var", array("Spyreport", $value));
//			return false;
//		}
		break;

		//Masque param&eacute;trable
		case "Special":
		if (!preg_match($mask, $value)) {
			log_("check_var", array("Special", $value));
			return false;
		}
		break;

		default:
		return false;
	}

	return true;
}



/**
* Liste des repertoires/fichiers selon un pattern donn&eacute;
*/
//safe_glob() by BigueNique at yahoo dot ca
//Function glob() is prohibited on some servers for security reasons as stated on:
//http://seclists.org/fulldisclosure/2005/Sep/0001.html
//(Message "Warning: glob() has been disabled for security reasons in (script) on line (line)")
//safe_glob() intends to replace glob() for simple applications
//using readdir() & fnmatch() instead.
//Since fnmatch() is not available on Windows or other non-POSFIX, I rely
//on soywiz at php dot net fnmatch clone.
//On the final hand, safe_glob() supports basic wildcards on one directory.
//Supported flags: GLOB_MARK. GLOB_NOSORT, GLOB_ONLYDIR
//Return false if path doesn't exist, and an empty array is no file matches the pattern
function safe_glob($pattern, $flags=0) {
   $split=explode('/',$pattern);
   $match=array_pop($split);
   $path=implode('/',$split);
   if (($dir=opendir($path))!==false) {
       $glob=array();
       while(($file=readdir($dir))!==false) {
           if (fnmatch($match,$file)) {
               if ((is_dir("$path/$file"))||(!($flags&GLOB_ONLYDIR))) {
                   if ($flags&GLOB_MARK) $file.='/';
                   $glob[]=$file;
               }
           }
       }
       closedir($dir);
       if (!($flags&GLOB_NOSORT)) sort($glob);
       return $glob;
   } else {
       return false;
   }
}

//thanks to soywiz for the following function, posted on http://php.net/fnmatch
//soywiz at php dot net
//17-Jul-2006 10:12
//A better "fnmatch" alternative for windows that converts a fnmatch pattern into a preg one. It should work on PHP >= 4.0.0
if (!function_exists('fnmatch')) {
   function fnmatch($pattern, $string) {
       return @preg_match('/^' . strtr(addcslashes($pattern, '\\.+^$(){}=!<>|'), array('*' => '.*', '?' => '.?')) . '$/i', $string);
   }
}

/**
* Fonction pour le xml
*/
function affiche_liste($sortby,$current_uni){
	global $Trades;
	echo "\n		<offers_list>\n";
	switch ($sortby){
		case "offermetal":
			$orderby="offer_metal desc";
			break;
		case "offercrystal":
			$orderby="offer_crystal desc";
			break;
		case "offerdeut":
			$orderby="offer_deuterium desc";
			break;
		case "wantmetal":
			$orderby="want_metal desc";
			break;
		case "wantcrystal":
			$orderby="want_crystal desc";
			break;
		case "wantdeut":
			$orderby="want_deuterium desc";
			break;
		case "player":
			$orderby="username desc";
			break;
		default:
			$orderby="creation_date desc";
			break;
	}
	echo "			".$Trades->trades_array_xml($current_uni["id"],$orderby,false);
	echo "		</offers_list>\n";
}

/*
*Enregistreement des données générales du market
*/
function admin_config_set () {
	global $db;
	global $pub_member_auto_activ, $pub_users_auth_type, $pub_users_adr_auth_db, $pub_users_auth_db, $pub_users_auth_dbuser, $pub_users_auth_dbpasswor, $pub_users_auth_table,
		$pub_users_inscription_ur, $pub_mail_nom_expediteur, $pub_mail_expediteur, $pub_mail_object, $pub_mail_message, $pub_servername, $pub_skin, $pub_logo_server, $pub_menuprive, $pub_menulogout, $pub_menuautre,
		$pub_menuforum, $pub_nomforum, $pub_adresseforum, $pub_home, $pub_market_read_access, $pub_market_write_access, $pub_market_password;
	
  if ($pub_users_auth_type == "" || $pub_skin == "" || $pub_servername == "") redirection("index.php?action=manque_info&goto=admin");
	$pub_users_active = (is_null($pub_member_auto_activ)) ? "0" : "1";

	$queries = array();
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_users_auth_type."' WHERE name='users_auth_type' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_users_adr_auth_db."' WHERE name='users_adr_auth_db' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_users_auth_db."' WHERE name='users_auth_db' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_users_auth_dbuser."' WHERE name='users_auth_dbuser' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_users_auth_dbpasswor."' WHERE name='users_auth_dbpasswor' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_users_auth_table."' WHERE name='users_auth_table' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_users_inscription_ur."' WHERE name='users_inscription_ur' LIMIT 1;" ;

	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_mail_nom_expediteur."' WHERE name='mail_nom_expediteur' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_mail_expediteur."' WHERE name='mail_expediteur' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_mail_object."' WHERE name='mail_object' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_mail_message."' WHERE name='mail_message' LIMIT 1;" ;

	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_servername."' WHERE name='servername' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_skin."' WHERE name='skin' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_logo_server."' WHERE name='logo_server' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_users_active."' WHERE name='users_active' LIMIT 1;" ;

	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_menuprive."' WHERE name='menuprive' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_menulogout."' WHERE name='menulogout' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_menuautre."' WHERE name='menuautre' LIMIT 1;" ;;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_menuforum."' WHERE name='menuforum' LIMIT 1;" ;

	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_nomforum."' WHERE name='nomforum' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_adresseforum."' WHERE name='adresseforum' LIMIT 1;" ;

	$queries[] = "UPDATE ".TABLE_INFOS." SET value='".$pub_home."' WHERE name='home' LIMIT 100000;" ;

	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_market_read_access."' WHERE name='market_read_access' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_market_write_access."' WHERE name='market_write_access' LIMIT 1;" ;
	$queries[] = "UPDATE ".TABLE_CONFIG." SET value='".$pub_market_password."' WHERE name='market_password' LIMIT 1;" ;

	foreach($queries as $query){
		$db->sql_query($query);
		
	}
	
	return "Param&egrave;tres mis &agrave; jour.";
}

/*
*Enregistreement des données général du market
*/
function admin_market_set () {
	global $db;
	global $pub_max_trade_delay_hours, $pub_max_trade_by_univers, $pub_tauxmetal, $pub_tauxcristal, $pub_tauxdeuterium, $pub_view_trade;
	
	//Conversion en heures
	$pub_max_trade_delay_seco = ($pub_max_trade_delay_hours)*60*60;
			
	$queries=array();
	$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$pub_max_trade_by_univers."' WHERE name='max_trade_by_univers' LIMIT 1;" ;
	$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$pub_max_trade_delay_seco."' WHERE name='max_trade_delay_seco' LIMIT 1;" ;

	$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$pub_tauxmetal."' WHERE name='tauxmetal' LIMIT 1;" ;
	$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$pub_tauxcristal."' WHERE name='tauxcristal' LIMIT 1;" ;
	$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$pub_tauxdeuterium."' WHERE name='tauxdeuterium' LIMIT 1;" ;

	$queries[]="UPDATE ".TABLE_CONFIG." SET value='".$pub_view_trade."' WHERE name='view_trade' LIMIT 1;" ;

	foreach($queries as $query)
	{
		$result = $db->sql_query($query);
	}
	
	return "Param&egrave;tres Commerciaux Mis &agrave; Jour";
}

/*
*Création d'offres par le module market
*/
function market_create(){
	global $db, $server_config, $user_data;
	global $pub_name, $pub_mdp, $pub_om, $pub_oc, $pub_od, $pub_dm, $pub_dc, $pub_dd, $pub_duree, $pub_note, $pub_id,
		$pub_og1, $pub_og2, $pub_og3, $pub_og4, $pub_og5, $pub_og6, $pub_og7, $pub_og8, $pub_og9,
		$pub_dg1, $pub_dg2, $pub_dg3, $pub_dg4, $pub_dg5, $pub_dg6, $pub_dg7, $pub_dg8, $pub_dg9;
			
	$sql="SELECT id,is_active FROM ".TABLE_USER." WHERE name like '".mysql_real_escape_string($pub_name)."'";
	$db->sql_query($sql);
	// L'utilisateur existe pas
	if (!(list($id,$is_active)=$db->sql_fetch_row())) return false;
	if ($is_active == 1){
		$sql="SELECT * FROM ".TABLE_USER." WHERE id = '".$id."'";	
		$db->sql_query($sql);
		$user=$db->sql_fetch_assoc();
		if ($user["password"] != $pub_mdp) return false;
	}
	$_SESSION["username"] = $form_username;
	$_SESSION["userpass"] = $form_userpass;

	$user_data = $user;
	return $user_data;
	
	$Trades->insert_new( $user_data["id"],$pub_id,
									intval($pub_om),
									intval($pub_oc),
									intval($pub_od),
									intval($pub_dm),
									intval($pub_dc),
									intval($pub_dd),
									intval(time())*60*60,
									$pub_note,
									$pub_og1,
									$pub_og2,
									$pub_og3,
									$pub_og4,
									$pub_og5,
									$pub_og6,
									$pub_og7,
									$pub_og8,
									$pub_og9,
									$pub_dg1,
									$pub_dg2,
									$pub_dg3,
									$pub_dg4,
									$pub_dg5,
									$pub_dg6,
									$pub_dg7,
									$pub_dg8,
									$pub_dg9);
	$alert = "creer";
	require_once("includes/mail.php");
}
?>
