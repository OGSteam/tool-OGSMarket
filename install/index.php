<?php
	/***************************************************************************
	*	filename	: index.php
	*	desc.		:
	*	Author		: Kyser - https://www.ogsteam.fr/
	*	created		: 07/01/2006
	*	modified	: 06/08/2006 12:11:09
	***************************************************************************/

	define('IN_OGSMARKET', true);
	define('INSTALL_IN_PROGRESS', true);
	if (isset($_POST['upgrade']) && !defined("UPGRADE_IN_PROGRESS")) define("UPGRADE_IN_PROGRESS", true);

	require_once('../common.php');
	require_once('functions.php');

	$version = '2018.2';

	if (!isset($pub_redirection))
		$pub_redirection = '';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='fr'>
	<head>
		<title>Installation d'OGSMarket</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
		<link rel='stylesheet' type='text/css' href='../skin/formate.css' />
		<link rel='stylesheet' type='text/css' href='style.css' />
	</head>

	<body>
		<div id='logo'></div>

		<h2>Bienvenue dans l'installation d'OGSMarket v <?php echo $version; ?></h2>

		<?php
			if ($pub_redirection == 'install')
				include('install.php');
			else if ($pub_redirection == 'upgrade')
				include('upgrade_to_latest.php');
			else
			{
		?>

		<p>
			Si vous souhaitez plus d'information, rendez vous sur ce forum : <a href='https://forum.ogsteam.fr/'>https://forum.ogsteam.fr/</a>
		</p>

		<form action='index.php' method='post'>
			<p>
				<label for='redirection'>Choisissez quel action vous d&eacute;sirez effectuer :</label>
				<select id='redirection' name='redirection' onchange='this.form.submit();' onkeyup='this.form.submit();'>
					<option></option>
					<option value='install'>Installation compl&egrave;te</option>
					<!--<option value='upgrade'>Mise &agrave; jour</option>-->
				</select>
			</p>
		</form>

		<?php
			}
		?>

		<p>
			<span class='italic'><span class='bold'>OGSMarket</span> is a <span class='bold'>OGSTeam Software</span> &copy; 2005-2018</span><br />
			v <?php echo $version; ?>
		</p>
	</body>
</html>
