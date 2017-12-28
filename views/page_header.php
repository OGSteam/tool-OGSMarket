<?php
	/***************************************************************************
	*	filename	:	page_header.php
	*	Author		:	ericalens 
	*	created		: 	04/06/2006
	*	edited		:	28/09/2007
	***************************************************************************/

	if (!defined('IN_OGSMARKET'))
	 	die ('Hacking attempt');
	
	if (!isset($user_data) || $user_data['skin'] == "")
		$link_css = $server_config['skin'];
	else
		$link_css = $user_data['skin'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
	<head>
		<title><?php echo $server_config['servername'].' - '.$server_config['version']; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo $link_css; ?>formate.css" />
		<link rel="alternate" type="application/rss+xml" title="Flux RSS des Offres" href="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']; ?>?action=rss" />
        <script type='text/javascript' src='js/jquery-3.2.1.min.js'></script>
		<script type='text/javascript' src='js/functions.js'></script>
	</head>
	
	<body>
		<table border="0" width="100%" cellpadding="10" cellspacing="0" align="center">
			<tr>
				<td width="150" align="center" valign="top" rowspan="2"><?php require_once("views/menu.php"); ?></td>
				<td height="70"><div align="center"><a href='index.php'><img src="./images/banniere.gif" border="0"></a></div></td>
			</tr>
			<tr>
				<td align="center" valign="top">
