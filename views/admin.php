<?php
/***************************************************************************
*	filename	: home.php
*	desc.		: 
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 17/12/2005
*	modified	: 28/12/2005 23:56:40
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

if ($user_data["is_admin"] != 1) {
	echo "Vous n'avez pas les droits requis pour acceder a cette page";
	die();
}

if (!isset($pub_subaction)) $pub_subaction = "";
require_once("views/page_header.php");
?>
<table width="80%">
<tr>
	<td class="l">Administration</td>
</tr>
<tr>
	<td>
		<table align="center" border="1">
		<tr align="center">
<?php
if ($user_data["is_admin"] == 1) {
	if ($pub_subaction != "") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=admin';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Administration G&eacute;n&eacute;rale</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Administration G&eacute;n&eacute;rale</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["is_admin"] == 1) {
	if ($pub_subaction != "trade") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=admin&subaction=trade';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Administration Commerciale</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Administration Commerciale</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["is_admin"] == 1) {
	if ($pub_subaction != "uni") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=admin&subaction=uni';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Administration des March&eacute;s</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Administration des March&eacute;s</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["is_admin"] == 1) {
	if ($pub_subaction != "members") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=admin&subaction=members';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Administration des Membres</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Administration des Membres</a>";
		echo "</th>"."\n";
	}
}

if ($user_data["is_admin"] == 1) {
	if ($pub_subaction != "debug") {
		echo "\t\t\t"."<td class='c' width='150' onclick=\"window.location = 'index.php?action=admin&subaction=debug';\">";
		echo "<a style='cursor:pointer'><font color='lime'>Debug</font></a>";
		echo "</td>"."\n";
	}
	else {
		echo "\t\t\t"."<th width='150'>";
		echo "<a>Debug</a>";
		echo "</th>"."\n";
	}
}

?>
		</tr>
		</table>
	</td>
</tr>
</tr>
<?php
switch ($pub_subaction) {
	case "debug":
		require_once("views/admin_debug.php");
		break;

	case "trade":
		require_once("views/admin_trade.php");
		break;

	case "members":
		require_once("views/admin_members.php");
		break;

	case "uni":
		require_once("views/admin_univers.php");
		break;
	
	default:
		require_once("views/admin_general.php");
		break;
}
	require_once("views/page_tail.php");
?>
