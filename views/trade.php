<?php
/***********************************************************************
 * filename	:	newtrade.php
 * desc.	:	Fichier principal
 * based 	: 	Convertisseur.php by Mirtador
 * created  :   Digiduck pour OGSMarket
 * *********************************************************************/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
require_once("views/page_header.php");

// DÈfinition du ouvert
if (isset($pub_ouvert)) $ouvert = $pub_ouvert;
else $ouvert = "0";
if ($ouvert == "1") {
	//dÈfinition des variables
	$metal = $pub_metal;
	$cristal = $pub_cristal;
	$deuterium = $pub_deuterium;
	$tauxm = $pub_tauxm;
	$tauxc = $pub_tauxc;
	$tauxd = $pub_tauxd;
	$combienm = $pub_combienm;
	$combienc = $pub_combienc;
	$combiend = $pub_combiend;
	$base = $pub_base;

	if ($base == "p") {
// Calcul par poucentage
		//message d'erreures
		$total_pourc = ($combienm) + ($combienc) + ($combiend);
		if ($total_pourc != "100") {
			echo "Le total des pourcentages doit donner 100%";
			$error = "1";
		}
		elseif ($metal == "0" && $cristal == "0" && $deuterium == "0") {
			echo "Vous devez mettre au moins une ressource que vous souhaitez &eacute;changer";
			$error = "1";
		}
		else {
		//On fait les totaux des taux
			if ($tauxm != "0" && $tauxc != "0" && $tauxd != "0")
			$Valleur = ($metal)/($tauxm) + ($cristal)/($tauxc) + ($deuterium)/($tauxd);
			else $Valleur = 0;
		//on calcule
			if ($tauxm != "0" && $tauxm != "" && $combienm != "0" && $combienm != "") {
				$pourcM = ($combienm)/100;
				$TotalM = ($Valleur)*($pourcM)*($tauxm);
			}
			if ($tauxc != "0" && $tauxc != "" && $combienc != "0" && $combienc != "") {
				$pourcC = ($combienc)/100;
				$TotalC = ($Valleur)*($pourcC)*($tauxc);
			}
			if ($tauxd != "0" && $combiend != "0" && $tauxd != "" && $combiend != "") {
				$pourcD = ($combiend)/100;
				$TotalD = ($Valleur)*($pourcD)*($tauxd);
			}
		}
	}

	if ($base == "q") {
//ou quantité
		//message d'erreur
		if ($metal == "0" && $cristal == "0" && $deuterium == "0") {
			echo "Vous devez mettre au moins une ressource que vous souhaitez échanger";
			$error = "1";
		}
		else {
		//On transpose les valeurs
			$TotalM = $combienm;
			$TotalC = $combienc;
			$TotalD = $combiend;
		}
	}
}
?>

<table align="center" width="60%"  class='style'>
	<tr>
		<td class="c" ><?php echo $value; ?> une offre pour l'<?php echo $current_uni["name"]; ?></td>
	</tr>
	<tr>
		<td>
			Attention les offres sont en K c'est &agrave; dire en milliers de ressources ( 10k Metal = 10.000 Métal)<br>
			N'oubliez pas de mettre &agrave; jour votre profil afin d'y laisser les informations pour vous contacter.<br>
			Vous pouvez modifier votre offre aussi souvent que vous le souhaitez. La prolongation est soumise &agrave; une limitation.
		</td>
	</tr>
</table>
<?php if ($value == "Creer") { ?>
<form action="index.php?action=newtrade" method="post">
	<input type="hidden" name="ouvert" value="1"/> 
<table align="center" width="60%">
	<tr>
		<td align="center">
			<table>
				<tr>
					<td class="l" colspan="2">
						<acronym title="Mettez ici, la quantité de ressource que vous souhaitez 2changer">Quantit&eacute;s</acronym> (K)
					</td>
				</tr>
				<tr>
					<td class="c">M&eacute;tal:</td>
					<td class="l">
						<input type="text" name="metal" value="<?php echo(isset($metal) ? $metal : '0'); ?>" />
					</td>
				</tr>
				<tr>
					<td class="c">Cristal:</td>
					<td class="l">
						<input type="text" name="cristal" value="<?php echo (isset($cristal) ? $cristal : '0'); ?>" />
					</td>
				</tr>
				<tr>
					<td class="c">Deut&eacute;rium:</td>
					<td class="l">
						<input type="text" name="deuterium" value="<?php echo (isset($deuterium) ? $deuterium : '0'); ?>" />
					</td>
				</tr>
			</table>
		</td>
		<td align="center">
			<table>
				<tr>
					<td class="l" colspan="2">
						<acronym title="Ici vous d&eacute;cidez a quel taux vous voulez vendre">Taux</acronym> (modifiable)
					</td>
				</tr>
				<tr>
					<td class="c">M&eacute;tal</td>
					<td class="l">
						<input type="text" name="tauxm" value="<?php echo (isset($tauxm) ? $tauxm : $server_config["tauxmetal"]); ?>" />
					</td>
				</tr>
				<tr>	
					<td class="c">Cristal</td>
					<td class="l">
						<input type="text" name="tauxc" value="<?php echo (isset($tauxc) ? $tauxc : $server_config["tauxcristal"]); ?>" />
					</td>
				</tr>
				<tr>	
					<td class="c">Deut&eacute;rium</td>
					<td class="l">
						<input type="text" name="tauxd" value="<?php echo (isset($tauxd) ? $tauxd : $server_config["tauxdeuterium"]); ?>" />
					</td>
				</tr>
			</table>
		</td>
		<td align="center">
			<table>
				<tr>
					<td class="l" colspan="2">
						<acronym title="Ce que vous d&eacute;sirez en &eacute;change">Demandes</acronym> en : 
							<input type="radio" name="base" value="p" <?php echo ($user_data["modepq"] == 'p' ? 'checked="checked"' : ''); ?> />
						<acronym title="Le total doit toujours faire 100%">%</acronym>
							<input type="radio" name="base" value="q" <?php echo ($user_data["modepq"] == 'q' ? 'checked="checked"' : ''); ?> />
						<acronym title="Saisie manuelle des quantit&eacute;s">Q</acronym>
					</td>
				</tr>
				<tr>
					<td class="c">M&eacute;tal</td>
					<td class="l">
						<input type="text" name="combienm" value="<?php echo (isset($combienm) ? $combienm : '0'); ?>" />
					</td>
				</tr>
				<tr>
					<td class="c">Cristal</td>
					<td class="l">
						<input type="text" name="combienc" value="<?php echo (isset($combienc) ? $combienc : '0'); ?>" />
					</td>
				</tr>
				<tr>
					<td class="c">Deut&eacute;rium</td>
					<td class="l">
						<input type="text" name="combiend" value="<?php echo (isset($combiend) ? $combiend : '0'); ?>" />
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="3">
			<input type="submit" value="Calculer">
		</td>
</table>
</form>

<?php 
//tableaux des rÈsultats 

//on doit tout d'abord s'assurer que le formulaire est ouvert
if ($ouvert == 1 && !isset($error)) {
	//Avant de poster les variables ils vous faut dÈfinir les variable non dÈfini
	if (!isset($metal)) $metal = 0;
	if (!isset($cristal)) $cristal = 0;
	if (!isset($deuterium)) $deuterium = 0;
	if (!isset($TotalM))$TotalM = 0;
	if (!isset($TotalC))$TotalC = 0;
	if (!isset($TotalD))$TotalD = 0;
?> 
<form action="index.php" method="post">
	<input type='hidden' name='action' value='addtrade'>	
<table width="60%" align="center">
	<tr>
		<td colspan="3" class="c">Calcul de votre Offre - Vous pouvez encore modifier votre offre &agrave; votre convenance.</td>
	</tr>
	<tr>
		<th><?php echo (rapport(round($metal), round($cristal), round($deuterium), round($TotalM), round($TotalC), round($TotalD))); ?></th>
		<th>votre offre (K)</th>
		<th>votre demande (K)</th>
	</tr>
	<tr>
		<th>M&eacute;tal</th>
		<th><input type="text" name="offer_metal" value=<?php echo round($metal); ?> /></th>
		<th><input type="text" name="want_metal" value=<?php echo round($TotalM); ?> /></th>
	</tr>
	<tr>
		<th>Cristal</th>
		<th><input type="text" name="offer_crystal" value=<?php echo round($cristal); ?> /></th>
		<th><input type="text" name="want_crystal" value=<?php echo round($TotalC); ?> /></th>
	</tr>
	<tr>
		<th>Deut&eacute;rium</th>
		<th><input type="text" name="offer_deuterium" value=<?php echo round($deuterium); ?> /></th>
		<th><input type="text" name="want_deuterium" value=<?php echo round($TotalD); ?> /></th>
	</tr>	
	<tr>
		<td class="c" colspan="3">Options de l'Offre</td>
	</tr>
	<tr>
		<th>
			<acronym title="Durée en nombre d'heures">Expiration</acronym>
		</th>
		<th colspan="2">
			<input type='text' size="5" name='expiration_hours' value='1'>Jours (MAXI <?php echo intval($server_config["max_trade_delay_seconds"]/(60*60*24)); ?> jours)
		</th>
	</tr>
	<tr>
		<th>
			Je peux Livrer en :

		</th>
		<th>
			<?php 
				for ($i = 1; $i <= $current_uni["g"]; $i++) {
					echo 'G'.$i.'<input type="checkbox" value="'.$i.'" id="deliver['.$i.']" name="deliver['.$i.']" '.($user_data["deliver"][$i] == 1 ? '"checked="checked"' : '').'/>';
					if (($i/9) == ceil($i/9)) echo "<br/>";
				} 
			?>
		</th>
        <th>
            <br><input type="button" id="inverse-deliver" name="valide" value="Inverser la sélection" /><br>
            <br><input type="button" id="valide" name="valide" value="Tout cocher" onClick="tick_all('deliver');"><br>
            <br><input type="button" id="valide" name="valide" value="Cocher Aucun" onClick="untick_all('deliver');"><br>

        </th>
	</tr>
	<tr>
		<th>
			Je peux R&eacute;ceptioner en :
		</th>
		<th>
			<?php 
				for ($i = 1; $i <= $current_uni["g"]; $i++) {
					echo 'G'.$i.'<input type="checkbox" value="'.$i.'" id="refunding['.$i.']" name="refunding['.$i.']" '.($user_data["refunding"][$i] == 1 ? '"checked="checked"' : '').'/>';
					if (($i/9) == ceil($i/9)) echo "<br/>";
				} 
			?>
		</th>
        <th>
            <br><input type="button" id="inverse-refunding" name="valide" value="Inverser la sélection" /><br>
            <br><input type="button" id="valide" name="valide" value="Tout cocher" onClick="tick_all('refunding');"><br>
            <br><input type="button" id="valide" name="valide" value="Cocher Aucun" onClick="untick_all('refunding');"><br>

        </th>
	</tr>
	<tr>
		<th>
			<acronym title="Note visible par tous">Note</acronym>
		</th>
		<th colspan='2'>
			<textarea cols="36" rows="7" name='note'></textarea>
		</th>
	</tr>
	<tr>
		<th colspan="3">
			<input type="submit" value="Créer cette offre!">
		</th>
	</tr>
</table>
</form>
<?php
	}
}
elseif ($value == "Modifier")
{
	$trade = $Trades->trades_array("uniquetrade", $pub_tradeid);
?>
<form action="index.php?action=upd_trade" method="post">
	<input type='hidden' name='tradeid' value='<?php echo $pub_tradeid; ?>'/>
	<input type='hidden' name='traderid' value='<?php echo $trade["traderid"]; ?>'>
	<input type='hidden' name='expiration_date' value='<?php echo $trade["expiration_date"]; ?>'/>
	<input type='hidden' name='creation_date' value='<?php echo $trade["creation_date"]; ?>'/>
<table width="60%" class="style">
	<tr>
		<th>&nbsp;</th>
		<th width="35%">Offres (Ko)</th>
		<th width="35%">Demandes (Ko)</th>
	</tr>
	<tr>
		<td class='c'>M&eacute;tal</td>
		<td align="center">
			<input type='text' size="8" name='offer_metal' value='<?php echo $trade["offer_metal"]; ?>'>
		</td>
		<td align="center">
			<input type='text' size="8"  name='want_metal' value='<?php echo $trade["want_metal"]; ?>'>
		</td>
	</tr>
	<tr>
		<td class='c'>Crystal</td>
		<td align="center">
			<input type='text' size="8"  name='offer_crystal' value='<?php echo $trade["offer_crystal"]; ?>'>
		</td>
		<td align="center">
			<input type='text' size="8"  name='want_crystal' value='<?php echo $trade["want_crystal"]; ?>'>
		</td>
	</tr>
	<tr>
		<td class='c'>Deut&eacute;rium</td>
		<td align="center">
			<input type='text' size="8"  name='offer_deuterium' value='<?php echo $trade["offer_deuterium"]; ?>'>
		</td>
		<td align="center">
			<input type='text' size="8"  name='want_deuterium' value='<?php echo $trade["want_deuterium"]; ?>'>
		</td>
	</tr>
	<tr>
		<td class='l' colspan='3'>&nbsp;</td>
	</tr>
	<tr>
		<td class='c'>Cr&eacute;ation</td>
		<td align="center" colspan='2'><?php echo(strftime("%a %d %b %H:%M:%S", $trade["creation_date"])); ?></td>				   
	</tr>
	<tr>
		<td class='c'>Expiration</td>
		<td align="center" colspan='2'><?php echo(strftime("%a %d %b %H:%M:%S", $trade["expiration_date"])); ?></td>
	</tr>
	<tr>
		<td class="c">Prolonger</td>
<?php
// Autorisation de prolonger l'offre
	$quartemps = (intval($trade["expiration_date"]) - intval($trade["creation_date"]))/4;
	$now = time();
		if ($now < intval($trade["expiration_date"]) - $quartemps)
			echo "\t<td class=\"l\" colspan=\"2\"><center><font color=\"lime\">A partir de ".strftime("%a %d %b %H:%M:%S", ($trade["expiration_date"] - $quartemps))."</font></centrer></td>\n";
		else 
			echo "\t<td align=\"center\" colspan=\"2\"><input type='text' size='5' name='expiration_hours' value='0'>h (MAXI ".intval($server_config["max_trade_delay_seconds"]/(60*60))." heures)</td>\n";
?> 
	</tr>
	<tr>
		<td class='l' colspan='3'>&nbsp;</td>
	</tr>
	<tr>
		<td class='c'><Note</td>
		<td colspan='2'><textarea name='note'><?php echo stripslashes($trade["note"]); ?></textarea></td>
	</tr>			
	<tr>
		<td class='c'>
			Livrable en:
		</td>
		<td
			<?php 
				for ($i = 1; $i <= $trade["g"]; $i++) {
					echo 'G'.$i.'<input type="checkbox" value="'.$i.'" id="deliver['.$i.']" name="deliver['.$i.']" '.($trade["deliver"][$i] == 1 ? '"checked="checked"' : '').'/>';
					if (($i/9) == ceil($i/9)) echo "<br/>";
				} 
			?>
		</td>
        <td>
            <br><input type="button" id="inverse-deliver" name="valide" value="Inverser la sélection" >
            <br><input type="button" id="valide" name="valide" value="Tout cocher" onClick="tick_all('deliver');">
            <br><input type="button" id="valide" name="valide" value="Cocher Aucun" onClick="untick_all('deliver');">

        </td>
	</tr>
	<tr>	
		<td class='c'>
			Payable en:
		</td>
		<td>
			<?php 
				for ($i = 1; $i <= $trade["g"]; $i++) {
					echo 'G'.$i.'<input type="checkbox" value="'.$i.'" id="refunding['.$i.']" name="refunding['.$i.']" '.($trade["refunding"][$i] == 1 ? '"checked="checked"' : '').'/>';
					if (($i/9) == ceil($i/9)) echo "<br/>";
				} 
			?>	
		</td>
        <td>
            <br><input type="button" id="inverse-refunding" name="valide" value="Inverser la sélection" >
            <br><input type="button" id="valide" name="valide" value="Tout cocher" onClick="tick_all('refunding');">
            <br><input type="button" id="valide" name="valide" value="Cocher Aucun" onClick="untick_all('refunding');">
        </td>
	</tr>
	<tr>
		<td class='c' align='center' colspan="3">
			<input type="submit" value="Modifier cette Offre!">
		</td>			
	<tr>
</table>
</form>
<?php }
require_once("views/page_tail.php");
?>
