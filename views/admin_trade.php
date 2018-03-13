<?php
/***************************************************************************
*	filename	: home.php
*	desc.		: 
*	Author		: Digiduck - http://ogsteam.fr/
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

//Convertion en heures (suite)
$max_trade_delay = ($server_config["max_trade_delay_seconds"])/60/60/24;

//Conversion des attributs des checkbox
$member_view_trade = ($server_config["view_trade"]) == 1 ? "checked" : "";


?>
<form action="index.php?action=admin_market_set" method="POST">
<table align='center' width='80%'>
<tr>
	<td>
		<table width="100%">
<!--General-->
			<tr><td class="c" colspan="2" align="center">Configuration G&eacute;n&eacute;rale</td></tr>
				<tr>
					<th width="50%">Nombre maximum d'&eacute;changes:</th>
					<th><input type="text" name="max_trade_by_universe" size="100%" value="<?php echo $server_config["max_trade_by_universe"]?>"/></th>
				</tr>
				<tr>
					<th>Temps max. d'un &eacute;change (Jours):</th>
					<th><input type="text" name="max_trade_delay" size="100%" value="<?php echo $max_trade_delay ?>"/></th>
				</tr>

<!--Taux-->
			<tr><td class="c" colspan="2" align="center">Taux de Change Officiel</td></tr>
				<tr>
					<th>M&eacute;tal</th>
					<th><input type="text" name="tauxmetal" size="100%" value="<?php echo $server_config["tauxmetal"]?>"/></th>
				</tr>

				<tr>
					<th>Cristal</th>
					<th><input type="text" name="tauxcristal" size="100%" value="<?php echo $server_config["tauxcristal"]?>"/></th>
				</tr>
				
				<tr>
					<th>Deut&eacute;rium</th>
					<th><input type="text" name="tauxdeuterium" size="100%" value="<?php echo $server_config["tauxdeuterium"]?>"/></th>
				</tr>

<!--Offres-->
			<tr><td class="c" colspan="2" align="center">Options des Offres</td></tr>

				<tr>
					<th>Visualisation des offres limit&eacute;e aux membres</th>
					<th><input type="checkbox" name="view_trade" size="100%" value="1" <?php echo $member_view_trade; ?> /></th>
				</tr>
			<tr><td colspan="2" class="c" align="center"><input type="submit"></td></tr>
		</table>
		</form>
	</td>
</table>