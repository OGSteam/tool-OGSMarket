<?php
/***************************************************************************
*	filename	: 	modmarket.php
*	desc.		:
*	Author		:	jey2k 
*	created		:	vendredi 25 Aout 2006
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

//Gestion des interrogations via ModMarket
class cModMarket {
	function checkMD5Password($password_given) {
		global $server_config;
		return ($password_given == md5($server_config["market_password"]));
	}
	function checkURLAuth($pub_ogspyurl, $type_acces) {
		global $db;

		$champ_concerne = "";
		
		switch ($type_acces) {
			case "read":
				$champ_concerne = "read_access";
				break;
			case "write":
				$champ_concerne = "write_access";
				break;
			default:
				return false;
		}
		
		$result = $db->sql_query("select ".$champ_concerne." from ".TABLE_OGSPY_AUTH." where url='".$pub_ogspyurl."' and active='1' LIMIT 1;");
		
		if (!(list($acces) = $db->sql_fetch_row($result))) {
			return false;
		}

		if ($acces == "1") {
			return true;
		}
		else {
			return false;
		}
	}
		
}
