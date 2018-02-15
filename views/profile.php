<?php
/***************************************************************************
*	filename	: profile.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 17/12/2005
*	modified	: 29/12/2005 23:56:40
***************************************************************************/

if (!defined('IN_OGSMARKET')) die ('Hacking attempt');

require_once ('views/page_header.php');

if (isset($pub_id) && $pub_id != "") {
	$user = $Users->get_user($pub_id);

	if (!$user)
		echo '<p>Aucun profil n\'a été trouvé !</p>';
	else {
?>
<table width='300' class='convertisseur'>
	<tr>
		<th colspan="2">Profil utilisateur de <?php echo $user["name"]; ?></th>
	</tr>
	<tr>
		<td>Enregistrement</td>
		<td><?php echo strftime("%a %d %b %H:%M:%S", $user["regdate"]); ?></td>
	</tr>
	<tr>
		<td>Derni&egrave;re connexion</td>
		<td><?php echo strftime("%a %d %b %H:%M:%S", $user["lastvisit"]); ?></td>
	</tr>
	<tr>
		<td>Pseudo IG</td>
		<td>	<?php
					if (empty($user["pm_link"]))
						echo 'Non renseign&eacute;';
					else
						echo $user["pm_link"];
				?>
		</td>
	</tr>
	<tr>
		<td>Pseudo sur IRC</td>
		<td>	<?php
					if (empty($user["irc_nick"]))
						echo 'Non renseign&eacute;';
					else
						echo "<a href='https://www.ogsteam.fr' target='_blank'>".$user["irc_nick"]."</a>";
				?>
		</td>
	</tr>
	<tr>
		<td>Note</td>
		<td><textarea name="note"><?php echo $user["note"]; ?></textarea></td>
	</tr>
</table>

<?php }
} else { ?>
	<p>
	Afin d'etre contact&eacute; pour un &eacute;change, les joueurs peuvent acc&eacute;der &agrave; votre profil et utiliser les liens suivants. N'oubliez donc pas de le remplir !<br>
	</p>

	<form action='index.php' method='post'>
	<input type='hidden' name='action' value='set_profile' />
	<table class='convertisseur'>
		<tr>
			<td align="center" class="c" colspan='3'>Edition de votre Profil</th>
		</tr>
		<tr>
			<th>Adresse e-mail</th>
			<th><input type='text' name='email' value='<?php echo $user_data["email"]; ?>' /></th>
		</tr>
		<tr>
			<th>Pseudo IG</th>
			<th><input type='text' name='pm_link' value='<?php echo $user_data["pm_link"]; ?>' /></th>
		</tr>
		<tr>
			<th>Nom IRC</th>
			<th><input type='text' name='irc_nick' value='<?php echo $user_data["irc_nick"]; ?>' /></th>
		</tr>
		<tr>
		<th>Lien Avatar</th>
		<th><input type='text' name='avatar_link' value='<?php echo $user_data["avatar_link"]; ?>' /></th>
	  </tr>
		<tr>
			<th>Ma description</th>
			<th><textarea name='note'><?php echo $user_data['note']; ?></textarea></th>
		</tr>
		<tr>
			<td align="center" class="c" colspan='3'>Options du compte</td>
		</tr>
		<tr>
			<th>Alerte par e-mail lors d'une nouvelle offre ?</th>
			<th><input type='checkbox' name='alert_mail' value='1' <?php if ($user_data["alert_mail"] == '1') {echo 'checked="checked"'; } ?> /></th>
		</tr>
		<tr>
			<th>Présélection du mode de saisie des ressources demandées</th>
			<th>- % - <input type='radio' name='modepq' value='p' <?php if ($user_data["modepq"] == 'p') {echo 'checked="checked"'; } ?> /> - Q - <input type='radio' name='modepq' value='q' <?php if ($user_data["modepq"] == 'q') {echo 'checked="checked"'; } ?> /></th>
		</tr>
		<tr>
			<th>
				Présélection des galaxies de livraison
				<br /><input type="button" id="inverse-deliver" name="valide" value="Inverser la sélection" />
			</th>
			<th>
				<?php
					for ($i = 1; $i <= 18; $i++) {
						echo 'G'.$i.'<input type="checkbox" value="'.$i.'" id="deliver['.$i.']" name="deliver['.$i.']" '.($user_data["deliver"][$i] == 1 ? '"checked="checked"' : '').'/>';
						if (($i/3) == ceil($i/3)) echo "<br/>";
					}
				?>
			</th>
		</tr>
		<tr>
			<th>
				Présélection des galaxies de réception
				<br /><input type="button" id="inverse-refunding" name="valide" value="Inverser la sélection" />
			</th>
			<th>
				<?php
					for ($i = 1; $i <= 18; $i++) {
						echo 'G'.$i.'<input type="checkbox" value="'.$i.'" id="refunding['.$i.']" name="refunding['.$i.']" '.($user_data["refunding"][$i] == 1 ? '"checked="checked"' : '').'/>';
						if (($i/3) == ceil($i/3)) echo "<br/>";
					}
				?>

			</th>
		</tr>
		<tr>
			<th>Skin utilisateur<br>-Skin interne : tapez "skin/"<br>-Skin par défault (admin) : laissez le champ vide<br>-Skin perso : tapez "http://url..."</th>
			<th><input type='text' name='skin' value='<?php echo $user_data["skin"]; ?>'/></th>
		</tr>
	</table>

	<input type='submit' value='Sauvegarder' />
</form>
<?php }
require_once ('views/page_tail.php');
?>
