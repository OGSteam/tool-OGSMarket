<?php
/***************************************************************************
*	filename	: inscription.php
*	desc.		:
*	Author		: ericalens - http://ogsteam.fr/
*	created		: 17/12/2005
*	modified	: 28/12/2005 23:56:40
*	modified	: dimanche 11 juin 2006, 01:05:08 (UTC+0200)
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");

?>

<br>
<form action="index.php" method="post">
<input type="hidden" name="action" value="newaccount" />

<table width="400">
<?php 
	if (isset($pub_info)) echo "<tr><th class='c' colspan='2'><h2>".$pub_info."</h2></th></tr>";
?>
<tr><td class="c" colspan="2" align="center">Param&egrave;tres de connexion</td></tr>
<tr><th>login*</th><th><input type="text" name="name" value="<?php if (isset($pub_name)) echo $pub_name; ?>" /></tr>
<tr><th>mot de passe*</th><th><input type="password" name="password" value="" /></tr>
<tr><th>r&eacute;p&eacute;tez le mot de passe*</th><th><input type="password" name="repassword" value="" /></tr>
<tr><th>Email*</th><th><input type='text' name='email' value="<?php if(isset($pub_email)) echo $pub_email; ?>" /></th></tr>
<tr><td class="c" colspan="2" align="center">Votre profil</td></tr>
<tr><th>Msg Priv&eacute;</th><th><input type='text' name='pm_link' value="<?php if(isset($pub_pm_link)) echo $pub_pm_link; ?>" /></th></tr>
<tr><th>Nom IRC</th><th><input type='text' name='irc_nick' value="<?php if(isset($pub_irc_nick)) echo $pub_irc_nick; ?>" /></th></tr>
<tr><th>Ma Description</th><th><textarea name='note'><?php if(isset($pub_note)) echo $pub_note; ?></textarea></th></tr>
<tr><th colspan="2"><input type="submit" value="S'enregistrer" /></th></tr>
</table>
<h5>* champs obligatoires</h5>
</form>

<?php
require_once("views/page_tail.php");
?>
