<?php
/***************************************************************************
*	filename	: home.php
*	desc.		:
*	Author		: ericalens - http://ogsteam.fr/
*	created		: 17/12/2005
*	modified	: 28/12/2005 23:56:40
*	modified	: dimanche 11 juin 2006, 01:05:08 (UTC+0200)
***************************************************************************/

if (!defined('IN_OGSMARKET'))
	exit('Hacking attempt');

require_once("views/page_header.php");
require_once("includes/ogamecalc.php");

function counter_ligne($sql){
		global $db;
		$db->sql_query($sql);
		list($counter)=$db->sql_fetch_row();
		return $counter;
}

$servername = $server_config["servername"];
$home = $infos_config["home"];
if (isset($user_data["id"])) {
  
	$new_users = counter_ligne( "SELECT COUNT(*) FROM ".TABLE_USER." WHERE is_active = '0'" );
	$current_trade = counter_ligne( "SELECT COUNT(*) FROM ".TABLE_TRADE." WHERE traderid = ".$user_data["id"]."  AND expiration_date >= ".time()." AND `trade_closed` = 0");
	$trade_pos_user = counter_ligne( "SELECT COUNT(*) FROM ".TABLE_TRADE." WHERE traderid = ".$user_data["id"]." AND pos_user <> '0' AND expiration_date >= ".time()." AND `trade_closed` = 0");
}
?>

<table style='width : 90%; margin-bottom : 12px;'>
	<tr>
		<td align="center" class="c">
			<b>Bienvenue sur le : <span style='color:red;'><?php echo $servername; ?></span><br /><br />
			
			<?php
				if (isset ($user_data) AND $user_data["is_admin"] == 1 AND $new_users != 0)
					echo 'Il y a <a href=\'index.php?action=admin_members\'><span style=\'color:red;\'>' . $new_users . '</span> nouveau(x)</a> membre(s) en attente d\'activation';
				
				if (isset($current_trade) && $current_trade != 0)
				{
					echo '<br />Vous avez <a href=\'index.php?action=listtrade&subaction=usertrades\'><span style=\'color:red;\'>' . $current_trade . '</span> offre(s)</a> en cours<br />';
					
					if ($trade_pos_user != 0)
						echo 'Il y a <a href=\'index.php?action=listtrade&subaction=usertrades\'><span style=\'color:red;\'>' . $trade_pos_user . '</span> r&eacute;servation(s)</a>';
				}
			?></b>
		</td>
	</tr>
	
	<tr>
		<td class="l"><?php echo $home; ?></td>
	</tr>
</table>

<table style='width : 90%;'>
	<tr>
		<td class="l" align="center" colspan="6"><b>Statistiques et Derni&egrave;res entr&eacute;es sur le serveur</b></td>
	</tr>
	
<?php
	$pair = 1;
	
	foreach ($Universes->universes_array() as $uni)
	{
		if ($pair)
			echo "<tr>\n";
		
		echo "\t<td class='k' width='100'><a href='index.php?action=listtrade&amp;uni=".$uni["id"]."'><acronym title='".$uni["info"]."'>".$uni["name"]."</acronym></a></th>\n";
		
		$LastTrade = $Trades->last($uni["id"]);
		
		if ($LastTrade)
		{
			echo "<td class='c'>".$Trades->count($uni["id"])." offres.</td>";
			
			if ($server_config["view_trade"] == "1" AND empty($user_data))
				echo "<td class='c' align='center'><font size =\"2\" color = \"yellow\">Serveur Priv&eacute;</font><br />Visualisation des offres limit&eacute;e aux membres<br />Veuillez vous identifier.</td>";
			else
			{
				echo "<td class='c' align='center'><a href='index.php?action=viewtrade&amp;tradeid=".$LastTrade["id"]."'>&nbsp;";
				
				if ($LastTrade["offer_metal"] > 0)
					echo " ".number_format($LastTrade["offer_metal"], 0, ',', ' ')." k M&eacute;tal ";
				
				if ($LastTrade["offer_crystal"] > 0)
					echo " ".number_format($LastTrade["offer_crystal"], 0, ',', ' ')." k Crystal ";
				
				if ($LastTrade["offer_deuterium"] > 0)
					echo " ".number_format($LastTrade["offer_deuterium"], 0, ',', ' ')." k Deut ";
				
				echo " contre " ;
				
				if ($LastTrade["want_metal"] > 0)
					echo " ".number_format($LastTrade["want_metal"], 0, ',', ' ')." k M&eacute;tal ";
				
				if ($LastTrade["want_crystal"] > 0)
					echo " ".number_format($LastTrade["want_crystal"], 0, ',', ' ')." k Crystal ";
				
				if ($LastTrade["want_deuterium"] > 0)
					echo " ".number_format($LastTrade["want_deuterium"], 0, ',', ' ')." k Deut ";
				
				echo "</a> par <a href='index.php?action=profile&amp;id=".$LastTrade["traderid"]."'>".$LastTrade["username"]."</a>";
				echo "<br />(".taux_echange($LastTrade["offer_metal"],$LastTrade["offer_crystal"],$LastTrade["offer_deuterium"],$LastTrade["want_metal"],$LastTrade["want_crystal"],$LastTrade["want_deuterium"]).")";
				echo "(Fini dans ".text_datediff($LastTrade["expiration_date"]).")";
				echo "</td>";
			}
		}
		else
			echo "<td class='c' colspan='2' valign='center' class='l'><em>Pas d'offre disponible dans cet univers</em></td>\n";
		
		if ($pair == 0)
		{
			echo "</tr>\n";
			$pair = 1;
		}
		else
			$pair = 0;
	}
	
	if ($pair == 0)
		echo "<td class='c' colspan='3'>&nbsp;</td></tr>";
?>
</table>

<?php require_once("views/page_tail.php"); ?>
