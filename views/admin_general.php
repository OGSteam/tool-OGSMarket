<?php
/***************************************************************************
*	filename	: Admin_general.php
*	desc.		:
*	Author		: Mirtador
*	created		: 11/15/06
***************************************************************************/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
//Conversion en heures (suite)
$max_trade_delay = ($server_config["max_trade_delay_seco"])/60/60;

//Conversion des attributs des checkbox
$member_activ_auto = ($server_config["users_active"]) == 1 ? "checked" : "";
?>
<table align='center' width='80%'>
<tr>
	<th>
		<form action="index.php?action=admin_config_set" method="post">
		<table width="100%">
				<tr>
					<td class="c" colspan="2" align="center">Configuration G&eacute;n&eacute;ral</td>
				</tr>
				<tr>
					<th>Nom du serveur:</th>
					<th><input type="text" name="servername" size="100%" value="<?php echo $server_config["servername"]?>"/></th>
				</tr>

				<tr>
					<th>Skin de base:</th>
					<th><input type="text" name="skin" size="100%" value="<?php echo $server_config["skin"]?>"/></th>
				</tr>

				<tr>
					<th>Logo Serveur:</th>
					<th><input type="text" name="logo_server" size="100%" value="<?php echo $server_config["logo_server"]?>"/></th>
				</tr>

				<tr>
					<th>Activation automatique des nouveaux membres:</th>
					<th><input type="checkbox" name="member_auto_activ" value="1" <?php echo $member_activ_auto ?> /></th>
				</tr>

<!--Forum-->
				<tr>
					<td class="c" colspan="2" align="center">Forum</td>
				</tr>
				<tr>
					<th>Nom du forum:</th>
					<th><input type="text" name="nomforum" size="100%" value="<?php echo $server_config["nomforum"]?>"/></th>
				</tr>

				<tr>
					<th>Adresse du forum:</th>
					<th><input type="text" name="adresseforum" size="100%" value="<?php echo $server_config["adresseforum"]?>"/></th>
				</tr>

<!--Mail-->
				<tr>
					<td class="c" colspan="2" align="center">Mailing List</td>
				</tr>
				<tr>
					<th>Nom de l'exp&eacute;diteur:</th>
					<th><input type="text" name="mail_nom_expediteur" size="100%" value="<?php echo $server_config["mail_nom_expediteur"]?>"/></th>
				</tr>
				<tr>
					<th>Mail de l'exp&eacute;diteur:</th>
					<th><input type="text" name="mail_expediteur" size="100%" value="<?php echo $server_config["mail_expediteur"]?>"/></th>
				</tr>
				<tr>
					<th>Object du mail:</th>
					<th><input type="text" name="mail_object" size="100%" value="<?php echo $server_config["mail_object"]?>"/></th>
				</tr>

				<tr>
					<th>Ent&ecirc;te du mail:</th>
					<th><input type="text" name="mail_message" size="100%" value="<?php echo $server_config["mail_message"]?>"/></th>
				</tr>

<!--catégorie-->

				<tr>
					<td class="c" colspan="2" align="center">Nom des Cat&eacute;gories</td>
				</tr>
				<tr>
					<th>Priv&eacute;s:</th>
					<th><input type="text" name="menuprive" size="100%" value="<?php echo $server_config["menuprive"]?>"/></th>
				</tr>

				<tr>
					<th>forum:</th>
					<th><input type="text" name="menuforum" size="100%" value="<?php echo $server_config["menuforum"]?>"/></th>
				</tr>

				<tr>
					<th>Logout:</th>
					<th><input type="text" name="menulogout" size="100%" value="<?php echo $server_config["menulogout"]?>"/></th>
				</tr>
				<tr>
					<th>autre:</th>
					<th><input type="text" name="menuautre" size="100%" value="<?php echo $server_config["menuautre"]?>"/></th>
				</tr>

<!--messages-->
				<tr>
					<td class="c" colspan="2" align="center">Configuration des messages configurables (En html sans ligne)</td>
				</tr>

				<tr>
					<th>message d'accueil:</th>
					<th><textarea name="home" rows="7"><?php echo stripcslashes($infos_config["home"]); ?></textarea></th>
				</tr>

<!--Authentification-->

				<tr>
					<td class="c" colspan="2" align="center">Configuration Authentification</td>
				</tr>
				<tr>
				<th width="50%">Type Authentification:</th>
				<th>
					<select name="users_auth_type">
						<option value="internal" <?php if ($server_config["users_auth_type"] == "internal") {echo " SELECTED"; } ?>>Internal</option>
						<option value="punbb" <?php if ($server_config["users_auth_type"] == "punbb") {echo " SELECTED"; } ?>>PunBB</option>
						<option value="smf" <?php if ($server_config["users_auth_type"] == "smf") {echo " SELECTED"; } ?>>SMF</option>
						<option value="phpbb2" <?php if ($server_config["users_auth_type"] == "phpbb2") {echo " SELECTED"; } ?>>PHPBB2</option>
					</select>
				</th>
			</tr>
			<tr>
				<th>Adresse Du Server SQL:</th>
				<th><input type="text" name="users_adr_auth_db" size="100%" value="<?php echo $server_config["users_adr_auth_db"]?>"/></th>
			</tr>
			<tr>
				<th>Base d'identification:</th>
				<th><input type="text" name="users_auth_db" size="100%" value="<?php echo $server_config["users_auth_db"]?>"/></th>
			</tr>
			<tr>
				<th>User Base d'identification:</th>
				<th><input type="text" name="users_auth_dbuser" size="100%" value="<?php echo $server_config["users_auth_dbuser"]?>"/></th>
			</tr>
			<tr>
				<th>Password Base d'identification:</th>
				<th><input type="text" name="users_auth_dbpassword" size="100%" value="<?php echo $server_config["users_auth_dbpassword"]?>"/></th>
			</tr>
			<tr>
				<th>Table d'identification:</th>
				<th><input type="text" name="users_auth_table" size="100%" value="<?php echo $server_config["users_auth_table"]?>"/></th>
			</tr>
			<tr>
				<th>URL d'inscription:</th>
				<th><input type="text" name="users_inscription_ur" size="100%" value="<?php echo $server_config["users_inscription_ur"]?>"/></th>
			</tr>

<!--MOD MARKET-->
			<tr>
				<td class="c" colspan="2" align="center">Authentification Mod Market</td>
			</tr>
			<tr>
			<th width="50%">Lecture des offres:</th>
				<th>
						<select name="market_read_access">
							<option value="0" <?php if ($server_config["market_read_access"] == "0") {echo " SELECTED"; } ?>>0 - Public</option>
							<option value="1" <?php if ($server_config["market_read_access"] == "1") {echo " SELECTED"; } ?>>1 - Mot de passe</option>
							<option value="2" <?php if ($server_config["market_read_access"] == "2") {echo " SELECTED"; } ?>>2 - URI</option>
							<option value="3" <?php if ($server_config["market_read_access"] == "3") {echo " SELECTED"; } ?>>3 - URI + Mot de passe</option>
						</select>
					</th>
				</tr>
				<tr>
					<th>Cr&eacute;ation d'offre:</th>
					<th>
						<select name="market_write_access">
							<option value="0" <?php if ($server_config["market_write_access"] == "0") {echo " SELECTED"; } ?>>0 - Public</option>
							<option value="1" <?php if ($server_config["market_write_access"] == "1") {echo " SELECTED"; } ?>>1 - Mot de passe</option>
							<option value="2" <?php if ($server_config["market_write_access"] == "2") {echo " SELECTED"; } ?>>2 - URI</option>
							<option value="3" <?php if ($server_config["market_write_access"] == "3") {echo " SELECTED"; } ?>>3 - URI + Mot de passe</option>
						</select>
					</th>
				</tr>
				<tr>
					<th>Password Acc&egrave;s:</th>
					<th><input type="password" name="market_password" size="100%" value="<?php echo $server_config["market_password"]?>"/></th>
				</tr>
			<tr><th colspan="2" align="center"><input type="submit"></th></tr>
		</table>
	</form>
	</th>
</tr>

<tr>
	<td class="c" align="center">Autres Param&egrave;tres</th>
</tr>

<tr>
	<th>
		<table width="100%" align="center">
			<tr>
				<td class="l" colspan="5">Liste des OGSpys autoris&eacute;s &agrave; poster</td>
			</tr>
			<tr>
				<td class="c">URL</td>
				<td class="c">Description</td>
				<td class="c">Acc&egrave;s Lecture</td>
				<td class="c">Acc&egrave;s Ecriture</td>
				<td class="c">Actif</td>
			</tr>
<?php
			$query = "SELECT `id`, `url`, `read_access`, `write_access`, `active`, `description` from ".TABLE_OGSPY_AUTH.";";
			$result = $db->sql_query($query);
			while (list($id, $url, $read_access, $write_access, $active, $description) = $db->sql_fetch_row($result)) {
				echo "<tr><th>$url</th><th>$description</th><th>$read_access</th><th>$write_access</th><th>$active</th></tr>";
			}
?>
		</table>
	</th>
</tr>
</table>
