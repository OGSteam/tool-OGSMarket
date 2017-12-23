<?php if (!defined('IN_OGSMARKET')) die("Hacking attempt");

//require_once("../common.php");

function installation_db($sgbd_server, $sgbd_dbname, $sgbd_username, $sgbd_password, $sgbd_tableprefix, $admin_username, $admin_password, $admin_password2)
{
	global $version;

	$db = sql_db::getInstance($sgbd_server, $sgbd_username, $sgbd_password, $sgbd_dbname);

	if (!$db->db_connect_id)
	 	error_sql('Impossible de se connecter &agrave; la base de donn&eacute;es');

	$admin_username = $db->sql_escape_string($admin_username);
	$admin_password = md5($admin_password);
	$time = time();

	// Cr&eacute;ation de la structure de la base de donn&eacute;es

	$sql_query = fread(fopen('schemas/database.sql', 'r'), filesize('schemas/database.sql')) or die ('<h1>Le script SQL d\'installation est introuvable !</h1>');
	$sql_query = preg_replace("#market_#", $sgbd_tableprefix, $sql_query);

	$sql_query = explode(';', $sql_query);

	$sql_query[]  = "INSERT INTO ".$sgbd_tableprefix."user (`name`, `password`, `regdate`, `lastvisit`, `countconnect`, `account_type`, `is_admin`, `is_moderator`, `is_active`, `alert_mail`, `skin`)  VALUES ('$admin_username', '$admin_password', '$time', '$time', '1', 'internal', '1', '1', '1', '1', 'skin/')";

	$sql_query[]  = "INSERT INTO ".$sgbd_tableprefix."config (`name`, `value`) VALUES('version','$version')";
	$sql_query[]  = "INSERT INTO ".$sgbd_tableprefix."infos (`name`, `value`) VALUES ('home', '
		<p align=\"center\"><b><font size=\"4\">Bienvenue sur votre Market!</font></b></p><p align=\"center\">
		<font size=\"4\">Félicitations ! Vous venez d\'installer OGMarket ".$version." !</font></p><p align=\"center\">
		<font size=\"4\">Vous pourrez maintenant beaucoup plus personnaliser votre serveur grace au panneau d\'administration !</font></p>
		<p align=\"center\"><font size=\"4\">Vous devriez des maintenant pouvoir vous loguer grace a votre compte Admin</font></p><p align=\"center\"></p>')";


	foreach ($sql_query as $request)
	{
		if (trim($request) != '')
		{
			if (!($result = $db->sql_query($request, false, false)))
			{
				$error = $db->sql_error($result);
			}
		}
	}
	generate_id($sgbd_server, $sgbd_dbname, $sgbd_username, $sgbd_password, $sgbd_tableprefix);
}

function generate_id($sgbd_server, $sgbd_dbname, $sgbd_username, $sgbd_password, $sgbd_tableprefix) {
	global $version;

	$id_php[] = '<?php';
	$id_php[] = '/***************************************************************************';
	$id_php[] = '*	filename	: id.php';
	$id_php[] = '*	generated	: '.date("d/M/Y H:i:s");
	$id_php[] = '***************************************************************************/';
	$id_php[] = '';
	$id_php[] = 'if (!defined("IN_OGSMARKET")) die("Hacking attempt");';
	$id_php[] = '';
	$id_php[] = '$table_prefix = "'.$sgbd_tableprefix.'";';
	$id_php[] = '';
	$id_php[] = '//Param&egrave;tres connexion &agrave; la base de donn&eacute;e';
	$id_php[] = '$db_host = "'.$sgbd_server.'";';
	$id_php[] = '$db_user = "'.$sgbd_username.'";';
	$id_php[] = '$db_password = "'.$sgbd_password.'";';
	$id_php[] = '$db_database = "'.$sgbd_dbname.'";';
	$id_php[] = '';
	$id_php[] = 'define("OGSMARKET_INSTALLED", TRUE);';
	$id_php[] = '?>';
	if (!write_file("../parameters/id.php", "w", $id_php)) {
		die("Echec installation, impossible de générer le fichier 'parameters/id.php'");
	}

	echo "<h3 align='center'><font color='yellow'>Installation du serveur OGSMarket ".$version." effectu&eacute;e avec succ&egrave;s</font></h3>";
	echo "<center>";
	echo "<b>Pensez &agrave; supprimer le dossier 'install'</b><br />";
	echo "<a href='../index.php'>Retour</a>";
	echo "</center>";
	exit();
}

?>
