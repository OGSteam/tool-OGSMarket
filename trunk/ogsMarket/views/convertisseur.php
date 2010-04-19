<?php
/***********************************************************************
 * filename	:	Convertisseur.php
 * desc.	:	Fichier principal
 * created	: 	06/11/2006	Mirtador
 * edited	:	04/07/2007	Ninety
 * *********************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

require_once ('views/page_header.php');

$tauxm = $server_config['tauxmetal'];
$tauxc = $server_config['tauxcristal'];
$tauxd = $server_config['tauxdeuterium'];

/* (1) - Initialisation des valeurs, radio aucun checked par defaut */
	
$valAucun = 'checked';
$valPT = '' ;
$valGT = '';
	
/* On defini si l'utilisateur a cliquer sur Calculer ! */

if (isset ($pub_ouvert)) {
	// --------------------------------------------------------
	// On verifie les champs Quantites
	// --------------------------------------------------------
	
	if (isset ($pub_metal) || isset ($pub_cristal) || isset ($pub_deuterium))
	{
		$metal = round ($pub_metal);
		$cristal = round ($pub_cristal);
		$deut = round ($pub_deuterium);
	}
	else
	{
		echo '<p class="error">Vous devez mettre au moins une ressource que vous souhaitez &eacute;changer !</p>';
		exit();
	}
	
	// -----------------------------------------------------
	// -- On verifie les champs Taux
	// -----------------------------------------------------
	
	if (isset ($pub_tauxm) && isset ($pub_tauxc) && isset ($pub_tauxd))
	{
		$tauxm = $pub_tauxm;
		$tauxc = $pub_tauxc;
		$tauxd = $pub_tauxd;
	}
	else
	{
		echo '<p class="error">Vous devez remplir les champs correspondant au Taux !</p>';
		exit();
	}
	
	// -----------------------------------------------------------
	// On verifie les champs Pourcentage
	// -----------------------------------------------------------
	
	if (isset ($pub_combienm) || isset ($pub_combienc) || isset ($pub_combiend))
	{
		$totalPourcentage = $pub_combienm  + $pub_combienc + $pub_combiend;
		
		if ($totalPourcentage == 100)
		{
			$combienm = intval ($pub_combienm);
			$combienc = intval ($pub_combienc);
			$combiend = intval ($pub_combiend);
			
			$totalM = round (($combienm / 100) * ($metal + $cristal * ($tauxm / $tauxc) + $deut * ($tauxm / $tauxd)));
			$totalC = round (($combienc / 100) * ($cristal + $metal * ($tauxc / $tauxm) + $deut * ($tauxc / $tauxd)));
			$totalD = round (($combiend / 100) * ($deut + $metal * ($tauxd / $tauxm) + $cristal * ($tauxd / $tauxc)));
		}
		else
		{
			echo '<p class="error">Le total des pourcentages doit donner 100 !</p>';
			exit();
		}
	}
	
	// ----------------------------------------------
	// (1) - On determine quel radio sera selectionne
	// ----------------------------------------------
	
	/* (1) - Initialisation des valeurs en fonction de ce que le gars a clique */
	
	if (isset ($pub_transporteur))
	{
		if ($pub_transporteur == "aucun")
		{
			$valAucun = 'checked';
			$valPT = '' ;
			$valGT = '';
		}
		elseif ($pub_transporteur == "PT")
		{
			$valAucun = '';
			$valPT = 'checked' ;
			$valGT = '';
		}
		elseif ($pub_transporteur == "GT")
		{
			$valAucun = '';
			$valPT = '' ;
			$valGT = 'checked';
		}
	}
}
	
/* (1) - On cree la fonction qu'on utilisera dans le form */
	
function checkTranspo ($valCheck)
{
	if ($valCheck != '')
	{
		echo 'checked="$valCheck"';
	}
}
	
/* Calcule des Transporteurs */

$transporteur = (isset($pub_transporteur) ? $pub_transporteur : 0);

?>

<form action="index.php?action=Convertisseur" method="post">
	<input type="hidden" name="ouvert" value="1" />
<table class="convertisseur">
	<tr>
		<td class="c" align="center" colspan="5"><b>Convertisseur de ressources<b></td>
	</tr>
	<tr>
		<th>Transporteurs</th>
		<th>Ressources</th>
		<th>Quantit&eacute;s (Unit&eacute;s)</th>
		<th>Taux</th>
		<th>Pourcentage</th>
	</tr>
	<tr>
		<th><label><input type="radio" name="transporteur" value="aucun" <?php checkTranspo ($valAucun);  ?> /> Aucun</label></th>
		<th>M&eacute;tal</th>
		<th><input type="text" name="metal" value="<?php echo formate_number ((isset($metal) ? $metal : 0)); ?>" tabindex="1" /></th>
		<th><input type="text" name="tauxm" value="<?php echo $tauxm; ?>" tabindex="4" /></th>
		<th><input type="text" name="combienm" value="<?php echo (isset($combienm) ? $combienm : 0); ?>" tabindex="7" /></th>
	</tr>
	<tr>
		<th><label><input type="radio" name="transporteur" value="PT" <?php checkTranspo ($valPT);  ?> /> PT</label></th>
		<th>Cristal</th>
		<th><input type="text" name="cristal" value="<?php echo formate_number ((isset($cristal) ? $cristal : 0)); ?>" tabindex="2" /></th>
		<th><input type="text" name="tauxc" value="<?php echo $tauxc; ?>" tabindex="5" /></th>
		<th><input type="text" name="combienc" value="<?php echo (isset($combienc) ? $combienc : 0); ?>" tabindex="8" /></th>
	</tr>
	<tr>
		<th><label><input type="radio" name="transporteur" value="GT" <?php checkTranspo ($valGT);  ?> /> GT</label></th>
		<th>Deut&eacute;rium</th>
		<th><input type="text" name="deuterium" value="<?php echo formate_number ((isset($deuterium) ? $deuterium : 0)); ?>" tabindex="3" /></th>
		<th><input type="text" name="tauxd" value="<?php echo $tauxd; ?>" tabindex="6" /></th>
		<th><input type="text" name="combiend" value="<?php echo (isset($combiend) ? $combiend : 0); ?>" tabindex="9" /></th>
	</tr>
	<tr>
		<th align="center" colspan="5"><input type="submit" value="Calculer !" tabindex="10" /></th>
	</tr>
</table>
</form>

<?php

if (isset($pub_ouvert)) // On defini si l'utilisateur a cliquer sur Calculer !
{
	?>
<br>
<table class="convertisseur">
	<tr>
		<td class="c" align="center" colspan="3"><b>Echange<b></td>
	</tr>
	<tr>
		<th>Infos</th>
		<th>Votre offre</th>
		<th>Votre demande</th>
	</tr>
	<tr>
		<th>M&eacute;tal</th>
		<th><?php echo formate_number ($metal); ?></th>
		<th><?php echo formate_number ($totalM); ?></th>
	</tr>
	<tr>
		<th>Cristal</th>
		<th><?php echo formate_number ($cristal); ?></th>
		<th><?php echo formate_number ($totalC); ?></th>
	</tr>
	<tr>
		<th>Deut&eacute;rium</th>
		<th><?php echo formate_number ($deut); ?></th>
		<th><?php echo formate_number ($totalD); ?></th>
	</tr>
	
	<?php
		if ($transporteur != "aucun")
		{
			$totalaenvoyer = $metal + $cristal + $deuterium;
			$totalaressevoir = $totalM + $totalC + $totalD;
			
			if ($transporteur == "PT")
			{
				$transporteurenvoyer = ceil ($totalaenvoyer / 5000);
				$transporteurressus = ceil ($totalaressevoir / 5000);
			}
			elseif ($transporteur == "GT")
			{
				$transporteurenvoyer = ceil ($totalaenvoyer / 25000);
				$transporteurressus = ceil ($totalaressevoir / 25000);
			}
	?>
	
	<tr>
		<th>Nombre de <?php echo $transporteur; ?></th>
		<th><?php echo $transporteurenvoyer; ?></th>
		<th><?php echo $transporteurressus; ?></th>
	</tr>
	
<?php } ?>	
</table>
<br>
<table width="60%">
	<tr>
		<td class="c" align="center"><b>Offre en BBCode pour les forums</b></td>
	</tr>
	<tr>
		<th>
			<?php $BBcode = '[center][size=18][b][color=red]Offre via OGSMarket[/color][/b][/size]';	
			$BBcode .= "\n";
			$BBcode .= "\n";
			$BBcode .= '[i][b][color=green]Offre[/color][/b][/i]' . "\n";
			$BBcode .= 'M&eacute;tal : [b]' . formate_number ($metal) . '[/b]' . "\n";
			$BBcode .= 'Cristal : [b]' . formate_number ($cristal) . '[/b]' . "\n";
			$BBcode .= 'Deut&eacute;rium : [b]' . formate_number ($deut) . '[/b]' . "\n";

			if ($transporteur == "PT")
				$BBcode .= 'Le nombre de [b]PT[/b] n&eacute;ccessaires est de [b]' . $transporteurenvoyer . '[/b].' . "\n";
			elseif ($transporteur == "GT")
				$BBcode .= 'Le nombre de [b]GT[/b] n&eacute;ccessaires est de [b]' . $transporteurenvoyer . '[/b].' . "\n";
				
			$BBcode .= "\n";
			$BBcode .= '[i][b][color=green]Demande[/color][/b][/i]' . "\n";
			$BBcode .= 'M&eacute;tal : [b]' . formate_number ($totalM) . '[/b]' . "\n";
			$BBcode .= 'Cristal : [b]' . formate_number ($totalC) . '[/b]' . "\n";
			$BBcode .= 'Deut&eacute;rium : [b]' . formate_number ($totalD) . '[/b]' . "\n";

			if ($transporteur == "PT")
				$BBcode .= 'Le nombre de [b]PT[/b] n&eacute;ccessaires est de [b]' . $transporteurressus . '[/b].' . "\n";
			elseif ($transporteur == "GT")
				$BBcode .= 'Le nombre de [b]GT[/b] n&eacute;ccessaires est de [b]' . $transporteurressus . '[/b].' . "\n";
				
			$BBcode .= "\n";
			$BBcode .= 'Le taux impos&eacute; est : [b]' . $tauxm . ' / ' . $tauxc . ' / ' . $tauxd . '[/b].' . "\n";
			$BBcode .= "\n" . "\n" . "\n" . '[size=6][url=ogsteam.fr]OGSMarket - Plateforme de Commerce[/url][/size]';
			$BBcode .= '[/center]'; ?>
			<textarea name="bbcode" rows="10" cols="20"><?php echo $BBcode; ?></textarea>
		</th>
	</tr>
</table>
<?php
} 

require_once("views/page_tail.php");
?>