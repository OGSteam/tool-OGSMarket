<?php
/***********************************************************************
 * filename	:	menu.php
 * desc.	:	Menu de Gauche
 * created	: 	05/06/2006 ericalens
 *
 * *********************************************************************/

if (!defined('IN_OGSMARKET'))
	exit("Hacking attempt");

$UserArray = $Users->OnlineUsers(300);
$univers = $Universes->universes_array();
?>

<table border="0" cellpadding="2" cellspacing="0"  class="style">
	<tr align="center">
		<td class="c"  width="110">
			<a href="index.php"><b>Accueil</b></a>
		</td>
	</tr>
	<tr align="center">
		<td id="datetime">
			<b>Chargement...</b>
		</td>
	</tr>
	<tr>
		<td align="center">
			<img src="<?php echo $link_css;?>gfx/ogame-produktion.jpg" />
		</td>
	</tr>
	<tr>
		<td align="center">
			<form method="post" name="uni_change" action="index.php?action=change_uni">
			<select name='uni' onchange="document.forms['uni_change'].submit();">
<?php
//sélection des univers
	foreach ($univers as $uni) {
		echo "\t\t<option value='".$uni["id"]."'";
		if ($current_uni["id"]==$uni["id"]) echo " selected ";
		echo ">".$uni["name"]."</option>";
	}
?>
			</select>
			</form>
		</td>
	</tr>
	<tr>
		<td><div align="center"><a href="index.php?action=listtrade">Voir les Offres</a></div></td>
	</tr>
<?php if (isset($user_data)){ ?>
	<tr>
		<td>
			<div align="center"><a href="index.php?action=listtrade&subaction=usertrades">Voir mes Offres</a></div>
		</td>
	</tr>
	<tr>
		<td>
			<div align='center'>
				<?php if($univers == Array()){ ?>
				<blink><font color="red"><b>Paramétrer Univers!</b></font></blink>
				<?php } else { ?>
				<a href='index.php?action=newtrade'>Nouvelle Offre</a>
				<?php } ?>
			</div>
		</td>
	</tr>
		<tr>
		<td>
			<div align="center"><a href="index.php?action=closedtrades">Livre des Ventes</a></div>
		</td>
	</tr>
	<tr>
		<td  class='c' align="center">
			<?php echo $server_config["menuprive"];?>
		</td>
	</tr>
<?php if ($user_data["is_admin"] == 1){ ?>
	<tr>
		<td>
			<div align='center'><a href='index.php?action=admin'>Administration</a></div>
		</td>
	</tr>
<?php } ?>
	<tr>
		<td>
			<div align='center'><a href='index.php?action=profile'>Profil</a></div>
		</td>
	</tr>
<?php
} else {
//sinon Boite de login
    echo "<form action='index.php' method='post'>\n"
        ."\t<input type='hidden' name='action' value='login'>\n";
    echo "\t<tr><th>Nom</th></tr><tr>\n\t<td align='center' class='c'><input type='text' name='name' value=''></td></tr>\n";
    echo "\t<tr><th>Password</th></tr><tr>\n\t<td align='center' class='c'><input type='password' name='password'></td></tr>\n";
    echo "\t<tr>\n\t<td align='center'><input type='submit' value='Envoyer'></td></tr>\n";
    echo "</form>\n";

    if ($server_config["users_auth_type"]=="internal")
		echo "<tr><td><div align=\"center\"><a href=\"index.php?action=inscription\">Inscription</a></div></td></tr>\n";
    else
		echo "\t<tr><td><div align=\"center\"><a href=\"".$server_config["users_inscription_ur"]."\" target=\"_blank\">Inscription</a></div></td></tr>\n";
}
?>
	<tr>
		<td class='c' align="center">
			<?php echo $server_config["menuforum"];?>
		</td>
	</tr>
	<tr>
		<td>
			<div align='center'><a href=<?php echo $server_config["adresseforum"];?> target="_blank"><?php echo $server_config["nomforum"];?></a></div>
		</td>
	</tr>
	<tr>
		<td>
			<div align='center'><a href='http://board.ogame.fr/board.php?boardid=291' target="_blank">Forums OGame</a></div>
		</td>
	</tr>
	<tr>
		<td>
			<div align='center'><a href='index.php?action=pjirc' target="_blank">Java IRC</a></div>
		</td>
	</tr>
	<tr>
		<td>
			<div align='center'><a href='irc://irc.sorcery.net/ogsmarket' target="_blank">Lien IRC</a></div>
		</td>
	</tr>

<?php if (isset($user_data)) { ?>
	<tr>
		<td class='c' align="center">
			<?php echo $server_config["menulogout"];?>
		</td>
	</tr>
	<tr>
		<td>
			<div align='center'><a href='index.php?action=logout'>Logout</a></div>
		</td>
	</tr>
<?php } ?>
	<tr>
		<td class='c' align="center">
			<?php echo $server_config["menuautre"];?>
		</td>
	</tr>
	<tr>
		<td>
			<div align='center'><a href='index.php?action=Convertisseur'>Convertisseur</a></div>
		</td>
	</tr>
	<tr>
		<td>
			<div align='center'><a href='index.php?action=contributeur'>Contributeurs</a></div>
		</td>
	</tr>
	<tr>
		<td>
			<div align='center'><a href='index.php?action=FAQ'>FAQ</a></div>
		</td>
	</tr>
	<tr align="center">
		<td  class='c'>
			Online <?php echo "(".count($UserArray).")";?>
		</td>
	</tr>
	<tr>
		<td width="110">
<?php
	if (isset($user_data) && $UserArray) {
		$i = 0;
		foreach ($UserArray as $User){
			if ($i == 0) 
				echo $User["name"];
			else
				echo ", ".$User["name"];
			$i++;
		}
	}
?>
		</td>
	</tr>
</table>
