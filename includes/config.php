<?php
	/***********************************************************************
	 * filename	:	config.php
	 * desc.	:	Inclusion G&eacute;n&eacute;rales
	 * created	: 	04/06/2006 ericalens
	 *
	 * *********************************************************************/

	if (!defined('IN_OGSMARKET'))
		exit('Hacking attempt');

	// Définitions des noms des tables de la BDD
	if (!defined('INSTALL_IN_PROGRESS') || defined('UPGRADE_IN_PROGRESS'))
	{
		define('TABLE_COMMENT', $table_prefix .'comment');
		define('TABLE_CONFIG', $table_prefix .'config');
		define('TABLE_INFOS', $table_prefix .'infos');
		define('TABLE_SESSIONS', $table_prefix .'sessions');
		define('TABLE_TRADE', $table_prefix .'trade');
		define('TABLE_UNIVERS', $table_prefix .'univers');
		define('TABLE_USER', $table_prefix .'user');
		define('TABLE_OGSPY_AUTH', $table_prefix .'ogspy_auth');
	}
?>
