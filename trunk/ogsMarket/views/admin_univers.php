<?php
/***************************************************************************
*	filename	: Admin_univers.php
*	desc.		:
*	Author		: Mirtador
*	created		: 11/21/06
***************************************************************************/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
?>
<table width="80%" align="center">
	<tr>
		<td colspan='6'>
			<table align="center">
				<tr>
					<th>
						<input type="button" value="Ajouter un March&eacute;" id="create_market" />
					</th>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="l" colspan="6">Liste des March&eacute;s</td>
	</tr>
	<tr>
		<td class="c">ID</td>
		<td class="c">Nom</td>
		<td class="c">Description</td>
		<td class="c">Nb. de Galaxie</td>
		<td class="c" colspan="2">Action</td>
	</tr>

	<?php
		foreach ($Universes->universes_array() as $universe)
		{
			$id = $universe['id'];
		
			echo "\n" .'<tr>';
			echo "\n\t" .'<th>'. $id .'</th>';
			echo "\n\t" .'<th id="name_'. $id .'">'. $universe['name'] .'</th>';
			echo "\n\t" .'<th id="info_'. $id .'">'. $universe['info']. '</th>';
			echo "\n\t" .'<th id="g_'. $id .'">'. $universe['g'] .'</th>';
			echo "\n\t" .'<th><input type="image" src="images/help_2.png" title="Modifier le march&eacute; : '. $universe['name'] .'" id="edit_market_'. $id .'" /></th>';
			echo "\n\t" .'<th>';
			echo "\n\t\t" .'<form method="post" action="index.php?action=admin_delete_univers&universeid='. $id .'" onsubmit="return confirm(\'Êtes-vous s&ucirc;r de vouloir supprimer '. $universe['name'] .'\');">';
			echo "\n\t\t\t" .'<input type="image" src="images/drop.png" title="Supprimer le march&eacute; : '. $universe['name'] .'" />';
			echo "\n\t\t" .'</form>';
			echo "\n\t" .'</th>';
			echo "\n" .'</tr>';
		}
	?>
</table>

<!-- Pop-up pour la creation/edition des marches -->
<div id='new_market'>
	<form action='index.php' method='post'>
		<input id="admin_maction" type="hidden" name="action" value="" />
		<input id="admin_mid" type="hidden" name="id" value="" />
		
		<table>
			<tr>
				<th colspan="2">Ajouter un March&eacute;</th>
			</tr>
			
			<tr>
				<td>Nom du March&eacute;</td>
				<td><input id="admin_mname" type="text" name="name" value="" /></td>
			</tr>
			<tr>
				<td>Description</td>
				<td><input id="admin_minfo" type="text" name="info" value="" /></td>
			</tr>
			<tr>
				<td>Nb. de Galaxie</td>
				<td><input id="admin_mg" type="text" name="g" value="9" /></td>
			</tr>
			
			<tr>
				<td class='center' colspan="2">
					<input type="submit" value="Cr&eacute;er" id="action" />
					<input type="button" value="Annuler" id="hide_new_market" />
				</td>
			</tr>
		</table>
	</form>
</div>
