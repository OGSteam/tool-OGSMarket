<?php
/***************************************************************************
*	filename	: Admin_members.php
*	desc.		: 
*	Author		: Mirtador
*	created		: 11/15/06
***************************************************************************/
if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}
?>
<table width="80%" align="center" border="1">
	<tr>
		<td class="l" colspan="7">Liste des Membres</td>
	</tr>
	<tr>
		<td class="c"><a href="index.php?action=admin&subaction=members&amp;sortby=byname">Nom</a></td>
		<td class="c"><a href="index.php?action=admin&subaction=members&amp;sortby=bymail">Email</a></td>
		<td class="c"><a href="index.php?action=admin&subaction=members&amp;sortby=bylastvisit">Derni&egrave;re Visite</a></td>
		<td class="c"><a href="index.php?action=admin&subaction=members&amp;sortby=byadmin">Administrateur</a></td>
		<td class="c"><a href="index.php?action=admin&subaction=members&amp;sortby=bymod">Mod&eacute;rateur</a></td>
		<td class="c"><a href="index.php?action=admin&subaction=members&amp;sortby=byactif">Actif</a></td>
		<td class="c">Action</td>
	</tr>
	<?php
	
	if(!isset($pub_sortby)) $pub_sortby = "";

	switch ($pub_sortby){
		case "byname":
			$orderby=" ORDER BY name asc";
		break;
		
		case "bymail":
			$orderby=" ORDER BY email asc";
		break;
		
		case "bylastvisit":
			$orderby=" ORDER BY lastvisit desc";
		break;
		
		case "byadmin":
			$orderby=" ORDER BY is_admin desc";
		break;
		
		case "bymod":
			$orderby=" ORDER BY is_moderator desc";
		break;
		
		case "byactif":
			$orderby=" ORDER BY is_active desc";
		break;
			
		default:
			$orderby=" ORDER BY id";
		break;
	}
	
	
	$query = "SELECT `id`, `name`, `lastvisit`, `email`, `is_admin`, `is_moderator`, `is_active` from ".TABLE_USER." ".$orderby.";";
	$result	=	$db->sql_query($query);
	while (list( $id, $name, $lastvisit, $email, $is_admin, $is_moderator, $is_active) = $db->sql_fetch_row($result)){
		echo "<tr>";
		//Première colonne
			echo"<th>";
		//	echo"$name</a>";
			echo "\t<a href='index.php?action=profile&amp;id=".$id."'>".$name."</a>\n";
			echo"</th>";
		//Deuxième colonne
			echo"<th>";
			echo"$email";
			echo"</th>";
		//Troisième colonne
			echo"<th>";
			echo strftime("%a %d %b %H:%M:%S",$lastvisit);
			echo"</th>";				
		//Quatrième colonne
			echo"<th>";
			if ($is_admin==1)
				{ echo "<font color=\"#00FF00\">Oui</font>"; 
				//Bouton retirer le statut d'Administrateur
					echo "<form method='POST' action='index.php?action=admin_unset_admin&user_id=".$id."' onsubmit=\"return confirm('Êtes-vous s&ucirc;r de vouloir retiter le statut d&rsquo;Admin &agrave; ".$name."');\">"."\n";
					echo "\t"." <input type='image' src='images/usercheck.png' title='Retirer le statut d&rsquo;Administrateur &agrave; ".$name."'>"."\n";
					echo "</form>"."\n";	
				}
			else 
				{echo "<font color=\"#FF0000\">Non</font>";
				//Bouton nommer un Administrateur
					echo "<form method='POST' action='index.php?action=admin_set_admin&user_id=".$id."' onsubmit=\"return confirm('Êtes-vous s&ucirc;r de vouloir donner le statut d&rsquo;Admin &agrave; ".$name."');\">"."\n";
					echo "\t"."<input type='image' src='images/usercheck.png' title='Donner le statut d&rsquo;Admin &agrave; ".$name."'>"."\n";
					echo "</form>"."\n";	
				}
				echo"</th>";
		//Cinquième colonne
			echo"<th>";
			if ($is_moderator==1)
				{
				echo "<font color=\"#00FF00\">Oui</font>";
				//Bouton retirer le statut de modérateur
			echo "<form method='POST' action='index.php?action=admin_unset_moderator&user_id=".$id."' onsubmit=\"return confirm('Êtes-vous s&ucirc;r de vouloir retirer le statut de mod&eacute;rateur &agrave; ".$name."');\">"."\n";
			echo "\t"."<input type='image' src='images/usercheck.png' title='Retirer le statut de mod&eacute;rateur &agrave; ".$name."'>"."\n";
			echo "</form>"."\n";
				}
			else 	{
				echo "<font color=\"#FF0000\">Non</font>";
				//Bouton nommer un modérateur
			echo "<form method='POST' action='index.php?action=admin_set_moderator&user_id=".$id."' onsubmit=\"return confirm('Etes-vous s&ucirc;r de vouloir donner le statut de mod&eacute;rateur &agrave; ".$name."');\">"."\n";
			echo "\t"."<input type='image' src='images/usercheck.png' title='Donner le statut de mod&eacute;rateur &agrave; ".$name."'>"."\n";
			echo "</form>"."\n";
				}
			echo"</th>";
		//Sixième colonne
			echo"<th>";
			if ($is_active==1)
				{
				echo "<font color=\"#00FF00\">Oui</font>";
				//Bouton Désactiver
					echo "<form method='POST' action='index.php?action=admin_unset_active&user_id=".$id."' onsubmit=\"return confirm('Êtes-vous s&ucirc;r de vouloir D&eacute;sactiver ".$name."');\">"."\n";
					echo "\t"."<input type='image' src='images/usercheck.png' title='D&eacute;sactiver  ".$name."'>"."\n";
					echo "</form>"."\n";
				}
			else 	{
				echo "<font color=\"#FF0000\">Non</font>";
				//Bouton activer
					echo "<form method='POST' action='index.php?action=admin_set_active&user_id=".$id."' onsubmit=\"return confirm('Êtes-vous s&ucirc;r de vouloir activer ".$name."');\">"."\n";
					echo "\t"."<input type='image' src='images/usercheck.png' title='Activer ".$name."'>"."\n";
					echo "</form>"."\n";
				}
			echo"</th>";
		//Septième colonne
			echo"<th>";
			echo "<form method='POST' action='index.php?action=admin_delete_user&user_id=".$id."' onsubmit=\"return confirm('Êtes-vous s&ucirc;r de vouloir supprimer ".$name."');\">"."\n";
			echo "\t"."<input type='image' src='images/userdrop.png' title='Supprimer ".$name."'>"."\n";
			echo "</form>"."\n";
			echo"</th>";
		//Fin de la ligne
	echo "</tr>";
	}
?>
</table>