<?php
/***************************************************************************
*	filename	: 	trade.php
*	desc.		:
*	Author		:	ericalens 
*	created		: 	06/06/2006
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

//Classe gÈrant les diffÈrents trades
class cTrades {
	//Nombre de Trades dans la base de donnÈe pour un univers donnÈ
	function count($universeid, $include_expired = false) {
		global $db;

		$sql = "SELECT count(*) FROM ".TABLE_TRADE." WHERE universid=".intval($universeid);
		if (!$include_expired) {
			$sql .= " AND expiration_date>".time();
		}
		$result = $db->sql_query($sql);

		if (list($rowcount) = $db->sql_fetch_row($result)) {
			return $rowcount;
		}

		return 0;
	}	

	function last($universeid) {
		global $db;

		$sql = "select t.*,u.name as username from ".TABLE_TRADE." t LEFT JOIN ".TABLE_USER." u ON u.id=t.traderid "
			." WHERE t.universid=".intval($universeid)." AND expiration_date>".time()." AND t.`trade_closed` = 0"
			." ORDER BY t.creation_date desc limit 1";
		$db->sql_query($sql);

		return $db->sql_fetch_assoc();
	}
//Reservation de l'offre	
	function pos_new($tradeid, $userid) {
		global $db;

		$now = time();
		$out = "effectué";
		$sql = "UPDATE ".TABLE_TRADE." SET `pos_user`=".$userid.", `pos_date`=".$now." WHERE `id`=".$tradeid;
		
		if (!($result = $db->sql_query($sql))) {
			$out = "Erreur";
		}
		return $out;
	}
//Annulation de la réservation	
	function unpos_new($tradeid) {
		global $db;

		$out = "effectué";
		$sql = "UPDATE ".TABLE_TRADE." SET `pos_user`=0 , `pos_date`=NULL WHERE `id`=".$tradeid;
		
		if (!($result = $db->sql_query($sql))) {
			$out = "Erreur";
		}
		return $out;
	}
 //Fin de la transaction et Archivage de l'offre.	
	function close_trade($tradeid) {
		global $db;

		$out = "Archivé";
		$sql = "UPDATE ".TABLE_TRADE." SET `trade_closed`=1 WHERE `id`=".$tradeid;
		
		if (!($result = $db->sql_query($sql))) {
			$out = "Erreur";
		}
		return $out;
	}

	//Ajoute un nouveau trade renvoie un tableau sur ce nouvel univers
	function insert_new($traderid, $universid, $offer_metal, $offer_crystal, $offer_deuterium, $want_metal, $want_crystal, $want_deuterium, $secs_duration, $note, $deliver, $refunding) {
		global $db;
		$now = time();
		$expiration = $now + intval($secs_duration);
		$sql = " INSERT INTO ".TABLE_TRADE
			." (`id`,`traderid`,`universid`,`offer_metal`,`offer_crystal`,`offer_deuterium`,`want_metal`,`want_crystal`,`want_deuterium`,`creation_date`,`expiration_date`,`note`,`deliver`,`refunding`)"
			." VALUES(null,".intval($traderid).",".intval($universid).",".intval($offer_metal).",".intval($offer_crystal).",".intval($offer_deuterium).",".intval($want_metal).",".intval($want_crystal).",".intval($want_deuterium).",$now,$expiration,'".mysql_escape_string($note)."','".implode("_", $deliver)."','".implode("_", $refunding)."')";

		$result = $db->sql_query($sql);	

		$newvalues = Array();
		$newvalues["id"] = $db->sql_insertid();
		$newvalues["traderid"] 			= $traderid;
		$newvalues["universid"] 		= $universid;
		$newvalues["offer_metal"] = $offer_metal;
		$newvalues["offer_crystal"] 	= $offer_crystal;
		$newvalues["offer_deuterium"] = $offer_deuterium;
		$newvalues["want_metal"] = $want_metal;
		$newvalues["want_crystal"] 		= $want_crystal;
		$newvalues["want_deuterium"] = $want_deuterium;
		$newvalues["creation_date"] 	= $now;
		$newvalues["expiration_date"] = $expiration;
		$newvalues["note"] = $note;

		return $newvalues;
	}
	
	//Mettre a jour une trade renvoie un tableau sur ce nouvel univers
	function upd_trade($id, $traderid, $universid, $offer_metal, $offer_crystal, $offer_deuterium, $want_metal, $want_crystal, $want_deuterium, $expiration_date, $note, $deliver, $refunding) {
		global $db;
			
		$sql = " UPDATE ".TABLE_TRADE." SET "
			."`offer_metal`=".intval($offer_metal).",`offer_crystal`=".intval($offer_crystal).",`offer_deuterium`=".intval($offer_deuterium).","
			."`want_metal`=".intval($want_metal).",`want_crystal`=".intval($want_crystal).",`want_deuterium`=".intval($want_deuterium).","
			."`expiration_date`=".$expiration_date.",`note`='".mysql_escape_string($note)."',"
			."`deliver`='".implode('_', $deliver)."', `refunding`='".implode('_', $refunding)."' WHERE `id`=".intval($id)." ";

		if (!$result = $db->sql_query($sql)) {
			return 0;
		}
		else {
			return 1;
		}
		
	}
	//Réactivation d'une offre
	function reactive_trade($id, $creation_date, $expiration_date) {
		global $db;
		$sql = " UPDATE ".TABLE_TRADE." SET `creation_date`=".$creation_date.",`expiration_date`=".$expiration_date.",`pos_user`='0',`pos_date`='0' WHERE id = ".intval($id);
		
		if (!$result = $db->sql_query($sql)) {
			return 0;
		}
		else {
			return 1;
		}
	}
	
	//Tableau de trades d'un univers donnÈ, eventuellement classÈs 

	/**
	 * @param string $action_id
	 */
	function trades_array($action, $action_id, $order="id") {
		global $db;
		global $user_data;
		
		$sql = "SELECT t.`id`, t.`traderid`, t.`universid`, v.`g`, t.`offer_metal`, t.`offer_crystal`, t.`offer_deuterium`, t.`want_metal`, t.`want_crystal`, t.`want_deuterium`, t.`creation_date`, t.`expiration_date`, t.`note`, u.`name` as username, u.`avatar_link`, t.`deliver`, t.`refunding`, t.`pos_user`, t.`pos_date` FROM ".TABLE_TRADE." t, ".TABLE_USER." u, ".TABLE_UNIVERS." v WHERE ";
		if ($action == "unitrades"){
			$sql .= "u.id = t.traderid AND v.id = '$action_id' AND t.universid = v.id AND expiration_date > '".time()."' AND t.`trade_closed` = 0 ORDER BY $order";
		}
		elseif ($action == "usertrades"){
			$sql .= "u.id = '$action_id' AND u.id = t.traderid AND t.universid = v.id AND t.`trade_closed` = 0 "
			.((isset($user_data) && ($user_data['id'] == $action_id || $user_data['is_admin'] == 1)) ? ("AND expiration_date > '".time()."' ") : '')
			."ORDER BY $order";
		}
		elseif ($action == "uniquetrade"){
			$sql .= "u.id = t.traderid  AND t.universid = v.id AND t.id = '$action_id' AND t.`trade_closed` = 0";
		}
    	elseif ($action == "userclosedtrades"){
      		$sql .= "u.id = t.traderid  AND t.universid = v.id AND t.`trade_closed` = 1";
      	}
		
		$result = $db->sql_query($sql);
		
		$tradearray=Array();
		
		while(list($id,$traderid,$universid,$g,$offer_metal,$offer_crystal,$offer_deuterium,$want_metal,$want_crystal,$want_deuterium,$creation_date,$expiration_date,$note,$username,$avatar_link,$deliver,$refunding,$pos_user,$pos_date) = $db->sql_fetch_row($result)){
			$newvalues = Array();
			
			$newvalues["id"] 				= $id;
			$newvalues["traderid"] 			= $traderid;
			$newvalues["g"] 				= $g;
			$newvalues["universid"] 		= $universid;
			$newvalues["offer_metal"] 		= $offer_metal;
			$newvalues["offer_crystal"] 	= $offer_crystal;
			$newvalues["offer_deuterium"]	= $offer_deuterium;
			$newvalues["want_metal"] 		= $want_metal;
			$newvalues["want_crystal"] 		= $want_crystal;
			$newvalues["want_deuterium"] 	= $want_deuterium;
			$newvalues["creation_date"] 	= $creation_date;
			$newvalues["expiration_date"] 	= $expiration_date;
			$newvalues["note"]				= $note;
			$newvalues["username"]			= $username;
			$newvalues["avatar_link"]		= $avatar_link;
			$newvalues["pos_user"]			= $pos_user;
			$newvalues["pos_date"]			= $pos_date;
			
			$newvalues["deliver"] = Array();
			// Unserialise deliver value
			$deliver = explode('_', $deliver);
			foreach ($deliver as $key=>$value) {
				$newvalues["deliver"][$value] = 1;
			}
			for ($i = 1; $i <= $g; $i++) {
				if (!isset($newvalues["deliver"][$i]) || $newvalues["deliver"][$i] != 1) {
					$newvalues["deliver"][$i] = 0;
				}
			}
			
			$newvalues["refunding"] = Array();
			//Unserialise refunding values
			$refunding = explode('_', $refunding);
			foreach ($refunding as $key=>$value) {
				$newvalues["refunding"][$value] = 1;
			}
			for ($i = 1; $i <= $g; $i++) {
				if (!isset($newvalues["refunding"][$i]) || $newvalues["refunding"][$i] != 1) {
					$newvalues["refunding"][$i] = 0;
				}
			}
			
			$tradearray[] = $newvalues;
		}
		
		if ($action == "uniquetrade") {
			return $tradearray[0];
		}
		else {
			return $tradearray;
		}
	}
	
	// Affichage d'un trade sous forme de xml
	function get_trade_xml($trade) {
		$xmlTrade = "\t<id>".$trade["id"]."</id>\n";
		$xmlTrade .= "\t<traderid>".$trade["traderid"]."</traderid>\n";
		$xmlTrade .= "\t<universid>".$trade["universid"]."</universid>\n";
		$xmlTrade .= "\t<offer_metal>".$trade["offer_metal"]."</offer_metal>\n";
		$xmlTrade .= "\t<offer_crystal>".$trade["offer_crystal"]."</offer_crystal>\n";
		$xmlTrade .= "\t<offer_deuterium>".$trade["offer_deuterium"]."</offer_deuterium>\n";
		$xmlTrade .= "\t<want_metal>".$trade["want_metal"]."</want_metal>\n";
		$xmlTrade .= "\t<want_crystal>".$trade["want_crystal"]."</want_crystal>\n";
		$xmlTrade .= "\t<want_deuterium>".$trade["want_deuterium"]."</want_deuterium>\n";
		$xmlTrade .= "\t<creation_date>".$trade["creation_date"]."</creation_date>\n";
		$xmlTrade .= "\t<expiration_date>".$trade["expiration_date"]."</expiration_date>\n";
		$xmlTrade .= "\t<note>".$trade["note"]."</note>\n";
		$xmlTrade .= "\t<username>".$trade["username"]."</username>\n";
		$xmlTrade .= "\t<deliver_g1>".$trade["deliver"][1]."</deliver_g1>\n";
		$xmlTrade .= "\t<deliver_g2>".$trade["deliver"][2]."</deliver_g2>\n";
		$xmlTrade .= "\t<deliver_g3>".$trade["deliver"][3]."</deliver_g3>\n";
		$xmlTrade .= "\t<deliver_g4>".$trade["deliver"][4]."</deliver_g4>\n";
		$xmlTrade .= "\t<deliver_g5>".$trade["deliver"][5]."</deliver_g5>\n";
		$xmlTrade .= "\t<deliver_g6>".$trade["deliver"][6]."</deliver_g6>\n";
		$xmlTrade .= "\t<deliver_g7>".$trade["deliver"][7]."</deliver_g7>\n";
		$xmlTrade .= "\t<deliver_g8>".$trade["deliver"][8]."</deliver_g8>\n";
		$xmlTrade .= "\t<deliver_g9>".$trade["deliver"][9]."</deliver_g9>\n";
		$xmlTrade .= "\t<refunding_g1>".$trade["refunding"][1]."</refunding_g1>\n";
		$xmlTrade .= "\t<refunding_g2>".$trade["refunding"][2]."</refunding_g2>\n";
		$xmlTrade .= "\t<refunding_g3>".$trade["refunding"][3]."</refunding_g3>\n";
		$xmlTrade .= "\t<refunding_g4>".$trade["refunding"][4]."</refunding_g4>\n";
		$xmlTrade .= "\t<refunding_g5>".$trade["refunding"][5]."</refunding_g5>\n";
		$xmlTrade .= "\t<refunding_g6>".$trade["refunding"][6]."</refunding_g6>\n";
		$xmlTrade .= "\t<refunding_g7>".$trade["refunding"][7]."</refunding_g7>\n";
		$xmlTrade .= "\t<refunding_g8>".$trade["refunding"][8]."</refunding_g8>\n";
		$xmlTrade .= "\t<refunding_g9>".$trade["refunding"][9]."</refunding_g9>\n";
		$xmlTrade .= "\t<pos_user>".$trade["pos_user"]."</pos_user>\n";
		$xmlTrade .= "\t<pos_date>".$trade["pos_date"]."</pos_date>\n";
		
		return $xmlTrade;			
	}

	// Affichage d'un trade sous format rss
	function get_trade_rss($trade, $universe) {
		$xmlTrade = "\n<item>";
		$xmlTrade .= "\n\t<guid>"."http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?action=viewtrade&amp;tradeid=".$trade["id"]."</guid>";
		$xmlTrade .= "\n\t<title>Vends ".$trade["offer_metal"]."M/".$trade["offer_crystal"]."C/".$trade["offer_deuterium"]."D sur ".$universe["name"]." par ".$trade["username"]."</title>";
		$xmlTrade .= "\n\t<link>http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?action=viewtrade&amp;tradeid=".$trade["id"]."</link>";
		//$xmlTrade .= "\n\t<author>"..$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?action=viewtrade&amp;tradeid=".$trade["id"]."</author>";
		$xmlTrade .= "\n\t<description>".utf8_encode("Dans ".$universe["name"].", ".$trade["username"]." vend ".$trade["offer_metal"]."M/".$trade["offer_crystal"]."C/".$trade["offer_deuterium"]."D contre ".$trade["want_metal"]."M/".$trade["want_crystal"]."C/".$trade["want_deuterium"]."D")."</description>";
		$xmlTrade .= "\n\t<comments>".utf8_encode($trade["note"])."</comments>";
		$xmlTrade .= "\n\t<pubDate>".date("D, j F Y g:i:s T", $trade["creation_date"])."</pubDate>";
		$xmlTrade .= "\n</item>";

		return $xmlTrade;			
	}

	// RÈcupÈration sous forme XML de la liste des offres d'un Univers
	function trades_array_xml($universeid, $order = "creation_date desc", $limit = "LIMIT 30", $excludeexpired = true) {
		$ret = "";
		foreach ($this->trades_array($universeid, $order, $limit, $excludeexpired) as $trade)
		{
			$ret .= "\n<offer>\n".$this->get_trade_xml($trade)."</offer>\n";
		}
		return $ret;
	}

	// RÈcupÈration sous format RSS de la liste des offres d'un Univers
	function trades_array_rss($universe, $limit = "LIMIT 30") {
		$ret = "";
		foreach ($this->trades_array($universe["id"], "creation_date desc", $limit, true) as $trade)
		{
			$ret .= "\n".$this->get_trade_rss($trade, $universe);
		}
		return $ret;
	}
	
	// RÈcupÈration sous format RSS de la liste des offres d'un Univers
	function trades_array_all_uni_rss($limit = "LIMIT 30") {
		$ret = "";
		foreach ($this->trades_array(null, "creation_date desc", $limit, true) as $trade)
		{
			$universe = cUniverses::get_universe($trade["universid"]);
			$ret .= "\n".$this->get_trade_rss($trade, $universe);
		}
		return $ret;
	}


	// Effacement d'une offre a partir de son ID
	function delete_trade($tradeid) {
		global $db;
		$sql = "DELETE FROM ".TABLE_TRADE." WHERE id=".intval($tradeid);
		$db->sql_query($sql);
	}
	
}

$Trades = new cTrades();

//Réservation d'une offre
function beton_trade($tradeid) {
	global $db;
	global $Users;
	global $Trades;
	global $user_data;
	global $server_config;

	$Trade = $Trades->trades_array("uniquetrade", $tradeid);

	if ($Trade) {
		if ($Trade["expiration_date"] < time()) {
			return "Cette offre n'est plus valide, sa date d'expiration est atteinte";
		}
		else {
			if ($Trade["pos_user"] <> 0) {
				$user2 = $Users->get_user($Trade["pos_user"]);
				if (!$user2) {
					return "<div>Profil non trouv&eacute;</div>";
				}
				else {
					return "Cette offre est d&eacute;j&agrave; r&eacute;serv&eacute; par l'utilsateur ".$user2["name"];
				}
			}
			else {	
				$out = $Trades->pos_new($Trade["id"], $user_data["id"]);
				$alert = "booktrade";
				require_once("includes/mail.php");
				return "<b>La r&eacute;servation sur l'offre n° ".$tradeid." par l'utilisateur ".$user_data["name"]." est ".$out."</b>";
			}
		}

	}
}

//Libaration d'une offre
function unbeton_trade($tradeid) {
	global $db;
	global $Users;
	global $Trades;
	global $user_data;
	global $server_config;
	
	$Trade = $Trades->trades_array("uniquetrade", $tradeid);
	if ($Trade) {
		if ($Trade["expiration_date"] < time()) {
			return "Cette offre n'est plus valide, sa date d'expiration est atteinte";
		}
		else {
			if ($Trade["pos_user"] <> 0) {
				$out = $Trades->unpos_new($Trade["id"]);
				$alert = "liberer";
				require_once("includes/mail.php");
				return "<b>La lib&eacute;ration de l'offre n° ".$tradeid." par l'utilisateur ".$user_data["name"]." est ".$out."</b>";				
			}
		}
	}
}

//suppression d'offre
function del_trade($tradeid) {
	global $db, $Trades, $user_data;
	
	$trade = $Trades->trades_array("uniquetrade", $tradeid);
	if ($trade) {
		if ($trade["traderid"] == $user_data["id"] || $user_data["is_admin"]) {
			$Trades->close_trade($tradeid);
			return "L'offre a été archivée";
		} 
		else {
			return "Cette offre ($tradeid) ne vous appartient pas, vous ne pouvez donc pas l'&eacute;ffacer";
		}
	} 
	else {
		return "Je ne trouve pas d'offre correspondant au numero $tradeid";
	}
}

//reactivation de l'offre
function reactive_trade($trade_id) {
	global $db;
	global $Trades;
	global $server_config;
	global $current_uni;
	global $user_data;
	
	$trade = $Trades->trades_array("uniquetrade", $trade_id);
	$now = time();
	$period = intval($trade["expiration_date"]) - intval($trade["creation_date"]);
	$expiration = ($period) > $server_config["max_trade_delay_seco"] ? $server_config["max_trade_delay_seco"] + $now : $period + $now;
	$Trades->reactive_trade($trade_id, $now, $expiration);
	return "Offre r&eacute;activ&eacute;e - ".$current_uni["name"];
	//$alert = "reactiver";
	//require_once("includes/mail.php");
}

//mise a jour de l'offre
function update_trade() {
	global $db, $user_data, $server_config, $Trades, $current_uni;
	global $pub_offer_metal, $pub_offer_crystal, $pub_offer_deuterium, $pub_want_metal, $pub_want_crystal, $pub_want_deuterium,
			$pub_deliver, $pub_refunding, $pub_expiration_hours, $pub_expiration_date, $pub_creation_date, $pub_note, $pub_tradeid, $pub_traderid;
	
	if (!isset($pub_expiration_hours)) {
		$pub_expiration_hours = 0;
	}
	if ($user_data["is_active"] != 1) {
		return "Impossible de modifer cette offre, l'utilisateur est inactif.";
	}
	else {
		if (((intval($pub_offer_metal) < 0) || intval($pub_offer_crystal) < 0 || intval($pub_offer_deuterium) < 0) || (intval($pub_want_metal) < 0 || intval($pub_want_crystal) < 0 || intval($pub_want_deuterium) < 0)) {
			return "Vos offres et demandes en ressources ne peuvent etre n&eacute;gatives :";
		}
		else {
			$totalressources = intval($pub_offer_metal) + intval($pub_offer_crystal) + intval($pub_offer_deuterium);
			if ($totalressources <= 0) {
				return "Le total des ressources offertes est &eacute;gal à 0.<br>Vous devez fournir une valeur valide >0 pour , au moins, une de vos ressources offertes.";
			}
			else {
				$totalressources = intval($pub_want_metal) + intval($pub_want_crystal) + intval($pub_want_deuterium);
				if ($totalressources <= 0) {
					return "Le total des ressources demand&eacute;es est &eacute;gal à 0.<br>Vous devez fournir une valeur valide >0 pour , au moins, une de vos ressources demand&eacute;es";
				}
				else {
					if (intval($pub_expiration_hours)*60*60 > $server_config["max_trade_delay_seco"]) {
						return "Le d&eacute;lai de prolongation ne doit d&eacute;passer ".intval($server_config["max_trade_delay_seco"]/(60*60))." heures (".text_datediff(time() + $server_config["max_trade_delay_seco"]).")";
					}
					else {
						// Calcul de la prolongation
						$maxi = $server_config["max_trade_delay_seco"]*2;

						if ($pub_expiration_hours == '0') 
							$expiration = $pub_expiration_date;
						else if (intval($pub_expiration_date) - intval($pub_creation_date) + (intval($pub_expiration_hours)*60*60) < $maxi)
							$expiration = intval($pub_expiration_date) + (intval($pub_expiration_hours)*60*60);
						else
							$expiration = intval($pub_creation_date) + $maxi;

						//Update de l'offre
						$Trades->upd_trade($pub_tradeid, $user_data["id"], $current_uni["id"],
									intval($pub_offer_metal),
									intval($pub_offer_crystal),
									intval($pub_offer_deuterium),
									intval($pub_want_metal),
									intval($pub_want_crystal),
									intval($pub_want_deuterium),
									intval($expiration),
									get_htmlspecialchars($pub_note),
									$pub_deliver,
									$pub_refunding);
									
						$alert = "modifier";
						require_once("includes/mail.php");
						return "Offre modifi&eacute;e sur l'univers ".$current_uni["name"];
					}
				}
			}
		}
	}
}

//ajout d'un offre
function add_trade() {
	global $db, $user_data, $server_config, $Trades, $current_uni;
	global $pub_offer_metal, $pub_offer_crystal, $pub_offer_deuterium, $pub_want_metal, $pub_want_crystal, $pub_want_deuterium,
		$pub_expiration_hours, $pub_note, $pub_deliver, $pub_refunding;
	
	if ($user_data["is_active"] != 1) return "Impossible d'ajouter une nouvelle offre, l'utilisateur est inactif.";
	else {
		if (((intval($pub_offer_metal) < 0) || intval($pub_offer_crystal) < 0 || intval($pub_offer_deuterium) < 0) ||
			(intval($pub_want_metal) < 0 || intval($pub_want_crystal) < 0 || intval($pub_want_deuterium) < 0))
			return "Vos offres et demandes en ressources ne peuvent etre négatives :";
		else {
			$totalressources = intval($pub_offer_metal) + intval($pub_offer_crystal) + intval($pub_offer_deuterium);
			if ($totalressources <= 0)
				return "Le total des ressources offertes est égal à 0.<br>Vous devez fournir une valeur valide >0 pour , au moins, une de vos ressources offertes.";
			else {
				$totalressources = intval($pub_want_metal) + intval($pub_want_crystal) + intval($pub_want_deuterium);
				if ($totalressources <= 0)
					return "Le total des ressources demandés est égal à 0.<br>Vous devez fournir une valeur valide >0 pour , au moins, une de vos ressources demandés";
				else {
					if (intval($pub_expiration_hours) < 1 || intval($pub_expiration_hours)*60*60 > $server_config["max_trade_delay_seco"])
						return "Le delai de validité doit etre compris entre 1 heure et ".intval($server_config["max_trade_delay_seco"]/(60*60))." heures "
						."(".text_datediff(time() + $server_config["max_trade_delay_seco"]).")";
					else {							
						$Trades->insert_new($user_data["id"], $current_uni["id"],
									intval($pub_offer_metal),
									intval($pub_offer_crystal),
									intval($pub_offer_deuterium),
									intval($pub_want_metal),
									intval($pub_want_crystal),
									intval($pub_want_deuterium),
									intval($pub_expiration_hours)*60*60,
									get_htmlspecialchars($pub_note),
									$pub_deliver,
									$pub_refunding);
						$alert = "creer";
						require_once("includes/mail.php");
						return "Offre ajoutée sur l'univers ".$current_uni["name"];
					}
				}
			}
		}
	}
}
