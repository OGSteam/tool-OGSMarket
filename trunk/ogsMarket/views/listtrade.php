<?php
/***************************************************************************
*	filename	: listtrade.php
*	desc.		:
*	Author		: ericalens - http://ogsteam.fr/
*	created		: 17/12/2005
*	modified	: 28/12/2005 23:56:40
*	modified	: dimanche 11 juin 2006, 01:05:08 (UTC+0200)
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
	
	if (isset($pub_subaction) && $pub_subaction == "usertrades")
	{
		$action = "usertrades";
		
		if (isset($pub_user_id))
		{
			$action_id = $pub_user_id;
			$user = $Users->get_user($pub_user_id);
		}
		else
		{
			$action_id = $user_data["id"];
			$user = $user_data;
		}
		
		$title = "Liste des Offres de ".$user["name"];
	}
	else
	{
		$action = "unitrades";
		$action_id = $current_uni["id"];
		
		$title = "March&eacute; de l'".$current_uni["name"];
	}
?>

<table width="100%">
<tr>
	<td>
		<table width="100%">
		<tr align="center">
			<td align="center"><a href='http://ogsteam.fr'>OGSMarket</a>: Le commerce Ogamien par l'<b>OGSTeam</b></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
		<table width="100%">
		<tr>
			<td class="l" align="center" colspan=12>
				<form method="post" name="order" action="index.php?action=listtrade">
				<?php echo $title." - March&eacute; : ".$server_config["servername"]; ?>
					<select name="order" onchange="document.forms['order'].submit();">
						<option value="<?php echo $order; ?>">Trier</option>
						<option value="<?php echo $order; ?>">-----------</option>
						<option value="expiration_date">Expiration</option>
						<option value="offer_metal DESC">Metal</option>
						<option value="offer_crystal DESC">Crystal</option>
						<option value="offer_deuterium DESC">Deuterium</option>
						<option value="(offer_metal + offer_crystal + offer_deuterium) DESC">M+C+D</option>
					</select>
				</form>
			</td>
		</tr>

<?php
	foreach($Trades->trades_array($action, $action_id, $order) as $trade)
	{
		echo "<tr style='height: 5px;' />"; //Espace entre chaque offre
		echo "\t    <tr>\n";
		echo "\t      <td class='k' colspan='1' rowspan='3' align='center'><img src='".$trade["avatar_link"]."' alt='No avatar' /><br />";
		echo "\t<a href='index.php?action=profile&amp;id=".$trade["traderid"]."'>".$trade["username"]."</a>\n";
		echo "</td>\n";
		echo "\t      <td class='c'><b>Date de cr&eacute;ation: ".strftime("%a %d %b",$trade["creation_date"])." ".strftime("%H:%M:%S",$trade["creation_date"])."</b></td>\n";
		echo "\t      <td class='c' style='width: 40%;'><b>Date de fin: <font color=\"green\">".strftime("%a %d %b %H:%M:%S",$trade["expiration_date"]);
		if ($trade["expiration_date"] < time()) {
			echo " (Offre Expir&eacute;e)";
?>
    <form action='index.php' methode='post'> 
      <input type='hidden' name='action' value='reactive_trade'> 
      <input type='hidden' name='id' value='<?php echo $trade["id"]; ?>'> 
      <input type="submit" value="R&eacute;activer Offre">
      </th>
    </form> 
<?php     
		} 
		echo"</font></b></td>\n";
		echo "\t</tr>\n";
		echo "\t<tr>\n";
		echo "\t<th colspan='2' rowspan='1' class='c' style='height: 50px; width: 40%;font-size:large;'>\n";
		echo "\t".$trade["username"]." offre ";
			if (intval($trade["offer_metal"])>0) echo number_format($trade["offer_metal"], 0, ',', ' ')." K de M&eacute;tal ";
			if (intval($trade["offer_crystal"])>0) echo number_format($trade["offer_crystal"], 0, ',', ' ')." K de Cristal ";
			if (intval($trade["offer_deuterium"])>0) echo number_format($trade["offer_deuterium"], 0, ',', ' ')." K de Deut&eacute;rium ";
		  echo " contre " ;
			if (intval($trade["want_metal"])>0) echo " ".number_format($trade["want_metal"], 0, ',', ' ')." K de M&eacute;tal ";
			if (intval($trade["want_crystal"])>0) echo " ".number_format($trade["want_crystal"], 0, ',', ' ')." K de Crystal ";
			if (intval($trade["want_deuterium"])>0) echo " ".number_format($trade["want_deuterium"], 0, ',', ' ')." K de Deut ";
		  echo "(".taux_echange($trade["offer_metal"],$trade["offer_crystal"],$trade["offer_deuterium"],$trade["want_metal"],$trade["want_crystal"],$trade["want_deuterium"]).")</th>";
		echo "\t</tr>\n";
		echo "\t<tr>\n";
		echo "\t<th  colspan='2' rowspan='1' style='height: 86px; width: 40%;'>".stripslashes($trade["note"])."</th>";
		echo "\t</tr>\n";
		echo "\t<tr>\n";
		echo "\t<td  class='c'>\n";
		//Menu
		echo "\t<div align='center'>";
		if (isset($user_data)){ 
			if (($user_data["id"] == $trade["traderid"] || $user_data["is_admin"]) && $trade["pos_user"] == 0  && $trade["expiration_date"] > time()){
				echo "\t<div align='center'>";		
				if($user_data["id"] != $trade["traderid"]) echo "[a]";
				echo "\t<a href='index.php?action=modifytrade&amp;tradeid=".$trade["id"]."'>Modifier</a></div>";
			}
			if ($user_data["id"] == $trade["traderid"] || $user_data["is_admin"] == 1){
				echo "\t<div align='center'>";
				if($user_data["id"] != $trade["traderid"]) echo "[a]";
				echo "\t<a href='index.php?action=deletetrade&amp;tradeid=".$trade["id"]."'>Effacer</a></div>";
			}
			if ($user_data["id"] != $trade["traderid"] && $trade["pos_user"] == 0) {
				echo "\t<div align='center'>";
				echo "\t<a href='index.php?action=betontrade&amp;tradeid=".$trade["id"]."'>R&eacute;server</a></div>";
			}
			if (($user_data["id"] == $trade["pos_user"] || $user_data["is_admin"] == 1) && $trade["pos_user"] != 0)	{
				echo "\t<div align='center'>";
				if($user_data["id"] != $trade["traderid"] && $user_data["is_admin"] == 1) echo "[a]";
				echo "\t<a href='index.php?action=unbetontrade&amp;tradeid=".$trade["id"]."'>Lib&eacute;rer</a></div>";
			}
		}// Fin menu
		if ($trade["pos_user"]<>0){
			$user2=$Users->get_user($trade["pos_user"]);
			if(!$user2) 
				echo "\tMembre Inconnu\n";
			else 
				echo "\t<a href='index.php?action=profile&amp;id=".$trade["pos_user"]."'>R&eacute;serv&eacute; par: ".$user2["name"]."</a>\n";
		}
		echo "\t</td>\n";
		echo "\t<td class='c' style='height: 0px; width: 40%;'>Livraison vers:<br />";
		echo "<table><tr>";
		for($i = 1; $i <= $trade["g"]; $i++) echo "<td>G".$i."</td>";
		echo "</tr><tr>";
		for($i = 1; $i <= $trade["g"]; $i++) echo "<td>".affiche_icone($trade["deliver"][$i])."</td>";
		echo "</tr></table>";
		echo "\n\t</td>\n";
		echo "\n\t<td class='c' style='height: 0px; width: 40%;'>R&eacute;ception possible en:<br />";
		echo "<table><tr>";
		for($i = 1; $i <= $trade["g"]; $i++) echo "<td>G".$i."</td>";
		echo "</tr><tr>";
		for($i = 1; $i <= $trade["g"]; $i++) echo "<td>".affiche_icone($trade["refunding"][$i])."</td>";
		echo "</tr></table>";        
		echo "\n\t</td>\n";
		echo "\t</td>\n";
		echo "\t</tr>\n";
	}
?>
		</table>
	</td>
</tr>
</table>
<?php }
require_once("views/page_tail.php");
?>
