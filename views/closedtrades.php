<?php
/***************************************************************************
*	filename	: closedtrades.php
*	desc.		:
*	Author		: DarkNoon - https://www.ogsteam.fr/
*	created		: 12/11/2009
*	modified	:
*	modified	:
***************************************************************************/

if (!defined('IN_OGSMARKET'))
	exit('Hacking attempt');

require_once("./views/page_header.php");

if ($server_config["view_trade"] != 0 || empty($user_data))
{
	echo "\t<table width=\"100%\">\n<tr>\n";
	echo "\t<td>\n<table width=\"100%\">\n<tr><th>\n";
	echo "\t<font size =\"4\" color = \"yellow\">Serveur Privé</font><br><br>Visualisation des offres limitée aux membres<br>Veuillez vous identifier.\n";
	echo "\t</th></tr>\n</table>\n</td>\n";
	echo "\t</tr>\n</table>\n";
}
else
{
	if (!isset($pub_order))
		$order = "id";
	else
		$order = $pub_order;

		$action = "userclosedtrades";
		$action_id = $user_data["id"];
		$title = "Marché de l'".$current_uni["name"];
?>

<table width="100%">
<tr>

<tr>
	<td>
		<table width="100%">
		<tr>
			<td class="l" align="center" colspan=12>
				<form method="post" name="order" action="index.php?action=closedtrades">
					Archives <select name="order" onchange="document.forms['order'].submit();">
						<option value="<?php echo $order; ?>">Trier</option>
						<option value="<?php echo $order; ?>">-----------</option>
						<option value="offer_metal DESC">Metal</option>
						<option value="offer_crystal DESC">Cristal</option>
						<option value="offer_deuterium DESC">Deuterium</option>
						<option value="(offer_metal + offer_crystal + offer_deuterium) DESC">M+C+D</option>
					</select>
				</form>
			</td>
		</tr>

<?php
	foreach ($Trades->trades_array($action, $action_id, $order) as $trade)
	{
	  $seller = $Users->get_user($trade["traderid"]);
	  $buyer  = $Users->get_user($trade["pos_user"]);

		echo "<tr style='height: 5px;' />"; //Espace entre chaque offre
		echo "\t    <tr>\n";
		echo "\t      <td class='k'  rowspan='2' align='center'><img src='".$seller["avatar_link"]."' alt='' /><br />";
		echo "\t<a href='index.php?action=profile&amp;id=".$seller["id"]."'>".$seller["name"]."</a><br>\n";
		echo "\t<a href='index.php?action=deletetrade&amp;tradeid=".$trade["id"]."'>Supprimer définitivement</a><br>\n";
		echo "</td>\n";
		echo "\t      <td class='c' style='width: 40%;'><b>Date de création: ".strftime("%a %d %b", $trade["creation_date"])." ".strftime("%H:%M:%S", $trade["creation_date"])."</b></td>\n";
		echo "\t      <td class='c' style='width: 40%;'><b>Date de vente: <font color=\"green\">".strftime("%a %d %b %H:%M:%S", $trade["pos_date"]);
		echo"</font></b></td>\n";
		//On affiche l'acheteur à droite
        echo "\t      <td class='k'  rowspan='2' align='center'>Acheteur<img src='".$buyer["avatar_link"]."' alt='' /><br />";
		echo "\t<a href='index.php?action=profile&amp;id=".$buyer["pos_user"]."'>".$buyer["name"]."</a>\n";
		echo "</td>\n";
        echo "\t</tr>\n";
		echo "\t<tr>\n";
		echo "\t<th colspan='2' class='c' style='width: 40%'>\n";
		echo "\t".$trade["username"]." a échangé ";
			if (intval($trade["offer_metal"]) > 0) echo number_format($trade["offer_metal"], 0, ',', ' ')." K de M&eacute;tal ";
			if (intval($trade["offer_crystal"]) > 0) echo number_format($trade["offer_crystal"], 0, ',', ' ')." K de Cristal ";
			if (intval($trade["offer_deuterium"]) > 0) echo number_format($trade["offer_deuterium"], 0, ',', ' ')." K de Deut&eacute;rium ";
		  echo " contre ";
			if (intval($trade["want_metal"]) > 0) echo " ".number_format($trade["want_metal"], 0, ',', ' ')." K de M&eacute;tal ";
			if (intval($trade["want_crystal"]) > 0) echo " ".number_format($trade["want_crystal"], 0, ',', ' ')." K de Crystal ";
			if (intval($trade["want_deuterium"]) > 0) echo " ".number_format($trade["want_deuterium"], 0, ',', ' ')." K de Deut ";
		  echo "(".taux_echange($trade["offer_metal"], $trade["offer_crystal"], $trade["offer_deuterium"], $trade["want_metal"], $trade["want_crystal"], $trade["want_deuterium"]).")</th>";
		echo "\t</tr>\n";
		echo "\t<tr>\n";
		echo "\t<th />";
		echo "\t</tr>\n";
  }
?>
 </table>
	</td>
</tr>
</table>

<?php
}
require_once("views/page_tail.php");
?>
