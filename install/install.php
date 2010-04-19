<?php
/***************************************************************************
*	filename	: index.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 07/01/2006
*	modified	: 06/08/2006 12:11:09
***************************************************************************/
if (!defined('IN_OGSMARKET')) die("Hacking attempt");
$error = '';

if (substr(sprintf('%o', fileperms('../parameters')), -4) != '0777' && !preg_match("^/.free.fr/", $_SERVER["SERVER_NAME"]))
	$error .= '- Le dossier "parameters" n\'est pas autoris&eacute; en &eacute;criture<br />';

if ($error != '')
{
	echo "<b><font color='red'>Installation impossible :</font></b><br />";
	echo $error;
	echo "<br /><br />";
	echo "<i>Veuillez suivre la proc&eacute;dure d'installation dans son int&eacute;gralit&eacute; !!!</i>";
	exit();
}

if (isset($pub_sgbd_server) && isset($pub_sgbd_dbname) && isset($pub_sgbd_username) && isset($pub_sgbd_password) && isset($pub_sgbd_tableprefix) &&
isset($pub_admin_username) && isset($pub_admin_password) && isset($pub_admin_password2)) {

	if (isset($pub_complete)) {
		if (!check_var($pub_admin_username, "Pseudo_Groupname", "", true) || !check_var($pub_admin_password, "Password", "", true)) {
			$pub_error = "Des caract&egrave;res utilis&eacute;s pour le nom d'utilisateur ou le mot de passe ne sont pas corrects";
		}
		else {
			if ($pub_sgbd_server != "" && $pub_sgbd_dbname != "" && $pub_sgbd_username != "" && $pub_admin_username != "" && $pub_admin_password != "" && $pub_admin_password == $pub_admin_password2) {
				installation_db($pub_sgbd_server, $pub_sgbd_dbname, $pub_sgbd_username, $pub_sgbd_password, $pub_sgbd_tableprefix, $pub_admin_username, $pub_admin_password, $pub_admin_password2);
			}
			else {
				$pub_error = "Saisissez correctement les champs de connexion &agrave; la base de donn&eacute;es et du compte administrateur";
			}
		}
	}
	elseif (isset($pub_file)) {
		if ($pub_sgbd_server != "" && $pub_sgbd_dbname != "" && $pub_sgbd_username != "") {
			generate_id($pub_sgbd_server, $pub_sgbd_dbname, $pub_sgbd_username, $pub_sgbd_password, $pub_sgbd_tableprefix);
		}
		else {
			$pub_error = "Saisissez correctement les champs de connexion &agrave; la base de donn&eacute;es";
		}
	}

	$sgbd_server = $pub_sgbd_server;
	$sgbd_dbname = $pub_sgbd_dbname;
	$sgbd_username = $pub_sgbd_username;
	$sgbd_password = $pub_sgbd_password;
	$sgbd_tableprefix = $pub_sgbd_tableprefix;
	$admin_username = $pub_admin_username;
	$admin_password = $pub_admin_password;
	$admin_password2 = $pub_admin_password2;
}
?>

<p class='error bold'>
	<?php echo isset($pub_error) ? $pub_error : ''; ?>
</p>

<form method='post' action='index.php'>
	<table>
		<tr>
			<th colspan='2'>Configuration de la base de donn&eacute;es</th>
		</tr>
	
		<tr>
			<td class='taille'>Nom du serveur de base de donn&eacute;es / SGBD</td>
			<td><input name='sgbd_server' type='text' value='<?php echo isset($pub_sgbd_server) ? $pub_sgbd_server : ''; ?>' /></td>
		</tr>	
		<tr>
			<td>Nom de votre base de donn&eacute;es</td>
			<td><input name='sgbd_dbname' type='text' value='<?php echo isset($pub_sgbd_dbname) ? $pub_sgbd_dbname : ''; ?>' /></td>
		</tr>	
		<tr>
			<td>Nom d'utilisateur de la base de donn&eacute;es</td>
			<td><input name='sgbd_username' type='text' value='<?php echo isset($pub_sgbd_username) ? $pub_sgbd_username : ''; ?>' /></td>
		</tr>	
		<tr>
			<td>Mot de passe</td>
			<td><input name='sgbd_password' type='password' /></td>
		</tr>	
		<tr>
			<td>Pr&eacute;fixe des tables (Merci de laisser market_ pour l'instant)</td>
			<td><input name='sgbd_tableprefix' type='text' value='<?php echo isset($pub_sgbd_tableprefix) ? $pub_sgbd_tableprefix : 'market_'; ?>' /></td>
		</tr>
	</table>

	<table>
		<tr>
			<th colspan='2'>Configuration du compte administrateur</th>
		</tr>
	
		<tr>
			<td class='taille'>Nom d'utilisateur</td>
			<td><input name='admin_username' type='text' value='<?php echo isset($pub_admin_username) ? $pub_admin_username : ''; ?>' /></td>
		</tr>	
		<tr>
			<td>Mot de passe</td>
			<td><input name='admin_password' type='password' /></td>
		</tr>	
		<tr>
			<td>Confirmez le mot de passe</td>
			<td><input name='admin_password2' type='password' /></td>
		</tr>
	</table>

	<p>
		<input type='hidden' name='redirection' value='install' />
		<input name='complete' type='submit' value="D&eacute;marrer l'installation compl&egrave;te" />
		&nbsp;ou&nbsp;
		<input name='file' type='submit' value="G&eacute;n&eacute;rer le fichier 'id.php'" />
	</p>
</form>

<p>
	<a href='http://ogsteam.fr/OGSpynstall/' class='italic'>Besoin d'assistance ?</a>
</p>

<script type='text/javascript' src='../js/prototype.js'></script>
