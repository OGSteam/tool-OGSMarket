<?php
/***************************************************************************
*	filename	: update_to_latest.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 28/11/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/
if (!defined('IN_OGSMARKET')) die("Hacking attempt");

if (file_exists("../parameters/id.php")) {
	require_once("../parameters/id.php");
} else
  die("Config file id.php is not present");

$db = new sql_db($db_host, $db_user, $db_password, $db_database);

if (!$db->db_connect_id)
	error_sql('Impossible de se connecter &agrave; la base de donn&eacute;es');

		define('TABLE_COMMENT', $table_prefix.'comment');
		define('TABLE_CONFIG', $table_prefix.'config');
		define('TABLE_INFOS', $table_prefix.'infos');
		define('TABLE_SESSIONS', $table_prefix.'sessions');
		define('TABLE_TRADE', $table_prefix.'trade');
		define('TABLE_UNIVERS', $table_prefix.'univers');
		define('TABLE_USER', $table_prefix.'user');
		define('TABLE_OGSPY_AUTH', $table_prefix.'ogspy_auth');

$request = "SELECT value FROM ".TABLE_CONFIG." WHERE name = 'version'";
$result = $db->sql_query($request);
list($version) = $db->sql_fetch_row($result);

$requests = array();
$up_to_date = false;
// $version="0.2";

switch ($version) {

	case "0.2a" :
		$version = "0.2";
	break;

	case "0.2b" :
		$version = "0.2";
	break;

	case "0.2" :
		$requests[] = "UPDATE ".TABLE_CONFIG." SET value = '0.3' WHERE name = 'version'";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('home', '<p>Bienvenu sur votre Market!</font></b></p>')";
		$requests[] = "INSERT INTO `".TABLE_CONFIG."` VALUES('menuprive','priv&eacute;')";
		$requests[] = "INSERT INTO `".TABLE_CONFIG."` VALUES('menulogout','logout')";
		$requests[] = "INSERT INTO `".TABLE_CONFIG."` VALUES('menuforum','Forum et IRC')";
		$requests[] = "INSERT INTO `".TABLE_CONFIG."` VALUES('menuautre','autre')";
		$requests[] = "INSERT INTO `".TABLE_CONFIG."` VALUES('adresseforum','Adresse de votre forum')";
		$requests[] = "INSERT INTO `".TABLE_CONFIG."` VALUES('nomforum','nom de votre forum')";
		$requests[] = "INSERT INTO `".TABLE_CONFIG."` VALUES('menuautre','autre')";

		$version = "0.3";
	break;


	case "0.3" :
		$request = "SELECT MAX(pos_user)  FROM ".TABLE_TRADE." ";
		if (!($result = $db->sql_query($request))) {
			$requests[] = "ALTER TABLE `".TABLE_TRADE."` ADD `pos_user` INT NOT NULL DEFAULT '0'";
			$requests[] = "ALTER TABLE `".TABLE_TRADE."` ADD `pos_date` INT NOT NULL ";
		}
		$requests[] = "UPDATE ".TABLE_CONFIG." SET value = '0.4' WHERE name = 'version'";
		$version = "0.4";
	break;

	case "0.41" :
		$version = "0.4";
	break;

	case "0.4b" :
		$version = "0.4";
	break;

	case "0.4" :
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES('users_active', '0')";

		$request = "SELECT *  FROM ".TABLE_INFOS." WHERE `name` = 'home'";
		if (!($result = $db->sql_query($request))) {

			$requests[] = "CREATE TABLE `".TABLE_INFOS."` (".
				"`id` int(11) NOT NULL auto_increment COMMENT 'Identificateur de la variable infos',".
				"`name` varchar(20) NOT NULL default '' COMMENT 'Nom de la variable infos',".
				"`value` longtext NOT NULL COMMENT 'Valeur de la variable infos',".
				 "PRIMARY KEY  (`id`)".
				")";
			$requests[] = "INSERT INTO `".TABLE_INFOS."` SELECT * FROM `".TABLE_CONFIG."` WHERE `name` = 'home'";
		}

		$requests[] = "DELETE FROM `".TABLE_CONFIG."` WHERE `name` = 'home'";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET value = '0.5' WHERE name = 'version'";
		$version = "0.5";
	break;

	case "0.5" :
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('tauxmetal', '3')";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('tauxcristal', '2')";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('tauxdeuterium', '1')";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('view_trade', '0')";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('users_adr_auth_db', '')";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET value = '0.6' WHERE name = 'version'";
		$version = "0.6";
	break;

	case "0.6" :
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('mail_message', 'Une nouvelle Offre vient d\'&ecirc;tre faite dans le March&eacute; Ogame.')";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('mail_object', 'OGSMarket')";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('mail_expediteur', 'admin@admin')";
		$requests[] = "INSERT INTO ".TABLE_CONFIG." VALUES ('mail_nom_expediteur', 'admin')";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET value = '0.7' WHERE name = 'version'";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET value = 'skin/' WHERE name = 'skin'";
		$requests[] = "ALTER TABLE ".TABLE_USER." ADD `alert_mail` INT( 1 ) DEFAULT '1' NOT NULL";
		$requests[] = "ALTER TABLE ".TABLE_USER." ADD `skin` VARCHAR( 50 ) DEFAULT 'skin/' NOT NULL";
		$version = "0.7";
	break;

	case "0.7" :
		$requests[] = "UPDATE ".TABLE_CONFIG." SET value = '0.8' WHERE name = 'version'";
		$requests[] = "ALTER TABLE ".TABLE_USER." ADD `modepq` enum('p','q') DEFAULT 'p' NOT NULL";
		$requests[] = "ALTER TABLE ".TABLE_USER." CHANGE `alert_mail` `alert_mail` enum('0','1') DEFAULT '1' NOT NULL";
		$requests[] = "ALTER TABLE ".TABLE_UNIVERS." CHANGE `url` `info`";
		$requests[] = "ALTER TABLE ".TABLE_TRADE." ADD `deliver` VARCHAR( 255 ) NOT NULL AFTER `note` ,
						ADD `refunding` VARCHAR( 255 ) NOT NULL AFTER `deliver`";
		$requests[] = "ALTER TABLE ".TABLE_TRADE." DROP `deliver_g1` ,
						DROP `deliver_g2` ,
						DROP `deliver_g3` ,
						DROP `deliver_g4` ,
						DROP `deliver_g5` ,
						DROP `deliver_g6` ,
						DROP `deliver_g7` ,
						DROP `deliver_g8` ,
						DROP `deliver_g9` ,
						DROP `refunding_g1` ,
						DROP `refunding_g2` ,
						DROP `refunding_g3` ,
						DROP `refunding_g4` ,
						DROP `refunding_g5` ,
						DROP `refunding_g6` ,
						DROP `refunding_g7` ,
						DROP `refunding_g8` ,
						DROP `refunding_g9`";
		$requests[] = "ALTER TABLE ".TABLE_USER." ADD `deliver` VARCHAR( 255 ) NOT NULL AFTER `modepq` ,
						ADD `refunding` VARCHAR( 255 ) NOT NULL AFTER `deliver`";
		$requests[] = "DROP TABLE ".$table_prefix."trade_deals";
		$requests[] = "DROP TABLE ".$table_prefix."menu";
		$requests[] = "ALTER TABLE ".TABLE_CONFIG." DROP `id`";
		$requests[] = "ALTER TABLE ".TABLE_INFOS." DROP `id`";
		$requests[] = "ALTER TABLE ".TABLE_SESSIONS." ADD `last_visit` INT( 11 ) NOT NULL";
		$requests[] = "ALTER TABLE ".TABLE_SESSIONS." CHANGE `id` `id` INT( 11 ) NOT NULL COMMENT 'Identificateur BD'";
		$requests[] = "ALTER TABLE ".TABLE_UNIVERS." ADD `g` VARCHAR( 3 ) NOT NULL";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET value = '3' WHERE name = 'tauxdeuterium'";
		$requests[] = "UPDATE ".TABLE_CONFIG." SET value = '1' WHERE name = 'tauxmetal'";
		generate_id($db_host, $db_database, $db_user, $db_password, $table_prefix);
		$version = "0.8";
		$up_to_date = true;
		$requests[] = "UPDATE ".TABLE_CONFIG." SET value = '0.81' WHERE name = 'version'";
		$requests[] = "ALTER TABLE ".TABLE_USER."  ADD `trade_closed` BOOLEAN DEFAULT 'false' AFTER `pos_date`";
		$version = "0.81";
		$up_to_date = true;
	case "0.81" :
	$requests[] = "UPDATE ".TABLE_CONFIG." SET value = '2017.1' WHERE name = 'version'";
	$version = "2017.1";
	$up_to_date = true;

	break;


	default:
		$up_to_date = true;
	break;
}

foreach ($requests as $request) {
	if (!($result = $db->sql_query($request)))
	{
		$out = "La requéte : ".$request." est non exécutée, erreur de version!!!";
		echo  $out;
	}
}
?>
	<h3 align='center'><font color='yellow'>Mise &agrave; jour du serveur OGSMarket vers la version <?php echo $version; ?> effectu&eacute;e avec succ&egrave;s</font></h3>
	<center>
	<b><i>Le script a seulement modifi&eacute; la base de donn&eacute;es, pensez &agrave; mettre &agrave; jour vos fichiers</i></b><br />
<?php
if ($up_to_date) {
	echo "\t"."<b><i>Pensez &agrave; supprimer le dossier 'install'</i></b><br />"."\n";
	echo "\t"."<br /><a href='../index.php'>Retour</a>"."\n";
}
else {
	echo "\t"."<br><font color='orange'><b>Cette version n'est pas la derni&egrave;re en date, veuillez r&eacute;&eacute;x&eacute;cuter le script</font><br />"."\n";
	echo "\t"."<a href=''>Recommencer l'op&eacute;ration</a>"."\n";
}
?>
	</center>
</body>
</html>
