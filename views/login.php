<?php
/***************************************************************************
*	filename	: login.php
*	desc.		:
*	Author		: ericalens - http://ogsteam.fr/
*	created		: samedi 10 juin 2006, 02:12:39 (UTC+0200)
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

if ($Users->login($pub_name, $pub_password)) {
	redirection("index.php");
} else {
unset($_SESSION["username"]);
unset($_SESSION["userpass"]);

require_once("views/page_header.php");
}
?>

<table width="100%">
<tr>
	<td>
		<table width="100%">
		<tr align="center">
			<td align="center"><a href='https://www.ogsteam.fr'>OGSMarket</a>: Le commerce Ogamien par l'<b>OGSTeam</b></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
		<table width="100%">
		<tr><th>
		Echec de l'authentification<br>
		(Login/Password incorrects)
		<br><br>
		<font color="yellow">Si vous venez de vous inscrire,<br>
		c'est que votre compte n'a pas &eacute;t&eacute; activ&eacute; automatiquement.<br><br>
		Veuillez contacter l'administrateur !!</font>
		</th></tr>
		</table>
	</td>
</tr>
</table>

<?php
require_once("views/page_tail.php");
?>
